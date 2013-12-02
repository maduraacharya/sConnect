<?php

    // Start the session
    session_start();
	
	// Redirect if not logged in
	if( !isset( $_SESSION['admin'] )){
		header('Location: login_admin.php');
	}

	// connect to db	
		require('connectvars.php');
		
		$con = mysqli_connect( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
		if(mysqli_connect_errno($con)) {
			echo "failed to connect to mysql";
		}
		
?>

<!DOCTYPE html>
<html>
<head>
<title>sConnect Admin Delete User</title>
<link href="admin.css" rel="stylesheet">
</head>
<body>


<div class="container">

<h2>Notify Users</h2>
<div class="header-sub">
<a href="admin_homepage.php">go back to admin home</a><br><br>
</div>

<div class="content">

<?php

if(!empty($_POST)) {
	if (empty($errors)){
		$email_subject = mysqli_real_escape_string($con, trim($_POST['email_subject']));
		$email_message = mysqli_real_escape_string($con, trim($_POST['email_message']));
		
		$query = "SELECT user_id, first_name, last_name, student_id, login_pwd, contact_email, contact_phone FROM sconnect_user WHERE role = 'user'";
		$data = mysqli_query($con, $query) or die('Error querying database.');
		
		if( mysqli_num_rows($data) > 0 ){			
			while ($row = mysqli_fetch_array($data)) {
				$message = "Hello " . $row['first_name'] . ",\r\n\r\n" . $email_message . "\r\n\r\n" . "Thanks, \r\n" . "sConnect Admin";
				mail($row['contact_email'], $email_subject, $email_message); 
			}
			echo '<span class="success"><p>Email has been sent successfully</p></span>';
		}
		else{
			echo '<span class="error"><p>No users to send to</p></span>';
		}
		
	}
}  

?>

<form name="notify_user" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>"> 
<div style="margin-left:75px">
<table border=0 width=100% cellspacing=7 cellpadding=0> 
<tr>
<td width=20% align=right font-size=13px>Subject: </td><td align=left><input type="text" name="email_subject" /><sup><font color="red">*</font></sup><span id="subject_error" style="color:red"></span></td>
</tr>
<tr>
<td width=20% align=right font-size=13px>Message: </td><td align=left><textarea name="email_message"></textarea><sup><font color="red">*</font></sup><span id="message_error" style="color:red"></span></td>
</tr>
<tr height=50>
<td width=20%></td><td align=left><input type="submit" value="Send Email"> 
</tr>
</table>
</div>
</form>

</div>
</div>
</body>
</html>