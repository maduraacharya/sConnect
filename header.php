<?php

session_start();
include_once 'lib.php';
$ch = dbConnect();
$errors = [];
?>

<!doctype html>
<html>
<head>
	<title></title>
	<meta charset="UTF-8" />
	<link rel="stylesheet" type="text/css" href="style.css?v=1.14">
	<script src="validate.js?v=1.15" type="text/javascript"></script>
	
</head>
<body style="overflow:hidden;>
<div id="global">
	<div id="header">
	<img align=left src="Logo2.png" alt="sConnect Logo" width="190" height="100" />
	<h1 align="center">sConnect </h1>  <p align=center>Reach out and stay connected</p>
		<?php
			if (isset($_SESSION['user'])) {
				echo "<p> Welcome " . $_SESSION['user']['first_name'] . " " . $_SESSION['user']['last_name'] . "</p>";
			}
		?>	
	</div>

	<div id="nav">
	<table width=100% border=0 height=100% cellspacing="0" cellpadding="0"> 
	<tr>
	<td width=86% valign=middle align=left ><a href="search.php" style="color:blue"  >Home</a></td>
	<td width=7% valign=middle align=right ><a href="JavaScript:newPopup('help.html');" style="color:blue">Help</a></td>
	<?php if (isset($_SESSION['user'])) : ?>
	<td width=7% valign=middle align=right ><a href="logout.php" style="color:blue" >Logout</a></td>
	<?php endif; ?>
	</tr>
	</table>
	</div>
	
	<div id="content1" >
	<table align="right" width=100% border=1 height=auto cellspacing="0" cellpadding="0"> 
	<?php if (!isset($_SESSION['user'])) { ?>
		<tr bgcolor=#C0C0C0  >
		<td height=30><a href="login.php"  >Login</a></td>
		</tr>
		<tr bgcolor=#C0C0C0 >
		<td height=30><a href="register.php"  >Register</a></td>
		</tr>
		<tr bgcolor=#C0C0C0 >
		<td height=30><a href="forgot_password.php"  >Forgot Password</a></td>
		</tr>
	<?php 
	}
	else { 
	?>
		<?php if ($_SESSION['user']['role'] == 'user') : ?>
			<tr bgcolor=#C0C0C0 > 
			<td height=30><a href="post_item.php"  >Create Post</a></td>
			</tr>
			<tr bgcolor=#C0C0C0 >
			<td height=30><a href="search.php"  >Search</a></td>
			</tr>
		<?php endif; ?>
		<?php if ($_SESSION['user']['role'] == 'admin') : ?>
			<tr bgcolor=#C0C0C0 >
			<td height=30><a href="search.php"  >Manage Posts</a></td>
			</tr>
			<tr bgcolor=#C0C0C0 >
			<td height=30><a href="admin_manage_users.php"  >Manage Users</a></td>
			</tr>
			<tr bgcolor=#C0C0C0 >
			<td height=30><a href="admin_notify_users.php"  >Notify Users</a></td>
			</tr>
		<?php endif; ?>
		<?php if ($_SESSION['user']['role'] == 'user') : ?>
			<tr bgcolor=#C0C0C0 >
			<td height=30><a href="my_listings.php"  >My Listings</a></td>
			</tr>
			<tr bgcolor=#C0C0C0 >
			<td height=30><a href="my_favorites.php"  >My Favorites</a></td>
			</tr>
			<tr bgcolor=#C0C0C0 >
			<td height=30><a href="my_activities.php"  >My Activities</a></td>
			</tr>
		<?php endif; ?>
		<tr bgcolor=#C0C0C0 >
		<td height=30><a href="#"   onclick="toggleProfileCookie(); toggleProfileMenu();">My Profile</a></td>
		</tr>
		<tr id="edit_profile" bgcolor=#C0C0C0 >
		<td height=30>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="edit_profile.php?action=update&user_id=<?= $_SESSION['user']['user_id']; ?>">Edit Profile</a></td>
		</tr>
		<tr id="change_password" bgcolor=#C0C0C0 >
		<td height=30>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="change_password.php">Change Password</a></td>
		</tr>
		<tr id="delete_account" bgcolor=#C0C0C0 >
		<td height=30>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="delete_account.php?&user_id=<?= $_SESSION['user']['user_id']; ?>">Delete Account</a></td>
		</tr>
		<script type="text/javascript">toggleProfileMenu()</script>
	<?php } ?>
	</table> 
	<table>
	<tr>
	<td><?= outputErrors($errors);?></td>
	</tr>
	</table>

	</div>
  <div id="content2">
	

	