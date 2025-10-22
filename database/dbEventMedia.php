<?php

require_once('database/dbinfo.php');
include_once(dirname(__FILE__).'/../domain/Event.php');
// include_once(dirname(__FILE__).'/../domain/Animal.php');
date_default_timezone_set("America/New_York");


function add_eventmedia($eventmedia) {
    $con = connect();
    $query = "SELECT * FROM dbeventmedia WHERE id = '" . $eventmedia->getID() . "'";
    $result = mysqli_query($con, $query);

    //if there's no entry for this id, add it
    if ($result === false || mysqli_num_rows($result) == 0) {
        mysqli_query($con, 'INSERT INTO dbeventmedia VALUES("' .
            $eventmedia->getID() . '","' .
            $eventmedia->getEventID() . '","' .
            $eventmedia->getFileName() . '","' .
            $eventmedia->getType() . '","' .
            $eventmedia->getFileFormat() . '","' .
            $eventmedia->getDescription() . '","' .
            $eventmedia->getTimeCreated() . '");');
        mysqli_close($con);
        return true;
    }

    mysqli_close($con);
    return false;
}


function get_eventmedia($eventID) {
    $query = "select * from dbeventmedia
              where eventID='$eventID'
              order by prioritylevel time_created";
    $connection = connect();
    $result = mysqli_query($connection, $query);
    if (!$result) {
        mysqli_close($connection);
        return null;
    }
}

