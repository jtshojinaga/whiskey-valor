<?php
session_cache_expire(30);
session_start();

if (!isset($_SESSION['access_level']) || $_SESSION['access_level'] < 1) {
    header('Location: login.php');
    die();
}

require_once('include/input-validation.php');
require_once('database/dbApplications.php');
require_once('database/dbEvents.php');
require_once('database/dbPersons.php');


ini_set('display_errors', 1);
error_reporting(E_ALL);

/*$args = sanitize($_GET);
$id = $args['id'] ?? null;*/

// Handle user removal
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $event_id = $_POST['event_id'] ?? null;
    $user_id = $_POST['user_id'] ?? null;

    if (!$event_id) {
        echo 'Event ID is missing.';
        die();
    }

    if (!$user_id) {
        echo 'User ID is missing.';
        die();
    }
}

// Fetch event details
$pending_apps = fetch_pending_apps();

$access_level = $_SESSION['access_level']; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once('universal.inc'); ?>
    <link rel="stylesheet" href="css/event.css" type="text/css" />

    <title>View Event Details | <?php /*echo htmlspecialchars($event_info['name']); */ ?></title>
    <link rel="stylesheet" href="css/messages.css" />

    <script>
        function showResolutionConfirmation(ei, ui) {
            document.getElementById('resolution-confirmation-wrapper-' + ei + '-' + ui).classList.remove('hidden');
            return false;
        }
        function showApprove(ei, ui) {
            document.getElementById('resolution-confirmation-wrapper-' + ei + '-' + ui).classList.add('hidden');
            document.getElementById('reject-confirmation-wrapper-' + ei + '-' + ui).classList.add('hidden');
            document.getElementById('flag-confirmation-wrapper-' + ei + '-' + ui).classList.add('hidden');
            document.getElementById('approve-confirmation-wrapper-' + ei + '-' + ui).classList.remove('hidden');
            return false;
        }
        function showReject(ei, ui) {
            document.getElementById('resolution-confirmation-wrapper-' + ei + '-' + ui).classList.add('hidden');
            document.getElementById('approve-confirmation-wrapper-' + ei + '-' + ui).classList.add('hidden');
            document.getElementById('flag-confirmation-wrapper-' + ei + '-' + ui).classList.add('hidden');
            document.getElementById('reject-confirmation-wrapper-' + ei + '-' + ui).classList.remove('hidden');
            return false;
        }
        function showFlag(ei, ui) {
            document.getElementById('resolution-confirmation-wrapper-' + ei + '-' + ui).classList.add('hidden');
            document.getElementById('approve-confirmation-wrapper-' + ei + '-' + ui).classList.add('hidden');
            document.getElementById('reject-confirmation-wrapper-' + ei + '-' + ui).classList.add('hidden');
            document.getElementById('flag-confirmation-wrapper-' + ei + '-' + ui).classList.remove('hidden');
            return false;
        }
        
    </script>
</head>

