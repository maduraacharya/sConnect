<?php 
include_once 'header.php'; 
include_once 'UserProfile.php'; 
?>

<?php
if (!empty($_POST)) { //check that form was submitted
	if (empty($errors)) {
		extract($_POST);
		if ($password != $confirm_password) {
			echo "<p>Passwords do not match,</p>"; 
		} 
		else {
			$user_profile = new UserProfile();
			$user_profile->setAttributes($firstname, $lastname, $username, $password, $email, $phoneno);
			$user_profile->insert($ch);
			echo "<p style='color:green'>User Registered!</p>";
			header('location:login.php');
		}
	}
}   
?>
<h2>Register</h2>
<br>
<form name="register" method="post" action="">
<table border=0 width=100% cellspacing=7 cellpadding=0> 
<tr>
<td width=20% align=right font-size=13px>First Name: </td><td align=left><input type="text" name="firstname" /><sup><font color="red">*</font></sup><span id="firstname_error" style="color:red"></span></td>
</tr>
<tr>
<td width=20% align=right font-size=13px>Last Name: </td><td align=left><input type="text" name="lastname" /><sup><font color="red">*</font></sup><span id="lastname_error" style="color:red"></span></td>
</tr>
<tr>
<td width=20% align=right valign=top font-size=13px>Username: </td><td align=left><input type="text" name="username" /><sup><font color="red">*</font></sup><span id="username_error" style="color:red"></span><br><span style="font-size: 0.8em">(Enter Student ID)</span></td>
</tr>
<tr>	
<td width=20% align=right font-size=13px>Password: </td><td align=left><input type="password" name="password" /><sup><font color="red">*</font></sup><span id="password_error" style="color:red"></span></td>
</tr>
<tr>
<td width=20% align=right font-size=13px>Confirm Password: </td><td align=left><input type="password" name="confirm_password" /><sup><font color="red">*</font></sup><span id="confirm_password_error" style="color:red"></span></td>
</tr>
<tr >
<td width=20% align=right font-size=13px>Contact Email: </td><td align=left><input type="text" name="email" /><sup><font color="red">*</font></sup><span id="email_error" style="color:red"></span></td>
</tr>
<tr>
<td width=20% align=right font-size=13px>Contact Phone: </td><td align=left><input type="text" name="phoneno" /><span id="phoneno_error" style="color:red"></span></td>
</tr>
<tr height=50>
<td width=20%></td><td align=left><input type="button" value="Register" onclick="validateRegisterForm()" /></td>
</tr>
</table> 
</form>

<?php include_once 'footer.php'; ?>
