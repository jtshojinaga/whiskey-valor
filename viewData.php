<?php
    // Template for new VMS pages. Base your new page on this one

    // Make session information accessible, allowing us to associate
    // data with the logged-in user.
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
?>
<!DOCTYPE html>
<html>
    <head>
        <?php require_once('universal.inc') ?>
        <title>View Data | Whiskey Valor Foundation</title>
    </head>
    <body>
        <?php require_once('header.php') ?>
        <main>
            <h1 style="color:white;">Data Browser</h1>
            <p>Use the controls below to pick a data source, filters and the fields you want in a report.</p>

            <form id="report-filters" method="POST">
            <section class="section-box">
                <h2>Select data source</h2>
                <div id="data-source">
                    <label><input type="checkbox" value="events" id="events">Events</label>
                    <label><input type="checkbox" value="users" id="users">Users</label>
                </div>

                <div id="filters" style="margin-top:1rem">
                    <!-- dynamic filters inserted here -->
                     <div id="event-filters">

                     </div>
                     <div id="user-filters">

                     </div>
                </div>

                <h3 style="margin-top:1rem">Field picker</h3>
                <div id="field-picker">
                    <label><input type="checkbox" value="user" checked> User</label>
                    <label><input type="checkbox" value="branch" checked> Branch</label>
                    <label><input type="checkbox" value="affiliation"> Affiliation</label>
                    <label><input type="checkbox" value="event_id" checked> Event ID</label>
                    <label><input type="checkbox" value="signed_up"> Signed Up</label>
                    <label><input type="checkbox" value="attended"> Attended</label>
                    <label><input type="checkbox" value="date"> Date</label>
                </div>

                <div style="margin-top:1rem">
                    <button id="generate-btn" disabled class="button-signup">Generate Report</button>
                </div>
            </section>
            </form>

        <script src="js/data-filters.js"></script>
        </main>
    </body>
</html>