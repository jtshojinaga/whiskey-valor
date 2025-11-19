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
    require_once('database/dbPersons.php');
    require_once('database/dbApplications.php');
    require_once('database/dbEvents.php');

    $args = sanitize($_GET);
    $app_id = $args['app_id'] ?? null;
    $user_id = $args['user_id'] ?? null;
    $user = retrieve_person($user_id) ?? null;
    $app = retrieve_app($app_id) ?? null;
    $eventID = $app->getEventID() ?? null;
    $event = retrieve_event($eventID) ?? null;


?>

<!DOCTYPE html>
<html>
    <head>
        <?php require_once('universal.inc'); ?>
        <title>Whiskey Valor | View Application</title>
        <link rel="stylesheet" href="css/base.css">
        <link rel="stylesheet" href="css/application.css">
    </head>
    <body>
        <?php require_once('header.php'); 
        $isAdmin = $_SESSION['access_level'] >= 2;

        if (!$isAdmin): ?> <!-- With permission array set this should be redundant -->
            <div class="error-toast">You do not have permission to view this page.</div></body>
        <?php else: ?>
            
            <h1 class="application-title" style="color: white" >Application for <?php echo $user->get_first_name() . " " . $user->get_last_name(); ?></h1>
            <div class="application-view-container">
                <div class="application-nav-button">
                    <!-- prev application button; will be replaced with imgs -->
                     <
                </div>
                <div class="application-view">
                    <!-- view the application content -->
                    <div class="user-details">
                        <span>Username:</span>
                        <p><?php echo $user_id ?></p>
                        <span>Name:</span>
                        <p><?php echo $user->get_first_name() . " " . $user->get_last_name() ?></p>
                        <span>Branch:</span>
                        <p><?php echo $user->get_branch()?></p>
                        <span>Affiliation:</span>
                        <p><?php echo ucfirst($user->get_affiliation())?></p>
                        <span>Note:</span>
                        <p>Temporary Note</p>
                    </div>
                    <div class="event-details">
                        <span>Event:</span>
                        <p><?php echo $event->getName() ?></p>
                        <span>Start Date:</span>
                        <p><?php echo $event->getStartDate() ?></p>
                        <span>End Date:</span>
                        <p><?php echo $event->getEndDate() ?></p>
                        <span>Start Time:</span>
                        <p><?php echo $event->getStartTime() ?></p>
                        <span>End Time:</span>
                        <p><?php echo $event->getEndTime() ?></p>
                        <span>Location:</span>
                        <p><?php echo $event->getLocation() ?></p>
                        <span>Branch:</span>
                        <p><?php echo $event->getBranch() ?></p>
                        <span>Affiliation:</span>
                        <p><?php echo $event->getAffiliation() ?></p>
                    </div>

                </div>
                <div class="application-sidebar">
                    <div class="application-comment">
                        <!-- post and view a comment; needs to integrate w backend -->
                        <div class="posted-app-comment">
                            <p class="app-comment-user">Username</p>
                            <p class="app-comment-text">Blah blah blah blah blah blah blah...</p>
                        </div>
                        <form id="application_comment">
                            <input type="text" name="app_comment" id="app_comment" placeholder="Enter a comment..." required>
                            <input type="submit" value="Comment">
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
