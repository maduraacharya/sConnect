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
		echo "failed to connect to mysql";
	}
	
?>

<!DOCTYPE html>
<html>
<head>
<title>sConnect Admin Delete Posts</title>
<link href="admin.css" rel="stylesheet">
</head>
<body>

<div class="container">

<?php

$number_of_items_to_delete = 0;

if( isset( $_POST['submit_delete'] )) {
	
	$item_type = strtoupper( $_POST['type'] );
	
	if( isset( $_POST['array_id'] )) { 
		$array_id = $_POST['array_id'];
		$number_of_items_to_delete = sizeof( $array_id );
	}
	
	if( (isset( $_POST['array_id'])) && ( $number_of_items_to_delete > 0) ){

		foreach( $array_id as $val ) {
			$query = "DELETE FROM SCONNECT_" . $item_type . " WHERE ID=$val";
			mysqli_query($con, $query)
				or die('Error querying database.');
		}
		
	}
	

	

}

?>

<br>
<?php echo $number_of_items_to_delete . ' '; ?> posts have been deleted.
<br><br>
<a href="admin_delete.php">go back to delete posts</a><br>

</div>
</body>
</html>