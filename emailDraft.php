<?php
session_start();
include_once('database/dbinfo.php');
include_once('email.php');

// Optional: restrict access
if (!isset($_SESSION['_id'])) {
    die("Access denied. Please log in.");
}

$conn = connect();
$message = "";
$selectedDraft = null;
$subject = "";
$body = "";
$recipientID = "";
$draftID = "";

// If a user selects a draft to view
if (isset($_GET['draft_id'])) {
    $draftID = intval($_GET['draft_id']);
    $stmt = $conn->prepare("SELECT * FROM dbdrafts WHERE userId = ?");
    $stmt->bind_param("i", $draftID);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $selectedDraft = $draftID;
        $recipientID = $row['recipientID'];
        $subject = $row['subject'];
        $body = $row['body'];
    } else {
        $message = "Draft not found.";
    }
    $stmt->close();
}

// If a user sends the selected draft
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['send_draft'])) {
    $draftID = intval($_POST['draftID']);
    $recipientID = $_POST['recipientID'];
    $subject = $_POST['subject'];
    $body = $_POST['body'];
    $fromUser = "WhiskeyValorAdmin"; // you can make this dynamic later

    switch ($recipientID) {
        case 'volunteer': $results = emailVolunteer($fromUser, $subject, $body); break;
        case 'admin': $results = emailAdmin($fromUser, $subject, $body); break;
        case 'board': $results = emailBoardMember($fromUser, $subject, $body); break;
        case 'donor': $results = emailDonor($fromUser, $subject, $body); break;
        case 'participant': $results = emailParti($fromUser, $subject, $body); break;
        case 'all': $results = emailAll($fromUser, $subject, $body); break;
        default:
            $results = [];
            $message = "Custom or unknown recipient type not handled here.";
            break;
    }

    $successCount = count(array_filter($results));
    $failCount = count($results) - $successCount;
    $message = "Sent {$successCount} emails successfully, {$failCount} failed.";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Email Drafts</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 900px;
            margin: 2rem auto;
            background: #f5f5f5;
            padding: 2rem;
            border-radius: 8px;
        }
        h1 { text-align: center; }
        .msg { margin: 1rem 0; font-weight: bold; color: green; }
        .draft-list {
            background: white;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 2rem;
            box-shadow: 0 0 5px rgba(0,0,0,0.1);
        }
        a.draft-link {
            display: block;
            padding: 6px;
            border-bottom: 1px solid #eee;
            color: #0066cc;
            text-decoration: none;
        }
        a.draft-link:hover { background: #eef; }
        textarea, input, select {
            width: 100%;
            padding: 10px;
            margin-top: 8px;
            margin-bottom: 15px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }
        button {
            background-color: #0066cc;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
        button:hover { background-color: #004999; }
    </style>
</head>
<body>
    <h1>View & Send Email Drafts</h1>

    <?php if ($message): ?>
        <div class="msg"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <div class="draft-list">
        <h3>Saved Drafts</h3>
        <?php
        $stmt = $conn->prepare("SELECT userId, recipientID, subject, scheduledSend FROM dbdrafts ORDER BY userId DESC");
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            echo "<p>No drafts found.</p>";
        } else {
            while ($row = $result->fetch_assoc()) {
                $id = $row['userId'];
                $recipient = htmlspecialchars($row['recipientID']);
                $subjectDisplay = htmlspecialchars($row['subject']);
                $date = $row['scheduledSend'] ?: "No date";
                echo "<a class='draft-link' href='?draft_id=$id'>
                        [To: $recipient] $subjectDisplay — <small>$date</small>
                      </a>";
            }
        }
        $stmt->close();
        ?>
    </div>

    <?php if ($selectedDraft): ?>
        <form method="POST">
            <h3>Loaded Draft #<?= htmlspecialchars($selectedDraft) ?></h3>

            <input type="hidden" name="draftID" value="<?= htmlspecialchars($selectedDraft) ?>">

            <label for="recipientID">Recipient Group:</label>
            <input type="text" id="recipientID" name="recipientID"
                value="<?= htmlspecialchars($recipientID) ?>" readonly>

            <label for="subject">Subject:</label>
            <input type="text" id="subject" name="subject"
                value="<?= htmlspecialchars($subject) ?>" required>

            <label for="body">Body:</label>
            <textarea id="body" name="body" rows="10" required><?= htmlspecialchars($body) ?></textarea>

            <button type="submit" name="send_draft">Send This Draft</button>
        </form>
    <?php endif; ?>
</body>
</html>
