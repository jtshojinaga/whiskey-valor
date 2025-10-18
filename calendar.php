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
    <head>
        <?php require('universal.inc'); ?>
        <?php require('header.php'); ?>
        <script src="js/calendar.js"></script>
        <title>Fredericksburg SPCA | Events Calendar</title>
        <style>.happy-toast { margin: 0 1rem 1rem 1rem; }</style>
    </head>
    <body>
        <!--May need to edit this for selection of days or weeks.-->
        <div id="month-jumper-wrapper" class="hidden"> 
            <form id="month-jumper">
                <p>Choose a month to jump to</p>
                <!-- Adding a 'day' selector -->
                <div>
                    <select id="jumper-month">
                        <?php
                            $months = [
                                'January', 'February', 'March', 'April',
                                'May', 'June', 'July', 'August',
                                'September', 'October', 'November', 'December'
                            ];
                            $digit = 1;
                            foreach ($months as $m) {
                                $month_digits = str_pad($digit, 2, '0', STR_PAD_LEFT);
                                if ($month_digits == $month2digit) {
                                    echo "<option value='$month_digits' selected>$m</option>";
                                } else {
                                    echo "<option value='$month_digits'>$m</option>";
                                }
                                $digit++;
                            }
                        ?>
                    </select>
                    <input id="jumper-year" type="number" value="<?php echo $year ?>" required min="2023">
                    
                    <?Php
                    //Logic for getting the last day of the month for input protection.
                    $finalDayofMonth = date("t", strtotime($year. "-". $month . 01));
                    ?>
                    <input id="jumper-day" type="number" value="<?php echo $day?>" required min="1" required max="<?php echo $finalDayofMonth?>" >
                </div>
                <input type="hidden" id="jumper-value" name="month" value="<?php echo 'test' ?>">
                <input type="submit" value="View">
                <button id="jumper-cancel" class="cancel" type="button">Cancel</button>
            </form>
        </div>
        
        <!-- TODO: WVF filter calendar to weekly or daily.-->
        <div id="view-filter-wraper" class="hidden"> 
            <form id="filter-view">
                <p>View by month, week, or day?</p>
                <div>
                    <select id="views">
                        <?php
                            #TODO: Add filter menue
                            $filterMode = 2; //Dev hardset filter to weekly
                        ?>
                    </select>
                    <!-- TODO: Make this show view. Might edit this to use icons?-->
                    <input id="calendar-view" type="number" value="<?php echo $year ?>" required min="2023">
                </div>
                <input type="hidden" id="jumper-value" name="month" value="<?php echo 'VIEW FILTER TEST' ?>">
                <input type="submit" value="View"> 
                <button id="filter-cancel" class="cancel" type="button">Cancel</button>
            </form> 

        </div>
        <main class="calendar-view">
            <h1 class='calendar-header' style="background: #294877; height: 75px;">
                <img id="previous-month-button" src="images/arrow-back.png" data-month="<?php echo date("Y-m-d", $previousMonth); ?>">
                <span id="calendar-heading-month" style="font-weight: 700; font-size: 36px;">Appointments - <?php echo date('F Y', $month); ?></span>
                <img id="next-month-button" src="images/arrow-forward.png" data-month="<?php echo date("Y-m-d", $nextMonth); ?>">
            </h1>
            <!-- <input type="date" id="month-jumper" value="<?php echo date('Y-m-d', $month); ?>" min="2023-01-01"> -->
            <?php if (isset($_GET['deleteSuccess'])) : ?>
                <div class="happy-toast">Event deleted successfully.</div>
            <?php elseif (isset($_GET['completeSuccess'])) : ?>
                <div class="happy-toast">Event completed successfully.</div>
            <?php elseif (isset($_GET['cancelSuccess'])) : ?>
                <div class="happy-toast">Event canceled successfully.</div>
                <?php elseif (isset($_GET['cancelSuccess'])) : ?>
                <div class="happy-toast">Event canceled successfully.</div>
            <?php endif ?>
                <!--Here we lay out the week. Table for view. Will likely need to switch this out for each view.-->
            <div class="table-wrapper">
                <table id="calendar">
                    <?php
                        switch($filterMode) 
                        {
                            case 0:
                            case 1:
                        
                    ?>
                    <thead>
                        <tr>
                            <th>Sunday</th>
                            <th>Monday</th>
                            <th>Tuesday</th>
                            <th>Wednesday</th>
                            <th>Thursday</th>
                            <th>Friday</th>
                            <th>Saturday</th>
                        </tr>
                    </thead>
                    <?php 
                            break;
                            case 2: 
                    ?>    
                    <thread>
                        <tr>
                            <th>
                                <?php echo date('l', strtotime($month)); ?>
                            </th>
                        </tr>
                    </thread>
                    <?php  
                            break;
                            }
                    ?>
                    <tbody>
                    <?php
                        //TODO: Implement changes here based on whether we're filtered, change start and end to the correct ends.
                        //TODO: Repetative code in this block can and should be functionized
                        
                        /*$date = $calendarStart;
                        $start = date('Y-m-d', $calendarStart);
                        $end = date('Y-m-d', $calendarEndEpoch);
                        require_once('database/dbEvents.php');
                        $events = fetch_events_in_date_range($start, $end);*/
                        if ($filterMode == 0) //Monthly
                        {
                            $date = $calendarStart;
                            $start = date('Y-m-d', $calendarStart);
                            $end = date('Y-m-d', $calendarEndEpoch);
                            require_once('database/dbEvents.php');
                            $events = fetch_events_in_date_range($start, $end);
                            for ($week = 0; $week < $weeks; $week++) {
                                echo '
                                    <tr class="calendar-week">
                                ';
                                for ($day = 0; $day < 7; $day++) {
                                    $extraAttributes = '';
                                    $extraClasses = '';
                                    if ($date == $today) {
                                        $extraClasses = ' today';
                                    }
                                    if (date('m', $date) != date('m', $month)) {
                                        $extraClasses .= ' other-month';
                                        $extraAttributes .= ' data-month="' . date('Y-m-d', $date) . '"';
                                    }
                                    $eventsStr = '';
                                    $e = date('Y-m-d', $date);

                                    if (isset($events[$e])) {
                                        $dayEvents = $events[$e];
                                        foreach ($dayEvents as $info) {

                                            $backgroundCol = '#294877'; // default color

                                            if (is_archived($info['id'])) { // archived event
                                                if ($_SESSION['access_level'] < 2) {
                                                    continue; // users cannot see archived events
                                                }
                                                $backgroundCol = '#aaaaaa';

                                            } elseif (check_if_signed_up($info['id'], $_SESSION['_id'])) {// user is signed-up for event
                                                $backgroundCol = '#4CAF50';

                                            }
                                            
                                            $eventsStr .= '<a class="calendar-event" style="background-color: ' . $backgroundCol . '" href="event.php?id=' . $info['id'] . '&user_id=' . $_SESSION['_id'] . '">' . htmlspecialchars_decode($info['name']) . '</a>';

                                        }
                                    }
                                    echo '<td class="calendar-day' . $extraClasses . '" ' . $extraAttributes . ' data-date="' . date('Y-m-d', $date) . '">
                                        <div class="calendar-day-wrapper">
                                            <p class="calendar-day-number">' . date('j', $date) . '</p>
                                            ' . $eventsStr . '
                                        </div>
                                    </td>';
                                    $date = strtotime(date('Y-m-d', $date) . ' +1 day');
                                }
                                echo '
                                    </tr>';
                            }
                        } 
                        elseif($filterMode == 1) //Weekly
                        {
                            
                            
                            $calendarStart = $month;
                            //Moving back to the last sunday.
                            while (date('w', $calendarStart) > 0) {
                                $calendarStart = strtotime(date('Y-m-d', $calendarStart) . ' -1 day');
                            }
                            $start = date('Y-m-d', $calendarStart);
                            echo "<script> console.log('PHP variable start:', '\" . $start. \"');</script>";

                            //Moving to the end of the week.
                            $calendarEndEpoch = $calendarStart;
                            while (date('w', $calendarEndEpoch) < 6) {
                                $calendarEndEpoch = strtotime(date('Y-m-d', $calendarEndEpoch) . ' +1 day');
                            }
                            $end = date('Y-m-d', $calendarEndEpoch);
                            echo "<script> console.log('PHP variable end:', '\" . $end. \"');</script>";

                            require_once('database/dbEvents.php');
                            $events = fetch_events_in_date_range($start, $end);
                            echo "<script> console.log('Events:', " . json_encode($events) . ");</script>";
                            
                            echo '<tr class="calendar-week">';
                            //Day work
                            $date = $calendarStart;
                                for ($day = 0; $day < 7; $day++) {
                                        $extraAttributes = '';
                                        $extraClasses = '';
                                        if (date('Y-m-d', $date) == date('Y-m-d',$today)) {
                                            $extraClasses = ' today';
                                        }
                                        if (date('m', $date) != date('m', $month)) {
                                            $extraClasses .= ' other-month';
                                            $extraAttributes .= ' data-month="' . date('Y-m-d', $date) . '"';
                                        }
                                        $eventsStr = '';
                                        $e = date('Y-m-d', $date);

                                        if (isset($events[$e])) {
                                            $dayEvents = $events[$e];
                                            foreach ($dayEvents as $info) {

                                                $backgroundCol = '#294877'; // default color

                                                if (is_archived($info['id'])) { // archived event
                                                    if ($_SESSION['access_level'] < 2) {
                                                        continue; // users cannot see archived events
                                                    }
                                                    $backgroundCol = '#aaaaaa'; //TODO

                                                } elseif (check_if_signed_up($info['id'], $_SESSION['_id'])) {// user is signed-up for event
                                                    $backgroundCol = '#4CAF50';

                                               }
                                                
                                                $eventsStr .= '<a class="calendar-event" style="background-color: ' . $backgroundCol . '" href="event.php?id=' . $info['id'] . '&user_id=' . $_SESSION['_id'] . '">' . htmlspecialchars_decode($info['name']) . '</a>';

                                            }
                                        }
                                        echo '<td class="calendar-day' . $extraClasses . '" ' . $extraAttributes . ' data-date="' . date('Y-m-d', $date) . '">
                                            <div class="calendar-day-wrapper">
                                                <p class="calendar-day-number">' . date('j', $date) . '</p>
                                                ' . $eventsStr . '
                                            </div>
                                        </td>';
                                        $date = strtotime(date('Y-m-d', $date) . ' +1 day');
                                    }


                            echo '</tr>';

                        } 
                        elseif($filterMode == 2) //One day
                        {
                            $selectedDateString = $month;
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
                    }  
                        else
                        {
                            echo (
                                '<h1> Calendar ERROR</h1>
                                <p> There was a critical error within the calendar view script!</p>'

                            );
                        }
                        
                    ?>
                    </tbody>
                </table>
            </div>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">            
            
            <?php
            //archive = grey
            //restricted =  red
            //signed up for = green
            //blue = unrestricted
            ?>
            <center>
            <p></p>
            <i class="fa-solid fa-circle" style="color: #294877"> </i>
                <span style="font-size: 25px;">
                    Open Event
                </span>
            <i class="fa-solid fa-circle" style="color: #4CAF50"> </i>
                <span style="font-size: 25px;">
                    Signed-Up
                </span>
            <i class="fa-solid fa-circle" style="color: #aaaaaa"> </i>
                <span style="font-size: 25px;">
                    Archived Event
                </span>
            </center>
                            <p></p>
        
<div style="display: flex; justify-content: center; align-items: center;">
<div style="margin-top: 1.5rem;">
  <a href="index.php" style="
    background-color: #6b7280;  /* bg-gray-500 */
    color: white;               /* text-white */
    padding: 0.5rem 1.5rem;     /* py-2 px-6 */
    border-radius: 0.5rem;      /* rounded-lg */
    text-decoration: none;      /* default for Tailwind links */
    display: inline-block;      /* ensures padding applies correctly */
  "
  onmouseover="this.style.backgroundColor='#4b5563';"
  onmouseout="this.style.backgroundColor='#6b7280';"
  >
    Return to Dashboard
  </a>
</div>
</div>

        </main>
    </body>
</html>
