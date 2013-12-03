<?php 
include_once 'header.php';
include_once 'UserProfile.php';  
?>

<?php

if (!empty($_POST)) {
	if (empty($errors)) {
		extract($_POST);
	
		$user_profile = new UserProfile();
		$user_profile->setStudentID($username);
		$user_profile->setLoginPassword($password);
		$user_profile->login($ch);
	}	
}

?>

<script type="text/javascript">createCookie("sConnectProfileToggleStatus", "0", 1); toggleProfileMenu();</script>
<h2>Login</h2>
<br>
<form method="post" name="login" action="">
<table border=0 width=100% cellspacing=7 cellpadding=0> 
<tr>
<td width=20% align=right font-size=13px>Username: </td><td align=left><input type="text" name="username" /><sup><font color="red">*</font></sup><span id="username_error" style="color:red"></span></td>
</tr>
<tr>
<td width=20% align=right font-size=13px>Password: </td><td align="left"><input type="password" name="password" /><sup><font color="red">*</font></sup><span id="password_error" style="color:red"></span></td>
</tr>
<tr height=50>
<td width=20%></td><td><input type="button" name="login" value="Login" onclick="validateLoginForm()" /></td>
</tr>
</table> 
</form>

<?php include_once 'footer.php'; ?>