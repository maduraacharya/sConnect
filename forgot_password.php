<?php include_once 'header.php'; ?>

<?php

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
			$email  = "brindha.sathish@gmail.com"; 
			$title   = "Test email"; 
			$message = "Your password is " . $user_record['login_pwd']; 
			mail($email, $title, $message); 
			echo "<p>Your Password has been emailed.</p>";
		}	
		
	}  
}
}

?>
<h2>Forgot Password</h2>	
<br>	
<form name="forgot_password" method="post" action="">
<table border=0 width=100% cellspacing=7 cellpadding=0> 
<tr>
<td width=20% align=right font-size=13px>Contact Email: </td><td align=left><input type="text" name="email"><span id="email_error" style="color:red"></span></td>
</tr>
<tr height=50>
<td width=20%></td><td><input type="button" name="forgot_password_submit" value="Submit" onclick="validateForgotPasswordForm()" /></td>
</tr>
</table>
</form>

<?php include_once 'footer.php'; ?>