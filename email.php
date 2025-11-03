<?php

/**
*  
*  FUNCTIONS USED FOR SENDNING EMAILS
*  WILL NOT FUNCTION XAMPP ONLY ON SITEGROUND
*  getEmailByType() + getAllEmails()  sendEmails() are helper functions 
*  but are left non-private to allow for using them if needed/being lazy
*  emailing should only be done through the email***() functions
*  sending emails is done through the php function mail()
*  
**/


/**
 * Fetch all emails from dbpersons matching a given type.
 *
 * @param string $type  e.g. 'volunteer', 'admin', 'board', 'donator', 'participant'
 * @return array       List of email strings
 */

function getEmailsByType(string $type): array {
    include_once('database/dbinfo.php');
    $conn = connect();
    $stmt = $conn->prepare("SELECT email FROM dbpersons WHERE type = ?");
    $stmt->bind_param('s', $type);
    $stmt->execute();
    $res = $stmt->get_result();
    $emails = [];
    while ($row = $res->fetch_assoc()) {
        $emails[] = $row['email'];
    }
    $stmt->close();
    $conn->close();
    return $emails;
}

/**
 * Fetch every email in dbpersons.
 *
 * @return array
 */
function getAllEmails(): array {
    include_once('database/dbinfo.php');
    $conn = connect();
    $res  = $conn->query("SELECT email FROM dbpersons");
    $emails = [];
    while ($row = $res->fetch_assoc()) {
        $emails[] = $row['email'];
    }
    $conn->close();
    return $emails;
}

/**
 * Send emails to all volunteers.
 */
function emailVolunteer(string $fromUser, string $subject, string $body): array {
    $list = getEmailsByType('volunteer');
    return sendEmails($list, $fromUser, $subject, $body);
}

/**
 *  EACH EMAIL TYPE IS A SEPERATE FUNCTION TO REQUIRE 1 LESS PARAM AND INCREASE READIBILITY
 **/
function emailAdmin(string $fromUser, string $subject, string $body): array {
    $list = getEmailsByType('admin');
    return sendEmails($list, $fromUser, $subject, $body);
}

function emailBoardMember(string $fromUser, string $subject, string $body): array {
    $list = getEmailsByType('board');
    return sendEmails($list, $fromUser, $subject, $body);
}

function emailDonor(string $fromUser, string $subject, string $body): array {
    $list = getEmailsByType('donor');
    return sendEmails($list, $fromUser, $subject, $body);
}

function emailParti(string $fromUser, string $subject, string $body): array {
    $list = getEmailsByType('participant');
    return sendEmails($list, $fromUser, $subject, $body);
}

function emailAll(string $fromUser, string $subject, string $body): array {
    $list = getAllEmails();
    return sendEmails($list, $fromUser, $subject, $body);
}

/**
 * Send emails to each address in the supplied list.
 *  
 *  ------->MAY NEED FIELDS CHANGED BEFORE REAL PRODUCTION <-----------
 *   -------> DOMAIN WILL ALMOST CERTIANLY CHANGE IN PRODUCTION <------------ 
 *
 * @param array  $emails   List of recipient email addresses.
 * @param string $fromUser Local-part for the From address.
 * @param string $subject  Email subject.
 * @param string $body     Email body.
 * @return array           Returns an  array where keys are emails and values are boolean statuses.
 */
