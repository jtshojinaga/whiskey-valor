<?php 
    /*
    * Author: Blue Shojinaga
    * For the Whiskey Valor Foundation
    * Fall 2025
    */

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    session_cache_expire(30);
    session_start();

    $loggedIn = false;
    $accessLevel = 0;
    $userID = null;
    if (isset($_SESSION['_id'])) {
        $loggedIn = true;
        // 0 = not logged in, 1 = standard user, 2 = manager (Admin), 3 super admin (TBI)
        $accessLevel = $_SESSION['access_level'];
        $userID = $_SESSION['_id'];
    }

    include_once('database/dbPersons.php');
    include_once('database/dbEvents.php');
    include_once('domain/Event.php');
    include_once('domain/Person.php');
    require_once('include/input-validation.php');
    $args = sanitize($_GET);
    if (isset($args["id"])) {
        $id = $args["id"];
    } else {
        header('Location: calendar.php');
        die();
  	}
  	
    // We need to check for a bad ID here before we query the db
    // otherwise we may be vulnerable to SQL injection(!)
  	$event_info = fetch_event_by_id($id);
    if ($event_info == NULL) {
        // TODO: Need to create error page for no event found
        // header('Location: calendar.php');

        // Lauren: changing this to a more specific error message for testing
        echo 'bad event ID';
        die();
    }

    $attendees_list = fetch_event_signups($id);
    $event_name = $event_info['name'];
?>
<!DOCTYPE html>
<html>
    <head>
        <?php require_once('universal.inc') ?>
        <title>Logging Attendance for <?php echo $event_name; ?> | Whiskey Valor Foundation</title>
    </head>
    <body>
        <?php require_once('header.php') ?>
        <main>
            <h1 style="color: white;">Logging Attendance for <?php echo $event_name; ?></h1>
            <div class="attendees-wrapper">
            <form method="POST" id="attendance-form" action="processAttendees.php">
                <div class="attendees-table-wrapper">
                    <div class="thead">
                        <div class="tr">
                            <span class="td"><input type="checkbox" name="all" id="select-all">Select All</span>
                            <span class="td" id="data">Attendee</span>
                            <span class="td" id="data">Username</span>
                            <span class="td" id="data">Notes</span>
                        </div>
                    </div>
                    <div class="tbody">
                    <?php foreach ($attendees_list as $attendee) { 
                        $uid = isset($attendee['userID']) ? htmlspecialchars($attendee['userID']) : '';
                        $attendee = retrieve_person($uid);
                        $first = $attendee->get_first_name();
                        $last = $attendee->get_last_name();

                        $name = trim($first . ' ' . $last);

                        echo "<div class='tr'>";
                        // added cb class for js targeting
                        echo "<span class='td'><input type='checkbox' class='cb' name='attendee[]' value='" . $uid . "'></span>";
                        echo "<span class='td' id='data'>" . $name . "</span>";
                        echo "<span class='td' id='data'>" . $uid . "</span>";
                        // key is uid to associate entries with user
                        echo "<span class='td' id='data'><input type='text' class='note' name='attendee_notes[" . $uid . "]' placeholder='Enter note...'></span>";
                        echo "</div>";
                    } ?>
                    </div>
                </div>
                <button type="submit" name="log" id="log">Log Selected Attendees</button>
            </form>
            </div>
            <script src="js/select-all.js"></script>
        </main>
    </body>
</html>