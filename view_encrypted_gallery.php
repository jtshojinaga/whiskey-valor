<?php
// view_encrypted_gallery.php
session_cache_expire(30);
session_start();
require_once('security_config.php');

if (!isset($_SESSION['_id'])) {
    header('Location: login.php');
    die();
}

$accessLevel = $_SESSION['access_level'] ?? 0;

// Scan directory but exclude '.' '..' and any subdirectories (like 'approved')
$allFiles = scandir(SECURE_UPLOAD_DIR);
$files = [];
foreach ($allFiles as $f) {
    if ($f === '.' || $f === '..') continue;
    if (is_dir(SECURE_UPLOAD_DIR . $f)) continue; // Skip folders
    $files[] = $f;
}

// Feedback Messages
$msgText = "";
$msgClass = "";
if (isset($_GET['msg'])) {
    if ($_GET['msg'] == 'denied') {
        $msgText = "Application Denied (File Deleted).";
        $msgClass = "msg-error";
    } elseif ($_GET['msg'] == 'approved') {
        $msgText = "Application Approved (File Archived).";
        $msgClass = "msg-success";
    } elseif ($_GET['msg'] == 'error') {
        $msgText = "Action Failed.";
        $msgClass = "msg-error";
    }
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
            border: 1px solid #ddd; 
            padding: 15px; 
            border-radius: 8px; 
            background: #fff;
            width: 240px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .gallery-item img { 
            max-width: 100%; 
            height: 150px; 
            object-fit: cover; 
            border-radius: 4px;
            border: 1px solid #eee;
            margin-bottom: 10px;
        }
        .file-name {
            display: block;
            margin-bottom: 15px;
            font-size: 0.85em;
            color: #666;
            word-wrap: break-word;
        }
        .actions {
            display: flex;
            gap: 10px;
            justify-content: center;
        }
        .btn {
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            font-size: 0.9em;
            flex: 1;
        }
        .btn-approve { background-color: #2ecc71; color: white; }
        .btn-approve:hover { background-color: #27ae60; }
        
        .btn-deny { background-color: #e74c3c; color: white; }
        .btn-deny:hover { background-color: #c0392b; }

        .msg-success { color: #155724; background-color: #d4edda; padding: 10px; border-radius: 5px; margin: 20px; border: 1px solid #c3e6cb;}
        .msg-error { color: #721c24; background-color: #f8d7da; padding: 10px; border-radius: 5px; margin: 20px; border: 1px solid #f5c6cb;}
    </style>
</head>
<body>
    <?php require_once('header.php'); ?>
    
    <div style="padding: 0 20px;">
        <h2>Pending Uploads</h2>
        <p>Review secure documents below. Approving them moves them to archive; Denying them deletes them permanently.</p>
        <?php if ($msgText): ?>
            <div class="<?php echo $msgClass; ?>"><?php echo htmlspecialchars($msgText); ?></div>
        <?php endif; ?>
    </div>

    <div class="gallery">
        <?php foreach ($files as $file): ?>
            <div class="gallery-item">
                <a href="serve_image.php?file=<?php echo urlencode($file); ?>" target="_blank">
                    <img src="serve_image.php?file=<?php echo urlencode($file); ?>" alt="Secure Image">
                </a>
                <span class="file-name"><?php echo htmlspecialchars($file); ?></span>

                <?php if ($accessLevel >= 2): ?>
                <div class="actions">
                    <form action="approve_encrypted_image.php" method="POST">
                        <input type="hidden" name="file" value="<?php echo htmlspecialchars($file); ?>">
                        <button type="submit" class="btn btn-approve">Approve</button>
                    </form>

                    <form action="deny_encrypted_image.php" method="POST" onsubmit="return confirm('Are you sure you want to DENY this document? This cannot be undone.');">
                        <input type="hidden" name="file" value="<?php echo htmlspecialchars($file); ?>">
                        <button type="submit" class="btn btn-deny">Deny</button>
                    </form>
                </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>

        <?php if (empty($files)): ?>
            <p style="padding: 20px; font-style: italic; color: #666;">No pending documents found.</p>
        <?php endif; ?>
    </div>
</body>
</html>