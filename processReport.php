<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_cache_expire(30);
session_start();

if (!isset($_SESSION['access_level']) || $_SESSION['access_level'] < 2) {
    header('Location: login.php');
    die();
}

require_once('database/dbPersons.php');
require_once('database/dbEvents.php');
require_once('domain/Person.php');

// 👉 Add month completeness check function
// function is_month_complete($dateFrom) {
//     $lastDayOfMonth = date("Y-m-t", strtotime($dateFrom));
//     $today = date("Y-m-d");
//     return $today > $lastDayOfMonth;
// }

// Get user input
$eventID = $_POST['eventID'] ?? '';
$format = $_POST['format'] ?? 'csv';
$active_admin = $_POST['admin'] ?? 'wvfadmin';
$date_generated = $_POST['time'] ?? date("d-M-Y");

// Get selected field columns (may or may not be present)
$user_select = isset($_POST['user']) ? true : false;
$name_select = isset($_POST['name']) ? true : false;
$branch_select = isset($_POST['branch']) ? true : false;
$affiliation_select = isset($_POST['affiliation']) ? true : false;

// Determine if any detail fields are selected
$hasDetailFields = $user_select || $name_select || $branch_select || $affiliation_select;

// $currentMonth = date("m");
// $currentYear = date("Y");
// $fiscalYearStart = ($currentMonth >= 10) ? $currentYear : $currentYear - 1;
// $fiscalYearEnd = $fiscalYearStart + 1;

// // Define Fiscal Year Months
// $fiscalMonths = [
//     "10" => "October $fiscalYearStart", "11" => "November $fiscalYearStart", "12" => "December $fiscalYearStart",
//     "01" => "January $fiscalYearEnd", "02" => "February $fiscalYearEnd", "03" => "March $fiscalYearEnd",
//     "04" => "April $fiscalYearEnd", "05" => "May $fiscalYearEnd", "06" => "June $fiscalYearEnd",
//     "07" => "July $fiscalYearEnd", "08" => "August $fiscalYearEnd", "09" => "September $fiscalYearEnd"
// ];

// // Define Quarters
// $quarters = [
//     "Quarter 1" => ["10", "11", "12"],
//     "Quarter 2" => ["01", "02", "03"],
//     "Quarter 3" => ["04", "05", "06"],
//     "Quarter 4" => ["07", "08", "09"]
// ];

// // Update new volunteer status before fetching report data
// update_new_volunteer_status();

// Fetch Data
$reportData = [];
$event = retrieve_event($eventID);
$eventName = $event->getName();
$num_attended = fetch_num_attendees($eventID);
$num_attended = $num_attended['RowCount'];
$capacity = $event->getCapacity();
$noshows = count(fetch_event_signups($eventID)) - $num_attended;

$persons = fetch_event_signups($eventID);

$reportData[$eventID] = [
    // capacity, total attendance, total no shows
    "capacity" => $capacity,
    "attended" => $num_attended,
    "no_shows" => $noshows
];

// if ($reportType === "monthly" && isset($fiscalMonths[$month])) {
//     $monthName = $fiscalMonths[$month];
//     $dateFrom = ($month >= 10) ? "$fiscalYearStart-$month-01" : "$fiscalYearEnd-$month-01";

//     // ✅ Check if month is complete
//     if (!is_month_complete($dateFrom)) {
//         echo "<script>alert('The selected month is not yet complete. Please try again later.'); window.history.back();</script>";
//         exit();
//     }

//     $dateTo = date("Y-m-t", strtotime($dateFrom));

//     $reportData[$monthName] = [
//         "total_volunteers" => get_total_volunteers_count($dateTo),
//         "new_volunteers" => get_new_volunteers_count($dateFrom, $dateTo),
//         "new_dog_walkers" => get_new_dog_walkers_count($dateFrom, $dateTo),
//         "group_volunteers" => get_group_volunteers_count($dateFrom, $dateTo),
//         "community_service_volunteers" => get_community_service_volunteers_count($dateFrom, $dateTo),
//         "total_volunteer_hours" => get_total_vol_hours($dateFrom, $dateTo)
//     ];
// } else {
//     // Fetch for Full Fiscal Year (Annual Report)
//     foreach ($fiscalMonths as $monthNum => $monthName) {
//         $dateFrom = ($monthNum >= 10) ? "$fiscalYearStart-$monthNum-01" : "$fiscalYearEnd-$monthNum-01";
//         $dateTo = date("Y-m-t", strtotime($dateFrom));

//         $reportData[$monthName] = [
//             "total_volunteers" => get_total_volunteers_count($dateTo),
//             "new_volunteers" => get_new_volunteers_count($dateFrom, $dateTo),
//             "new_dog_walkers" => get_new_dog_walkers_count($dateFrom, $dateTo),
//             "group_volunteers" => get_group_volunteers_count($dateFrom, $dateTo),
//             "community_service_volunteers" => get_community_service_volunteers_count($dateFrom, $dateTo),
//             "total_volunteer_hours" => get_total_vol_hours($dateFrom, $dateTo)
//         ];
//     }
// }

