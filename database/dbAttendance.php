<?php

include_once("dbinfo.php");


//TODO: Constain parameter data types fr
/**
 * Creates an insert for the user which attended/did not attend the event.
 * @param mixed $eventId The id for the event in which we are tallying attendance for.
 * @param mixed $loggingId The username of the user which logged the $userId's attendance.
 * @param mixed $userId The username of the user which we are marking as present.
 * @param bool $present True if present, false if absent.
 * @param mixed $comments Any comments the organizer/admin may have.
 * @return bool Returns whether or not the function was successful.
 */
function logAttendance($eventId, $loggingId, $userId, bool $present, $comments): bool
{
    $connection = connect();
    //Check if attendance log exists.
    //ideally we're getting the $eventId from the event's page. I want to SLAM an attendance menu into viewEvent so maybe I write the ID to session?
    $verificationQuery = 'SELECT * FROM dbattendance WHERE eventId = ' . $eventId . 'AND userId = ' .  $userId . ';';
    $verifyResult = mysqli_query($connection,$verificationQuery);
    if ($verifyResult == null || mysqli_num_rows($verifyResult) ==0)
    {
        //Build insert Query
        $insertQuery = 'INSERT INTO dbattendance VALUES('. $eventId . ', ' . $userId . ', ' . $loggingId . ', ' . $present . ', ' . $comments .');'; 
        mysqli_query($connection,$insertQuery);
        return TRUE;
    }elseif(mysqli_num_rows($verifyResult) == 1) //There is, as there should be, only 1 row.
    {
        
        //Attendance exists so update entry. 
        $updateQuery = 'UPDATE dbattendance SET attended = ' . $present . ' WHERE id == ' . mysqli_fetch_row($verifyResult)['id']  .';';
        mysqli_query($connection,$updateQuery);
        return TRUE;
    }else //ERROR There are more than 1 rows returned
    {
        return FALSE;
    }
        
    //Close connection
}

/**
 * Gets all users registered for the event supplied by $eventId and checks them against that event in dbattendance. Marks all registered users who have not been marked as attending as not present.
 * @param mixed $eventId The id for the event in which we are tallying attendance for.
 * @param mixed $comments Any comments the organizer/admin may have.
 * @return bool Returns whether or not the function was successful.
 */
function logAllNotPresent($eventId, $comments): bool
{

}
?>