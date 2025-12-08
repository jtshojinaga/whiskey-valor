<?php
session_cache_expire(30);
session_start();
require_once('security_config.php');
require_once('database/dbinfo.php'); // Include your DB connection file

// 1. Security Check
if (!isset($_SESSION['_id']) || $_SESSION['access_level'] < 2) {
    header('HTTP/1.0 403 Forbidden');
    die("Access Denied");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['file'])) {
    
    $filename = basename($_POST['file']);
    $source = SECURE_UPLOAD_DIR . $filename;
    
    // 2. Extract Data
    $idType = preg_replace("/[^a-zA-Z0-9]/", "", $_POST['id_type'] ?? 'Unspecified');
    
    // Parse UserID from filename (Format: USERID___FILENAME.enc)
    $parts = explode("___", $filename, 2);
    $fileOwnerID = (count($parts) > 1) ? $parts[0] : "Unknown";
    
    // ---------------------------------------------------------
    // MYSQL COMMAND SHELL
    // ---------------------------------------------------------
    $con = connect();
    if ($con) {
        $safeOwnerID = mysqli_real_escape_string($con, $fileOwnerID);
        $safeIdType = mysqli_real_escape_string($con, $idType);

        // TOODO:Make query
        // $query = "UPDATE dbpersons SET status='Verified', id_type='$safeIdType' WHERE id='$safeOwnerID'";
        

        // $query = "INSERT INTO user_documents (user_id, doc_type, uploaded_at) VALUES ('$safeOwnerID', '$safeIdType', NOW())";

 
        // if (isset($query)) {
        //     mysqli_query($con, $query);
        // }
        
        mysqli_close($con);
    }
    // ---------------------------------------------------------


    // 3. Move/Rename File Logic
    $approvedDir = SECURE_UPLOAD_DIR . 'approved/';
    if (!file_exists($approvedDir)) {
        mkdir($approvedDir, 0755, true);
        if (!file_exists($approvedDir . '.htaccess')) file_put_contents($approvedDir . '.htaccess', 'Deny from all');
    }

    // Rename to: IDTYPE_USERID_FILENAME.enc
    $newFilename = $idType . "_" . $filename; 
    $destination = $approvedDir . $newFilename;

    if (file_exists($source) && is_file($source)) {
        if (rename($source, $destination)) {
            header("Location: view_encrypted_gallery.php?msg=approved");
            exit;
        }
    }
}

header("Location: view_encrypted_gallery.php?msg=error");
exit;
?>