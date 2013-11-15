<?php

function outputErrors($errors) {
	if (!empty($errors)) { 
		foreach($errors as $k => $error) { 
			echo "<p>$k: $error </p>"; 
		}
}
}

function updateProfile($profile, $ch) {
	extract($profile);
	$q = "UPDATE sconnect_user set FIRST_NAME = '$firstname' , LAST_NAME = '$lastname', STUDENT_ID = '$username', CONTACT_EMAIL = '$email', CONTACT_PHONE =  '$phoneno' WHERE USER_ID = $profile[USER_ID]";
	if (!mysqli_query($ch, $q)) {
		die("Query Error:" . mysqli_error($ch));
	}
	echo "<p style='color:green'>Profile Updated</p>";
}

function addprofile($profile, $ch) { 
	extract($profile);
	$q = "INSERT INTO sconnect_user (FIRST_NAME, LAST_NAME, STUDENT_ID, login_pwd, CONTACT_EMAIL, CONTACT_PHONE) VALUES ('$firstname', '$lastname', '$username', '$pw1', '$email', '$phoneno')";
	if (!mysqli_query($ch, $q)) {
		die("Query Error:" . mysqli_error($ch));
	}
	echo "<p style='color:green'>Prodfile Added</p>";
}

function showprofile($ch) {
	$q = "SELECT * FROM sconnect_user where user_id = " . $_SESSION['user']['USER_ID'];
	$results = mysqli_query($ch, $q);
	$row = mysqli_fetch_assoc($results);

	?>
	<h2>Your Account</h2>
	<form method="post" action="">
	<table>
	<tr>
	<td><a href="manage_profile.php?action=update&USER_ID=<?= $row['USER_ID']; ?>">Edit profile</a></td>
	</tr>
	<tr>
	<td><a href="change_password">Change Password</a></td>
	</tr>
	<tr>
	<td><a href="delete_account.php?&USER_ID=<?= $row['USER_ID']; ?>">Delete Account</a></td>
	</tr>
	<tr>
	<td><a href="logout.php">Log Out</a></td>
	</tr>
	
	</table>
	</form>
	<?php
}

function showform($type=false, $ch=false) { 

	if ($type == "update") :

	$q = "SELECT * FROM sconnect_user WHERE USER_ID = $_GET[USER_ID]";
	$result = mysqli_query($ch, $q);
	$profile = mysqli_fetch_assoc($result);
	extract($profile); 

	?>
		<form method="post" action=""> 
		<input type="hidden" name="USER_ID" value="<?= $profile['USER_ID']; ?>"  /> <br /> 
		First Name:<input type="text" name="firstname" value="<?= $profile['FIRST_NAME']; ?>" /><br />
		Last Name:<input type="text" name="lastname" value="<?= $profile['LAST_NAME']; ?>" /><br />
		User Name:<input type="text" name="username" value="<?= $profile['STUDENT_ID']; ?>"/><br />
		Email ID:<input type="text" name="email" value="<?= $profile['CONTACT_EMAIL']; ?>"/><br />
		Contact No:<input type="text" name="phoneno" value="<?= $profile['CONTACT_PHONE']; ?>"/><br />
		<button type="submit">Update Profile</button>
		<button type="cancel"><a href="manage_profile.php">Cancel</a></button>
		</form>
<?php	
endif;

}


	
?>
<?php 
function dbConnect() {
	$host ="localhost";
	$user = "sconnect";
	$pw = "sconnect";
	$db = "sconnect";

	$ch = mysqli_connect($host, $user, $pw, $db);
	if (!$ch) {
		die('DB ERROR: ' . mysqli_connect_errno() . " " . mysqli_connect_error());
	}
	return  $ch;
}

?>
