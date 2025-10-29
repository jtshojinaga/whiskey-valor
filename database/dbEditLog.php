<?php

//Add a log to the database.

require_once(dirname(__FILE__) ."../domain/logEntry.php");
include_once("dbinfo.php");

    /**
     * Takes in a logEntry object and inserts it into the EditLog database
     * @param logEntry $in_log the incomming log-object to be added to the database.
     * @return bool Returns true if the process was successful.
     */
    function newLogEntry(logEntry $in_log): bool
    {
        
        $connection = connect();
        return true;
    }

?>