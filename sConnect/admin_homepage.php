<?php
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
    echo "Welcome! " . $_SESSION['admin']['FIRST_NAME'] .", You have logged on successfully <br />";
    ?>
</div>

<div id="nav">
<a href="http://localhost:8888/sConnect/sConnect/logout_admin.php">Logout</a></br>
</div>
