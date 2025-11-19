<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    session_cache_expire(30);
    session_start();
    
    /*if ($_SESSION['access_level'] < 2 || $_SERVER['REQUEST_METHOD'] != 'POST') {
        header('Location: index.php');
        die();
    }*/

    require_once('database/dbApplications.php');
    require_once('database/dbEvents.php');
    require_once('include/input-validation.php');
    $args = sanitize($_POST);
    $app_id = $args['app_id'] ?? null;
    $event_id = $args['event_id'] ?? null;
    $user_id = $args['user_id'] ?? null;
    $notes = $args['notes'] ?? null;
    $status = 'Approved';

    if (!$app_id) {
        header('Location: index.php');
        die();
    }
    if (update_app_status($app_id, $status)) {
        if (!check_if_signed_up($event_id, $user_id)) {
            sign_up_for_event($event_id, $user_id, $notes);
        }
        header('Location: viewPendingApps.php?pendingSignupSuccess');
        die();
    }
    header('Location: index.php');
?>