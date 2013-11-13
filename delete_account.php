<?php
include 'lib.php';
$ch = dbConnect();
if (!empty($_GET)) {
	if (isset($_GET['USER_ID'])) {
		$q = "DELETE FROM sconnect_user WHERE USER_ID = $_GET[USER_ID]";
	if (!mysqli_query($ch, $q)) {
		die("Query Error:" . mysqli_error($ch));
	}
}
}
header('location:logout.php');
?>
