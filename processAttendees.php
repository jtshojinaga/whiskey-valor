<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_cache_expire(30);
session_start();

if (!isset($_SESSION['access_level']) || $_SESSION['access_level'] < 2) {
    header('Location: index.php');
    exit;
}

require_once('database/dbPersons.php');
require_once('database/dbEvents.php');
require_once('include/input-validation.php');

$args = sanitize($_POST);

$eventID = $args['eventID'] ?? null;
if (empty($eventID)) {
    header('Location: index.php');
    exit;
}

// checkboxes are named attendee[<uid>] and notes are attendee_notes[<uid>]
$checked = isset($args['attendee']) && is_array($args['attendee']) ? $args['attendee'] : [];
$notes = isset($args['attendee_notes']) && is_array($args['attendee_notes']) ? $args['attendee_notes'] : [];

$signups = fetch_event_signups($eventID);

// signups may be an array of arrays or Person objs
foreach ($signups as $s) {
    // determine user id
    if (is_array($s)) {
        $uid = $s['userID'] ?? ($s['id'] ?? null);
    } elseif (is_object($s) && method_exists($s, 'get_id')) {
        $uid = $s->get_id();
    } else {
        // try common keys
        $uid = $s->userID ?? $s->id ?? null;
    }
    if (empty($uid)) continue;

    // checkbox is present in $checked only if it was checked
    $value = array_key_exists($uid, $checked) ? 1 : 0;

    // get note if any (already sanitized)
    $note = isset($notes[$uid]) ? $notes[$uid] : '';

    // call db function to log attendance 
    if (function_exists('log_attendance')) {
        log_attendance($uid, $eventID, $value, $note);
    } 
}

// After processing, redirect back to the event page
header('Location: event.php?id=' . urlencode($eventID) . '&update=1');
exit;
?>