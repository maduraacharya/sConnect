<?php

// Start the session
    session_start();

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
<div id="header">
<?php
	echo '<h2>Admin Page</h2>';
    echo "Welcome! " . $_SESSION['admin']['FIRST_NAME'] .", You have logged on successfully. <br><br>";
    ?>
</div>

<div id="nav">
<a href="admin_stats.php">Stats</a></br>
<a href="logout_admin.php">Logout</a></br>
</div>
