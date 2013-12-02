<?php

// Start the session
    session_start();

// Redirect if not logged in
	if( !isset( $_SESSION['admin'] )){
		header('Location: login_admin.php');
	}
	
?>

<!doctype html>
<html>
<head>
<title></title>
<meta charset="UTF-8" />
<link href="admin.css" rel="stylesheet">
</head>

<body>

<div class="container">

<div class="header">
<h2>Admin Page</h2>
<div class="header-sub">
<?php
    echo "Welcome, " . $_SESSION['admin']['FIRST_NAME'] ." !  You have logged on successfully. <br><br>";
    ?>
</div>
</div>

<div class="content">

<a href="admin_stats.php">Stats</a><br>
<a href="admin_delete.php">Delete Post</a><br>
<a href="admin_delete_comment.php">Delete Comment</a><br>
<br>
<a href="admin_delete_user.php">Delete User</a><br>
<br>
<a href="logout_admin.php">Logout</a><br>
</div>

</div>

</body>
</html>