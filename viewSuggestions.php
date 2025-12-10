<?php
ob_start();
session_cache_expire(30);
session_start();

$loggedIn = false;
$accessLevel = 0;
$userID = null;

if (isset($_SESSION['_id'])) {
    $loggedIn = true;
    $accessLevel = $_SESSION['access_level'];
    $userID = $_SESSION['_id'];
}

// Ensure only admins (Level 2+) can access this page
if ($accessLevel < 2) {
    header('Location: index.php');
    die();
}

include_once "database/dbSuggestions.php";
$suggestions = get_all_suggestions();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link href="css/normal_tw.css" rel="stylesheet">
    <?php 
    $tailwind_mode = true;
    require_once('header.php'); 
    ?>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .user-link {
            color: #297760; /* Theme green color */
            font-weight: bold;
            text-decoration: none;
        }
        .user-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<header class="hero-header">
    <div class="center-header">
        <h1>Review Suggestions</h1>
    </div>
</header>

<main>
    <div class="main-content-box w-[80%] p-8" style="margin: 2rem auto; background: white; border-radius: 10px; padding: 2rem; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
        
        <?php if (empty($suggestions)): ?>
            <p style="text-align: center; font-size: 1.2rem;">No suggestions found.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>User</th>
                        <th>Subject</th>
                        <th>Suggestion</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($suggestions as $row): ?>
                        <tr>
                            <td style="white-space: nowrap;"><?php echo htmlspecialchars($row['created_at']); ?></td>
                            <td>
                                <a href="viewProfile.php?id=<?php echo urlencode($row['user_id']); ?>" class="user-link">
                                    <?php echo htmlspecialchars($row['user_id']); ?>
                                </a>
                            </td>
                            <td><?php echo htmlspecialchars($row['title']); ?></td>
                            <td><?php echo nl2br(htmlspecialchars($row['body'])); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

    </div>
    
    <div class="text-center mt-6">
        <a href="index.php" class="return-button" style="padding: 10px 20px; background-color: #6c757d; color: white; text-decoration: none; border-radius: 5px;">Return to Dashboard</a>
    </div>

</main>
</body>
</html>
<?php ob_end_flush(); ?>