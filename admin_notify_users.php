<?php 
include_once 'header.php';
include_once 'UserProfile.php'; 
?>

<?php
is_valid_session();
is_admin_user();
?>

<h2>Notify Users</h2>
<br><br>

<?php

if(!empty($_POST)) {
	if (empty($errors)){
		extract($_POST);
		$email_subject = mysqli_real_escape_string($ch, trim($email_subject));
		$email_message = mysqli_real_escape_string($ch, trim($email_message));
		
		$query = "SELECT user_id, first_name, last_name, student_id, login_pwd, contact_email, contact_phone FROM sconnect_user WHERE role = 'user'";
		$data = mysqli_query($ch, $query) or die('Error querying database.');
		while ($row = mysqli_fetch_array($data)) {
			extract($row);
			$email = $contact_email;
			$subject  = $email_subject;
			$message = "Hello " . $first_name . ",\r\n\r\n" . $email_message . "\r\n\r\n" . "Thanks, \r\n" . "sConnect Admin";
			mail($email, $subject, $message); 
		}
		echo "<p style='color:green'>Email has been sent successfully</p>";
	}
}  

?>

<form name="notify_user" method="post" action=""> 
<table border=0 width=100% cellspacing=7 cellpadding=0> 
<tr>
<td width=20% align=right font-size=13px>Subject: </td><td align=left><input style="width:400px;" type="text" name="email_subject" /><sup><font color="red">*</font></sup><span id="subject_error" style="color:red"></span></td>
</tr>
<tr>
<td width=20% align=right valign=top font-size=13px>Message: </td><td align=left><textarea name="email_message"></textarea><sup><font color="red">*</font></sup><span id="message_error" style="color:red"></span></td>
</tr>
<tr height=50>
<td width=20%></td><td align=left><input type="button" value="Send Email" onclick="validateNotifyUsersForm()"> 
</tr>
</table>
</form>


<?php include_once 'footer.php'; ?>