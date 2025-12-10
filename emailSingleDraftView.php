<?php
session_cache_expire(30);
session_start();

// Require login
if (!isset($_SESSION['_id']) || empty($_SESSION['_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SESSION['access_level'] < 1) {
    header('Location: index.php');
    exit();
}

require_once('include/input-validation.php');
require_once('database/dbConnect.php');

ini_set('display_errors', 1);
error_reporting(E_ALL);

$user_id = $_SESSION['_id'];
$draft_id = $_GET['id'] ?? null;

if (!$draft_id) {
    die("No draft selected.");
}

$connection = connect();
$draft_id = mysqli_real_escape_string($connection, $draft_id);

// Fetch the selected draft
$query = "SELECT id, recipientID, subject, body, scheduledSend
          FROM dbdrafts 
          WHERE id = '$draft_id' AND userID = '$user_id'";

$result = mysqli_query($connection, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($connection));
}

$draft = mysqli_fetch_assoc($result);
mysqli_close($connection);

if (!$draft) {
    die("Draft not found or access denied.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once('universal.inc'); ?>
    <title>View Draft - <?php echo htmlspecialchars($draft['subject']); ?></title>
    <link rel="stylesheet" href="css/style.css" />
    <style>
        .draft-container {
            background: #fff;
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            margin: 2rem auto;
            max-width: 800px;
        }
        .draft-header {
            margin-bottom: 1rem;
        }
        .draft-body {
            white-space: pre-wrap;
            border-top: 1px solid #ccc;
            padding-top: 1rem;
            margin-top: 1rem;
        }
        .label {
            font-weight: bold;
        }
        .button-bar {
            margin-top: 2rem;
            display: flex;
            gap: 1rem;
        }
    </style>
</head>
<body>
    <?php require_once('header.php'); ?>

    <h1>View Email Draft</h1>

    <div class="draft-container">
        <div class="draft-header">
            <p><span class="label">Recipient Group:</span> <?php echo htmlspecialchars($draft['recipientID']); ?></p>
            <p><span class="label">Subject:</span> <?php echo htmlspecialchars($draft['subject']); ?></p>
            <p><span class="label">Scheduled Send:</span> <?php echo htmlspecialchars($draft['scheduledSend']); ?></p>
        </div>
        <div class="draft-body">
            <?php echo nl2br(htmlspecialchars($draft['body'])); ?>
        </div>

        <div class="button-bar">
            <a class="button" href="viewEmailDrafts.php">Back to Drafts</a>
            <a class="button" href="editEmailDraft.php?id=<?php echo htmlspecialchars($draft['id']); ?>">Edit</a>
        </div>
    </div>
</body>
</html>
