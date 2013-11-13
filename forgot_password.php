<?php include 'header.php'; ?>

<?php
$errmsg_arr = array();

if (!empty($_POST)) {
	if (empty($errors)) {
		extract($_POST);
		if (!$email) {
			die('Please enter email address');
		} else {
		$q = "SELECT * FROM sconnect_user WHERE CONTACT_EMAIL='$email'";
		$result = mysqli_query($ch, $q) or die("QUERY ERROR:" . mysqli_error($ch));
		if (mysqli_num_rows($result) >0) { 
			$user_record = mysqli_fetch_assoc($result);
		//	$email  = "brindha.sathish@gmail.com"; 
			$title   = "Test email"; 
			$message = "Your password is " . $user_record['login_pwd']; 
			mail($email, $title, $message); 
			echo "<p>Your Password has been emailed.</p>";
		}	
		
	}
	
	
}
}

?>
<html>
<head></head>
<title></title>
<body>			
<form method="post" action="">
Enter you email ID: <input type="text" name="email">
<input type="submit" name="submit" value="Submit">
</form>
</body>
</html>	

<?php include 'footer.php'; ?>
