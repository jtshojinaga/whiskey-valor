<?php
require_once(__DIR__ . '/database/dbinfo.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function retrieveAllEmails(array $names) {
    $conn = connect();

    error_log("retrieveAllEmails called with: " . json_encode($names));

    // Sending to ALL members
    if (count($names) === 1 && $names[0] === "All Whiskey Valor Members") {
        $query = "SELECT email FROM dbpersons WHERE email IS NOT NULL AND email != ''";
        $result = $conn->query($query);

        $emails = [];
        while ($row = $result->fetch_assoc()) {
            $emails[] = $row['email'];
        }

        error_log("retrieveAllEmails found " . count($emails) . " emails for ALL members");
        return array_values(array_unique($emails));
    }

    $emails = [];
    foreach ($names as $raw) {
        // Normalize whitespace and trim
        $fullName = preg_replace('/\s+/', ' ', trim($raw));

        if ($fullName === '') {
            continue;
        }

        // If user provided an email address directly, use it
        if (strpos($fullName, '@') !== false) {
            $stmt = $conn->prepare("SELECT email FROM dbpersons WHERE email = ? LIMIT 1");
            $stmt->bind_param("s", $fullName);
            $stmt->execute();
            $res = $stmt->get_result();
            if ($row = $res->fetch_assoc()) {
                $emails[] = $row['email'];
            } else {
                // If the email isn't in dbpersons, still include it (optional)
                // $emails[] = $fullName;
                error_log("Email not found in dbpersons: $fullName");
            }
            $stmt->close();
            continue;
        }

        // Split into parts — handle single-word names as well
        $parts = explode(' ', $fullName);
        if (count($parts) >= 2) {
            $firstName = $parts[0];
            $lastName = array_pop($parts);
            // try exact first+last
            $stmt = $conn->prepare(
                "SELECT email FROM dbpersons WHERE first_name = ? AND last_name = ? AND email IS NOT NULL AND email != ''"
            );
            $stmt->bind_param("ss", $firstName, $lastName);
            $stmt->execute();
            $res = $stmt->get_result();
            while ($row = $res->fetch_assoc()) {
                $emails[] = $row['email'];
            }
            $stmt->close();

            // fallback: try full name concatenation (handles middle names, different spacing)
            if (empty($emails)) {
                $likeName = '%' . $conn->real_escape_string($fullName) . '%';
                $stmt2 = $conn->prepare(
                    "SELECT email FROM dbpersons WHERE CONCAT(first_name,' ',last_name) LIKE ? AND email IS NOT NULL AND email != ''"
                );
                $stmt2->bind_param("s", $likeName);
                $stmt2->execute();
                $res2 = $stmt2->get_result();
                while ($row = $res2->fetch_assoc()) {
                    $emails[] = $row['email'];
                }
                $stmt2->close();
            }
        } else {
            // single token — try first_name or last_name
            $token = $parts[0];
            $stmt = $conn->prepare(
                "SELECT email FROM dbpersons WHERE (first_name = ? OR last_name = ?) AND email IS NOT NULL AND email != ''"
            );
            $stmt->bind_param("ss", $token, $token);
            $stmt->execute();
            $res = $stmt->get_result();
            while ($row = $res->fetch_assoc()) {
                $emails[] = $row['email'];
            }
            $stmt->close();
        }

        if (empty($emails)) {
            error_log("No email found for input: '$fullName'");
        }
    }

    // Deduplicate and return
    $emails = array_values(array_unique($emails));
    error_log("retrieveAllEmails returning: " . json_encode($emails));
    return $emails;
}


function sendEmails(array $emails, string $senderName, string $subject, string $body): array
{
    $python = "C:\\Users\\Jakea\\AppData\\Local\\Microsoft\\WindowsApps\\python.exe";
    $script = __DIR__ . "/email/send_email.py";
    $log = __DIR__ . "/email/email_errors.log";

    file_put_contents($log, "=== START ===\n", FILE_APPEND);

    // Build proper JSON
    $payload = json_encode([
        "emails" => array_values($emails),
        "senderName" => $senderName,
        "subject" => $subject,
        "body" => $body
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

    file_put_contents($log, "RAW JSON: $payload\n", FILE_APPEND);

    // Use temporary file to avoid escaping issues on Windows
    $tmpFile = tempnam(sys_get_temp_dir(), "email_payload_") . ".json";
    file_put_contents($tmpFile, $payload);

    // Build command: pass JSON file as stdin
    $cmd = "\"$python\" \"$script\" < \"$tmpFile\" 2>&1";
    file_put_contents($log, "CMD: $cmd\n", FILE_APPEND);

    exec($cmd, $output, $resultCode);

    file_put_contents($log, "RC: $resultCode\n", FILE_APPEND);
    file_put_contents($log, "OUTPUT:\n" . implode("\n", $output) . "\n", FILE_APPEND);

    unlink($tmpFile); // clean up temp file

    // Parse Python result
    $json = json_decode(implode("\n", $output), true);

    if (!$json) {
        file_put_contents($log, "Invalid JSON returned\n", FILE_APPEND);
        return [];
    }

    $results = [];

    if (isset($json["sent"])) {
        foreach ($json["sent"] as $email) {
            $results[$email] = true;
        }
    }

    if (isset($json["failed"])) {
        foreach ($json["failed"] as $fail) {
            $results[$fail["email"]] = false;
        }
    }

    return $results;
}
