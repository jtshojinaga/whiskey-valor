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
    require_once('include/input-validation.php');
    $args = sanitize($_POST);
    $app_id = $args['app_id'] ?? null;

    if (!$app_id) {
        header('Location: index.php');
        die();
    }
    if (flag_app($app_id)) {
        header('Location: viewPendingApps.php?pendingFlagSuccess');
        die();
    }
    header('Location: index.php');
?>