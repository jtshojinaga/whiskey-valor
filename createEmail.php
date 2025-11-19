<?php
session_cache_expire(30);
session_start();
ini_set("display_errors",1);
error_reporting(E_ALL & ~E_WARNING);
if(!isset($_SESSION['_id'])) {
    header('Location: login.php');
    die();
}

require_once(dirname(__FILE__).'/email.php');
require('include/input-validation.php');

function submitEmail(array $names, $emailSubject, $emailBody, $sendNow, $sendTime, $recipientsType)
{
    error_log("--- New Email Submission ---");
    error_log("Subject: " . $emailSubject);
    error_log("Body: " . $emailBody);
    error_log("Send Now: " . ($sendNow ? 'Yes' : 'No'));
    if (!$sendNow) {
        error_log("Send Time: " . $sendTime);
    } else {
        sendEmails(retrieveAllEmails($names),"WhiskeyValorAdmin", $emailSubject, $emailBody);
        echo("<p>Emails Sent!</p>");
    }
    error_log("Recipients: " . implode(', ', $names));
    error_log("--------------------------");
    return true;
}

$isAdmin = $_SESSION['access_level'] >= 2;
$submissionMessage = '';

if ($isAdmin && $_SERVER["REQUEST_METHOD"] == "POST") 
{
    $subject = $_POST['subject'] ?? '';
    $content = $_POST['content'] ?? '';
    $sendNowStr = $_POST['scheduled'] ?? 'true'; 
    $sendTime = $_POST['sendTime'] ?? '';
    $recipientsType = $_POST['recipients'] ?? 'all';
    $recipientName = $_POST['recipientFullName'] ?? '';

    $sendNow = ($sendNowStr === 'true');
    
    $names = [];
    if ($recipientsType == 'specific') {
        if (!empty($recipientName)) {
            $names = explode(",", $recipientName);
        }
    } else {
        $names[] = "All Whiskey Valor Members"; 
    }

    if (empty($subject)) {
        $submissionMessage = "<div class='error-toast'>Email Subject is required.</div>";
    } else if (empty($names)) {
        $submissionMessage = "<div class='error-toast'>At least one recipient is required.</div>";
    } else {
        $success = submitEmail($names, $subject, $content, $sendNow, $sendTime, $recipientsType);

        if ($success) {
            $submissionMessage = "<div class='success-toast'>Email has been created successfully!</div>";
        } else {
            $submissionMessage = "<div class='error-toast'>There was an error creating the email.</div>";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <?php require_once('universal.inc'); ?>
    <title>Whiskey Valor | View Application</title>
    <link src="css/base.css" rel="stylesheet">
    <style>
        .modal-backdrop{position:fixed;inset:0;background:rgba(0,0,0,.45);display:none;align-items:center;justify-content:center;z-index:9999}
        .modal{background:#1f1f1f;color:#fff;max-width:460px;width:90%;border-radius:12px;box-shadow:0 10px 30px rgba(0,0,0,.4);padding:22px}
        .modal h3{margin:0 0 10px 0;font-size:18px}
        .modal p{margin:0 0 18px 0;line-height:1.4}
        .modal .actions{display:flex;gap:10px;justify-content:flex-end}
        .btn{border:0;border-radius:8px;padding:10px 14px;font-size:14px;cursor:pointer}
        .btn-primary{background:#2b6cb0;color:#fff}
        .btn-danger{background:#e53e3e;color:#fff}
        .btn-ghost{background:#2a2a2a;color:#ddd}
    </style>
</head>
<body>
    <h1 style="color:white;">Create New Email</h1>
<?php 
    $__old = error_reporting(E_ALL & ~E_WARNING);
    require_once('header.php'); if(!$isAdmin): ?> 
    error_reporting($__old);

    if(!$isAdmin): ?> 
        <div class="error-toast">You do not have permission to view this page.</div>
</body>
<?php else: ?>

    <?php echo $submissionMessage; ?>

    <form id="emailForm" action="" method="POST">
        <div class="section-box" style="width:80%;margin:auto;">
            <label for="subject"><em>*</em> Email Subject</label>
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
                <label for="recipientFullName">User Full Name</label>
                <input type="text" id="recipientFullName" name="recipientFullName">
            </div>

            <input type="submit" id="createEmailBtn" value="Create Email" style="width:100%;">
        </div>
    </form>

    <div id="confirmModal" class="modal-backdrop" aria-hidden="true">
        <div class="modal" role="dialog" aria-modal="true" aria-labelledby="confirmTitle">
            <h3 id="confirmTitle">Are you sure you want to send this email?</h3>
            <p>You can choose to send anyway or cancel.</p>
            <div class="actions">
                <button type="button" id="cancelSend" class="btn btn-ghost">Cancel</button>
                <button type="button" id="confirmSend" class="btn btn-primary">Send Anyway</button>
            </div>
        </div>
    </div>

    <script>
        const recipientSelect = document.getElementById('recipients');
        const recipientsDiv = document.getElementById('selectorRecipients');
        function toggleRecipients() {
            recipientsDiv.style.display = (recipientSelect.value === 'specific') ? 'block' : 'none';
        }
        recipientSelect.addEventListener('change', toggleRecipients);
        toggleRecipients();

        const scheduledSelect = document.getElementById('scheduled');
        const timeDiv = document.getElementById('selectorTime');
        function toggleTime() {
            timeDiv.style.display = (scheduledSelect.value === 'false') ? 'block' : 'none';
        }
        scheduledSelect.addEventListener('change', toggleTime);
        toggleTime();

        const form = document.getElementById('emailForm');
        const modal = document.getElementById('confirmModal');
        const confirmBtn = document.getElementById('confirmSend');
        const cancelBtn = document.getElementById('cancelSend');
        let allowSubmit = false;

        form.addEventListener('submit', function(e){
            if (allowSubmit) return;
            e.preventDefault();
            modal.style.display = 'flex';
        });

        cancelBtn.addEventListener('click', function(){
            modal.style.display = 'none';
        });

        confirmBtn.addEventListener('click', function(){
            modal.style.display = 'none';
            allowSubmit = true;
            form.submit();
        });
    </script>

<?php endif ?>
</body>
</html>
