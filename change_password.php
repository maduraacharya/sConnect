<?php 
include_once 'header.php'; 
include_once 'UserProfile.php'; 
?>

<?php
is_valid_session();
?>

<?php
$errmsg_arr = array();

if (!empty($_POST)) { 
	if (empty($errors)) {
		extract($_POST); 

		if ($_SESSION['user']['login_pwd'] != $old_password) {
			die('Old password is incorrect');
		}
		else {
			$session_user_id = $_SESSION['user']['user_id'];
			$user_profile = new UserProfile();
			$user_profile->fetch($ch, $session_user_id);
			$user_profile->setLoginPassword($password);
			$user_profile->update($ch);
			echo "<p style='color:green'>Password Updated</p>";
		} 
	}		
}
 	
?>
		
<h2>Change Password</h2>
<br>
<form name="change_password" method="post" action="">
<table border=0 width=100% cellspacing=7 cellpadding=0> 
<tr>
<td width=20% align=right font-size=13px>Username: </td><td align=left><input type="text" name="username" /><sup><font color="red">*</font></sup><span id="username_error" style="color:red"></span></td>
</tr>
<tr>
<td width=20% align=right font-size=13px>Password: </td><td align=left><input type="password" name="old_password" /><sup><font color="red">*</font></sup><span id="old_password_error" style="color:red"></span></td>
</tr>
<tr>
<td width=20% align=right font-size=13px>New Password: </td><td align=left><input type="password" name="password" /><sup><font color="red">*</font></sup><span id="password_error" style="color:red"></span></td>
 </tr>
<tr>
<td width=20% align=right font-size=13px>Confirm Password: </td><td align=left><input type="password" name="confirm_password" /><sup><font color="red">*</font></sup><span id="confirm_password_error" style="color:red"></span></td>
 </tr>
<tr height=50>
<td width=20%></td><td><input type="button" value="Change Password" onclick="validateChangePasswordForm()" />
<input type="button" value="Cancel" onclick='location.href="manage_profile.php"' /></td>
</tr>
</table>
</form>
<?php include_once 'footer.php'; ?>