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
        <title>Whiskey Valor | Deny Application</title>
        <link rel="stylesheet" href="css/base.css">
        <link rel="stylesheet" href="css/application.css">
    </head>
    <body>
        <?php require_once('header.php'); 
        $isAdmin = $_SESSION['access_level'] >= 2;

        if (!$isAdmin): ?> <!-- With permission array set this should be redundant -->
            <div class="error-toast">You do not have permission to view this page.</div></body>
        <?php else: ?>
            
            <h1 class="application-title" style="color: white" >Deny Application</h1>
            <div class="application-note">
                <h2 class="application-subtitle" style="color: white" >Please leave a note explaining why <?php echo $user->get_first_name() . " " . $user->get_last_name() ?>'s application for <?php echo $event->getName()?> is being denied.</h2>
                <div class="note-box">
                    <form id="deny-app" method="POST" action="process_application.php">
                        <input type="hidden" name="app_id" value="<?php echo htmlspecialchars($app_id); ?>">
                        <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user_id); ?>">
                        <textarea type="text" name="deny-note" id="deny-note" rows="4" placeholder="Enter note here" required></textarea>
                        <button type="submit" name="action" value="deny">Submit Application Denial</button>
                    </form>
                </div>
            </div>
        <?php endif ?>


    </body>
</html>