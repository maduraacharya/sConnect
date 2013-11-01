<?php

// Start the session
  session_start();

if( isset( $_POST['login'])) {

	// process form
	require('connectvars.php');
	
	// connect to db
	$con = mysqli_connect( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	if(mysqli_connect_errno($con)) {
		echo "failed to connect to mysql";
	}
	
	// get data from form
      $form_email = $_POST['contact_email'];
      $form_password = mysqli_real_escape_string($con, trim($_POST['login_pwd']));
	
	// query user with the email and password from form
	$query = "SELECT USER_ID FROM SCONNECT_USER WHERE CONTACT_EMAIL = '". $form_email . "' AND LOGIN_PWD = '" .
			$form_password . "'";
	$data = mysqli_query($con, $query)
		or die('Error querying database.');
	
	// process query
	if (mysqli_num_rows($data) == 1) {		 
		$row = mysqli_fetch_array($data);
		
		// set session variables
		$_SESSION['user_id'] = $row['USER_ID'];
		echo 'User is logged in <br />';	
	}
	else {
		echo 'Login failed. (email doesnt exist)<br />';
	}

	
} // end: if( isset( $_POST['login']))

?>



<!DOCTYPE html>
<html>
<head>
<title>sConnect Log-in</title>
</head>
<body>

<br><br><br>
    <p align="center"><b>sConnect Registration</b></p>
    	
	<div align="center">
	<form method="post" action="login.php" >
    <br /> &nbsp; &nbsp; &nbsp;Email &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<input type="text" name="contact_email" size=50>
    <br><br> &nbsp; &nbsp; &nbsp;Password &nbsp; &nbsp; &nbsp; &nbsp;<input type="text" name="login_pwd" size=50>
	<br /><br /><br /><input type="submit" name="login" value="Log In">
    </form>
	</div>
	

</body>
</html>