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
    require_once('domain/Application.php');

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
        <!--<link rel="stylesheet" href="css/base.css">-->
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
                <?php 
                    $next_app_id = get_next_app($app_id)->getID();
                    $next_app_uid = get_next_app($app_id)->getUserID();
                    $prev_app_id = get_previous_app($app_id)->getID();
                    $prev_app_uid = get_previous_app($app_id)->getUserID();
                ?>
                <div class="application-nav-button">
                    <!-- prev application button; will be replaced with imgs -->
                     <a href="<?php echo 'viewApplication.php?app_id=', urlencode($prev_app_id), '&user_id=', urlencode($prev_app_uid); ?>">
                        <img src="images/arrow-back.png" alt="Previous application" style="margin-left: 5px;">
                     </a>
                </div>
                <div class="application-view">
                    <!-- view the application content -->
                    <div class="user-details">
                        <span class="user-headers">Username:</span>
                        <p class="user-content"><?php echo $user_id ?></p>
                        <span class="user-headers">Name:</span>
                        <p class="user-content"><?php echo $user->get_first_name() . " " . $user->get_last_name() ?></p>
                        <span class="user-headers">Branch:</span>
                        <p class="user-content"><?php echo $user->get_branch()?></p>
                        <span class="user-headers">Affiliation:</span>
                        <p class="user-content">
                            <?php 
                            if ($user->get_affiliation()) {
                                echo ucfirst($user->get_affiliation());
                            } 
                            else {
                                echo "";
                            }?></p>
                        
                        
                        <span class="user-headers">Note:</span>
                        <p class="user-content">Temporary Note</p>
                    </div>
                    <div class="event-details">
                        <span class="event-headers">Event:</span>
                        <p class="event-content"><?php echo $event->getName() ?></p>
                        <span class="event-headers">Start Date:</span>
                        <p class="event-content"><?php echo $event->getStartDate() ?></p>
                        <span class="event-headers">End Date:</span>
                        <p class="event-content"><?php echo $event->getEndDate() ?></p>
                        <span class="event-headers">Start Time:</span>
                        <p class="event-content"><?php echo $event->getStartTime() ?></p>
                        <span class="event-headers">End Time:</span>
                        <p class="event-content"><?php echo $event->getEndTime() ?></p>
                        <span class="event-headers">Location:</span>
                        <p class="event-content"><?php echo $event->getLocation() ?></p>
                        <span class="event-headers">Branch:</span>
                        <p class="event-content"><?php echo $event->getBranch() ?></p>
                        <span class="event-headers">Affiliation:</span>
                        <p class="event-content"><?php echo $event->getAffiliation() ?></p>



                    </div>
                </div>
                <div class="application-sidebar">
                    <div class="application-control-buttons">
                        <!-- accent app, deny app, app flag, etc; will be replaced w buttons-->
                        <form id="application-form" method="POST" action="process_application.php">
                            <input type="hidden" name="app_id" value="<?php echo htmlspecialchars($app_id); ?>">
                            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user_id); ?>">
                            <button id="approve" type="submit" name="action" value="approve" class="btn-action">
                                <img src="images/approve.png" alt="Approve application">
                            </button>
                            <button id="deny" type="submit" name="action" value="deny" class="btn-action">
                                <img src="images/disapprove.png" alt="Deny application">
                            </button>
                            <button id="flag" type="submit" name="action" value="<?php if($app->getFlagged()) { echo 'unflag'; } else { echo 'flag'; }?>" class="btn-action">
                                <?php if($app->getFlagged()): ?>
                                    <img id="flagged" src="images/filled-flag.png" alt="Unflag application">
                                    
                                <?php else: ?>
                                    <img id="unflagged" src="images/flag.png" alt="Flag application">
                                <?php endif; ?>
                            </button>
                        </form>
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
                     <a href="<?php echo 'viewApplication.php?app_id=', urlencode($next_app_id), '&user_id=', urlencode($next_app_uid); ?>">
                        <img src="images/arrow-forward.png" alt="Next application">
                     </a>
                </div>
            </div>

            <a href="./viewAllApplications.php" class="btn">Back to All Applications</a>
        <?php endif ?>
    </body>
</html>