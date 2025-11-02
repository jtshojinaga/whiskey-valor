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
    //$domain = 'jenniferp161.sg-host.com';
    //$domain = 'gvam1012.siteground.biz';   // <------------- NEEDS TO BE CHANGED ON LIVE PRODUCTION!!! 
    //$fromAddress = "{$fromUser}@{$domain}";
    
    // Simplified headers – only include essential information.
       //$headers = "From: {$fromAddress}\r\n";
    
    //$results = [];
    //foreach ($emails as $email) {
        //if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            //$results[$email] = mail($email, $subject, $body, $headers);
        //} else {
            //$results[$email] = false;
        //}
    //}
    //return $results;
    return [];
    //Commented out for the video - Jake
}

    /**
     * Manual email is a function to send emails manually(wow). 
     * @param array $toPeople An array of people(NOTE: undecided if People objects or just IDs.) to which the email is addressed.
     * @param string $fromAddress The address/user/admin who is sending the email.
     * @param string $subject The subject line of the email to be mass-sent.
     * @param string $content The body of content to be sent.
     * @return bool Return true if the opperation was a success. False if there was an error durring the method.
     */
    function manualEmail(array $toPeople, string $fromAddress, string $subject, string $content): bool
    {
        //Include dbPersons because I'd like to take in an array of People(or Person Ids) to be able to seamlessly build dynamic emails.
        include_once(dirname(__FILE__).'/../database/dbPersons.php');
        
        //An array of arrays, each an entry of Address(0) and Name(1)
        $personalInfoArray = [];
        
        
        // Itterate through Addresses to get information.
        foreach($toPeople as $person)
        {
            $personName = $person->get_first_name() . " " . $person->get_last_name();
            $personAddress = $person->get_email();

            $personalInfoArray = array($personAddress, $personName);


        }

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
            $emailContents = approvalEmailBuilder($eventName, $userName, $actionJustification);
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
