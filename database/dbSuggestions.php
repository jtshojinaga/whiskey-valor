<?php
include_once('dbinfo.php');

/**
 * Adds a new suggestion to the database.
 */
function add_suggestion($user_id, $title, $body) {
    $con = connect();
    
    // Sanitize inputs
    $user_id = mysqli_real_escape_string($con, $user_id);
    $title = mysqli_real_escape_string($con, $title);
    $body = mysqli_real_escape_string($con, $body);
    $time = date("Y-m-d H:i:s");

    $query = "INSERT INTO dbsuggestions (user_id, title, body, created_at) VALUES ('$user_id', '$title', '$body', '$time')";
    $result = mysqli_query($con, $query);
    
    mysqli_close($con);
    return $result;
}

/**
 * Retrieves all suggestions from the database, ordered by newest first.
 */
function get_all_suggestions() {
    $con = connect();
    $query = "SELECT * FROM dbsuggestions ORDER BY created_at DESC";
    $result = mysqli_query($con, $query);
    
    $suggestions = [];
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $suggestions[] = $row;
        }
    }
    
    mysqli_close($con);
    return $suggestions;
}
?>