<?php 
include_once 'header.php';
include_once 'UserProfile.php';
?>

<?php
is_valid_session();
is_admin_user();
?>

<h2>Edit Profile</h2>
<br><br>

<?php

if(!empty($_POST)) {
	if (empty($errors)){
		if (isset($_POST['user_id'])) {
			extract($_POST);
			$user_profile = new UserProfile();
			$user_profile->fetch($ch, $user_id);
			$user_profile->setFirstName($firstname);
			$user_profile->setLastName($lastname);
			$user_profile->setStudentID($username);
			$user_profile->setContactEmail($email);
			$user_profile->setContactPhone($phoneno);
			$user_profile->update($ch);
		}
	}
}  

if (!empty($_GET)) {

	if ($_GET['action'] == "edit") {

		$user_profile = new UserProfile();
		$row = $user_profile->fetchAsArray($ch, $_GET['user_id']);
		extract($row);
 ?>
		<form name="edit_profile" method="post" action=""> 
		<table border=0 width=100% cellspacing=7 cellpadding=0> 
		<tr>
		<td width=20% align=right font-size=13px> </td><td align=left><input type="hidden" name="user_id" value="<?= $user_id; ?>"  /></td>
		</tr>
		 <tr>
		<td width=20% align=right font-size=13px>First Name: </td><td align=left><input type="text" name="firstname" value="<?= $first_name; ?>" /><sup><font color="red">*</font></sup><span id="firstname_error" style="color:red"></span></td>
		</tr>
		 <tr>
		<td width=20% align=right font-size=13px>Last Name: </td><td align=left><input type="text" name="lastname" value="<?= $last_name; ?>" /><sup><font color="red">*</font></sup><span id="lastname_error" style="color:red"></span></td>
		</tr>
		 <tr>
		<td width=20% align=right valign=top font-size=13px>Username: </td><td align=left><input type="text" name="username" value="<?= $student_id; ?>"/><sup><font color="red">*</font></sup><span id="username_error" style="color:red"></span><br><span style="font-size: 0.8em">(Enter Student ID)</span></td>
		</tr>
		 <tr>
		<td width=20% align=right font-size=13px>Contact Email: </td><td align=left><input type="text" name="email" value="<?= $contact_email; ?>"/><sup><font color="red">*</font></sup><span id="email_error" style="color:red"></span></td>
		</tr>
		 <tr>
		<td width=20% align=right font-size=13px>Contact Phone: </td><td align=left><input type="text" name="phoneno" value="<?= $contact_phone; ?>"/></td>
		</tr>
		<tr height=50>
		<td width=20%></td><td align=left><input type="button" value="Update Profile" onclick="validateEditProfileForm()"> 
		<input type="button" name="btnDeleteUser" value="Delete User" onclick="location.href='admin_edit_profile.php?action=delete&user_id=<?= $user_id ?>'"></td>
		</tr>
		</table>
		</form>
	<?php	
	}
	elseif ($_GET['action'] == "delete") {
		$user_profile = new UserProfile();
		$user_profile->setUserID($_GET['user_id']);
		$user_profile->delete($ch);
		echo "<p style='color:green'>User has been successfully deleted</p>";
	}
}
?>
<?php include_once 'footer.php'; ?>