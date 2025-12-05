<?php
session_cache_expire(30);
session_start();
ini_set("display_errors", 1);
error_reporting(E_ALL);
date_default_timezone_set("America/New_York");

// Ensure admin authentication
if (!isset($_SESSION['access_level']) || $_SESSION['access_level'] < 2) {
    header('Location: login.php');
    die();
}

// Get current fiscal year
$currentMonth = date("m");
$currentYear = date("Y");
$fiscalYearStart = ($currentMonth >= 10) ? $currentYear : $currentYear - 1;
$fiscalYearEnd = $fiscalYearStart + 1;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Whiskey Valor | Attendance Reports</title>
    <!--<script src="js/data-filters.js" defer></script>-->
    <link href="css/base.css" rel="stylesheet">
    <?php require_once('header.php'); ?>
</head>
<body>
    <?php require_once('database/dbEvents.php');?>
    <?php require_once('database/dbPersons.php');?>

    <!-- Hero Section with Title -->
        <div class="center-header">
            <h1 style="color:white;">Generate Attendance Report</h1>
        </div>
                <!-- Info Section -->
        <section class="section-box">
            <p style="margin-top: 1rem;text-align:center;">
                Use this tool to generate monthly or annual reports on volunteer activity. Reports are available in Excel or CSV format.
            </p>
        </section>

    <main>
        <?php $events = get_all_events_sorted_by_date_not_archived();?>

        <div class="main-content-box">
            <!--<div class="text-center">
                <p style="font-size: 18px; color: #c2c2c2ff; margin-top: 0.5rem; margin-bottom: 0.5rem;">Fiscal Year: <?= $fiscalYearStart ?> - <?= $fiscalYearEnd ?></p>
            </div>-->

            <form method="POST" action="processReport.php">
                <!-- Event ID -->
                <div style="margin-bottom: 1.5rem;">
                    <label for="eventID" style="font-weight: 600;">Select Event</label>
                    <select name="eventID" id="eventID">
                        <?php foreach ($events as $event) {
                            $eventID = $event->getID();
                            $eventName = $event->getName();
                            echo "<option value='$eventID'>$eventName (ID: $eventID)</option>";
                        }
                        ?>
                    </select>
                </div>

                <!-- Month (conditionally hidden)
                <div id="monthField">
                    <label for="month" class="font-semibold">Select Month:</label>
                    <select name="month" id="month">
                        <?php
                        $months = [
                            '10' => 'October', '11' => 'November', '12' => 'December', '01' => 'January',
                            '02' => 'February', '03' => 'March', '04' => 'April', '05' => 'May',
                            '06' => 'June', '07' => 'July', '08' => 'August', '09' => 'September'
                        ];
                        foreach ($months as $num => $name) {
                            echo "<option value='$num'>$name</option>";
                        }
                        ?>
                    </select>
                </div> -->

                <!-- Content Select -->

                    <h4 style="margin-top: 1rem; margin-bottom: 0.5rem; font-weight: 600; color: var(--accent-color);">Field Selector</h4>
                    <p style="font-size: 16px; color: #c2c2c2ff; margin-top: 0.5rem; margin-bottom: 0.5rem;">If any fields are selected, the report will include all users who signed up and whether they attended.</p>
                    <div id="field-picker">
                            <div class="checkbox-grouping">
                                <label class="checkbox-label">
                                    <input type="checkbox" value="user" name="user" id="user" checked> Username</label>
                                <label class="checkbox-label">
                                    <input type="checkbox" value="name" name="name" id="name" checked> Full Name</label>
                                <label class="checkbox-label">
                                    <input type="checkbox" value="branch" name="branch" id="branch"> Branch</label>
                                <label class="checkbox-label">
                                    <input type="checkbox" value="affiliation" name="affiliation" id="affiliation"> Affiliation</label>
                        </div>
                    </div>
                </section>

                <!-- Format -->
                <div style="margin-bottom: 1.5rem; margin-top: 1.5rem;">
                    <label for="format" style="font-weight: 600;">File Format</label>
                    <select name="format" id="format">
                        <option value="excel">Excel (.xls)</option>
                        <option value="csv">CSV (.csv)</option>
                    </select>
                </div>

                <div style="text-align: center; margin-top: 2rem;">
                    <input type="hidden" value="<?php echo $_SESSION['_id']; ?>" name="admin" id="admin">
                    <input type="hidden" value="<?php echo date("d-M-Y H:i:s e") ?>" name="time" id="time">
                    <input type="submit" value="Generate Report" class="button generate-btn">
                </div>
            </form>

        <!-- Return Button -->
        </div>
        <div style="text-align: center; margin-top: 2rem;">
            <a href="index.php" class="button" style="display: inline-block; text-decoration: none; width: 41%;">Return to Dashboard</a>
        </div>

    </main>

    <script>
        function toggleDateFields() {
            const eventID = document.getElementById("eventID").value;
            // const monthField = document.getElementById("monthField");
            // monthField.style.display = reportType === "annually" ? "none" : "block";
        }
        document.addEventListener("DOMContentLoaded", toggleDateFields);
    </script>
</body>
</html>

