<?php
    // Template for new VMS pages. Base your new page on this one

    // Make session information accessible, allowing us to associate
    // data with the logged-in user.
    session_cache_expire(30);
    session_start();
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);

    $loggedIn = false;
    $accessLevel = 0;
    $userID = null;
    if (isset($_SESSION['_id'])) {
        $loggedIn = true;
        // 0 = not logged in, 1 = standard user, 2 = manager (Admin), 3 super admin (TBI)
        $accessLevel = $_SESSION['access_level'];
        $userID = $_SESSION['_id'];
    }  
    include 'database/dbEvents.php';
    
    //include 'domain/Event.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <?php require_once('universal.inc') ?>
        <link rel="stylesheet" href="css/event.css">
        <script src="js/messages.js"></script>
        <title>Viewing All Applications | Whiskey Valor Foundation</title>
    </head>
    <body>
        <?php require_once('header.php') ?>
        <?php require_once('database/dbApplications.php');?>
        <h1>Applications</h1>
        <main class="general">
            <?php 
                //require_once('database/dbMessages.php');
                //$messages = get_user_messages($userID);
                //require_once('database/dbevents.php');
                require_once('domain/Application.php');
                //$events = get_all_events();
                $applications = get_all_apps();
                $today = new DateTime(); // Current date


                if (sizeof($applications) > 0): ?>
                <div class="table-wrapper">
                    <h2>Upcoming Applications</h2>
                    <table class="general">
                        <thead>
                            <tr>
                                <th style="width:1px">ID</th>
                                <th>User</th>
                                <th>Event</th>
                                <th>Status</th>
                                <th style="width:1px"></th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                require_once('domain/Event.php');
                                require_once('database/dbEvents.php');
                                #require_once('include/output.php');
                                #$id_to_name_hash = [];
                                foreach ($applications as $app) {
                                    $appID = $app->getID();
                                    $user = $app->getUserID();
                                    $event_id = $app->getEventID();
                                    $status = $app->getStatus();
                                    $flagged = $app->getFlagged();
                                    $event = retrieve_event($event_id);
                                    $eventName = $event->getName();


                                    //TODO: remove training_level_required and add other necessary fields -Blue
                                    echo "
                                    <tr data-app-id='$appID'>
                                        
                                        <td><a href='viewApplication.php?app_id=$appID&user_id=$user' class='app-link'>$appID</a></td>
                                        <td>$user</td>
                                        <td>$eventName</td>
                                        <td>$status</td>";
                                    if ($flagged) {
                                        echo "<td style='background-color: #ff693cff'></td></tr>";
                                    }
                                    else {
                                        echo "</tr";
                                    }


                                }
                            ?>
                        </tbody>
                    </table>
                </div>

                <?php else: ?>
                <p class="no-events standout">There are currently no applications available to view.</p>
            <?php endif ?>
            <a class="button cancel" href="index.php">Return to Dashboard</a>
        </main>
    

    </body>
</html>