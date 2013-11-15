<?php

session_start();
include 'lib.php';
$ch =dbConnect();
$errors = [];
 ?>
 
 
 <!doctype html>
<html>
<head>
	<title></title>
	<meta charset="UTF-8" />
	<style>
	// CSS Goes here
	</style>
</head>

<body>
<div id="global">
	<div id="header">
			<h1>sConnect</h1>
			<?php
			if (isset($_SESSION['user'])) {
				echo "<p> Welcome " . $_SESSION['user']['FIRST_NAME'] . " " . $_SESSION['user']['LAST_NAME'] . "</p>";
			}
	
		?>	
	</div>

	<div id="nav">
	
	</div>

	<div id="content">
	<table align="left" width=300 height=550>
	<tr>
	<td><a href="index.php">Home</a> </br>
	<?php if (!isset($_SESSION['user'])) : ?>
	<a href="login.php">Login</a></br>
	<a href="register.php">Register</a></br>
	<?php else: ?>
	<a href="logout.php">Logout</a></br>
	<?php endif; ?>
	<a href="change_password.php">Change Password</a></br>
	<a href="forgot_password.php">Forgot Password</a></br>
	<a href="manage_profile.php">Manage Profile</a></br>
	<a href="post_item.php">Post An Item or Service</a></br>
	<a href="search.php">Search</a></br>
	<a href="view_post.php">View Post</a>
	</td></tr>
	</table> 
	<table>
	<tr>
	<td><?= outputErrors($errors);?></td>
	</tr>
	</table>
	
	 
	
