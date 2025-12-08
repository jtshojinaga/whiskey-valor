<?php
// security_config.php

// In production, load this from an Environment Variable using getenv()
define('ENCRYPTION_KEY', 'YOUR_SUPER_SECRET_32_BYTE_KEY_HERE_!!!'); 
define('CIPHER_METHOD', 'aes-256-cbc');

// Ensure the upload directory exists and is protected
// ideally, place this folder outside the public web root.
define('SECURE_UPLOAD_DIR', __DIR__ . '/secure_uploads/');

if (!file_exists(SECURE_UPLOAD_DIR)) {
    mkdir(SECURE_UPLOAD_DIR, 0755, true);
}
?>