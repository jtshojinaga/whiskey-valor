<?php
    session_cache_expire(30);
    session_start();

    date_default_timezone_set("America/New_York");

    // Ensure user is logged in
    if (!isset($_SESSION['access_level']) || $_SESSION['access_level'] < 1) {
        //header('Location: login.php');
        //die();
    }

    // Redirect to current month
    if (!isset($_GET['month'])) {
        $month = date("Y-m-d");
    } else {
        $month = $_GET['month'];
    }
    
    $year = substr($month, 0, 4);
    $month2digit = substr($month, 5, 2);

    $today = strtotime(date("Y-m-d"));

    $first = $month . '-01';
    // Convert to date
    $month = strtotime($month);
    // Find first day of the month
    $first = strtotime($first);
    // Find previous and next month
    $previousMonth = strtotime(date('Y-m-d', $month) . ' -1 month');
    $nextMonth = strtotime(date('Y-m-d', $month) . ' +1 month');
    // Validate; redirect if bad arg given
    if (!$month) {
        header('Location: calendar.php?month=' . date("Y-m-d"));
        die();
    }
    $calendarStart = $first;
    // Back up until we find the first Sunday that should appear on the calendar
    while (date('w', $calendarStart) > 0) {
        $calendarStart = strtotime(date('Y-m-d', $calendarStart) . ' -1 day');
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
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="js/calendar.js"></script>
        <script src="js/view-switcher.js" defer></script>
        <title>Whiskey Valor Foundation | Events Calendar</title>
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
        <div id="view-filter-wrapper" class="hidden"> 
            <form id="filter-view">
                <p>View by month, week, or day?</p>
                <div>
                    <select id="views">
                        <?php
                        $views = ['Month', 'Week', 'day'];
                        $digit = 1;
                            foreach ($views as $m) {
                                $view_digits = str_pad($digit, 2, '0', STR_PAD_LEFT);
                                if ($view_digits == $view2digit) {
                                    echo "<option value='$view_digits' selected>$m</option>";
                                } else {
                                    echo "<option value='$view_digits'>$m</option>";
                                }
                                $digit++;
                            }
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
            
            <h1 class='calendar-header' style="height: 75px;">
                <img id="previous-month-button" src="images/arrow-back.png" data-month="<?php echo date("Y-m-d", $previousMonth); ?>">
                <span id="calendar-heading-month" style="font-weight: 700; font-size: 36px;">Events - <?php echo date('F Y', $month); ?></span>
                <img id="next-month-button" src="images/arrow-forward.png" data-month="<?php echo date("Y-m-d", $nextMonth); ?>">
            </h1>

            <!-- Add JS to show and hide the filter menu.-->
            <div class="filter-wrapper">
                <div class="filter-menu-wrapper">
                    <input type="checkbox" /> <!-- Toggle to show/hide filter menu -->
                    <div class="filter-menu"><img class="filter-menu-icon" src="./images/menu.png" style="filter: invert(1);"></div>
                    <div class="calendar-filter" style="height: 3rem;">
                        <img id="list-view-button" class="filter-button" src="images/list-solid.svg" alt="List view">
                        <img id="calendar-view-button" class="filter-button" src="images/view-calendar.png" alt="Calendar view">
                        <img id="calendar-weekly-view-button" class="filter-button" src="images/new-event.png" alt="Calendar view: Weekly">
                        <img id="calendar-day-view-button" class="filter-button" src="images/day-sunny-svgrepo-com.svg" alt="Calendar view: Day">
                    </div>
                </div>
                <!-- <div class="time-filter" class="hidden"> <!-- will later be used for week<->month
                    <img id="day-view-button" class="filter-button" class="hidden" src="images/day-view.png" alt="Day view">
                    <img id="week-view-button" class="filter-button" class="hidden" src="images/week-view.png" alt="week view">
                    <img id="month-view-button" class="filter-button" class="hidden" src="images/month-view.png" alt="month view">
                </div> -->
            </div>

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

                <!-- to be replaced -Blue -->

            <div class="table-wrapper" id="event-viewer">
                <!-- <table id="calendar">

                <!-- to be replaced -Blue -->

            <div class="table-wrapper" id="event-viewer">
                <!-- <table id="calendar">
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
                    <tbody>
                    <?php
                        $date = $calendarStart;
                        $start = date('Y-m-d', $calendarStart);
                        $end = date('Y-m-d', $calendarEndEpoch);
                        require_once('database/dbEvents.php');
                        $events = fetch_events_in_date_range($start, $end, $loggedIn);
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

                                        $backgroundCol = '#996d49ff'; // default color
                                        $backgroundCol = '#996d49ff'; // default color

                                        if(isset($_SESSION['access_level'])) {
                                            if (is_archived($info['id'])) { // archived event
                                                if ($_SESSION['access_level'] < 2) {
                                                    continue; // users cannot see archived events
                                                }
                                                $backgroundCol = '#aaaaaa'; //TODO
                                        if(isset($_SESSION['access_level'])) {
                                            if (is_archived($info['id'])) { // archived event
                                                if ($_SESSION['access_level'] < 2) {
                                                    continue; // users cannot see archived events
                                                }
                                                $backgroundCol = '#aaaaaa'; //TODO

                                            } elseif (check_if_signed_up($info['id'], $_SESSION['_id'])) {// user is signed-up for event
                                                $backgroundCol = '#4CAF50';
                                            } elseif (check_if_signed_up($info['id'], $_SESSION['_id'])) {// user is signed-up for event
                                                $backgroundCol = '#4CAF50';

                                            }
                                            $eventsStr .= '<a class="calendar-event" style="background-color: ' . $backgroundCol . '" href="event.php?id=' . $info['id'] . '&user_id=' . $_SESSION['_id'] . '">' . htmlspecialchars_decode($info['name']) . '</a>';

                                        } else {
                                            $eventsStr .= '<a class="calendar-event" style="background-color: ' . $backgroundCol . '" href="event.php?id=' . $info['id'] . '&user_id=guest' . '">' . htmlspecialchars_decode($info['name']) . '</a>';
                                            }
                                            $eventsStr .= '<a class="calendar-event" style="background-color: ' . $backgroundCol . '" href="event.php?id=' . $info['id'] . '&user_id=' . $_SESSION['_id'] . '">' . htmlspecialchars_decode($info['name']) . '</a>';

                                        } else {
                                            $eventsStr .= '<a class="calendar-event" style="background-color: ' . $backgroundCol . '" href="event.php?id=' . $info['id'] . '&user_id=guest' . '">' . htmlspecialchars_decode($info['name']) . '</a>';
                                        }
                                        
                                        
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
                        }}
                    ?>
                    </tbody>
                </table>-->
                
            </div>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">            
            
            <?php
            //archive = grey
            //restricted = red
            //signed up for = green
            //blue = unrestricted
            ?>
            <!--<center>
            <p></p>
            <i class="fa-solid fa-circle legend-dot accent"></i>
                <span class="legend-label">Open Event</span>
            <i class="fa-solid fa-circle legend-dot green"></i>
                <span class="legend-label">Signed-Up</span>
            <i class="fa-solid fa-circle legend-dot gray"></i>
                <span class="legend-label">Archived Event</span>
            </center>
                            <p></p>-->
        
<div style="display: flex; justify-content: center; align-items: center;">
<div style="margin-top: 1.5rem;">
    <a href="index.php" class="btn-muted">
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