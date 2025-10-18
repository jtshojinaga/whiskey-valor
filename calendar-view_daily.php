<?php
session_cache_expire(30);
    session_start();

    date_default_timezone_set("America/New_York");

    // Ensure user is logged in
    if (!isset($_SESSION['access_level']) || $_SESSION['access_level'] < 1) {
        header('Location: login.php');
        die();
    }

    //NOTE: Keeping the variable derrived from the attribute named as $month for now. 
    // Redirect to current month
    //TODO: Day Format
    if (!isset($_GET['month'])) { //If there is no month attribute set then:
        //Altered to show this.
        $month = date("Y-m-d");
    } else {
        $month = $_GET['month']; //If there is a month
    }
    //TODO: Alter the below to add the day and day validation. 
    
    //Parsing month attribute into usable variables 2025-10-30
    $year = substr($month, 0, 4); // Year from $month
    $month2digit = substr($month, 5, 2); //Month from $month
    $day = substr($month, 8, 2); // day from $month

    $today = strtotime(date("Y-m-d"));
    

    $first = substr($month, 0, 7) . '-01'; //Setting the first of the month 

    // Convert to date
    $month = strtotime($month);
    // Find first day of the month
    $first = strtotime($first);
    // Find previous and next month
    $previousMonth = strtotime(date('Y-m-d', $month) . ' -1 month');
    $nextMonth = strtotime(date('Y-m-d', $month) . ' +1 month');
    // Validate; redirect if bad arg given
    
    if (!$month) {
        header('Location: calendar.php?month=' . date("Y-m-d")); //Setting the attribute if there was none
        die();
    }
    $calendarStart = $first;
    // Back up until we find the first Sunday that should appear on the calendar
    //  WVF: They're itterating backwards until the day is a sunday, which is a '0' in week('w') format. 
    while (date('w', $calendarStart) > 0) {
        $calendarStart = strtotime(datetime: date('Y-m-d', $calendarStart) . ' -1 day');
    }
    $calendarEnd = date('Y-m-d', strtotime(date('Y-m-d', $calendarStart) . ' +34 day'));
    $calendarEndEpoch = strtotime($calendarEnd);
    $weeks = 5;
    // Add another row if it's needed to display all days in the month
    if (date('m', strtotime($calendarEnd . ' +1 day')) == date('m', $first)) { 
        $calendarEnd = date('Y-m-d', strtotime($calendarEnd . ' +7 day'));
        $calendarEndEpoch = strtotime($calendarEnd);
        $weeks = 6;

    
    }
    ?>
<!DOCTYPE html>
<html>




        <?php
        $selectedDateString = $_GET['month'];
        $date = strtotime($selectedDateString);
        require_once('database/dbEvents.php');
            echo "<script> console.log('daily view date:', '\" . $selectedDateString . \"');</script>";

        $dayEvents = fetch_events_on_date($selectedDateString);
        echo "<script> console.log('Events:', " . json_encode($dayEvents) . ");</script>";
        
        // Set up attributes for the <td>
        $extraAttributes = '';
        $extraClasses = '';
        if (date('Y-m-d', $date) == date('Y-m-d', $today)) {
            $extraClasses = ' today'; //it's today
        }
        if (date('m', $date) != date('m', $month)) {
            $extraClasses .= ' other-month';
            $extraAttributes .= ' data-month="' . date('Y-m-d', $date) . '"';
        }
        //string builder
        $eventsStr = '';
        if (!empty($dayEvents)) 
        { // Check if fetch_events_on_date returned anything
            foreach ($dayEvents as $info) 
                {
                    $backgroundCol = '#294877'; // default color

                if (is_archived($info['id'])) { // archived event
                    if ($_SESSION['access_level'] < 2) {
                        continue; // users cannot see archived events
                            
                            $backgroundCol = '#aaaaaa'; //TODO

                    } elseif (check_if_signed_up($info['id'], $_SESSION['_id'])) {// user is signed-up for event
                        $backgroundCol = '#4CAF50';

                    }
                
                }
                
                $eventsStr .= '<a class="calendar-event" style="background-color: ' . $backgroundCol . '" href="event.php?id=' . $info['id'] . '&user_id=' . $_SESSION['_id'] . '">' . htmlspecialchars_decode($info['name']) . '</a>';

            
        }
        echo '<tr class="calendar-week">'; // This row will only have one cell
            echo '<td class="calendar-day' . $extraClasses . '" ' . $extraAttributes . ' data-date="' . date('Y-m-d', $date) . '">
            <div class="calendar-day-wrapper">
                <p class="calendar-day-number">' . date('j', $date) . '</p>
                ' . $eventsStr . '
            </div>
        </td>';
        echo '</tr>'; // End the row
    }
    ?>
</html>