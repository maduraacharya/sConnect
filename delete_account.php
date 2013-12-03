<?php
session_start();
include_once 'lib.php';
include_once 'UserProfile.php'; 
$ch = dbConnect();

is_valid_session();

if (!empty($_GET)) {
	if (isset($_GET['user_id'])) {
		$user_profile = new UserProfile();
		$user_profile->setUserID($_GET['user_id']);
		$user_profile->fetch($ch, $_GET['user_id']);
		if ($user_profile->getRole() == 'admin') {
			die("Admin account cannot be deleted.");
		}
		if ($user_profile->getUserID() != $_SESSION['user']['user_id']) {
			die("You do not have privileges to perform this operation.");
		}
		$user_profile->delete($ch);
	}  
}
header('location:register.php');
?>
