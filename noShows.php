<?php
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

// admin-only access
if ($accessLevel < 2) {
    header('Location: index.php');
    die();
}

require_once 'database/dbPersons.php';
require_once 'domain/Person.php';
require_once 'database/dbEvents.php';
require_once 'domain/Event.php';

$no_shows = fetch_no_shows() ?? null;



?>

<!DOCTYPE html>
<html lang="en">
<head>
  	<link href="css/normal_tw.css" rel="stylesheet">
<!-- BANDAID FIX FOR HEADER BEING WEIRD -->
<?php
$tailwind_mode = true;
require_once('header.php');
?>
<style>
        .date-box {
            background: #C9AB81;
            padding: 7px 30px;
            border-radius: 50px;
            box-shadow: -4px 4px 4px rgba(0, 0, 0, 0.25) inset;
            color: white;
            font-size: 24px;
            font-weight: 700;
            text-align: center;
        }   
        .dropdown {
            padding-right: 50px;
        }   

</style>
<!-- BANDAID END, REMOVE ONCE SOME GENIUS FIXES -->

</head>
<body>
    <header class="hero-header">
        <div class="center-header">
            <h1>No Shows</h1>
        </div>
    </header>

    <main>
        <div class="main-content-box w-[80%] p-6">
            <?php if (isset($error)) echo "<p style='color: red;'>$error</p>"; ?>

            <table>
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Name</th>
                        <th>Number of No Shows</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($no_shows)): ?>
                        <?php 
                        $num_no_shows = count($no_shows);
                        ?>
                        <?php for ($i=0; $i<$num_no_shows; $i++) {
                            $userID = $no_shows[$i][0];
                            $user = retrieve_person($userID);
                            $name = get_name_from_id($userID);
                            $no_sho = $no_shows[$i][1];
                            
                            echo "
                            <tr>
                                <td>$userID</td>
                                <td>$name</td>
                                <td>$no_sho</td>
                            </tr>";
                        }?>
                            



                    <?php else: ?>
                        <tr><td colspan="3">No groups found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>



        </div>
        <div class="text-center mt-4">
                <a href="groupManagement.php" class="return-button">Back to Groups</a>
            </div>

        <div class="info-section">
            <div class="blue-div"></div>
            <p class="info-text">
            </p>
        </div>
    </main>
</body>
</html>
