<?php
session_cache_expire(30);
session_start();
ini_set("display_errors", 1);
error_reporting(E_ALL);

require_once(__DIR__ . '/database/dbinfo.php');
require_once('include/input-validation.php');
require_once('email.php'); // Your email functions

// Check login
if (!isset($_SESSION['_id'])) {
    header('Location: login.php');
    exit;
}

// Only admins can send drafts
if ($_SESSION['access_level'] < 2) {
    echo "<div class='error-toast'>You do not have permission to send emails.</div>";
    exit();
}

if (!isset($_GET['id'])) {
    header('Location: drafts.php');
    exit();
}

$draftId = intval($_GET['id']);
$userId = $_SESSION['_id'];
$connection = connect();

// Retrieve draft
$stmt = $connection->prepare("SELECT subject, recipientID, body FROM dbdrafts WHERE draftID = ? AND userID = ?");
$stmt->bind_param("is", $draftId, $userId);
$stmt->execute();
$result = $stmt->get_result();
$draft = $result->fetch_assoc();
$stmt->close();

if (!$draft) {
    mysqli_close($connection);
    header('Location: drafts.php?msg=Draft+not+found');
    exit();
}

// Determine recipients
$recipients = explode(',', $draft['recipientID']); // Assuming CSV of emails or IDs
$recipients = array_map('trim', $recipients); // Clean spaces

// Optional: if recipientID are numeric IDs, fetch emails from dbpersons
foreach ($recipients as &$r) {
    if (is_numeric($r)) {
        $stmt = $connection->prepare("SELECT email FROM dbpersons WHERE id = ?");
        $stmt->bind_param("i", $r);
        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res->fetch_assoc();
        $r = $row['email'] ?? null;
        $stmt->close();
    }
}
// Remove invalid/null emails
$recipients = array_filter($recipients, fn($email) => filter_var($email, FILTER_VALIDATE_EMAIL));

if (empty($recipients)) {
    mysqli_close($connection);
    header('Location: drafts.php?msg=No+valid+recipients');
    exit();
}

// Send the email
$results = sendEmails($recipients, 'WhiskeyValorAdmin', $draft['subject'], $draft['body']);

// Optional: Update draft as sent
$stmt = $connection->prepare("UPDATE dbdrafts SET sent_at = NOW() WHERE draftID = ?");
$stmt->bind_param("i", $draftId);
$stmt->execute();
$stmt->close();

mysqli_close($connection);

// Prepare feedback message
$successCount = count(array_filter($results));
$failureCount = count($results) - $successCount;

header("Location: drafts.php?msg=Sent+$successCount+emails,+$failureCount+failed");
exit();
