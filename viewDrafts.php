<?php
session_cache_expire(30);
session_start();
ini_set("display_errors", 1);
error_reporting(E_ALL);

require_once(__DIR__ . '/database/dbinfo.php');
require_once('include/input-validation.php');

if (!isset($_SESSION['_id'])) {
    header('Location: login.php');
    exit;
}

$isAdmin = $_SESSION['access_level'] >= 2;
$userId = $_SESSION['_id'];
$message = '';

if (!$isAdmin) {
    echo "<div class='error-toast'>You do not have permission to view this page.</div>";
    exit();
}

$connection = connect();

// === Delete Draft (if requested) ===
if (isset($_GET['delete'])) {
    $draftId = intval($_GET['delete']);
    $stmt = $connection->prepare("DELETE FROM dbdrafts WHERE draftID = ? AND userID = ?");
    $stmt->bind_param("is", $draftId, $userId);
    $stmt->execute();
    $stmt->close();
    $message = "<div class='success-toast'>Draft deleted successfully!</div>";
}

// === Retrieve Drafts for Current User ===
$query = "SELECT draftID, subject, recipientID, scheduledSend
          FROM dbdrafts
          WHERE userID = ?
          ORDER BY scheduledSend DESC, subject ASC";

$stmt = $connection->prepare($query);
$stmt->bind_param("s", $userId);
$stmt->execute();
$result = $stmt->get_result();

$drafts = [];
while ($row = $result->fetch_assoc()) {
    $drafts[] = $row;
}

$stmt->close();
mysqli_close($connection);
?>

<!DOCTYPE html>
<html>
<head>
    <?php require_once('universal.inc'); ?>
    <title>Whiskey Valor | Email Drafts</title>
    <link href="css/base.css" rel="stylesheet">
    <style>
        .drafts-container {
            margin: 2rem auto;
            width: 90%;
            max-width: 1000px;
            font-family: Arial, sans-serif;
        }

        h1 {
            margin-bottom: 1rem;
            color: #333;
            text-align: center;
        }

        .drafts-table {
            width: 100%;
            border-collapse: collapse;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        .drafts-table th, .drafts-table td {
            padding: 12px 15px;
            text-align: left;
        }

        .drafts-table th {
            background-color: #2c3e50;
            color: white;
            font-weight: 600;
        }

        .actions a {
            text-decoration: none;
            padding: 5px 12px;
            margin-right: 5px;
            border-radius: 5px;
            font-size: 0.9rem;
            transition: all 0.2s ease;
        }

        .actions .btn-edit {
            background-color: #3498db;
            color: white;
        }

        .actions .btn-edit:hover {
            background-color: #217dbb;
        }

        .actions .btn-delete {
            background-color: #e74c3c;
            color: white;
        }

        .actions .btn-delete:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>
    <?php require_once('header.php'); ?>

    <div class="drafts-container">
        <h1>Your Drafts</h1>

        <?php echo $message; ?>

        <?php if (empty($drafts)): ?>
            <p>No drafts found.</p>
        <?php else: ?>
            <table class="drafts-table">
                <thead>
                    <tr>
                        <th>Subject</th>
                        <th>Recipients</th>
                        <th>Scheduled Send</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($drafts as $draft): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($draft['subject']); ?></td>
                            <td><?php echo htmlspecialchars($draft['recipientID']); ?></td>
                            <td><?php echo htmlspecialchars($draft['scheduledSend'] ?? '—'); ?></td>
                            <td class="actions">
                                <a class="btn-edit" href="editDrafts.php?id=<?php echo $draft['draftID']; ?>">Edit</a>
                                <a class="btn-send" href="sendDraft.php?id=<?php echo $draft['draftID']; ?>" onclick="return confirm('Send this draft now?');">Send</a>
                                <a class="btn-delete" href="?delete=<?php echo $draft['draftID']; ?>" onclick="return confirm('Delete this draft?');">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>


