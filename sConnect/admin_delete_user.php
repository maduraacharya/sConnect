<?php

    // Start the session
    session_start();
	
	// Redirect if not logged in
	if( !isset( $_SESSION['admin'] )){
		header('Location: login_admin.php');
	}

	// Process form
	if( isset( $_POST['submit_delete'])) {
	
		$bool_form_is_ok = true;
	
		// connect to db	
		require('connectvars.php');
		
		$con = mysqli_connect( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
		if(mysqli_connect_errno($con)) {
			echo "failed to connect to mysql";
		}
	
		// get data from form
		$form_email = mysqli_real_escape_string($con, trim($_POST['email']));
	
		// check if email exists
		
		$query = "SELECT * FROM SCONNECT_USER WHERE CONTACT_EMAIL = '$form_email'";
		$data = mysqli_query($con, $query);
		
		if (mysqli_num_rows($data) < 1) {
			$bool_form_is_ok = false;
		}
		
		// delete user and user-related things
		
		if( $bool_form_is_ok == true ) {
			
			while( $row = mysqli_fetch_array($data)) {
		
				$user_id = $row['USER_ID'];
		
				$query2 = "DELETE FROM SCONNECT_USER WHERE USER_ID = $user_id";
				mysqli_query($con, $query2);
				
				$query2 = "DELETE FROM SCONNECT_ITEM WHERE SELLER_USER_ID = $user_id";
				mysqli_query($con, $query2);
				
				$query2 = "DELETE FROM SCONNECT_SERVICE WHERE SELLER_USER_ID = $user_id";
				mysqli_query($con, $query2);
				
				$query2 = "DELETE FROM SCONNECT_ITEM_BID WHERE BUYER_USER_ID = $user_id";
				mysqli_query($con, $query2);
				
				$query2 = "DELETE FROM SCONNECT_SERVICE_COMMENT WHERE BUYER_USER_ID = $user_id";
				mysqli_query($con, $query2);
				
			}
		
		}
		
	
	
	} // end: if( isset( $_POST['submit_delete']))
	
?>

<!DOCTYPE html>
<html>
<head>
<title>sConnect Admin Delete User</title>
<link href="admin.css" rel="stylesheet">
</head>
<body>

<div class="container">

<h2>Admin Delete Users Page</h2>

<div class="header-sub">
<a href="admin_homepage.php">go back to admin home</a><br><br>
</div>


<div class="content">

<?php
	if( isset($bool_form_is_ok) && $bool_form_is_ok == false ){
		echo '<span class="error">Email not found</span><br><br>';
	}

	if( isset($bool_form_is_ok) && $bool_form_is_ok == true ){
		echo '<span class="success">'.$form_email.' deleted.</span><br><br>';
	}
?>

<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">

Email of user to delete : &nbsp; &nbsp;<input type="text" name="email" size=50> &nbsp; &nbsp;

<input type="submit" name="submit_delete" value="Delete">

</form>


</div>

</div>
</body>
</html>