<?php
    session_cache_expire(30);
    session_start();
    ini_set("display_errors",1);
    error_reporting(E_ALL);
    if(!isset($_SESSION['_id'])) {
        header('Location: login.php');
        die();
    }

    require_once(dirname(__FILE__).'/email.php');
    require('include/input-validation.php');
    

    function submitEmail(array $names, $emailSubject, $emailBody, $sendNow, $sendTime)
    {
        error_log("--- New Email Submission ---");
        error_log("Subject: " . $emailSubject);
        error_log("Body: " . $emailBody);
        error_log("Send Now: " . ($sendNow ? 'Yes' : 'No'));
        if (!$sendNow) {
            //TODO: Add logic for interfacing with scheduler.
            error_log("Send Time: " . $sendTime);
        }else
        {
            sendEmails(retrieveAllEmails(),"WhiskeyValorAdmin", $emailSubject, $emailBody);
        }
        error_log("Recipients: " . implode(', ', $names));
        error_log("--------------------------");

        // Return true on success or false on failure
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
        $recipientName = $_POST['recipientFullName'] ?? ''; // Only used if 'specific'

   
        $sendNow = ($sendNowStr === 'true'); // Convert string to boolean
        
        $names = [];
        if ($recipientsType == 'specific') {
            if (!empty($recipientName)) {
                $names[] = $recipientName;
            }
        } else {
            $names[] = "All Whiskey Valor Members"; 
        }

       
        if (empty($subject)) {
             $submissionMessage = "<div class='error-toast'>Email Subject is required.</div>";
        } else if (empty($names)) {
             $submissionMessage = "<div class='error-toast'>At least one recipient is required.</div>";
        } else {
           
            $success = submitEmail($names, $subject, $content, $sendNow, $sendTime);

            if ($success) {
                $submissionMessage = "<div class='success-toast'>Email has been created successfully!</div>";
            } else {
                $submissionMessage = "<div class='error-toast'>There was an error creating the email.</div>";
            }
        }
    }
?>
?>

<!DOCTYPE html>
<html>
    <head>
        <?php require_once('universal.inc'); ?>
        <title>Whiskey Valor | View Application</title>
        <link src="css/base.css" rel="stylesheet">
 
 
    </head>
    <body>
        <?php require_once('header.php'); 

        if(!$isAdmin): ?> 
            <div class="error-toast">You do not have permission to view this page.</div></body>
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
                   <option value="false">No</option> 
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

                <input type="submit" value="Create Email.">
            </form>

        <?php endif ?>
    </body>


</html>