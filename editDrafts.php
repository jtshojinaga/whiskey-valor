<?php
session_cache_expire(30);
session_start();
ini_set("display_errors", 1);
error_reporting(E_ALL);

require_once(__DIR__ . '/database/dbinfo.php');
require_once(__DIR__ . '/email.php'); // optional, only if you need connect() or helper funcs

if (!isset($_SESSION['_id'])) {
    header('Location: login.php');
    exit;
}

$isAdmin = $_SESSION['access_level'] >= 2;
if (!$isAdmin) {
    echo "<div class='error-toast'>You do not have permission to edit drafts.</div>";
    exit;
}

// === Connect to DB ===
$conn = connect();

// === Fetch draft by ID ===
$draftID = $_GET['id'] ?? null;
if (!$draftID) {
    echo "<div class='error-toast'>No draft ID provided.</div>";
    exit;
}

$query = $conn->prepare("SELECT * FROM dbdrafts WHERE draftID = ?");
$query->bind_param("i", $draftID);
$query->execute();
$result = $query->get_result();

if ($result->num_rows === 0) {
    echo "<div class='error-toast'>Draft not found.</div>";
    exit;
}

$draft = $result->fetch_assoc();
$query->close();

// === Handle Form Submission ===
$message = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $subject = $_POST['subject'] ?? '';
    $body = $_POST['body'] ?? '';
    $recipientID = $_POST['recipientID'] ?? '';
    $scheduledSend = $_POST['scheduledSend'] ?? null;

    // Convert datetime-local to date for DB
    $sendDate = !empty($scheduledSend) ? date('Y-m-d', strtotime($scheduledSend)) : null;

    $update = $conn->prepare("
        UPDATE dbdrafts
        SET subject = ?, body = ?, recipientID = ?, scheduledSend = ?
        WHERE draftID = ?
    ");
    $update->bind_param("ssssi", $subject, $body, $recipientID, $sendDate, $draftID);

    if ($update->execute()) {
        $message = "<div class='success-toast'>Draft updated successfully!</div>";
        // Refresh data
        $draft['subject'] = $subject;
        $draft['body'] = $body;
        $draft['recipientID'] = $recipientID;
        $draft['scheduledSend'] = $sendDate;
    } else {
        $message = "<div class='error-toast'>Error updating draft: " . htmlspecialchars($update->error) . "</div>";
    }

    $update->close();
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <?php require_once('universal.inc'); ?>
    <title>Edit Draft | Whiskey Valor</title>
    <link href="css/base.css" rel="stylesheet">
    <style>
        form {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            max-width: 600px;
            margin: 0 auto;
        }

        label {
            font-weight: bold;
        }

        input, textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 1rem;
        }

        textarea {
            height: 200px;
            resize: vertical;
        }

        .btn-save {
            width: fit-content; /* button width matches text */
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.2s ease;
            margin-top: 1rem;
        }

        .btn-save:hover {
            background-color: #0056b3;
        }

        .btn-cancel {
            display: inline-block;
            margin-top: 10px;
            color: #007bff;
            text-decoration: none;
        }

        .btn-cancel:hover {
            text-decoration: underline;
        }

        .success-toast, .error-toast {
            margin-bottom: 1rem;
            padding: 10px;
            border-radius: 6px;
        }

        .success-toast {
            background-color: #d4edda;
            color: #155724;
        }

        .error-toast {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <?php require_once('header.php'); ?>

    <h1>Edit Draft</h1>
    <?php echo $message; ?>

    <form method="POST" action="">
        <label for="subject">Subject:</label>
        <input type="text" id="subject" name="subject" value="<?php echo htmlspecialchars($draft['subject']); ?>" required>

        <label for="body">Body:</label>
        <textarea id="body" name="body" rows="10"><?php echo htmlspecialchars($draft['body']); ?></textarea>

        <label for="recipientID">Recipients:</label>
        <input type="text" id="recipientID" name="recipientID" value="<?php echo htmlspecialchars($draft['recipientID']); ?>">

        <label for="scheduledSend">Scheduled Send:</label>
        <input type="date" id="scheduledSend" name="scheduledSend" value="<?php echo htmlspecialchars($draft['scheduledSend']); ?>">

        <button type="submit" class="btn-save">Save Changes</button>
        <a href="viewDrafts.php" class="btn-cancel">Back to Drafts</a>
    </form>
</body>
</html>