// CSV EXPORT
if ($format === 'csv') {
    header("Content-Type: text/csv");
    header("Content-Disposition: attachment; filename=attendance_report_{$eventID}_{$eventName}.csv");
    header("Pragma: no-cache");
    header("Expires: 0");

    $output = fopen('php://output', 'w');
    fputcsv($output, ["Attendance Report - Event " . $eventID . ": {$eventName}"]);
    fputcsv($output, ["Report generated by " . $active_admin . " at {$date_generated}"]);

    // Column Headers
    fputcsv($output, ["ID", "Capacity", "Attended", "No Shows"]);

    // Data
    foreach ($reportData as $eventID => $data) {
        fputcsv($output, [
            $eventID,
            $data["capacity"],
            $data["attended"],
            $data["no_shows"]
        ]);
    }

    // Additional detail section if any fields are selected
    if ($hasDetailFields) {
        fputcsv($output, []);
        fputcsv($output, ["Attendee Details"]);
        
        // Build detail header
        $detailHeader = ["Username"];
        if ($name_select) $detailHeader[] = "Name";
        if ($branch_select) $detailHeader[] = "Branch";
        if ($affiliation_select) $detailHeader[] = "Affiliation";
        $detailHeader[] = "Attended";
        fputcsv($output, $detailHeader);
        
        // Populate detail rows
        foreach ($persons as $usr) {
            $person = retrieve_person($usr['userID']);
            $row = [$person->get_id()];
            if ($name_select) $row[] = $person->get_first_name() . " " . $person->get_last_name();
            if ($branch_select) $row[] = $person->get_branch() ?? 'N/A';
            if ($affiliation_select) $row[] = $person->get_affiliation() ?? 'N/A';
            
            // Check if person attended
            $attended = check_if_attended($eventID, $person->get_id()) ? 'Yes' : 'No';
            $row[] = $attended;
            
            fputcsv($output, $row);
        }
    }

    fclose($output);
    exit();
}

// EXCEL EXPORT
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=attendance_report_{$eventID}_{$eventName}.xls");
header("Pragma: no-cache");
header("Expires: 0");

echo "<html><head><meta charset='UTF-8'></head><body>";
echo "<table border='1' style='border-collapse: collapse; font-family: Arial, sans-serif; text-align: center;'>";

// Report Title
echo "<tr><th colspan='4' style='font-size: 18px; background-color: #1F1F21; color: white; padding: 10px;'>Attendance Report - " . $eventID . ": {$eventName}</th></tr>";
echo "<tr><th colspan='4' style='font-size: 16px; background-color: #1f1f21; color: white; padding: 10px;'>Report generated by " . $active_admin . " at {$date_generated}</th></tr>";

// Column Headers
echo "<tr>
        <th style='background-color: #88cceeff; padding: 5px;'>Event ID</th>
        <th style='background-color: #AA4499; padding: 5px;'>Capacity</th>
        <th style='background-color: #DDCC77; padding: 5px;'>Attended</th>
        <th style='background-color: #88CCEE; padding: 5px;'>No Shows</th>
      </tr>";

// Data Rows
foreach ($reportData as $eventID => $data) {
    echo "<tr>
            <td style='background-color: #EAEAEA; padding: 5px; text-align: center;'>$eventID</td>
            <td style='padding: 5px;'>{$data["capacity"]}</td>
            <td style='padding: 5px;'>{$data["attended"]}</td>
            <td style='padding: 5px;'>{$data["no_shows"]}</td>
          </tr>";
}

// Attendee detail section if any fields are selected
if ($hasDetailFields) {
    // Calculate colspan for detail section headers
    $detailColspan = 1; // Username
    if ($name_select) $detailColspan++;
    if ($branch_select) $detailColspan++;
    if ($affiliation_select) $detailColspan++;
    $detailColspan++; // Attended
    
    echo "<tr><td colspan='{$detailColspan}' style='background-color: #1F1F21; color: white; padding: 10px; font-weight: bold;'>Attendee Details</td></tr>";
    
    // Detail column headers
    echo "<tr>";
    echo "<th style='background-color: #88CCEE; padding: 5px;'>Username</th>";
    if ($name_select) echo "<th style='background-color: #88CCEE; padding: 5px;'>Name</th>";
    if ($branch_select) echo "<th style='background-color: #88CCEE; padding: 5px;'>Branch</th>";
    if ($affiliation_select) echo "<th style='background-color: #88CCEE; padding: 5px;'>Affiliation</th>";
    echo "<th style='background-color: #88CCEE; padding: 5px;'>Attended</th>";
    echo "</tr>";
    
    // Detail data rows
    foreach ($persons as $usr) {
        $person = retrieve_person($usr['userID']);
        echo "<tr>";
        echo "<td style='padding: 5px;'>" . htmlspecialchars($person->get_id()) . "</td>";
        
        if ($name_select) {
            $fullName = $person->get_first_name() . " " . $person->get_last_name();
            echo "<td style='padding: 5px;'>" . htmlspecialchars($fullName) . "</td>";
        }
        
        if ($branch_select) {
            $branch = $person->get_branch() ?? 'N/A';
            echo "<td style='padding: 5px;'>" . htmlspecialchars($branch) . "</td>";
        }
        
        if ($affiliation_select) {
            $affiliation = $person->get_affiliation() ?? 'N/A';
            echo "<td style='padding: 5px;'>" . htmlspecialchars($affiliation) . "</td>";
        }
        
        // Check if person attended
        $attended = check_if_attended($eventID, $person->get_id()) ? 'Yes' : 'No';
        echo "<td style='padding: 5px;'>{$attended}</td>";
        
        echo "</tr>";
    }
}

echo "</table>";
echo "</body></html>";
exit();
?>
