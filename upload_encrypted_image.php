<?php
session_cache_expire(30);
session_start();
require_once('security_config.php');

// Security Check (from your existing code)
if (!isset($_SESSION['_id']) || $_SESSION['access_level'] < 2) {
    die("Access Denied");
}

function compressAndEncryptImage($sourcePath, $destinationPath, $quality = 60) {
    // 1. COMPRESSION ATTEMPT
    $compressedData = null;
    $gdAvailable = extension_loaded('gd') && function_exists('imagecreatefromjpeg');

    if ($gdAvailable) {
        // GD is active, try to compress
        $info = getimagesize($sourcePath);
        $image = null;

        if ($info['mime'] == 'image/jpeg') {
            $image = imagecreatefromjpeg($sourcePath);
        } elseif ($info['mime'] == 'image/png') {
            $image = imagecreatefrompng($sourcePath);
        } elseif ($info['mime'] == 'image/gif') {
            $image = imagecreatefromgif($sourcePath);
        }

        if ($image) {
            ob_start();
            // Convert to JPEG for consistent compression
            imagejpeg($image, null, $quality); 
            $compressedData = ob_get_clean();
            imagedestroy($image);
        }
    }

    // 2. FALLBACK (If GD is missing or image format wasn't supported)
    if (!$compressedData) {
        // If we couldn't compress, just read the raw original file
        $compressedData = file_get_contents($sourcePath);
    }

    // 3. ENCRYPTION (AES-256-CBC)
    $ivLength = openssl_cipher_iv_length(CIPHER_METHOD);
    $iv = openssl_random_pseudo_bytes($ivLength);
    
    $encryptedData = openssl_encrypt($compressedData, CIPHER_METHOD, ENCRYPTION_KEY, 0, $iv);

    if ($encryptedData === false) {
        return false; // Encryption failed
    }

    // 4. STORAGE (IV + Encrypted Data)
    return file_put_contents($destinationPath, $iv . $encryptedData);
}

$message = "";

if (isset($_POST["submit"])) {
    $fileName = basename($_FILES["fileToUpload"]["name"]);
    // Sanitize filename to prevent directory traversal
    $fileName = preg_replace("/[^a-zA-Z0-9.]/", "_", $fileName);
    $targetFile = SECURE_UPLOAD_DIR . $fileName . ".enc"; // Append .enc extension

    // Check if image
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        if (compressAndEncryptImage($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
            $message = "File uploaded, compressed, and encrypted successfully!";
        } else {
            $message = "Error processing image.";
        }
    } else {
        $message = "File is not an image.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <?php require_once('universal.inc'); ?>
    <title>Secure Upload</title>
</head>
<body>
    <?php require_once('header.php'); ?>
    <div style="padding: 20px;">
        <h3>Upload Secure Image</h3>
        <p><?php echo $message; ?></p>
        <form action="" method="post" enctype="multipart/form-data">
            Select image to upload:
            <input type="file" name="fileToUpload" id="fileToUpload" required>
            <br><br>
            <input type="submit" value="Upload Image" name="submit">
        </form>
    </div>
</body>
</html>