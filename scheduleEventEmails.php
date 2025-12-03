<?php
// include/event-functions.php
require_once '/database/dbinfo.php'; // DB connection
require_once '/email.php'; // email sending function
require_once '/database/dbEvents.php'; //getPAttendance

$conn = connect();

function scheduleEventEmails($userID, $event) {
    global $conn;

    // Automatically fetch recipient userIDs from the event
    $recipientIDs = getPAttendance($event['id']);

    $eventDateTime = $event['startDate'] . ' ' . ($event['startTime'] ?? '00:00:00');

    $oneWeekBefore = date('Y-m-d H:i:s', strtotime($eventDateTime . ' -7 days'));
    $oneDayBefore  = date('Y-m-d H:i:s', strtotime($eventDateTime . ' -1 day'));

    $emails = [
        [
            'scheduledSend' => $oneWeekBefore,
            'subject' => "Reminder: {$event['name']} in 1 week",
            'body' => "This is a reminder that the event '{$event['name']}' is coming up on {$eventDateTime}.",
        ],
        [
            'scheduledSend' => $oneDayBefore,
            'subject' => "Reminder: {$event['name']} tomorrow",
            'body' => "This is a reminder that the event '{$event['name']}' is happening tomorrow ({$eventDateTime}).",
        ]
    ];

    $stmt = $conn->prepare("
        INSERT INTO dbscheduledemails (userID, recipientID, subject, body, scheduledSend)
        VALUES (?, ?, ?, ?, ?)
    ");

    foreach ($emails as $email) {
        foreach ($recipientIDs as $recipientID) {
            $stmt->execute([$userID, $recipientID, $email['subject'], $email['body'], $email['scheduledSend']]);
        }
    }
}
