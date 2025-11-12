<?php
include_once(__DIR__ . '/../database/dbinfo.php');
include_once(__DIR__ . '/../email.php');

$conn = connect();
$now = date('Y-m-d H:i:s');

// Get all scheduled emails that need to be sent
$query = "SELECT * FROM scheduled_emails WHERE sent = 0 AND scheduledSend <= ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('s', $now);
$stmt->execute();
$result = $stmt->get_result();

while ($email = $result->fetch_assoc()) {

    // 🔍 Look up recipient's actual email address
    $recipientUsername = $email['recipientID'];
    $personQuery = $conn->prepare("SELECT email FROM dbPersons WHERE username = ?");
    $personQuery->bind_param('s', $recipientUsername);
    $personQuery->execute();
    $personResult = $personQuery->get_result();
    $person = $personResult->fetch_assoc();
    $personQuery->close();

    if (!$person) {
        // Could not find user — skip and log
        error_log("Scheduled email #{$email['id']} skipped: recipient username '{$recipientUsername}' not found.");
        continue;
    }

    $recipientEmail = $person['email'];

    // Send the email
    $success = sendEmails(
        [$recipientEmail],
        $email['userID'],     // Sender’s username (from_user)
        $email['subject'],
        $email['body']
    );

    // If it was sent successfully, mark as sent
    if (!empty($success[$recipientEmail]) && $success[$recipientEmail] === true) {
        $update = $conn->prepare("UPDATE scheduled_emails SET sent = 1, created = NOW() WHERE id = ?");
        $update->bind_param('i', $email['id']);
        $update->execute();
        $update->close();
    } else {
        error_log("Scheduled email #{$email['id']} failed to send to {$recipientEmail}.");
    }
}

$stmt->close();
$conn->close();
?>

