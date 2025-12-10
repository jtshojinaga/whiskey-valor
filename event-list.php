    
<!DOCTYPE html>
    <body>
        <?php require_once('database/dbEvents.php');?>
        <?php require_once('database/dbPersons.php');?>
        <main class="general">
            <?php 
                    $loggedIn = false;
                    $accessLevel = 0;
                    $userID = null;
                    if (isset($_SESSION['_id'])) {
                        $loggedIn = true;
                        $accessLevel = $_SESSION['access_level'];
                        $userID = $_SESSION['_id'];
                    }
                    
                    $events = get_all_events_sorted_by_date_not_archived();
                    $archivedevents = get_all_events_sorted_by_date_and_archived();
                    $today = new DateTime();
                    
                    // Filter out expired events
                    $upcomingEvents = array_filter($events, function($event) use ($today) {
                        $eventDate = new DateTime($event->getEndDate());
                        return $eventDate >= $today;
                    });

                    $upcomingArchivedEvents = array_filter($archivedevents, function($event) use ($today) {
                        $eventDate = new DateTime($event->getEndDate());
                        return $eventDate >= $today;
                    });

                    if (sizeof($upcomingEvents) > 0): ?>
                        <table class="general">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Event Type</th>
                                    <th style="width:1px">Date</th>
                                    <th style="width:1px">Capacity</th>
                                    <th style="width:1px"></th>
                                </tr>
                            </thead>
                        <tbody>
                           <?php
                                foreach ($upcomingEvents as $event) {
                                    $eventID = $event->getID();
                                    $title = $event->getName();
                                    $date = $event->getStartDate();
                                    $startTime = $event->getStartTime();
                                    $endTime = $event->getEndTime();
                                    $description = $event->getDescription();
                                    $capacity = $event->getCapacity();
                                    $completed = $event->getCompleted();
                                    $restricted_signup = $event->getAccess();
                                    $type = $event->getEventType();

                                    // Fetch signups for the event
                                    $signups = fetch_event_signups($eventID);
                                    $numSignups = count($signups); // Number of people signed up
                                    // Check if the user is signed up for this event
                                    $isSignedUp = check_if_signed_up($eventID, $userID);

                                    //TODO: remove training_level_required and add other necessary fields -Blue
                                    echo "
                                    <tr data-event-id='$eventID'>
                                        <td><a href='event.php?id=$eventID' class='event-link'>$title</a></td>
                                        <td>$type</td>
                                        <td>$date</td>";

                                    if($numSignups >= $capacity) {
                                        echo "<td class='full-capacity'>Full</td>";
                                    } else {
                                        echo "<td>$numSignups / $capacity</td>";
                                    }
                                    
                                    if(isset($_SESSION['user_id']) && $_SESSION['user_id'] != 'guest') {
                                    // Display Sign Up or Cancel button based on user sign-up status
                                        if ($isSignedUp) {
                                            echo "
                                            <td>
                                            <a class='button cancel' href='viewMyUpcomingEvents.php' >Already Signed Up!</a>
                                            </td>";
                                        } elseif($numSignups >= $capacity) {
                                            echo "
                                                <td><a class='button-signup' style='background-color:#c73d06'>Sign Ups Closed!</a></td>";
                                        } else {
                                        echo "<td><a class='button-signup' href='eventSignUp.php?event_name=" . urlencode($title) . "&restricted=" . urlencode($restricted_signup) . "'>Sign Up</a></td>";
                                        }
                                    echo "</tr>"; 
                                        } else {
                                        echo "
                                        <td>
                                        <a class='button-signup' href='login.php' style='display:inline-block; width:116%; ' >Login to Register</a></td>
                                        </tr>";
                                        }
                                }
                            ?>
                        </tbody>
                    </table>
                <?php else: ?>
                <p class="no-events standout">There are currently no events available to view.<a class="button add" href="addEvent.php">Create a New Event</a> </p>
            <?php endif ?>
            </main>
        </body>
    </html>