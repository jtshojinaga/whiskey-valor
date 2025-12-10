<?php
session_cache_expire(30);
session_start();
require_once('security_config.php');

// Security Check
if (!isset($_SESSION['_id']) || $_SESSION['access_level'] < 1) { // Assuming uploads are internal or admin-only
    // If this is a public upload form, change access_level check accordingly
    die("Access Denied");
}

function compressAndEncryptImage($sourcePath, $destinationPath, $quality = 60) {
    // 1. COMPRESSION (Robust Check)
    $compressedData = null;
    $gdAvailable = extension_loaded('gd') && function_exists('imagecreatefromjpeg');

    if ($gdAvailable) {
        $info = getimagesize($sourcePath);
        $image = null;

        if ($info['mime'] == 'image/jpeg') $image = imagecreatefromjpeg($sourcePath);
        elseif ($info['mime'] == 'image/png') $image = imagecreatefrompng($sourcePath);
        elseif ($info['mime'] == 'image/gif') $image = imagecreatefromgif($sourcePath);

        if ($image) {
            ob_start();
            imagejpeg($image, null, $quality); 
            $compressedData = ob_get_clean();
            imagedestroy($image);
        }
    }

    if (!$compressedData) {
        $compressedData = file_get_contents($sourcePath);
    }

    // 2. ENCRYPTION
    $ivLength = openssl_cipher_iv_length(CIPHER_METHOD);
    $iv = openssl_random_pseudo_bytes($ivLength);
    $encryptedData = openssl_encrypt($compressedData, CIPHER_METHOD, ENCRYPTION_KEY, 0, $iv);

    if ($encryptedData === false) return false;

    return file_put_contents($destinationPath, $iv . $encryptedData);
}

$message = "";

if (isset($_POST["submit"])) {
    $userID = $_SESSION['_id']; // Grab User ID from Session
    $originalName = basename($_FILES["fileToUpload"]["name"]);
    
    // Sanitize
    $userID = preg_replace("/[^a-zA-Z0-9]/", "", $userID); 
    $safeName = preg_replace("/[^a-zA-Z0-9.]/", "_", $originalName);

    // Create format: USERID___FILENAME.enc (Using triple underscore as separator)
    $finalFileName = $userID . "___" . $safeName . ".enc";
    $targetFile = SECURE_UPLOAD_DIR . $finalFileName;

    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        if (compressAndEncryptImage($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
            $message = "File uploaded successfully for User: " . htmlspecialchars($userID);
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
        <h3>Upload Secure ID</h3>
        <p><?php echo $message; ?></p>
        <form action="" method="post" enctype="multipart/form-data">
            Select ID to upload for account <strong><?php echo $_SESSION['_id']; ?></strong>:
            <br><br>
            <input type="file" name="fileToUpload" id="fileToUpload" required>
            <br><br>
            <input type="submit" value="Upload Image" name="submit">
        </form>
    </div>
</body>
</html>