<body>
    <?php require_once('header.php'); ?>

    <h1>View Pending Applications</h1>
    <?php if (isset($_GET['pendingSignupSuccess'])): ?>
        <div class="happy-toast">Application resolved successfully.</div>
    <?php endif ?>
    <?php if (isset($_GET['pendingFlagSuccess'])): ?>
        <div class="happy-toast">Application flagged successfully.</div>
    <?php endif ?>

    <main class="general">

        <p>
            <?php if (sizeof($pending_apps) === 0):
                echo "There are 0 pending applications awaiting resolution.";
                ?>
            <?php elseif (sizeof($pending_apps) === 1):
                echo "There is 1 pending applications awaiting resolution"; ?>
            <?php else: ?>
                <?php echo "There are " . htmlspecialchars(string: sizeof($pending_apps)) . " pending applications awaiting resolution"; ?>
            <?php endif; ?>
        </p>

        <?php if (count(value: $pending_apps) > 0): ?>
            <div class="table-wrapper">
                <table class="general">
                    <thead>
                        <tr>
                            <th>Event Name</th>
                            <th>Applicant Name</th>
                            <th>User ID</th>
                            
                            <?php if ($access_level >= 2): ?>
                                <th>Actions</th>
                            <?php endif; ?>
                            <th><th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            foreach ($pending_apps as $app): ?>
                                    <?php $appID = $app->getID(); 
                                    $userID = $app->getUserID();
                                    $event_id = $app->getEventID();
                                    $flagged = $app->getFlagged();
                                    $event = retrieve_event($event_id);
                                    $eventName = $event->getName();
                                    $person = retrieve_person($userID);
                                    $first_name = $person->get_first_name();
                                    $last_name = $person->get_last_name();
                                    $note = $app->getNote(); ?>
                            
                            <tr>


                                <td><a
                                        href="event.php?id=<?php echo urlencode($event_id); ?>"><?php echo htmlspecialchars($eventName); ?></a>
                                </td>
                                <td><?php echo htmlspecialchars($first_name); ?> <?php echo htmlspecialchars($last_name); ?></td>
                                
                                <td><a href="viewProfile.php?id=<?php echo urlencode($userID); ?>"><?php echo htmlspecialchars($userID); ?></a></td>

                                <?php if ($access_level >= 2): ?>
                                    <td>
                                        <form method="POST" style="display:inline;">
                                            <input type="hidden" name="event_id" value="<?= $event_id; ?>">
                                            <input type="hidden" name="user_id"
                                                value="<?php echo htmlspecialchars($userID); ?>">
                                        </form>
                                        <?php $ei = $event_id;
                                        $ui = $userID; ?>
                                        <button onclick="showResolutionConfirmation(<?=$ei?>, '<?=$ui?>')" class="button">Resolve</button>
                                    </td>
                                <?php endif; ?>
                                <td><a href='viewApplication.php?app_id=<?php echo urlencode($appID); ?>&user_id=<?php echo urlencode($userID); ?>'>View</a></td>

                                <?php if ($flagged): ?>
                                    <td style='background-color: #e50000ff'></td></tr>
                                <?php else: ?>
                                    <td style='background-color: #1F1F21'></td></tr> 
                                <?php endif ?>
                            </tr>
                            <div id="resolution-confirmation-wrapper-<?= $event_id ?>-<?= $userID ?>" class="modal-content hidden" style = "margin:auto">
                                <div class="modal-content">
                                <?php $en = $event_id;
                                $un = $userID; ?>
                                    <p style="color: black;">What would you like to do?</p>
                                    <button onclick="showApprove(<?=$en?>, '<?=$un?>')" class="button success">Approve</button>
                                    <button onclick="showReject(<?=$en?>, '<?=$un?>')" class="button danger">Reject</button>
                                    <button onclick="showFlag(<?=$en?>, '<?=$un?>')" class="button warning">Flag</button>
                                    <button
                                        onclick="document.getElementById('resolution-confirmation-wrapper-<?= $event_id ?>-<?= $userID ?>').classList.add('hidden')"
                                        id="cancel-cancel" class="button cancel">Cancel</button>
                                </div>
                            </div>
                            <div id="approve-confirmation-wrapper-<?= $event_id ?>-<?= $userID ?>" class="modal-content hidden" style = "margin:auto">
                                <div class="modal-content">
                                    <p style="color: black;">Are you sure you want to approve this sign-up request?</p>
                                    <p style="color: black;">This action cannot be undone</p>
                                    <form method="post" action="fromPendingApproveSignup.php">
                                        <input type="submit" value="Approve" class="button success">
                                        <input type="hidden" name="app_id" value="<?= $appID ?>">
                                        <input type="hidden" name="event_id" value="<?= $event_id ?>">
                                        <input type="hidden" name="user_id" value="<?= $userID ?>">
                                        <input type="hidden" name="notes" value="<?= $note ?>">
                                    </form>
                                    <button
                                        onclick="document.getElementById('approve-confirmation-wrapper-<?= $event_id ?>-<?= $userID ?>').classList.add('hidden')"
                                        id="cancel-cancel" class="button cancel">Cancel</button>
                                </div>
                            </div>
                            <div id="reject-confirmation-wrapper-<?= $event_id ?>-<?= $userID ?>" class="modal-content hidden" style = "margin:auto">
                                <div class="modal-content">
                                    <p style="color: black;">Are you sure you want to reject this sign-up request?</p>
                                    <p style="color: black;">This action cannot be undone </p>
                                    <form method="post" action="fromPendingRejectSignup.php">
                                        <input type="submit" value="Reject" class="button danger">
                                        <input type="hidden" name="app_id" value="<?= $appID ?>">
                                        <input type="hidden" name="event_id" value="<?= $event_id ?>">
                                        <input type="hidden" name="user_id" value="<?= $userID ?>">
                                        <input type="hidden" name="notes" value="<?= $note ?>">
                                    </form>
                                    <button
                                        onclick="document.getElementById('reject-confirmation-wrapper-<?= $event_id ?>-<?= $userID ?>').classList.add('hidden')"
                                        id="cancel-cancel" class="button cancel">Cancel</button>
                                </div>
                            </div>
                            
                            <div id="flag-confirmation-wrapper-<?= $event_id ?>-<?= $userID ?>" class="modal-content hidden" style = "margin:auto">
                                <div class="modal-content">
                                    <p style="color: black;">Are you sure you want to flag this sign-up request?</p>
                                    <form method="post" action="fromPendingFlagSignup.php">
                                        <input type="submit" value="Flag" class="button warning">
                                        <input type="hidden" name="app_id" value="<?= $appID ?>">
                                    </form>
                                    <button
                                        onclick="document.getElementById('flag-confirmation-wrapper-<?= $event_id ?>-<?= $userID ?>').classList.add('hidden')"
                                        id="cancel-cancel" class="button cancel">Cancel</button>
                                </div>
                            </div>


                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif ?>
        <a class="button cancel" href="viewAllApplications.php">View All Applications</a>
        <a class="button cancel" href="index.php">Return to Dashboard</a>
        
    </main>


</body>

</html>