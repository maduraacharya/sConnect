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
<title>sConnect Admin Delete Comments</title>
<link href="admin.css" rel="stylesheet">
</head>
<body>

<div class="container">

<?php

$number_of_items_to_delete = 0;

if( isset( $_POST['submit_delete'] )) {
	
	if( isset( $_POST['array_id'] )) { 
		$array_id = $_POST['array_id'];
		$number_of_items_to_delete = sizeof( $array_id );
	}
	
	if( (isset( $_POST['array_id'])) && ( $number_of_items_to_delete > 0) ){

		foreach( $array_id as $val ) {
			$query = "DELETE FROM SCONNECT_SERVICE_COMMENT WHERE ID=$val";
			mysqli_query($con, $query)
				or die('Error querying database.');
		}
		
	}
	

	

}

?>

<br>
<?php echo $number_of_items_to_delete . ' '; ?> comments have been deleted.
<br><br>
<a href="admin_delete_comment.php">go back to delete comments</a><br>

</div>
</body>
</html>