<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    session_cache_expire(30);
    session_start();
    
    print_r($_SESSION);

    require_once('database/dbApplications.php');
    require_once('include/input-validation.php');
    $args = sanitize($_POST);
    $app_id = $args['app_id'] ?? null;
    $user_id = $args['user_id' ?? null];
    $action = $args['action'] ?? null;
    $note = $args['deny-note'] ?? null;

    if (!$app_id || !$user_id || !$action) {
        header('Location: index.php');
        die();
    }

    $valid_actions = ['approve', 'deny', 'flag'];
    if (!in_array($action, $valid_actions)) {
        die("Invalid action");
    }

    if ($action=='flag') {
        $result = flag_app($app_id);
    }
    else {
        if ($action=='approve') {
            $status = 'Approved';
            update_app_note($appID, '');
            $result = update_app_status($app_id, $status);
        }
        else if ($action=='deny') {
            $status = 'Denied';
            if ($note) {
                $result = update_app_status($app_id, $status);
                update_app_note($appID, $note);
            }
            else {
                header("Location: denyApplication.php?app_id=$app_id&user_id=$user_id");
                exit;
            }

        }
    }

    if ($result) {
        header("Location: applicationSuccess.php");
        exit;
    }
    else {
        echo "Error updating application";
    }

?>