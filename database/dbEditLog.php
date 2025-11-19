<?php

//Add a log to the database.

require_once(dirname(__FILE__) ."../domain/logEntry.php");
include_once("dbinfo.php");

    /**
     * Takes in a logEntry object and inserts it into the EditLog database
     * @param logEntry $in_log the incomming log-object to be added to the database.
     * @return bool Returns true if the process was successful. False if it found the log was already in the databse.
     */
    function newLogEntryfromObject(logEntry $in_log): bool
    {
        
        $connection = connect();
        //Check if entry exists:
        $query = "SELECT * FROM dbeditlogs WHERE id = '" . $in_log->getID() . "'";
        $result = mysqli_query($connection,$query);
        if ($result == null || mysqli_num_rows($result) == 0) {
            //Execute insertion.
            mysqli_query($connection, 'INSERT INTO dbeditlogs VALUES("'.
                $in_log->getId() . '","' .
                $in_log->getTimestamp() . '","' .
                $in_log->getAuthorId() . '","' .  
                $in_log->getAlterId(). '","' . 
                $in_log->getAuditType(). '","' .
                $in_log->getAuditDescription() .
                '");"');	

            mysqli_close($connection);
            return true;
            //Close the connection to teh database
            
        }
        else
        {
            //Close the connection, but this time the opperation failed(found an entry)
            mysqli_close($connection);
            return false;
        }
    }
    /**fucntion fetch_log($logId): array {

    } */
    
    function newLogEntry($operationType, $inID)
    {
        $connection = connect();
        
        $query = "INSERT INTO dbeditlog "

        $editorID = $_SESSION['_id'];

        $result = mysqli_query($connection,$query);

    }

?>