<?php
    session_start(); 

    date_default_timezone_set("America/New_York");


    if (isset($_GET['month']) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $_GET['month'])) {
        $dayStr = $_GET['month']; // string like "2025-10-18"
    } else {
        $dayStr = date('Y-m-d'); // Default to today
    }

    // Get the timestamp for the day we are viewing
    $dayEpoch = strtotime($dayStr);
    if (!$dayEpoch) {

        header('Location: calendar.php?month=' . date("Y-m-d"));
        exit;
    }

    $today = strtotime(date("Y-m-d"));

    // Compute previous and next week
    $previousWeek = strtotime(date('Y-m-d', $dayEpoch) . ' -7 days');
    $nextWeek = strtotime(date('Y-m-d', $dayEpoch) . ' +7 days');



?>


<table id="calendar"
       data-current-month="<?php echo date('Y-m-d', $dayEpoch); ?>"
       data-prev-month="<?php echo date('Y-m-d', $previousWeek); ?>"
       data-next-month="<?php echo date('Y-m-d', $nextWeek); ?>">
    <thead>

    <?php
    $selectedDateString = $_GET['month'];
        $date = strtotime($selectedDateString);
        require_once('database/dbEvents.php');
            echo "<script> console.log('daily view date:', '\" . $selectedDateString . \"');</script>";
            echo "<tr> <th>" . $selectedDateString . "</tr> </th>"; 

    ?>
    </thead>


        <?php

        $loggedIn = 0; //Logged in set to 0 change later
        $dayEvents = fetch_events_on_date($selectedDateString, $loggedIn);
        echo "<script> console.log('Events:', " . json_encode($dayEvents) . ");</script>";
        
        // Set up attributes for the <td>
        $extraAttributes = '';
        $extraClasses = '';
        if (date('Y-m-d', $date) == date('Y-m-d', $today)) {
            $extraClasses = ' today'; //it's today
        }
        //string builder
        $eventsStr = '';
        if (!empty($dayEvents)) 
        { // Check if fetch_events_on_date returned anything
            foreach ($dayEvents as $info) 
                {
                    $backgroundCol = '#294877'; // default color

                    if (isset($_SESSION['access_level'])) {

                        // Check for archived events
                        if (is_archived($info['id'])) { 
                            if ($_SESSION['access_level'] < 2) {
                                continue; // users cannot see archived events
                            }
                            $backgroundCol = '#aaaaaa'; // Corrected position

                        } elseif (check_if_signed_up($info['id'], $_SESSION['_id'])) {
                            $backgroundCol = '#4CAF50';
                        }

                        // Build string for logged-in user
                        $eventsStr .= '<a class="calendar-event" style="background-color: ' . $backgroundCol . '" href="event.php?id=' . $info['id'] . '&user_id=' . $_SESSION['_id'] . '">' . htmlspecialchars_decode($info['name']) . '</a>';
                    
                    } else {
                        
                        // Guests cannot see archived events
                        if (is_archived($info['id'])) {
                            continue;
                        }

                        // Build string for gues-t
                        $eventsStr .= '<a class="calendar-event" style="background-color: ' . $backgroundCol . '" href="event.php?id=' . $info['id'] . '&user_id=guest">' . htmlspecialchars_decode($info['name']) . '</a>';
                    }

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