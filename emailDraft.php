<?php
session_start();
include_once('database/dbinfo.php');
include_once('email.php'); // must contain sendEmails()

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

// --------------------------------------------------------
// Load specific draft when ?draft_id=###
// --------------------------------------------------------
if (isset($_GET['draft_id'])) {
    $draftID = intval($_GET['draft_id']);
    $stmt = $conn->prepare("SELECT * FROM dbdrafts WHERE draftID = ?");
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

// --------------------------------------------------------
// Send loaded draft
// --------------------------------------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['send_draft'])) {

    $draftID = intval($_POST['draftID']);
    $recipientID = $_POST['recipientID'];
    $subject = $_POST['subject'];
    $body = $_POST['body'];

    // Retrieve recipient’s email if it's a person ID
    $stmt = $conn->prepare("SELECT email FROM dbpersons WHERE id = ?");
    $stmt->bind_param("s", $recipientID);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($row = $res->fetch_assoc()) {
        $emailList = [$row['email']];
    } else {
        $message = "Recipient not found.";
        $emailList = [];
    }

    $stmt->close();

    if (!empty($emailList)) {
        $results = sendEmails($emailList, $subject, $body);

        if ($results['success']) {
            $message = "Draft sent successfully!";
        } else {
            $message = "Some emails failed to send.";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Email Drafts</title>
</head>
<body>
<h1>Email Drafts</h1>

<?php if ($message): ?>
    <div style="font-weight:bold; color:green;"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<!-- -----------------------------------------------------
     LIST ALL DRAFTS
-------------------------------------------------------- -->
<h3>Saved Drafts</h3>
<?php
$stmt = $conn->prepare("SELECT draftID, recipientID, subject FROM dbdrafts ORDER BY draftID DESC");
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<p>No drafts found.</p>";
} else {
    while ($row = $result->fetch_assoc()) {
        $id = $row['draftID'];
        $recipient = htmlspecialchars($row['recipientID']);
        $subjectDisplay = htmlspecialchars($row['subject']);

        echo "<div>
                <a href='?draft_id=$id'>
                    Draft #$id — To: $recipient — $subjectDisplay
                </a>
              </div>";
    }
}
$stmt->close();
?>

<!-- -----------------------------------------------------
     DISPLAY LOADED DRAFT
-------------------------------------------------------- -->
<?php if ($selectedDraft): ?>
    <h3>Editing Draft #<?= htmlspecialchars($selectedDraft) ?></h3>

    <form method="POST">

        <input type="hidden" name="draftID" value="<?= htmlspecialchars($selectedDraft) ?>">

        <label>Recipient ID:</label>
        <input type="text" name="recipientID" value="<?= htmlspecialchars($recipientID) ?>" readonly>

        <label>Subject:</label>
        <input type="text" name="subject" value="<?= htmlspecialchars($subject) ?>" required>

        <label>Body:</label>
        <textarea name="body" rows="10" required><?= htmlspecialchars($body) ?></textarea>

        <button type="submit" name="send_draft">Send Draft</button>
    </form>
<?php endif; ?>

</body>
</html>

