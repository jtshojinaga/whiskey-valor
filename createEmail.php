<?php
session_cache_expire(30);
session_start();
ini_set("display_errors",1);
error_reporting(E_ALL);

// Admin check
if(!isset($_SESSION['_id'])) {
    header('Location: login.php');
    exit;
}

require_once(__DIR__ . '/database/dbinfo.php');
require_once(__DIR__ . '/database/dbPersons.php');

// Manual PHPMailer include
require_once __DIR__ . '/email/PHPMailer/PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/email/PHPMailer/PHPMailer/src/SMTP.php';
require_once __DIR__ . '/email/PHPMailer/PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// ------------------------
// Get all members for dropdown
// ------------------------
function getUsersAndEmails() {
    $conn = connect();
    $members = [];
    $res = $conn->query("SELECT id, CONCAT(first_name,' ',last_name,' (',email,')') as label FROM dbpersons ORDER BY first_name");
    while ($row = $res->fetch_assoc()) {
        $members[] = ['label' => $row['label'], 'value' => $row['id']];
    }
    return $members;
}

$allMembers = getUsersAndEmails();

function loadEnv(string $file): array {
    $env = [];
    if (!file_exists($file)) return $env;
    $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '' || strpos($line, '#') === 0) continue;
        [$key, $value] = explode('=', $line, 2);
        $env[trim($key)] = trim($value);
    }
    return $env;
}

// Load .env file
$env = loadEnv(__DIR__ . '/email/.env');

// ------------------------
// Send emails via PHPMailer
// ------------------------
function sendEmails(array $emails, string $subject, string $body): array {
    global $env; // use loaded .env variables
    $results = [];
    $success = true;

    foreach ($emails as $email) {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = $env['SMTP_HOST'];
            $mail->SMTPAuth   = true;
            $mail->Username   = $env['SMTP_USER'];
            $mail->Password   = $env['SMTP_PASS'];
            $mail->SMTPSecure = 'tls';
            $mail->Port       = $env['SMTP_PORT'];

            $mail->setFrom($env['SMTP_USER'], $env['SMTP_FROM_NAME']);
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $body;

            $mail->send();
            $results[] = ["email" => $email, "success" => true];
        } catch (Exception $e) {
            $success = false;
            $results[] = ["email" => $email, "success" => false, "error" => $mail->ErrorInfo];
        }
    }

    return ['success' => $success, 'results' => $results];
}


// ------------------------
// Retrieve emails from db
// ------------------------
function retrieveAllEmails(array $ids = []): array {
    $conn = connect();
    $emails = [];

    if (empty($ids)) {
        $res = $conn->query("SELECT id, email FROM dbpersons WHERE email IS NOT NULL AND email != ''");
        while ($row = $res->fetch_assoc()) {
            $emails[$row['id']] = $row['email'];
        }
        return $emails;
    }

    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $types = str_repeat('s', count($ids));

    $sql = "SELECT id, email FROM dbpersons WHERE id IN ($placeholders) AND email IS NOT NULL AND email != ''";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) return [];

    $params = [&$types];
    foreach ($ids as $k => $v) $params[] = &$ids[$k];
    call_user_func_array([$stmt, 'bind_param'], $params);

    $stmt->execute();
    $res = $stmt->get_result();
    while ($row = $res->fetch_assoc()) $emails[$row['id']] = $row['email'];
    $stmt->close();

    return $emails;
}

