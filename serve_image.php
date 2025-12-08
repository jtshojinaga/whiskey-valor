<?php
session_cache_expire(30);
session_start();
require_once('security_config.php');

// Security Check
if (!isset($_SESSION['_id'])) {
    header("HTTP/1.1 403 Forbidden");
    exit;
}

if (isset($_GET['file'])) {
    // Sanitize input
    $file = preg_replace("/[^a-zA-Z0-9._]/", "", $_GET['file']);
    $path = SECURE_UPLOAD_DIR . $file;

    if (file_exists($path)) {
        // Read the file
        $fileContent = file_get_contents($path);

        // Extract IV and Encrypted Data
        $ivLength = openssl_cipher_iv_length(CIPHER_METHOD);
        $iv = substr($fileContent, 0, $ivLength);
        $encryptedData = substr($fileContent, $ivLength);

        // Decrypt
        $decryptedData = openssl_decrypt($encryptedData, CIPHER_METHOD, ENCRYPTION_KEY, 0, $iv);

        if ($decryptedData === false) {
            die("Decryption failed.");
        }

        // Output Headers and Data
        header("Content-Type: image/jpeg"); // We converted everything to JPEG in upload
        header("Content-Length: " . strlen($decryptedData));
        echo $decryptedData;
        exit;
    }
}
echo "File not found.";
?>