function sendEmails(array $emails, string $fromUser, string $subject, string $body): array {
    //I wish the site url would work since it would be prettier but it stops working after 
    //a certian amount of emails
    $domain = 'ZANNYMAIL.siteground.biz';   // <------------- NEEDS TO BE CHANGED ON LIVE PRODUCTION!!! 
    $fromAddress = "{$fromUser}@{$domain}";
    
    // Simplified headers – only include essential information.
       $headers = "From: {$fromAddress}\r\n";
    
    $results = [];
    foreach ($emails as $email) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $results[$email] = mail($email, $subject, $body, $headers);
        } else {
            $results[$email] = false;
        }
    }
    return $results;
    
    return [];
    //Commented out for the video - Jake
}



    /**
     * emailHandler takes in an event_id and a $user_id and builds an email to that user
    *This logic is ugly, maybe make it so that it takes in an array of id's to bulk make emails and lessen the strain for SQL calls?
    *
    * @param int $event_id The ID of the event which this email may pertain to.
    * @param int $user_id The ID of the user which this email is being sent to.
    * @param int $emailType A numeric representation of the type of email that we are handling. 1: Removed from event. 2: Approved to attend an event. NOTE: Please add to this list as you edit this section!
    * @param string $actionJustification The justification for the action being done. E.g. Why the user was removed from an event.
    * @return bool If the emailHandler returns false then there was an error which occured. 
    */
    function emailHandler($event_id, $user_id, int $emailType, string $actionJustification): bool
    {

        list($eventName, $userName, $userEmail) = retrieveInformation($user_id, $event_id);
        //Create the type of email.
        $emailContents = ""; 
        $emailSubject = "";
        if  ($emailType == 1) //Removed from an event
        {
            $emailContents = removalEmailBuilder($eventName, $userName, $actionJustification);
            $emailSubject = "Removed from " . $eventName . ".";
        } if ($emailType == 2) //Approved for an event
        {
            //$emailContents = approvalEmailBuilder($eventName, $userName, $actionJustification);
            $emailSubject = "Approved for " . $eventName . ".";
        }


        //Make sure that $emailContents has content:
        if ($emailContents == "")
        {
            return(false);
        }

        //Send the email
        sendEmails([$userEmail], "WhiskeyValorAdmin", $emailSubject, $emailContents);
        return(true);
       
    }

   
    //Email Handler tools below here
    function retrieveInformation($user_id, $event_id): array   
    {
        //event name Queries
        $connection = connect();

        $sql1 = "SELECT name FROM dbevents WHERE id = ?";
        $stmt1 = mysqli_prepare($connection, $sql1);

        // Bind the $event_id variable to the placeholder
        mysqli_stmt_bind_param($stmt1, "i", $event_id);

        // Execute the statement
        mysqli_stmt_execute($stmt1);
        $result1 = mysqli_stmt_get_result($stmt1);

        // Fetch the data
        $eventRow = mysqli_fetch_assoc($result1);
        $eventName = $eventRow['name']; //Holds event name


        //user info queries

        // Prepare a single query for all user data
        $sql2 = "SELECT email, first_name, last_name FROM dbpersons WHERE id = ?";
        $stmt2 = mysqli_prepare($connection, $sql2);

        mysqli_stmt_bind_param($stmt2, "s", $user_id);

        mysqli_stmt_execute($stmt2);
        $result2 = mysqli_stmt_get_result($stmt2);
        $userRow = mysqli_fetch_assoc($result2);

        $userEmail = $userRow['email'];
        $firstName = $userRow['first_name'];
        $lastName = $userRow['last_name'];
        $userName = $firstName . " " . $lastName;
        return [$eventName, $userName, $userEmail];

    }

    /**
     * A function to get every email within Whiskey Valor.
     * @return bool|mysqli_result   an array of the emails
     */
    function retrieveAllEmails(array $inNames): array
    {  
        $emails = []; // 1. Initialize an empty array
        $connection = connect();
        $result = null;

        if($inNames[0] == "All Whiskey Valor Members"){
            //TODO: Need to add an extra clause for email preferences
            $query = "SELECT email FROM dbpersons WHERE email IS NOT NULL AND email <> ''";
            $queryPrep = mysqli_prepare($connection, $query);
            mysqli_stmt_execute($queryPrep);
            $result = mysqli_stmt_get_result($queryPrep);
            while ($row = mysqli_fetch_assoc($result)) 
            {
                $emails[] = $row['email']; // 3. Add just the email string to your array
            }
            
        }else
        {
            foreach ($inNames as $name)
            {
                //TODO: Need to add an extra clause for email preferences
               
                $trimmedName = trim($name);

                
                $nameParts = explode(' ', $trimmedName);

                //Make sure we have at least a first and last name
                if (count($nameParts) >= 2) 
                {
                    $firstName = $nameParts[0];
                    $lastName = $nameParts[1];

                    $query = "SELECT email FROM dbpersons WHERE email IS NOT NULL AND email <> '' AND first_name = ? AND last_name = ?";
                    $queryPrep = mysqli_prepare($connection, $query);
                    mysqli_stmt_bind_param($queryPrep, "ss", $firstName, $lastName);
                    mysqli_stmt_execute($queryPrep);
                    $result = mysqli_stmt_get_result($queryPrep);
                    
                    if ($row = mysqli_fetch_assoc($result)) 
                    {
                        $emails[] = $row['email'];
                    }
                
            }
        }
        
    }


        mysqli_stmt_close($queryPrep); // Good practice to close the statement
        return $emails;

    }
     
    
    //Email Builders below here!
    /** 
     * removalEmailBuilder generates a email to send to users who were removed from an event. 
     * 
     * @param string $eventName The name of the event the user was removed from.
     * @param string $userName The name of the user which was removed from said event.
     * @param string $actionJustification The justifcation for the user's removal.
     * @return string The removal email body of content.
     */
    function removalEmailBuilder(string $eventName, string $userName, string $actionJustification) :string
    {
         return "Hello, '$userName'\n You've been removed from the event: '$eventName' for the reason of: '$actionJustification'.\n If you have any questions about this removal, please reach out to an administrator.";
    }
    /** 
     * removalEmailBuilder generates a email to send to users who were removed from an event. 
     * 
     * @param string $eventName The name of the event the user was approved for.
     * @param string $userName The name of the user which was approved for said event.
     * @param string $actionJustification The justifcation for the user's approval.
     * @return string The approval email body of content.
     */
    function approvalEmailBuilder(string $eventName, string $userName, string $actionJustification):string
    {
        return "Hello, '$userName'\n You've been approved for the event: '$eventName' for the reason of: '$actionJustification'.\n If you have any questions about this approval, please reach out to an administrator.";
    }
?>
