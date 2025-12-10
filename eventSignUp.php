<?php
    // Make session information accessible, allowing us to associate
    // data with the logged-in user.
    session_cache_expire(30);
    session_start();

    $loggedIn = false;
    $accessLevel = 0;
    $userID = null;

    if (isset($_SESSION['_id'])) {
        $loggedIn = true;
        // 0 = not logged in, 1 = standard user, 2 = manager (Admin), 3 super admin (TBI)
        $accessLevel = $_SESSION['access_level'];
        $userID = $_SESSION['_id'];
    } 

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        require_once('include/input-validation.php');
        require_once('database/dbEvents.php');
        require_once('database/dbPersons.php');
        $args = sanitize($_POST, null);

        $required = array("event-name", "account-name");

        if (!wereRequiredFieldsSubmitted($args, $required)) {
            echo 'bad form data';
            die();
        }

        $name = htmlspecialchars_decode($args['event-name']);
        $account_name = htmlspecialchars_decode($args['account-name']);
        $role = isset($args['role']) ? $args['role'] : '';
        $skills = isset($args['skills']) ? $args['skills'] : '';
        $restrictions = isset($args['restrictions']) ? $args['restrictions'] : '';
        $disabilities = isset($args['disabilities']) ? $args['disabilities'] : '';
        $materials = isset($args['materials']) ? $args['materials'] : '';

        $notes = "Skills: $skills | Dietary restrictions: $restrictions | Disabilities: $disabilities | Materials: $materials";

        // 🔹 FIXED: read restricted flag from POST, not GET
        $type = isset($args['type']) ? $args['type'] : '';
        if ($type === "Retreat") {
            $id = request_event_signup($name, $account_name, $role, $notes);
            if (!$id) {
                header('Location: requestFailed.php');
                die();
            }

            require_once('database/dbMessages.php');
            send_system_message(
                $userID,
                "Your request to sign up for $name has been sent to an admin.",
                "Your request to sign up for $name will be reviewed by an admin shortly. You will get another notification when you are approved or denied."
            );

            header('Location: signupPending.php');
            die();
        } 
        else {
            $id = sign_up_for_event($name, $account_name, $role, $notes);
            if (!$id) {
                header('Location: eventFailure.php');
                exit();
            }

            require_once('database/dbMessages.php');
            send_system_message(
                $userID,
                "You are now signed up for $name!",
                "Thank you for signing up for $name!"
            );

            header('Location: signupSuccess.php');
            die();
        }
    }

    // Connect to database
    include_once('database/dbinfo.php'); 
    $con = connect();  

    // Get event info from GET parameters
    $event_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    $event_name = isset($_GET['event_name']) ? htmlspecialchars($_GET['event_name']) : '';
    $type = isset($_GET['type']) ? htmlspecialchars($_GET['type']) : '';

    if ($event_id === 0){
        header('Location: requestFailed.php');
                die();
    }

    // Retrieve user info from session
    $username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
    $account_name = isset($_SESSION['_id']) ? $_SESSION['_id'] : '';
?>
<!DOCTYPE html>
<html>
    <head>
        <?php require_once('universal.inc') ?>
        <title>Whiskey Valor | Sign-Up for Event</title>
    </head>
    <body>
        <?php require_once('header.php') ?>
        <h1>Sign-Up for Event</h1>
        <main class="date">
            <h2>Sign-Up for Event Form</h2>

            <form id="new-event-form" method="post">
                <!-- ✅ Hidden event ID -->
                <input type="hidden" name="event_id" value="<?php echo $event_id; ?>">

                <label for="event-name">* Event Name </label>
                    <input type="text" id="event-name" name="event-name" required 
                    value="<?php echo htmlspecialchars_decode($event_name, ENT_QUOTES); ?>"
                    placeholder="Event name" readonly>

                <!-- Autofill and make the account name readonly -->               
                <label for="account-name">* Your Account Name </label>
                <input type="text" id="account-name" name="account-name" 
                    <?php echo ($accessLevel >= 2) ? '' : 'readonly'; ?> 
                    value="<?php echo htmlspecialchars($account_name); ?>" 
                    placeholder="Enter account name">

                <label for="skills"> Do You Have Any Skills To Share? </label>
                <input type="text" id="skills" name="skills" placeholder="Enter skills. Ex. crochet, tap dancer">

                <label for="disabilities"> Do You Have Any Disabilities We Should Be Aware Of? </label>
                <input type="text" id="disabilities" name="disabilities" placeholder="Enter disabilities">

                <label for="materials"> Are You Bringing Any Materials (e.g. snacks, craft supplies)? </label>
                <input type="text" id="materials" name="materials" placeholder="Enter materials. Ex. felt, pipe cleaners">

                <fieldset>
                    <label for="role">* Are you a volunteer or a participant? </label>
                    <div class="radio-group">
                        <input type="radio" id="v" name="role" value="v" required>
                        <label for="v">Volunteer</label>
                        <input type="radio" id="p" name="role" value="p" required>
                        <label for="p">Participant</label>
                    </div>
                </fieldset>

                <!-- 🔹 Preserve type flag across POST -->
                <input type="hidden" name="type" value="<?php echo $type; ?>">

                <br/>
                <input type="submit" value="Sign up for Event">
            </form>

            <a class="button cancel" href="index.php" style="margin-top: -.5rem">Return to Dashboard</a>
        </main>
    </body>
</html>
