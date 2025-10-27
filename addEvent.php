<?php session_cache_expire(30);
    session_start();
    // Make session information accessible, allowing us to associate
    // data with the logged-in user.

    ini_set("display_errors",1);
    error_reporting(E_ALL);

    $loggedIn = false;
    $accessLevel = 0;
    $userID = null;
    if (isset($_SESSION['_id'])) {
        $loggedIn = true;
        // 0 = not logged in, 1 = standard user, 2 = manager (Admin), 3 super admin (TBI)
        $accessLevel = $_SESSION['access_level'];
        $userID = $_SESSION['_id'];
    } 
    // Require admin privileges
    if ($accessLevel < 2) {
        header('Location: login.php');
        //echo 'bad access level';
        die();
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        require_once('include/input-validation.php');
        require_once('database/dbEvents.php');
        $args = sanitize($_POST, null);
        $required = array(
            "name", "start-date", "start-time", "end-time", "description", "type"
        );
        if (!wereRequiredFieldsSubmitted($args, $required)) {
            echo 'bad form data';
            die();
        } else {
            $validated = validate12hTimeRangeAndConvertTo24h($args["start-time"], $args["end-time"]);
            if (!$validated) {
                echo 'bad time range';
                die();
            }

            $startTime = $args['start-time'] = $validated[0];
            $endTime = $args['end-time'] = $validated[1];
            $startDate = $args['start-date'] = validateDate($args["start-date"]);
            $endDate = $args['end-date'] = validateDate($args["end-date"]);
            $args["access"] = $_POST['access'];
    
            if (!$startTime || !$endTime || !$date > 11){
                echo 'bad args';
                die();
            }

            $id = create_event($args);
            if(!$id){
                die();
            } else {
                header('Location: eventSuccess.php');
                exit();
            }
            
        }
    }
    $startDate = null;
    if (isset($_GET['start-date'])) {
        $startDate = $_GET['start-date'];
        $startDatePattern = '/[0-9]{4}-[0-9]{2}-[0-9]{2}/';
        $timeStamp = strtotime($startDate);
        if (!preg_match($startDatePattern, $startDate) || !$timeStamp) {
            header('Location: calendar.php');
            die();
        }
    }

    $endDate = null;
    if (isset($_GET['end-date'])) {
        $endDate = $_GET['end-date'];
        $endDatePattern = '/[0-9]{4}-[0-9]{2}-[0-9]{2}/';
        $timeStamp = strtotime($endDate);
        if (!preg_match($endDatePattern, $endDate) || !$timeStamp) {
            header('Location: calendar.php');
            die();
        }
    }

    include_once('database/dbinfo.php'); 
    $con=connect();  

?><!DOCTYPE html>
<html>
    <head>
        <?php require_once('universal.inc') ?>
        <title>Fredericksburg SPCA | Create Event</title>
    </head>
    <body>
        <?php require_once('header.php') ?>
        <h1>Create Event</h1>
        <main class="date">
            <h2>New Event Form</h2>
            <form id="new-event-form" method="POST">
                <label for="name">* Event Name </label>
                <input type="text" id="name" name="name" required placeholder="Enter name"> 
                <label for="name">* Start Date </label>
                <input type="date" id="start-date" name="start-date" <?php if ($startDate) echo 'value="' . $startDate . '"'; ?> min="<?php echo date('Y-m-d'); ?>" required>
                <label for="name">* Start Time </label>
                <input type="text" id="start-time" name="start-time" pattern="([1-9]|10|11|12):[0-5][0-9] ?([aApP][mM])" required placeholder="Enter start time. Ex. 12:00 PM">
                <label for="name">* End Time </label>
                <input type="text" id="end-time" name="end-time" pattern="([1-9]|10|11|12):[0-5][0-9] ?([aApP][mM])" required placeholder="Enter end time. Ex. 1:00 PM">
                <label for="name">* End Date </label>
                <input type="date" id="end-date" name="end-date" <?php if ($endDate) echo 'value="' . $endDate . '"'; ?> min="<?php echo date('Y-m-d'); ?>" required>
                <label for="name">* Description </label>
                <input type="text" id="description" name="description" required placeholder="Enter description">
                <label for="name">* Event Type </label>
                <select id="type" name="type">
                    <option value="Normal">Normal</option>
                    <option value="Retreat">Retreat</option>
                </select>
                <label for="name">Location </label>
                <input type="text" id="location" name="location" required placeholder="Enter location">
                <label for="name">Capacity </label>
                <input type="number" id="capacity" name="capacity" required placeholder="Enter capacity (e.g. 1-99)">
                <label for="level">Access Level:</label>
                <select id="access" name="access">
                    <option value="Public">Public</option>
                    <option value="Private">Private</option>
                </select>
                
                <input type="submit" value="Create Event">
                
            </form>
                <?php if ($startDate && $endDate): ?>
                    <a class="button cancel" href="calendar.php?month=<?php echo substr($date, 0, 7) ?>" style="margin-top: -.5rem">Return to Calendar</a>
                <?php else: ?>
                    <a class="button cancel" href="index.php" style="margin-top: -.5rem">Return to Dashboard</a>
                <?php endif ?>

                <!-- Require at least one checkbox be checked -->
                <script type="text/javascript">
                    $(document).ready(function(){
                        var checkboxes = $('.checkboxes');
                        checkboxes.change(function(){
                            if($('.checkboxes:checked').length>0) {
                                checkboxes.removeAttr('required');
                            } else {
                                checkboxes.attr('required', 'required');
                            }
                        });
                    });
                </script>
        </main>
    </body>
</html>