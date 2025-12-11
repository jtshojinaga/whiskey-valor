<?php
    // Template for new VMS pages. Base your new page on this one

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
    // admin-only access
    if ($accessLevel < 2) {
        header('Location: index.php');
        die();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Whiskey Valor | Volunteer/Participant Search</title>
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

        body, main {
        background-color: #1F1F21;
        }

        .text-blue-700,
        .text-blue-700:visited {
        color: black !important;
        }   

        .info-section .info-text {
         color: #C9AB81 !important;
        }

        .blue-div {
        background-color: #C9AB81 !important;
        }

        .main-content-box label {
        color: #000000 !important;
        }
        
        .text-blue-700 {
        color: #000000 !important;
        }
        .sub-text {
        color: black !important;
        }

        .main-content-box table,
        .main-content-box table thead,
        .main-content-box table tbody,
        .main-content-box table tr,
        .main-content-box table th,
        .main-content-box table td {
            background-color: #1F1F21 !important;
            color: #C9AB81 !important;
            border: 1px solid #C9AB81 !important;
        }

        .main-content-box table a.text-blue-700,
        .main-content-box table a.text-blue-700:visited {
            color: #C9AB81 !important;
            }

        .main-content-box table thead.bg-blue-400 th {
            background-color: #1F1F21 !important;
        }

        .main-content-box table a.text-blue-700,
        .main-content-box table a.text-blue-700:visited {
            color: #C9AB81 !important;
        }
    
</style>
<!-- BANDAID END, REMOVE ONCE SOME GENIUS FIXES -->
</head>
<body>

<header class="hero-header">
    <div class="center-header">
        <h1>Volunteer/Participant Search</h1>
    </div>
</header>

<main>
    <div class="main-content-box w-[80%] p-8">

        <div class="text-center mb-8">
            <h2>Find a Volunteer or Participant</h2>
            <p class="sub-text">Use filters below to search and create mailing lists.</p>
        </div>

        <form id="person-search" class="space-y-6" method="get">

        <?php
            if (isset($_GET['name']) || isset($_GET['id']) || isset($_GET['phone']) || isset($_GET['zip']) || isset($_GET['role']) || isset($_GET['status']) || isset($_GET['photo_release'])) {
                require_once('include/input-validation.php');
                require_once('database/dbPersons.php');
                $args = sanitize($_GET);
                $required = ['name', 'id', 'phone', 'zip', 'role', 'status', 'photo_release'];

                if (!wereRequiredFieldsSubmitted($args, $required, true)) {
                    echo '<div class="error-block">Missing expected form elements.</div>';
                }

                $name = $args['name'];
                $id = $args['id'];
                $phone = preg_replace("/[^0-9]/", "", $args['phone']);
                $zip = $args['zip'];
                $role = $args['role'];
                $status = $args['status'];
                $photo_release = $args['photo_release'];

                if (!($name || $id || $phone || $zip || $role || $status || $photo_release)) {
                    echo '<div class="error-block">At least one search criterion is required.</div>';
                } else if (!valueConstrainedTo($role, ['admin', 'participant', 'superadmin', 'volunteer', ''])) {
                    echo '<div class="error-block">The system did not understand your request.</div>';
                } else if (!valueConstrainedTo($status, ['Active', 'Inactive', ''])) {
                    echo '<div class="error-block">The system did not understand your request.</div>';
                } else if (!valueConstrainedTo($photo_release, ['Restricted', 'Not Restricted', ''])) {
                    echo '<div class="error-block">The system did not understand your request.</div>';
                } else {
                    echo "<h3>Search Results</h3>";
                    $persons = find_users($name, $id, $phone, $zip, $role, $status, $photo_release);
                    require_once('include/output.php');

                    if (count($persons) > 0) {
                        echo '
                        <div class="overflow-x-auto">
                            <table>
                                <thead class="bg-blue-400">
                                    <tr>
                                        <th>First</th>
                                        <th>Last</th>
                                        <th>Username</th>
                                        <th>Phone</th>
                                        <th>Zip Code</th>
                                        <th>Role</th>
                                        <th>Archive Status</th>
                                        <th>Profile</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>';
                        $mailingList = '';
                        $notFirst = false;
                        foreach ($persons as $person) {
                            if ($notFirst) {
                                $mailingList .= ', ';
                            } else {
                                $notFirst = true;
                            }
                            $mailingList .= $person->get_email();
                            echo '
                                    <tr>
                                        <td>' . $person->get_first_name() . '</td>
                                        <td>' . $person->get_last_name() . '</td>
                                        <td><a href="mailto:' . $person->get_id() . '" class="text-blue-700 underline">' . $person->get_id() . '</a></td>
                                        <td><a href="tel:' . $person->get_phone1() . '" class="text-blue-700 underline">' . formatPhoneNumber($person->get_phone1()) . '</a></td>
                                        <td>' . $person->get_zip_code() . '</td>
                                        <td>' . ucfirst($person->get_type()) . '</td>
                                        <td>' . ucfirst($person->get_status()) . '</td>
                                        <td><a href="viewProfile.php?id=' . $person->get_id() . '" class="text-blue-700 underline">Profile</a></td>
                                        <td><a href="modifyUserRole.php?id=' . $person->get_id() . '" class="text-blue-700 underline">Update Status</a></td>
                                    </tr>';
                        }
                        echo '
                                </tbody>
                            </table>
                        </div>';

                        echo '
                        <div class="mt-4">
                            <label>Result Mailing List:</label>
                            <p class="text-gray-700 break-words">' . $mailingList . '</p>
                        </div>';
                    } else {
                        echo '<div class="error-block">Your search returned no results.</div>';
                    }
                    echo '<h3>Search Again</h3>';
                }
            }
        ?>

            <div>
                <label for="name">Name</label>
                <input type="text" id="name" name="name" class="w-full" value="<?php if (isset($name)) echo htmlspecialchars($_GET['name']); ?>" placeholder="Enter the user's first and/or last name">
            </div>

            <div>
                <label for="id">Username</label>
                <input type="text" id="id" name="id" class="w-full" value="<?php if (isset($id)) echo htmlspecialchars($_GET['id']); ?>" placeholder="Enter the user's username (login ID)">
            </div>

            <div>
                <label for="phone">Phone Number</label>
                <input type="tel" id="phone" name="phone" class="w-full" value="<?php if (isset($phone)) echo htmlspecialchars($_GET['phone']); ?>" placeholder="Enter the user's phone number">
            </div>

            <div>
                <label for="zip">Zip Code</label>
                <input type="text" id="zip" name="zip" class="w-full" value="<?php if (isset($zip)) echo htmlspecialchars($_GET['zip']); ?>" placeholder="Enter the user's zip code">
            </div>

            

            <div class="text-center pt-4">
                <input type="submit" value="Search" class="blue-button">
            </div>

        </form>
    </div>

    <div class="text-center mt-6">
        <a href="index.php" class="return-button">Return to Dashboard</a>
    </div>

    <div class="info-section">
        <div class="blue-div"></div>
        <p class="info-text">
            Use this tool to filter and search for volunteers or participants by their role, zip code, phone, archive status, and more. Mailing list support is built in.
        </p>
    </div>
</main>

</body>
</html>

