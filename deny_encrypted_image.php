<?php
// deny_encrypted_image.php
session_cache_expire(30);
session_start();
require_once('security_config.php');

// 1. Security Check
if (!isset($_SESSION['_id']) || $_SESSION['access_level'] < 2) {
    header('HTTP/1.0 403 Forbidden');
    die("Access Denied");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['file'])) {
    
    // 2. Sanitize
    $filename = basename($_POST['file']);
    $filepath = SECURE_UPLOAD_DIR . $filename;

    // 3. Delete (Deny)
    if (file_exists($filepath) && is_file($filepath)) {
        if (unlink($filepath)) {
            header("Location: view_encrypted_gallery.php?msg=denied");
            exit;
        }
    }
}

// Fallback
header("Location: view_encrypted_gallery.php?msg=error");
exit;
?>