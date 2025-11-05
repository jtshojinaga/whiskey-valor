<?php
session_cache_expire(30);
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
ini_set("display_errors", 1);
error_reporting(E_ALL);

require_once(dirname(__FILE__).'/email.php');
require('include/input-validation.php');

// --- Access Control ---
if (!isset($_SESSION['_id'])) {
    header('Location: login.php');
    exit;
}

$isAdmin = $_SESSION['access_level'] >= 2;
$submissionMessage = '';

/**
 * Convert a full name into user ID.
 * @param string $fullName
 * @return int|null
 */
function getUserIdByFullName(string $fullName): ?string {
    include_once('database/dbinfo.php');
    $conn = connect();

    $parts = explode(' ', trim($fullName), 2); // Split into first + last name
    if (count($parts) < 2) return null;
    [$firstName, $lastName] = $parts;

    $stmt = $conn->prepare("SELECT id FROM dbpersons WHERE first_name = ? AND last_name = ? LIMIT 1");
    $stmt->bind_param("ss", $firstName, $lastName);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();
    $conn->close();

    return $row['id'] ?? null;
}

/**
 * Submit an email (send now or schedule)
 */
function submitEmail(array $userIds, string $subject, string $body, bool $sendNow, $sendTime) {
    error_log("--- New Email Submission ---");
    error_log("Subject: " . $subject);
    error_log("Send Now: " . ($sendNow ? 'Yes' : 'No'));

    // Determine recipients
    if (empty($userIds) || in_array("All Whiskey Valor Members", $userIds)) {
        $recipients = retrieveAllEmails(); // all emails
    } else {
        $recipients = retrieveAllEmails($userIds); // specific user IDs
    }

    if ($sendNow) {
        sendEmails($recipients, "WhiskeyValorAdmin", $subject, $body);
        echo("<p>Emails Sent!</p>");
    } else {
        // Scheduled logic: you can implement cron/scheduler here
        error_log("Scheduled for: " . $sendTime);
    }

    error_log("Recipients: " . implode(', ', $recipients));
    error_log("--------------------------");

    return true;
}

// --- Form Processing ---
if ($isAdmin && $_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'] ?? 'send'; // send or draft
    $subject = $_POST['subject'] ?? '';
    $body = $_POST['content'] ?? '';
    $sendNow = ($_POST['scheduled'] ?? 'true') === 'true';
    $sendTime = $_POST['sendTime'] ?? '';
    $recipientsType = $_POST['recipients'] ?? 'all';
    $recipientName = $_POST['recipientFullName'] ?? '';

    $userIds = [];

    if ($recipientsType == 'specific' && !empty($recipientName)) {
        $rawNames = explode(",", $recipientName);
        foreach ($rawNames as $fullName) {
            $fullName = trim($fullName);
            $userId = getUserIdByFullName($fullName);
            if ($userId !== null) {
                $userIds[] = $userId;
            }
        }
    } else {
        $userIds[] = "All Whiskey Valor Members";
    }

    if (empty($subject)) {
        $submissionMessage = "<div class='error-toast'>Email Subject is required.</div>";
    } else if (empty($userIds)) {
        $submissionMessage = "<div class='error-toast'>No valid recipients found.</div>";
    } else {
        if ($action === 'draft') {
            // --- Save Draft ---
            $connection = connect();
            $userId = $_SESSION['_id'];

            // Save user IDs as comma-separated string
            $recipientString = implode(",", $userIds);

            // Convert datetime-local to Y-m-d H:i:s for scheduledSend
            $sendDate = !empty($sendTime) ? date('Y-m-d H:i:s', strtotime($sendTime)) : date('Y-m-d H:i:s');

            $stmt = $connection->prepare("
                INSERT INTO dbdrafts (userID, recipientID, subject, body, scheduledSend)
                VALUES (?, ?, ?, ?, ?)
            ");
            $stmt->bind_param("sssss", $userId, $recipientString, $subject, $body, $sendDate);

            if ($stmt->execute()) {
                $submissionMessage = "<div class='success-toast'>Draft saved successfully!</div>";
            } else {
                $submissionMessage = "<div class='error-toast'>Failed to save draft: " . htmlspecialchars($stmt->error) . "</div>";
            }

            $stmt->close();
            mysqli_close($connection);
        } else {
            // --- Send Email ---
            $success = submitEmail($userIds, $subject, $body, $sendNow, $sendTime);

            if ($success) {
                $submissionMessage = "<div class='success-toast'>Email has been sent successfully!</div>";
            } else {
                $submissionMessage = "<div class='error-toast'>There was an error sending the email.</div>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <?php require_once('universal.inc'); ?>
    <title>Whiskey Valor | Create Email</title>
    <link href="css/base.css" rel="stylesheet">
    <style>
        .btn-send { background-color: #27ae60; color: white; padding: 8px 16px; margin-right: 5px; }
        .btn-draft { background-color: #3498db; color: white; padding: 8px 16px; }
    </style>
</head>
<body>
<?php require_once('header.php'); ?>

<?php if (!$isAdmin): ?>
    <div class="error-toast">You do not have permission to view this page.</div>
<?php else: ?>

    <?php echo $submissionMessage; ?>

    <form action="" method="POST">
        <label for="subject">* Email Subject</label>
        <input type="text" id="subject" name="subject" required>

        <label for="content">Email Body</label>
        <textarea id="content" name="content" rows="10"></textarea>

        <label for="scheduled">Send Now?</label>
        <select name="scheduled" id="scheduled">
            <option value="true">Yes</option>
            <option value="false">No (Schedule for later)</option>
        </select>

        <div id="selectorTime" style="display:none;">
            <label for="sendTime">When should the email be sent?</label>
            <input type="datetime-local" id="sendTime" name="sendTime">
        </div>

        <label for="recipients">Recipients</label>
        <select name="recipients" id="recipients">
            <option value="all">All Whiskey Valor Members</option>
            <option value="specific">Specific Users</option>
        </select>

        <div id="selectorRecipients" style="display:none;">
            <label for="recipientFullName">User Full Name (comma-separated)</label>
            <input type="text" id="recipientFullName" name="recipientFullName">
        </div>

        <!-- Buttons -->
        <button type="submit" name="action" value="send" class="btn-send">Send / Schedule Email</button>
        <button type="submit" name="action" value="draft" class="btn-draft">Save as Draft</button>
    </form>

    <script>
        const recipientSelect = document.getElementById('recipients');
        const recipientsDiv = document.getElementById('selectorRecipients');
        function toggleRecipients() {
            recipientsDiv.style.display = recipientSelect.value === 'specific' ? 'block' : 'none';
        }
        recipientSelect.addEventListener('change', toggleRecipients);
        toggleRecipients();

        const scheduledSelect = document.getElementById('scheduled');
        const timeDiv = document.getElementById('selectorTime');
        function toggleTime() {
            timeDiv.style.display = scheduledSelect.value === 'false' ? 'block' : 'none';
        }
        scheduledSelect.addEventListener('change', toggleTime);
        toggleTime();
    </script>

<?php endif; ?>
</body>
</html>

