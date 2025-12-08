<?php
// approve_encrypted_image.php
session_cache_expire(30);
session_start();
require_once('security_config.php');

// 1. Security Check
if (!isset($_SESSION['_id']) || $_SESSION['access_level'] < 2) {
    header('HTTP/1.0 403 Forbidden');
    die("Access Denied");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['file'])) {
    
    $filename = basename($_POST['file']);
    $source = SECURE_UPLOAD_DIR . $filename;
    
    // Define Approved Directory
    $approvedDir = SECURE_UPLOAD_DIR . 'approved/';

    // Create directory if it doesn't exist
    if (!file_exists($approvedDir)) {
        mkdir($approvedDir, 0755, true);
        // Secure this new folder too
        if (!file_exists($approvedDir . '.htaccess')) {
            file_put_contents($approvedDir . '.htaccess', 'Deny from all');
        }
    }

    $destination = $approvedDir . $filename;

    // 2. Move File (Approve)
    if (file_exists($source) && is_file($source)) {
        if (rename($source, $destination)) {
            header("Location: view_encrypted_gallery.php?msg=approved");
            exit;
        }
    }
}

// Fallback
header("Location: view_encrypted_gallery.php?msg=error");
exit;
?>