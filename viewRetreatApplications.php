<?php 
    session_cache_expire(30);
    session_start();
    ini_set("display_errors",1);
    error_reporting(E_ALL);
    if(!isset($_SESSION['_id'])) {
        header('Location: login.php');
        die();
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <?php require_once('universal.inc'); ?>
        <title>Whiskey Valor | View Retreat Applications</title>
        <link src="css/base.css" rel="stylesheet">
    </head>
    <body>
        <?php require_once('header.php'); 
        $isAdmin = $_SESSION['access_level'] >= 2;

        if(!$isAdmin): ?> <!-- With permission array set this should be redundant -->
            <div class="error-toast">You do not have permission to view this page.</div></body>
        <?php else: ?>
            <div class="applications-container">
                <div class="application-card">
                    <!-- feel free to change or use these as you like -->
                </div>
            </div>

            <a href="./viewApplication.php?app_id=test">View Test Application Page</a>
        <?php endif ?>
    </body>
</html>
