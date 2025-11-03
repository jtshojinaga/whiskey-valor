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
require_once('database/dbConnect.php'); // connection helper

ini_set('display_errors', 1);
error_reporting(E_ALL);

$user_id = $_SESSION['_id'];

// Database connection
$connection = connect();

// Handle delete draft action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $delete_id = mysqli_real_escape_string($connection, $_POST['delete_id']);
    $query = "DELETE FROM dbdrafts WHERE id = '$delete_id' AND userID = '$user_id'";
    if (mysqli_query($connection, $query)) {
        $message = "Draft deleted successfully.";
    } else {
        $error = "Failed to delete draft: " . mysqli_error($connection);
    }
}

// Fetch drafts for this user
$query = "SELECT id, recipientID, subject, body, scheduledSend 
          FROM dbdrafts 
          WHERE userID = '$user_id'
          ORDER BY scheduledSend DESC";

$result = mysqli_query($connection, $query);

if (!$result) {
    die('Query failed: ' . mysqli_error($connection));
}

$drafts = [];
while ($row = mysqli_fetch_assoc($result)) {
    $drafts[] = $row;
}

mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once('universal.inc'); ?>
    <title>My Email Drafts</title>
    <link rel="stylesheet" href="css/style.css" />
</head>
<body>
    <?php require_once('header.php'); ?>

    <h1>My Email Drafts</h1>
    <main class="general">
        <?php if (isset($message)): ?>
            <p class="success"><?php echo htmlspecialchars($message); ?></p>
        <?php elseif (isset($error)): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <?php if (count($drafts) > 0): ?>
            <div class="table-wrapper">
                <table class="general">
                    <thead>
                        <tr>
                            <th>Recipient Group</th>
                            <th>Subject</th>
                            <th>Scheduled Send</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($drafts as $draft): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($draft['recipientID']); ?></td>
                                <td>
                                    <a href="viewSingleDraft.php?id=<?php echo htmlspecialchars($draft['id']); ?>">
                                        <?php echo htmlspecialchars($draft['subject']); ?>
                                    </a>
                                </td>
                                <td><?php echo htmlspecialchars($draft['scheduledSend']); ?></td>
                                <td>
                                    <form method="POST" style="display:inline;">
                                        <input type="hidden" name="delete_id" value="<?php echo htmlspecialchars($draft['id']); ?>">
                                        <button type="submit" class="button danger" onclick="return confirm('Delete this draft?');">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p>You have no saved email drafts.</p>
        <?php endif; ?>

        <a class="button" href="createEmailDraft.php">Create New Draft</a>
        <a class="button cancel" href="index.php">Return to Dashboard</a>
    </main>
</body>
</html>

