<?php


$key = getenv('ENCRYPTION_KEY');

// Fallback/Error if not set
if (!$key) {
    die("Security Error: Encryption key not configured.");
}

define('ENCRYPTION_KEY', $key); 
define('CIPHER_METHOD', 'aes-256-cbc');


define('SECURE_UPLOAD_DIR', dirname(__DIR__) . '/secure_uploads/');

if (!file_exists(SECURE_UPLOAD_DIR)) {
    mkdir(SECURE_UPLOAD_DIR, 0755, true);
}
?>