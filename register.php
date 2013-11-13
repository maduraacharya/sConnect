<?php include 'header.php'; ?>

<?php
if (!empty($_POST)) { //check that form was submitted
	if (empty($errors)) {
		extract($_POST);
	if ($pw1 !=$pw2) {
		echo "<p>Passwords do not match,</p>";
	} else {
		$q = "INSERT INTO sconnect_user (FIRST_NAME, LAST_NAME, STUDENT_ID, login_pwd, CONTACT_EMAIL, CONTACT_PHONE) VALUES ('$firstname', '$lastname', '$username', '$pw1', '$email', '$phoneno')";
		if (!mysqli_query($ch, $q)) {
			die("Query Error:" . mysqli_error($ch));
		}
		echo "<p style='color:green'>User Registered!</p>";
	}
 }
}
?>

<h2>Register</h2>
<form method="post" action="">
	First Name: <input type="text" name="firstname" /><sup><font color="red">*</font></sup><br />
	Last Name: <input type="text" name="lastname" /><br />
	Username: <input type="text" name="username" /><sup><font color="red">*</font></sup><br />
	Password: <input type="text" name="pw1" /><sup><font color="red">*</font></sup><br />
	Confirm Password: <input type="text" name="pw2" /><sup><font color="red">*</font></sup><br />
	Email: <input type="text" name="email" /><sup><font color="red">*</font></sup><br />
	Phone no: <input type="text" name="phoneno" /><br />
	<button type="submit">Register</button>
</form>

<?php include 'footer.php'; ?>
