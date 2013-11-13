<?php include 'header.php'; ?>

<?php
$errmsg_arr = array();

if (!empty($_POST)) {
	if (empty($errors)) {
		extract($_POST);
	
		$q = "SELECT * FROM sconnect_user WHERE STUDENT_ID = '$username' AND login_pwd = '$password'";
		$result = mysqli_query($ch, $q) or die("QUERY ERROR:" . mysqli_error($ch));
		if (mysqli_num_rows($result) >0) { 
			$_SESSION['user'] = mysqli_fetch_assoc($result);
			header('location:login.php');
		}  else {
			die('Please enter the Username and Password');
		}	
		
	}
	
	
}
 

?>


<form method="post" action="">
	Username: <input type="text" name="username" /><br />
	Password: <input type="password" name="password" /><br />
	<button type="submit" name="submit" value="Log In">Log In</button>
</form>

<?php include 'footer.php'; ?>
