<?php

    // Start the session
    session_start();
	
	// Redirect if not logged in
	if( !isset( $_SESSION['admin'] )){
		header('Location: login_admin.php');
	}
	
	// Connect to db
	require('connectvars.php');
	 
	$con = mysqli_connect( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if(mysqli_connect_errno($con)) {
            echo "failed to connect to mysql, please try again later";
        }
	
	// Calculate various things...
	
	// number of users
	$query = "SELECT USER_ID FROM SCONNECT_USER";
	$data = mysqli_query($con, $query)
		or die('Error querying database.');
	
	$number_of_users = mysqli_num_rows($data);
	
	// number of items, services, active users
	$active_users_array = array();
	
	$query = "SELECT SELLER_USER_ID FROM SCONNECT_ITEM";
	$data = mysqli_query($con, $query)
		or die('Error querying database.');
		
	$number_of_items = mysqli_num_rows($data);
	
	while( $row= mysqli_fetch_array($data) ){
		if( !in_array( $row['SELLER_USER_ID'], $active_users_array) ){
			array_push( $active_users_array, $row['SELLER_USER_ID'] );
		}	
	}
	
	$query = "SELECT SELLER_USER_ID FROM SCONNECT_SERVICE";
	$data = mysqli_query($con, $query)
		or die('Error querying database.');
		
	$number_of_services = mysqli_num_rows($data);
	
	while( $row= mysqli_fetch_array($data) ){
		if( !in_array( $row['SELLER_USER_ID'], $active_users_array) ){
			array_push( $active_users_array, $row['SELLER_USER_ID'] );
		}	
	}
	
	$number_of_active_users = sizeof($active_users_array);
	
	
?>

<!DOCTYPE html>
<html>
<head>
<title>sConnect Admin Stats</title>
<link href="admin.css" rel="stylesheet">
</head>
<body>

<div class="container">

<div class="header">
<h2>Admin Stats Page</h2>

<div class="header-sub">
<a href="admin_homepage.php">Back to admin home</a><br><br>
</div>

</div>

<div class="content">
<?php

echo 'Number of users : ' . $number_of_users . '<br>';
echo 'Number of active users (have items/services posted) : ' . $number_of_active_users . '<br>';
echo 'Percentage of users active: ' . round((($number_of_active_users/ $number_of_users)*100), 1) . '%<br>';

echo '<br>';
echo 'Number of items : ' . $number_of_items . '<br>';
echo 'Number of services : ' . $number_of_services . '<br>';

?>
</div>

</div>
</body>
</html>