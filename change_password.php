<?php include 'header.php'; ?>

<?php
$errmsg_arr = array();

if (!empty($_POST)) { 
	if (empty($errors)) {
		extract($_POST);
	if ($pw1 !=$pw2) {	
		die('Passwords do not match');
	} elseif ($_SESSION['user']['login_pwd'] != $pw) {
		die('Old password is incorrect');
	}
	else {
		$q = "UPDATE sconnect_user set login_pwd = '$pw1' WHERE USER_ID = " . $_SESSION['user']['USER_ID'];
		if (!mysqli_query($ch, $q)) {
		die("Query Error:" . mysqli_error($ch));
	} 
	echo "<p style='color:green'>Password Updated</p>";
		}		
 	}
}
 	
?>
		
<h2>Change Password</h2>
<form method="post" action="">
	Username: <input type="text" name="username" /><sup><font color="red">*</font></sup><br />
	Password: <input type="password" name="pw" /><sup><font color="red">*</font></sup><br />
	New Password: <input type="password" name="pw1" /><sup><font color="red">*</font></sup><br /> 
	Confirm Password: <input type="password" name="pw2" /><sup><font color="red">*</font></sup><br />
	<button type="submit">Change Password</button>
	<button type="submit"><a href="index.php">Cancel</a></button>
</form>
<?php include 'footer.php'; ?>
