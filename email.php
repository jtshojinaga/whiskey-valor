<?php
require_once(__DIR__ . '/database/dbinfo.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


function retrieveAllEmails(array $ids = []): array {
    $conn = connect();
    $emails = [];

    // Ensure NULL → empty array
    if (!is_array($ids)) {
        $ids = [];
    }

    // --- ALL members ---
    if (empty($ids)) {
        $query = "SELECT id, email FROM dbpersons WHERE email IS NOT NULL AND email != ''";
        $res = $conn->query($query);
        while ($row = $res->fetch_assoc()) {
            $emails[$row['id']] = $row['email'];
        }
        return $emails;
    }

    // --- SPECIFIC members ---
    // DO NOT convert to int — IDs are VARCHAR
    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $types = str_repeat('s', count($ids));  // <-- string params!

    $sql = "SELECT id, email 
            FROM dbpersons 
            WHERE id IN ($placeholders) 
            AND email IS NOT NULL 
            AND email != ''";

    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        return [];
    }

    // Prepare binding references
    $params = [ &$types ];
    foreach ($ids as $k => $v) {
        $params[] = &$ids[$k];
    }

    call_user_func_array([$stmt, 'bind_param'], $params);

    $stmt->execute();
    $res = $stmt->get_result();

    while ($row = $res->fetch_assoc()) {
        $emails[$row['id']] = $row['email'];
    }

    $stmt->close();
    return $emails;
}

function sendEmails(array $emails, string $senderName, string $subject, string $body): array {
    $url = "https://jenniferp217.sg-host.com/email/send_email.php";

    $payload = [
        "emails" => $emails,
        "subject" => $subject,
        "body" => $body,
        "senderName" => $senderName
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

    $response = curl_exec($ch);
    $curlError = curl_error($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    // Log raw response and HTTP status for debugging
    $log = "[sendEmails] HTTP $httpCode | cURL Error: $curlError | Response: $response\n";
    file_put_contents(__DIR__ . '/email_debug.log', $log, FILE_APPEND);

    $decoded = json_decode($response, true);

    if (!is_array($decoded)) {
        return [
            "success" => false,
            "results" => [[
                "email" => "all",
                "success" => false,
                "error" => $curlError ?: "Invalid JSON response",
                "raw_output" => $response
            ]]
        ];
    }

    return $decoded;
}





