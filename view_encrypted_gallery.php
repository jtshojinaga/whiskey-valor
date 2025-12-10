<?php
session_cache_expire(30);
session_start();
require_once('security_config.php');

if (!isset($_SESSION['_id'])) {
    header('Location: login.php');
    die();
}

$accessLevel = $_SESSION['access_level'] ?? 0;
$allFiles = scandir(SECURE_UPLOAD_DIR);
$files = [];
foreach ($allFiles as $f) {
    if ($f === '.' || $f === '..') continue;
    if (is_dir(SECURE_UPLOAD_DIR . $f)) continue; 
    $files[] = $f;
}

$msgText = "";
$msgClass = "";
if (isset($_GET['msg'])) {
    if ($_GET['msg'] == 'denied') { $msgText = "Application Denied."; $msgClass = "msg-error"; }
    elseif ($_GET['msg'] == 'approved') { $msgText = "Application Approved."; $msgClass = "msg-success"; }
    elseif ($_GET['msg'] == 'error') { $msgText = "Action Failed."; $msgClass = "msg-error"; }
}
?>

<!DOCTYPE html>
<html>
<head>
    <?php require_once('universal.inc'); ?>
    <title>Review Uploads</title>
    <style>
        .gallery { display: flex; flex-wrap: wrap; gap: 20px; padding: 20px; }
        .gallery-item { 
            border: 1px solid #ddd; padding: 15px; border-radius: 8px; background: #fff;
            width: 250px; text-align: center; box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .gallery-item img { 
            max-width: 100%; height: 150px; object-fit: cover; border-radius: 4px;
            border: 1px solid #eee; margin-bottom: 10px;
        }
        .meta-info { font-size: 0.85em; color: #555; margin-bottom: 10px; text-align: left; }
        .meta-info strong { color: #333; }
        .id-select { padding: 5px; border: 1px solid #ccc; border-radius: 4px; width: 100%; margin-bottom: 5px;}
        .btn { border: none; padding: 8px; border-radius: 4px; cursor: pointer; font-weight: bold; width: 100%; }
        .btn-approve { background-color: #2ecc71; color: white; }
        .btn-deny { background-color: #e74c3c; color: white; }
        .msg-success { color: #155724; background-color: #d4edda; padding: 10px; border-radius: 5px; margin: 20px; border: 1px solid #c3e6cb;}
        .msg-error { color: #721c24; background-color: #f8d7da; padding: 10px; border-radius: 5px; margin: 20px; border: 1px solid #f5c6cb;}
    </style>
</head>
<body>
    <?php require_once('header.php'); ?>
    
    <div style="padding: 0 20px;">
        <h2>Pending Uploads</h2>
        <?php if ($msgText): ?>
            <div class="<?php echo $msgClass; ?>"><?php echo htmlspecialchars($msgText); ?></div>
        <?php endif; ?>
    </div>

    <div class="gallery">
        <?php foreach ($files as $file): ?>
            <?php 
                // Parse filename
                $parts = explode("___", $file, 2);
                $displayUser = (count($parts) > 1) ? $parts[0] : "Unknown";
                $displayFile = (count($parts) > 1) ? $parts[1] : $file;
            ?>
            <div class="gallery-item">
                <a href="serve_image.php?file=<?php echo urlencode($file); ?>" target="_blank">
                    <img src="serve_image.php?file=<?php echo urlencode($file); ?>" alt="Secure Image">
                </a>
                
                <div class="meta-info">
                    <div><strong>User:</strong> <?php echo htmlspecialchars($displayUser); ?></div>
                    <div><strong>File:</strong> <?php echo htmlspecialchars($displayFile); ?></div>
                </div>

                <?php if ($accessLevel >= 2): ?>
                <form action="approve_encrypted_image.php" method="POST">
                    <input type="hidden" name="file" value="<?php echo htmlspecialchars($file); ?>">
                    <select name="id_type" class="id-select" required>
                        <option value="" disabled selected>Select ID Type...</option>
                        <option value="DL">Driver's License</option>
                        <option value="Passport">Passport</option>
                        <option value="Military">Military ID</option>
                        <option value="Other">Other</option>
                    </select>
                    <button type="submit" class="btn btn-approve">Approve</button>
                </form>

                <form action="deny_encrypted_image.php" method="POST" onsubmit="return confirm('Deny and delete?');" style="margin-top:5px;">
                    <input type="hidden" name="file" value="<?php echo htmlspecialchars($file); ?>">
                    <button type="submit" class="btn btn-deny">Deny</button>
                </form>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>