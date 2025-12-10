<?php
    // Make session information accessible, allowing us to associate
    // data with the logged-in user.
    session_cache_expire(30);
    session_start();

    $loggedIn = false;
    $accessLevel = 0;
    $userID = null;
    $isAdmin = false;
    if (!isset($_SESSION['access_level']) || $_SESSION['access_level'] < 1) {
        header('Location: login.php');
        die();
    }
    if (isset($_SESSION['_id'])) {
        $loggedIn = true;
        // 0 = not logged in, 1 = standard user, 2 = manager (Admin), 3 super admin (TBI)
        $accessLevel = $_SESSION['access_level'];
        $isAdmin = $accessLevel >= 2;
        $userID = $_SESSION['_id'];
    } else {
        header('Location: login.php');
        die();
    }
    if ($isAdmin && isset($_GET['id'])) {
        require_once('include/input-validation.php');
        $args = sanitize($_GET);
        $id = strtolower($args['id']);
    } else {
        $id = $userID;
    }
    require_once('database/dbPersons.php');
    //if (isset($_GET['removePic'])) {
     // if ($_GET['removePic'] === 'true') {
       // remove_profile_picture($id);
      //}
    //}

   $user = retrieve_person($id);
  $verified_ids = get_verified_ids($user->get_id());

   if ($isAdmin && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_hours'])) {
    require_once('database/dbPersons.php'); // already required, so you can just remove the duplicate
    $con = connect();

    $newHours = floatval($_POST['new_hours']);
    $safeID = mysqli_real_escape_string($con, $id);

    $update = mysqli_query($con, "
        UPDATE dbpersons 
        SET total_hours_volunteered = $newHours 
        WHERE id = '$safeID'
    ");

    if ($update) {
        $user = retrieve_person($id); // refresh with updated hours
        echo '
        <div id="success-message" class="absolute left-[40%] top-[15%] z-50 bg-green-800 p-4 text-white rounded-xl text-xl">
          Hours updated successfully!
        </div>
        <script>
          setTimeout(() => {
            const msg = document.getElementById("success-message");
            if (msg) msg.remove();
          }, 3000);
        </script>
        ';
    } else {
        echo '<div class="absolute left-[40%] top-[15%] z-50 bg-red-800 p-4 text-white rounded-xl text-xl">Failed to update hours.</div>';
    }
  
}

    $viewingOwnProfile = $id == $userID;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      if (isset($_POST['url'])) {
        if (!update_profile_pic($id, $_POST['url'])) {
          header('Location: viewProfile.php?id='.$id.'&picsuccess=False');
        } else {
          header('Location: viewProfile.php?id='.$id.'&picsuccess=True');
        }
      }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Whiskey Valor | Profile Page</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    function showSection(sectionId) {
      const sections = document.querySelectorAll('.profile-section');
      sections.forEach(section => section.classList.add('hidden'));
      document.getElementById(sectionId).classList.remove('hidden');

      const tabs = document.querySelectorAll('.tab-button');
      tabs.forEach(tab => {
        tab.classList.remove('border-b-4', 'border-[#C9AB81]');
        tab.classList.add('hover:border-b-2', 'hover:border-[#C9AB81]');
      });

      const activeTab = document.querySelector(`[data-tab="${sectionId}"]`);
      activeTab.classList.add('border-b-4', 'border-[#C9AB81]');
      activeTab.classList.remove('hover:border-b-2', 'hover:border-[#C9AB81]');
    }

    window.onload = () => showSection('personal');
  </script>
  <?php 
    require_once('header.php'); 
    require_once('include/output.php');
  ?>

    <script>

      function openModal(modalID) {
          document.getElementById(modalID).classList.remove('hidden');
      }

      function closeModal(modalID) {
          document.getElementById(modalID).classList.add('hidden');
      }

      window.onload = () => showSection('personal');
  </script>

</head>
            <?php if ($id == 'vmsroot'): ?>
		<div class="absolute left-[40%] top-[20%] bg-red-800 p-4 text-white rounded-xl text-xl">The root user does not have a profile.</div>
                </main></body></html>
                <?php die() ?>
            <?php elseif (!$user): ?>
		<div class="absolute left-[40%] top-[20%] bg-red-800 p-4 text-white rounded-xl text-xl">User does not exist.</div>
                </main></body></html>
                <?php die() ?>
            <?php endif ?>
            <?php if (isset($_GET['editSuccess'])): ?>
		<div class="absolute left-[40%] top-[15%] z-50 bg-green-800 p-4 text-white rounded-xl text-xl">Profile updated successfully!</div>
            <?php endif ?>
            <?php if (isset($_GET['rscSuccess'])): ?>
		<div class="absolute left-[40%] top-[15%] z-50 bg-green-800 p-4 text-white rounded-xl text-xl">User role/status updated successfully!</div>
            <?php endif ?>

<body class="bg-gray-100">
  <!-- Hero Section -->
  <div class="h-48 relative" style="background-color: var(--page-background-color);">
  </div>

  <!-- Profile Content -->
  <div class="max-w-6xl mx-auto px-4 -mt-20 relative z-10 flex flex-col md:flex-row gap-6">
    <!-- Left Box -->
    <div class="w-full md:w-1/3 bg-white border border-gray-300 rounded-2xl shadow-lg p-6 flex flex-col justify-between">
      <div>
	<div class="flex justify-between items-center">
	<?php if ($viewingOwnProfile): ?>
          <h2 class="text-xl font-semibold mb-4">My Profile</h2>

	<?php else: ?>
	  <h2 class="text-xl font-semibold mb-4">Viewing <?php echo $user->get_first_name() . ' ' . $user->get_last_name() ?></h2>
	<?php endif ?>
	</div>
        <div class="space-y-2 divide-y divide-gray-300">
          <div class="flex justify-between py-2">
            <span class="font-medium">Joined</span><span>Jan 2022</span>
          </div>
          <div class="flex justify-between py-2">
            <span class="font-medium">Branch</span><span><?php echo ucfirst($user->get_branch()) ?></span>
          </div>
          <div class="flex justify-between py-2">
            <span class="font-medium">Affiliation</span><span><?php echo ucfirst($user->get_affiliation()) ?></span>
          </div>
        </div>
      </div>
      <div class="mt-6 space-y-2">
        <button type="button" class="text-lg font-medium w-full px-4 py-2 bg-[#C9AB81] text-[#1F1F21] rounded-md hover:bg-[#1F1F21] hover:text-[#C9AB81] cursor-pointer" onclick="openModal('verifiedIdsModal')">
          View Verified IDs
        </button>
        <button onclick="window.location.href='editProfile.php<?php if ($id != $userID) echo '?id=' . $id ?>';" class="text-lg font-medium w-full px-4 py-2 bg-[#C9AB81] text-[#1F1F21] rounded-md hover:bg-[#1F1F21] hover:text-[#C9AB81] cursor-pointer">Edit Profile</button>
        <button onclick="window.location.href='index.php';" class="text-lg font-medium w-full px-4 py-2 border-2 border-gray-300 text-black rounded-md hover:border-[#1F1F21] cursor-pointer">Return to Dashboard</button>
      </div>
    </div>

    <!-- Right Box -->
    <div class="w-full md:w-2/3 bg-white rounded-2xl shadow-lg border border-gray-300 p-6">
      <!-- Tabs -->
      <div class="flex border-b border-gray-300 mb-4">
        <button class="tab-button px-4 py-2 text-lg font-medium text-[#2B2B2E] border-b-4 border-[#1F1F21]" data-tab="personal" onclick="showSection('personal')">Personal Information</button>
        <button class="tab-button px-4 py-2 text-lg font-medium text-[#2B2B2E]" data-tab="contact" onclick="showSection('contact')">Contact Information</button>
        <button class="tab-button px-4 py-2 text-lg font-medium text-[#2B2B2E]" data-tab="volunteer" onclick="showSection('volunteer')">Email Preferences</button>
      </div>

      <!-- Personal Section -->
      <div id="personal" class="profile-section space-y-4">
        <div>
          <span class="block text-sm font-medium text-[#1F1F21]">Username</span>
          <p class="text-gray-900 font-medium text-xl"><?php echo $user->get_id() ?></p>
        </div>
        <div>
          <span class="block text-sm font-medium text-[#1F1F21]">Name</span>
          <p class="text-gray-900 font-medium text-xl"><?php echo $user->get_first_name() ?> <?php echo $user->get_last_name() ?></p>
        </div>
        <div>
          <span class="block text-sm font-medium text-[#1F1F21]">Date of Birth</span>
          <p class="text-gray-900 font-medium text-xl"><?php echo date('m/d/Y', strtotime($user->get_birthday())) ?></p>
        </div>
        <div>
          <span class="block text-sm font-medium text-[#1F1F21]">Address</span>
          <p class="text-gray-900 font-medium text-xl"><?php echo $user->get_street_address() . ', ' . $user->get_city() . ', ' . $user->get_state() . ' ' . $user->get_zip_code() ?></p>
        </div>
      </div>

      <!-- Contact Section -->
      <div id="contact" class="profile-section space-y-4 hidden">
        <div>
          <span class="block text-sm font-medium text-[#1F1F21]">Email</span>
          <p class="text-gray-900 font-medium text-xl"><a href="mailto:<?php echo $user->get_email() ?>"><?php echo $user->get_email() ?></a></p>
        </div>
        <div>
          <span class="block text-sm font-medium text-[#1F1F21]">Phone Number</span>
          <p class="text-gray-900 font-medium text-xl"><a href="tel:<?php echo $user->get_phone1() ?>"><?php echo formatPhoneNumber($user->get_phone1()) ?></a> (<?php echo ucfirst($user->get_phone1type()) ?>)</p>
        </div>
        <div>
          <span class="block text-sm font-medium text-[#1F1F21]">Emergency Contact Name</span>
          <?php if ($user->get_emergency_contact_first_name()):?>
            <p class="text-gray-900 font-medium text-xl"><?php $user->get_emergency_contact_first_name . $user->get_emergency_contact_last_name?></p>
          <?php else: ?>
            <p class="text-gray-900 font-medium text-xl">N/A</p>
          <?php endif ?>
        </div>
        <div>
          <span class="block text-sm font-medium text-[#1F1F21]">Emergency Contact Relation</span>
          <?php if ($user->get_emergency_contact_relation()):?>
            <p class="text-gray-900 font-medium text-xl"><?php echo $user->get_emergency_contact_relation()?></p>
          <?php else: ?>
            <p class="text-gray-900 font-medium text-xl">N/A</p>
          <?php endif ?>
        </div>
        <div>
          <span class="block text-sm font-medium text-[#1F1F21]">Emergency Contact Phone Number</span>
          <?php if ($user->get_emergency_contact_phone()): ?>
            <p class="text-gray-900 font-medium text-xl"><a href="tel:<?php echo $user->get_emergency_contact_phone() ?>"><?php echo formatPhoneNumber($user->get_emergency_contact_phone()) ?></a> (<?php echo ucfirst($user->get_emergency_contact_phone_type()) ?>)</p>
          <?php else: ?>
            <p class="text-gray-900 font-medium text-xl">N/A</p>
          <?php endif ?>
        </div>
 
      </div>

      <!-- Email Prefs Section -->
      <div id="volunteer" class="profile-section space-y-4 hidden">
        <div>
          <span class="block text-sm font-medium text-[#1F1F21]">Email</span>
          <p class="text-gray-900 font-medium text-xl"><?php echo $user->get_email() ?></p>
        </div>
        <div>
          <span class="block text-sm font-medium text-[#1F1F21]">Receive Emails?</span>
          <?php if ($user->get_email_prefs()):?>
            <p class="text-gray-900 font-medium text-xl"> Yes </p>
          <?php else: ?>
            <p class="text-gray-900 font-medium text-xl"> No </p>
          <?php endif ?>
        </div>


	      
      </div>
    </div>
  </div>

  <div id="verifiedIdsModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 overflow-y-auto h-full w-full hidden" style="z-index: 1000;">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-1/2 shadow-lg rounded-md bg-white">
        
        <div class="flex justify-between items-center pb-3 border-b">
            <h3 class="text-xl font-medium text-gray-900">Verified IDs for <?php echo htmlspecialchars($user->get_first_name()); ?></h3>
            <button class="text-black close-modal cursor-pointer font-bold text-2xl" onclick="closeModal('verifiedIdsModal')">&times;</button>
        </div>

        <div class="mt-4">
            <?php if (empty($verified_ids)): ?>
                <p class="text-gray-600 italic">No verified IDs found for this user.</p>
            <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-left text-sm font-light">
                        <thead class="border-b font-medium">
                            <tr>
                                <th scope="col" class="px-6 py-4">ID Type</th>
                                <th scope="col" class="px-6 py-4">Date Verified</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($verified_ids as $vid): ?>
                                <tr class="border-b hover:bg-gray-100">
                                    <td class="whitespace-nowrap px-6 py-4 font-medium text-green-700">
                                        ✓ <?php echo htmlspecialchars($vid['id_type']); ?>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-gray-700">
                                        <?php echo date("M j, Y", strtotime($vid['approved_at'])); ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>

        <div class="mt-6 flex justify-end">
            <button class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md w-auto shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-300" onclick="closeModal('verifiedIdsModal')">
                Close
            </button>
        </div>
        
    </div>
  </div>
</body>
</html>