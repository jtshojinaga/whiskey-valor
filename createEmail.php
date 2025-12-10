<?php
session_cache_expire(30);
session_start();
ini_set("display_errors",1);
error_reporting(E_ALL & ~E_WARNING);
if(!isset($_SESSION['_id'])) {
    header('Location: login.php');
    die();
}

require_once(__DIR__ . '/email.php');
require_once('include/input-validation.php');
require_once(__DIR__ . '/database/dbinfo.php');
require_once(__DIR__ . '/database/dbPersons.php');

$allMembers = getUsersAndEmails();

function submitEmail(array $names, string $subject, string $body, bool $sendNow, string $sendDate, string $recipientsType): bool
{
    $conn = connect();

    // --- SEND NOW ---
    if ($sendNow) {
        $emails = retrieveAllEmails($names);
        if (empty($emails)) {
            error_log("No emails retrieved.");
            return false;
        }

        $results = sendEmails($emails, "WhiskeyValorAdmin", $subject, $body);

        if (!$results || !isset($results['success'])) {
            error_log("Invalid result from sendEmails()");
            return false;
        }

        // If failure occurred in Python
        if (!$results['success']) {
            foreach ($results['failed'] as $f) {
                error_log("Email FAILED to: " . $f['email'] . " (" . $f['error'] . ")");
            }
            return false;
        }

        // All good
        return true;
    }

    // --- SCHEDULE EMAIL ---
    if (empty($sendDate)) {
        error_log("No send date provided for scheduled email.");
        return false;
    }

    foreach ($names as $recipient) {
        $stmt = $conn->prepare("
            INSERT INTO dbscheduledemails
            (userID, recipientID, subject, body, scheduledSend, sent)
            VALUES (?, ?, ?, ?, ?, 0)
        ");

        if (!$stmt) {
            error_log("Prepare failed: " . $conn->error);
            return false;
        }

        $stmt->bind_param(
            "sssss",
            $_SESSION['_id'],
            $recipient,
            $subject,
            $body,
            $sendDate
        );

        if (!$stmt->execute()) {
            error_log("Execute failed: " . $stmt->error);
            return false;
        }
    }

    return true;
}

$isAdmin = $_SESSION['access_level'] >= 2;
$submissionMessage = '';

if ($isAdmin && $_SERVER["REQUEST_METHOD"] === "POST") {
    $subject = trim($_POST['subject'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $sendNowStr = $_POST['scheduled'] ?? 'true';
    $sendDate = $_POST['sendTime'] ?? '';
    $recipientsType = $_POST['recipients'] ?? 'all';
    $recipientName = $_POST['recipientFullName'] ?? '';

    $sendNow = ($sendNowStr === 'true');

    // Build list of names
    $names = [];
    if ($recipientsType === 'specific' && !empty($recipientName)) {
        $names = array_map('trim', explode(",", $recipientName));
    } else {
        $names[] = "All Whiskey Valor Members";
    }

    // Validate
    if (empty($subject)) {
        $submissionMessage = "<div class='error-toast'>Email Subject is required.</div>";
    } else {
        $success = submitEmail($names, $subject, $content, $sendNow, $sendDate, $recipientsType);
        if ($success) {
            $submissionMessage = "<div class='success-toast'>Email successfully sent!</div>";
        } else {
            //$submissionMessage = "<div class='error-toast'>ERROR: Email did NOT send. Check logs.</div>";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <?php require_once('universal.inc'); ?>
    <title>Whiskey Valor | Send Email</title>
    <link rel="stylesheet" href="css/base.css">
</head>
<body>
<?php require_once('header.php'); ?>

<?php if (!$isAdmin): ?>
    <div class='error-toast'>You do not have permission to view this page.</div>
<?php else: ?>

    <?= $submissionMessage ?>

    <form method="POST">
        <label for="subject">* Email Subject</label>
        <input type="text" id="subject" name="subject" required>

        <label for="content">Email Body</label>
        <textarea id="content" name="content" rows="10"></textarea>

        <label for="scheduled">Send Now?</label>
        <select name="scheduled" id="scheduled">
            <option value="true">Yes</option>
            <option value="false">No (Schedule)</option>
        </select>

        <div id="selectorTime" style="display:none;">
            <label for="sendTime">Send Date</label>
            <input type="date" id="sendTime" name="sendTime">
        </div>

        <label for="recipients">Recipients</label>
        <select name="recipients" id="recipients">
            <option value="all">All Whiskey Valor Members</option>
            <option value="specific">Specific Users</option>
        </select>

        <div id="selectorRecipients" style="display:none;">
            <label for="recipientFullName">Select Member</label>
            <select id="recipientFullName" name="recipientFullName">
                <option value="">-- Select a Member --</option>
                <?php foreach ($allMembers as $m): ?>
                    <option value="<?= htmlspecialchars($m['value']) ?>">
                        <?= htmlspecialchars($m['label']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <input type="submit" value="Create Email">
    </form>

    <script>
        const scheduledSelect = document.getElementById('scheduled');
        const timeDiv = document.getElementById('selectorTime');
        const sendTimeInput = document.getElementById('sendTime');
        const recipientsSelect = document.getElementById('recipients');
        const recipientsDiv = document.getElementById('selectorRecipients');

        function toggleTime() {
            const sendNow = scheduledSelect.value === 'true';
            timeDiv.style.display = sendNow ? 'none' : 'block';
            sendTimeInput.required = !sendNow;
        }

        function toggleRecipients() {
            recipientsDiv.style.display = recipientsSelect.value === 'specific' ? 'block' : 'none';
        }

        scheduledSelect.addEventListener('change', toggleTime);
        recipientsSelect.addEventListener('change', toggleRecipients);
        document.addEventListener('DOMContentLoaded', () => { toggleTime(); toggleRecipients(); });
    </script>

<?php endif; ?>
</body>
</html>