<?php

date_default_timezone_set("America/New_York");

// Accept a ?month=YYYY-MM query param fallback to current month
if (isset($_GET['month']) && preg_match('/^\d{4}-\d{2}$/', $_GET['month'])) {
    $monthStr = $_GET['month'];           // string like "2025-10"
} else {
    $monthStr = date('Y-m');
}

// Extract pieces from the string
$year = substr($monthStr, 0, 4);
$month2digit = substr($monthStr, 5, 2);  // "01", "02" ... used when comparing date('m', ...)

// canonical epoch/timestamps for the month and first day
$today = strtotime(date("Y-m-d"));
$firstOfMonthStr = $monthStr . '-01';
$firstOfMonthEpoch = strtotime($firstOfMonthStr);
$monthEpoch = strtotime($monthStr . '-01'); // same as firstOfMonthEpoch; kept for clarity

// Defensive: if invalid month param redirect to calendar.php with current month
if (!$monthEpoch) {
    header('Location: calendar.php?month=' . date("Y-m"));
    exit;
}

// compute previous and next month (epochs)
$previousMonth = strtotime(date('Y-m', $monthEpoch) . ' -1 month');
$nextMonth = strtotime(date('Y-m', $monthEpoch) . ' +1 month');

// Set calendar start to first of month, then back up to the Sunday that should be the first cell
$calendarStart = $firstOfMonthEpoch;
while (date('w', $calendarStart) > 0) { // date('w') returns 0 for Sunday
    $calendarStart = strtotime(date('Y-m-d', $calendarStart) . ' -1 day');
}

// Start with 5 weeks (35 days) and extend if needed
$calendarEnd = date('Y-m-d', strtotime(date('Y-m-d', $calendarStart) . ' +34 day'));
$calendarEndEpoch = strtotime($calendarEnd);
$weeks = 5;
if (date('m', strtotime($calendarEnd . ' +1 day')) != $monthEpoch) {
    // Need another row (6 weeks) to show all days of the month
    $weeks = 6;
    $calendarEnd = date('Y-m-d', strtotime(date('Y-m-d', $calendarStart) . ' +41 day'));
    $calendarEndEpoch = strtotime($calendarEnd);
}
?>

                <!-- Add navigation data to the calendar -->
                <table id="calendar" 
                       data-current-month="<?php echo date('Y-m', $monthEpoch); ?>"
                       data-prev-month="<?php echo date('Y-m', $previousMonth); ?>"
                       data-next-month="<?php echo date('Y-m', $nextMonth); ?>">
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
                        $loggedIn = 0; //Logged in set to 0 change later
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
                                if (date('m', $date) != date('m', $monthEpoch)) {
                                    $extraClasses .= ' other-month';
                                    $extraAttributes .= ' data-month="' . date('Y-m', $date) . '"';
                                }
                                $eventsStr = '';
                                $e = date('Y-m-d', $date);

                                if (isset($events[$e])) {
                                    $dayEvents = $events[$e];
                                    foreach ($dayEvents as $info) {

                                        $backgroundCol = '#996d49ff'; // default color

                                        if(isset($_SESSION['access_level'])) {
                                            if (is_archived($info['id'])) { // archived event
                                                if ($_SESSION['access_level'] < 2) {
                                                    continue; // users cannot see archived events
                                                }
                                                $backgroundCol = '#aaaaaa'; //TODO

                                            } elseif (check_if_signed_up($info['id'], $_SESSION['_id'])) {// user is signed-up for event
                                                $backgroundCol = '#4CAF50';

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
                        }
                    ?>
                    </tbody>
                </table>
</html>