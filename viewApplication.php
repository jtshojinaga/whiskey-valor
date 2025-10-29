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
        <title>Whiskey Valor | View Application</title>
        <link src="css/base.css" rel="stylesheet">
    </head>
    <body>
        <?php require_once('header.php'); 
        $isAdmin = $_SESSION['access_level'] >= 2;

        if(!$isAdmin): ?> <!-- With permission array set this should be redundant -->
            <div class="error-toast">You do not have permission to view this page.</div></body>
        <?php else: ?>
            <div class="application-view-container">
                <div class="application-nav-button">
                    <!-- prev application button -->
                </div>
                <div class="application-view">
                    <!-- view the application content -->
                </div>
                <div class="application-sidebar">
                    <div class="application-control-buttons">
                        <!-- accent app, deny app, app flag, etc -->
                    </div>
                    <div class="application-comment">
                        <!-- post and view a comment -->
                    </div>
                </div>
                <div class="application-nav-button">
                    <!-- next application button -->
                </div>
            </div>

            <a href="./viewRetreatApplications.php" class="button-cancel">Back to All Applications</a>
        <?php endif ?>
    </body>
</html>
