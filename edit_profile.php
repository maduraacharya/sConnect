<?php include_once 'header.php'; ?>

<?php

is_valid_session();

if(!empty($_POST)) {
	if (empty($errors)){
		if (isset($_POST['user_id'])) {
			extract($_POST);
			$user_profile = new UserProfile();
			$user_profile->fetch($ch, $user_id);
			if ($user_profile->getUserID() != $_SESSION['user']['user_id']) {
				die("You do not have privileges to perform this operation.");
			}
			$user_profile->setFirstName($firstname);
			$user_profile->setLastName($lastname);
			$user_profile->setStudentID($username);
			$user_profile->setContactEmail($email);
			$user_profile->setContactPhone($phoneno);
			$user_profile->update($ch);
			echo "<p style='color:green'>Profile Updated</p>";
		}
	}
}  


if (!empty($_GET)) {
	switch ($_GET['action']) {
		case "update":
			show_profile("update" , $ch);
	}
}
else {
	show_profile();
}
?>


<?php include_once 'footer.php'; ?>