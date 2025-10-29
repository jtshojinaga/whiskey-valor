<?php 
    session_cache_expire(30);
    session_start();
    ini_set("display_errors",1);
    error_reporting(E_ALL);
    if(!isset($_SESSION['_id'])) {
        header('Location: login.php');
        die();
    }

    require('include/input-validation.php');

    $args = sanitize($_GET);
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
            <h1 class="application-title">Application for <?php echo $args['app_id']; ?></h1>
            <div class="application-view-container">
                <div class="application-nav-button">
                    <!-- prev application button; will be replaced with imgs -->
                     <
                </div>
                <div class="application-view">
                    <!-- view the application content -->
                     <p>Username - <?php echo $args['user_id']; ?></p>
                     <p></p>
                     <p>Full Name - John Smith</p>
                     <p></p>
                     <p>Notes - None</p>
                </div>
                <div class="application-sidebar">
                    <div class="application-control-buttons">
                        <!-- accent app, deny app, app flag, etc; will be replaced w buttons-->
                         <button type="button" value="approve">Approve</button>
                         <button type="button" value="deny">Deny</button>
                         <button type="button" value="flag">Flag</button>
                    </div>
                    <div class="application-comment">
                        <!-- post and view a comment; needs to integrate w backend -->
                         <div class="posted-app-comment">
                            <p class="app-comment-user">Username</p>
                            <p class="app-comment-text">Blah blah blah blah blah blah blah...</p>
                         </div>
                         <form id="application_comment">
                            <input type="text" name="app_comment" id="app_comment" placeholder="Enter a comment..." required>
                            <input type="submit" value="Comment" style="width: 25%;">
                         </form>
                    </div>
                </div>
                <div class="application-nav-button">
                    <!-- next application button -->
                     >
                </div>
            </div>

            <a href="./viewRetreatApplications.php">Back to All Applications</a>
        <?php endif ?>
    </body>
</html>
