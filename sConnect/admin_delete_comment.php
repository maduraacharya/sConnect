<?php

    // Start the session
    session_start();
	
	// Redirect if not logged in
	if( !isset( $_SESSION['admin'] )){
		header('Location: login_admin.php');
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

<h2>Admin Delete Comments Page</h2>

<div class="header-sub">
<a href="admin_homepage.php">go back to admin home</a><br><br>
</div>

<div class="content">

<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" >

Search for comment : &nbsp; &nbsp; <br>
<div class="form-textbox"><input type="text" name="search_text" size=50> &nbsp; &nbsp;

<input type="submit" name="submit_search" value="Search"></div>

</form>

<?php

if( isset( $_POST['submit_search'])) {

	// connect to db	
	require('connectvars.php');
	
	$con = mysqli_connect( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	if(mysqli_connect_errno($con)) {
		echo "failed to connect to mysql";
	}
	
	// get data from form
    $search_text = mysqli_real_escape_string($con, trim($_POST['search_text']));

	// parse search string, store terms in array
	$search_text = str_replace(',', '', $search_text);
	
	$search_array = array();
	
	while( strlen($search_text) > 0 ) {
		$search_text = trim($search_text);
				
		if( strpos($search_text, '\"') === 0) {
			$search_text = substr($search_text, 2);
			$search_text = trim($search_text);
			$close_quote_position = strpos($search_text, '\"');
			if( $close_quote_position !== false ) {
				array_push( $search_array, substr( $search_text,  0, $close_quote_position));
				$search_text = substr( $search_text, $close_quote_position + 2);
			}
			continue;
		}			
		else if( ($next_space_position = strpos($search_text, ' ')) !== false ){
			array_push( $search_array, substr( $search_text,  0, $next_space_position));
			$search_text = substr( $search_text, $next_space_position + 1);
			continue;
		}
		else{
			array_push( $search_array, $search_text);
			$search_text = '';
		}		
	} // end, while loop to process search_text	
	
	// form search query and display results
	
	if( sizeof($search_array) <= 0) {
		$query = "SELECT * FROM SCONNECT_SERVICE_COMMENT";
	}	
	
	if( sizeof($search_array) > 0) {
		$query = "SELECT * FROM SCONNECT_SERVICE_COMMENT WHERE ";
	
		foreach( $search_array as $index => $word ){
			if( $index != 0){
				$query .= ' OR ';
			}
			$query .= "(COMMENT LIKE '%$word%')";
		}
	}
	
	$query .= " ORDER BY DATE_COMMENT_ADDED DESC";

	$data = mysqli_query($con, $query)
		or die('Error querying database.');
		
	if( mysqli_num_rows($data) > 0) {

		echo '<br><div' /*align="center"*/ .'><form method="post" action="admin_delete_comment2.php">';
		echo '<table border="1" cellspacing="0" cellpadding="5"><tr>
				<td>Date posted</td><td>Comment</td><td>Delete</td></tr>';
				
		while ($row = mysqli_fetch_array($data)) {
		
			$date_posted = substr($row['DATE_COMMENT_ADDED'],0,10);
			$comment = substr($row['COMMENT'],0,100);
			
			echo "<tr>
				<td> $date_posted </td>
				<td> $comment </td>";
				
			echo '<td><input type="checkbox" name="array_id[]" value="'. $row['ID'].'"></td>';
			echo "</tr>";
		}
		
		echo '</table>';
		echo '<br><input type="submit" name="submit_delete" value="Delete">';
		echo '</form></div>';
	}
	else{
		echo '<br><span class="error">No results found.</span><br>';
	}
	
	
}

?>


</div>


</div>
</body>
</html>