// ------------------------
// Submit or schedule email
// ------------------------
function submitEmail(array $recipientIDs, string $subject, string $body, bool $sendNow, string $sendDate, string $recipientsType): array {
    $errors = [];

    // Determine recipients
    if ($recipientsType === 'specific' && !empty($recipientIDs)) {
        $emails = retrieveAllEmails($recipientIDs);
    } else {
        $emails = retrieveAllEmails();
        $recipientIDs = array_keys($emails);
    }

    if (empty($emails)) {
        return ['success' => false, 'errors' => ["No emails found for selected recipients."]];
    }

    // Send Now
    if ($sendNow) {
        $results = sendEmails(array_values($emails), "WhiskeyValorAdmin", $subject, $body);
        if (!$results['success']) {
            foreach ($results['results'] as $f) $errors[] = "Failed to send to {$f['email']}: {$f['error']}";
            return ['success' => false, 'errors' => $errors ?: ["Unknown error sending emails"]];
        }
        return ['success' => true, 'errors' => []];
    }

    // Schedule email
    if (empty($sendDate)) return ['success' => false, 'errors' => ["Send date is required for scheduled emails."]];

    $conn = connect();
    foreach ($recipientIDs as $recipientID) {
        $stmt = $conn->prepare("
            INSERT INTO dbscheduledemails
            (userID, recipientID, subject, body, scheduledSend, sent)
            VALUES (?, ?, ?, ?, ?, 0)
        ");
        if (!$stmt) {
            $errors[] = "DB prepare failed: " . $conn->error;
            continue;
        }
        $uid = (string)$_SESSION['_id'];
        $rid = (string)$recipientID;
        $stmt->bind_param("sssss", $uid, $rid, $subject, $body, $sendDate);
        if (!$stmt->execute()) $errors[] = "Failed to schedule email for {$recipientID}: " . $stmt->error;
        $stmt->close();
    }

    return ['success' => empty($errors), 'errors' => $errors];
}

// ------------------------
// Form handling
// ------------------------
$isAdmin = $_SESSION['access_level'] >= 2;
$submissionMessage = '';

if ($isAdmin && $_SERVER["REQUEST_METHOD"] === "POST") {

    $action = $_POST['action'] ?? 'send';
    $subject = trim($_POST['subject'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $sendNowStr = $_POST['scheduled'] ?? 'true';
    $sendDate = $_POST['sendTime'] ?? '';
    $recipientsType = $_POST['recipients'] ?? 'all';
    $recipientID = $_POST['recipientID'] ?? '';

    $sendNow = ($sendNowStr === 'true');

    // Collect recipient IDs
    $recipientIDs = [];
    if ($recipientsType === 'specific' && !empty($recipientID)) {
        $recipientIDs = [$recipientID];
    }

    // ------------------------------------------------------
    // ACTION: SAVE DRAFT
    // ------------------------------------------------------
    if ($action === 'draft') {

        $conn = connect();
        $stmt = $conn->prepare("
            INSERT INTO dbdrafts (userID, subject, body, recipientID)
            VALUES (?, ?, ?, ?)
        ");

        $uid = (string)$_SESSION['_id'];

        // use the real recipientID selected from the form
        // If no recipient selected, store "all"
        $rid = $recipientID !== '' ? $recipientID : "all";


        $stmt->bind_param("ssss", 
            $uid, 
            $subject, 
            $content, 
            $rid
        );

        if (!$stmt->execute()) {
            $submissionMessage = "<div class='error-toast'>Failed to save draft: {$stmt->error}</div>";
        } else {
            $submissionMessage = "<div class='success-toast'>Draft saved!</div>";
        }

        $stmt->close();
    }


    // ------------------------------------------------------
    // ACTION: SEND (NOW / SCHEDULE)
    // ------------------------------------------------------
    else if ($action === 'send') {

        if (empty($subject)) {
            $submissionMessage = "<div class='error-toast'>Email Subject is required.</div>";
        } else {

            $result = submitEmail($recipientIDs, $subject, $content, $sendNow, $sendDate, $recipientsType);

            if ($result['success']) {
                $submissionMessage = "<div class='success-toast'>Email successfully sent/scheduled!</div>";
            } else {
                $submissionMessage = "<div class='error-toast'>Errors:<br>" . implode("<br>", $result['errors']) . "</div>";
            }
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
        <label for="recipientID">Select Member</label>
        <select id="recipientID" name="recipientID">
            <option value="">-- Select a Member --</option>
            <?php foreach ($allMembers as $m): ?>
                <option value="<?= htmlspecialchars($m['value']) ?>"><?= htmlspecialchars($m['label']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <button type="submit" name="action" value="send" class="submit-btn">Create Email</button>
    <button type="submit" name="action" value="draft" class="draft-btn">Save Draft</button>

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




