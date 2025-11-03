<?php
/**
 * @version Oct 28, 2025
 * @author Kassandra Williams
 */

/* 
 * Created for Whiskey Valor
 */

include_once('dbinfo.php');
include_once(dirname(__FILE__).'/../domain/Application.php');

/*
 * add an application to dbapplications table: if already there, return false
 */

function add_app($app) {
    if (!$app instanceof Application)
        die("Error: add_app type mismatch");
    $con=connect();
    $query = "SELECT * FROM dbapplications WHERE id = '" . $app->get_id() . "'";
    $result = mysqli_query($con,$query);
    //if there's no entry for this id, add it
    if ($result == null || mysqli_num_rows($result) == 0) {
        mysqli_query($con,'INSERT INTO dbapplications VALUES("' .
                $app->get_id() . '","' .
                $app->get_user_id() . '","' .
                $app->get_event_id() . '","' .
                $app->get_status() . '","' .
                $app->get_flagged() . '","' .
                $app->get_note() .
                '");');							
        mysqli_close($con);
        return true;
    }
    mysqli_close($con);
    return false;
}

/*
 * remove an application from dbapplications table.  If already there, return false
 */

function remove_app($id) {
    $con=connect();
    $query = 'SELECT * FROM dbapplications WHERE id = "' . $id . '"';
    $result = mysqli_query($con,$query);
    if ($result == null || mysqli_num_rows($result) == 0) {
        mysqli_close($con);
        return false;
    }
    $query = 'DELETE FROM dbapplications WHERE id = "' . $id . '"';
    $result = mysqli_query($con,$query);
    mysqli_close($con);
    return true;
}


/*
 * @return an Application from dbapplication table matching a particular id.
 * if not in table, return false
 */

function retrieve_app($id) {
    $con=connect();
    $query = "SELECT * FROM dbapplications WHERE id = '" . $id . "'";
    $result = mysqli_query($con,$query);
    if (mysqli_num_rows($result) !== 1) {
        mysqli_close($con);
        return false;
    }
    $result_row = mysqli_fetch_assoc($result);
    // var_dump($result_row);
    $theApp = make_an_app($result_row);
//    mysqli_close($con);
    return $theApp;
}


function make_an_app($result_row) {
    $theApp = new Application(
                    $result_row['id'],
                    $result_row['user_id'],                   
                    $result_row['event_id'],
                    $result_row['status'],
                    $result_row['flagged'],
                    $result_row['note']); 
    return $theApp;
}


function fetch_app_by_id($id) {
    $connection = connect();
    $id = mysqli_real_escape_string($connection, $id);
    $query = "select * from dbapplications where id = '$id'";
    $result = mysqli_query($connection, $query);
    $app = mysqli_fetch_assoc($result);
    if ($app) {
        require_once('include/output.php');
        $app = hsc($app);
        mysqli_close($connection);
        return $app;
    }
    mysqli_close($connection);
    return null;
}

function create_app($app) {
    $connection = connect();
    $user_id = $app["user_id"];
    $event_id = $app["event_id"];
    $status = $app["status"];
    $flagged = $app["flagged"];

    $query = "
        insert into dbapplications (user_id, event_id, status, flagged)
        values ('$user_id', '$event_id', '$status', '$flagged')
    ";
    $result = mysqli_query($connection, $query);
    if (!$result) {
        return null;
    }
    $id = mysqli_insert_id($connection);
    mysqli_commit($connection);
    mysqli_close($connection);
    return $id;
}

function update_app_status($appID, $status) {
    $connection = connect();
    $query = "
        update dbapplications set status='$status'
        where id='$appID'
    ";
    $result = mysqli_query($connection, $query);
    mysqli_commit($connection);
    mysqli_close($connection);
    return $result;
}

function update_app_note($appID, $note) {
    $connection = connect();
    $query = "
        update dbapplications set note='$note'
        where id='$appID'
    ";
    $result = mysqli_query($connection, $query);
    mysqli_commit($connection);
    mysqli_close($connection);
    return $result;
}

function flag_app($appID) {
    $connection = connect();
    $query = "
        update dbapplications set flagged=1
        where id='$appID'
    ";
    $result = mysqli_query($connection, $query);
    mysqli_commit($connection);
    mysqli_close($connection);
    return $result;
}



function get_all_apps() {
    $con=connect();
    $query = "SELECT * FROM dbapplications" .
            " ORDER BY flagged";
    $result = mysqli_query($con,$query);
    $theApps = array();
    while ($result_row = mysqli_fetch_assoc($result)) {
        $theApp = make_an_app($result_row);
        $theApps[] = $theApp;
    }
    mysqli_close($con);
    return $theApps;
 }

?>
