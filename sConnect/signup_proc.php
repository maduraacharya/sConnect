<?php
	echo "sign up haha";
	echo "<br />". $_POST['first_name'];
	
	require 'connectvars.php';
	
	// connect to db
	$con = mysqli_connect( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	if(mysqli_connect_errno($con)) {
		echo "failed to connect to mysql";
	}
	
	// insert form values into db
	$query = "INSERT INTO sconnect_user (first_name, last_name, student_id, login_pwd, contact_email,
		contact_phone) VALUES( '$_POST[first_name]', '$_POST[last_name]', '$_POST[student_id]', 
		'$_POST[login_pwd]', '$_POST[contact_email]', '$_POST[contact_phone]')";  
	// mysqli_query($con, $query);
	
	if (!mysqli_query($con,$query)) { die('Error: ' . mysqli_error($con)); }
	
	// confirm insert
	echo "1 record added";
	
	
	mysqli_close($con);
	
?>