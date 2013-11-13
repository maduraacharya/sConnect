
<?php

// note: there is form processing after the html form below 

?>

<!DOCTYPE html>
<html>
<head>
<title>sConnect</title>
</head>
<body>

<br><br><br>
<p align="center"><b>sConnect Search</b></p>
	
<div align="center">
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" >

<select name="search_type">
	<option value="item">Item</option>
	<option value="service">Service</option>
</select>
&nbsp;
<input type="text" name="search_text" size=50>
&nbsp; 
<input type="submit" name="search_submit" value="Search">
</form>
</div>


<?php

if( isset( $_POST['search_submit'])) {

	// connect to db	
	require('connectvars.php');
	
	$con = mysqli_connect( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	if(mysqli_connect_errno($con)) {
		echo "failed to connect to mysql";
	}
	
	// get data from form
	$search_type = mysqli_real_escape_string($con, trim($_POST['search_type']));
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
	
	// test
	// echo $search_type . '<br>';
	// var_dump( $search_text );
	// var_dump( $search_array );
	
	// form search query
	
	if( sizeof($search_array) > 0) {
	
	if( $search_type == 'item'){
		$query = "SELECT * FROM SCONNECT_ITEM WHERE (DATE_SOLD IS NULL) AND (";
	}
	else{
		$query = "SELECT * FROM SCONNECT_SERVICE WHERE ";
	}
	
	foreach( $search_array as $index => $word ){
		if( $index != 0){
			$query .= ' OR ';
		}
		$query .= "(DESCRIPTION LIKE '%$word%') OR (TITLE LIKE '%$word%')";
	}
	if( $search_type == 'item'){ $query .= ')'; }
	
	} // if( sizeof($search_array) > 0)
	else{
	
		if( $search_type == 'item'){
			$query = "SELECT * FROM SCONNECT_ITEM";
		}
		else{
			$query = "SELECT * FROM SCONNECT_SERVICE";
		}	
	}
	
	$query .= " ORDER BY DATE_POSTED DESC";
	
	$data = mysqli_query($con, $query)
			or die('Error querying database.');
			
	if( mysqli_num_rows($data) > 0) {

		echo '<br><div align="center">';
		echo '<table border="1" cellspacing="0" cellpadding="5"><tr>
				<td>Date posted</td> <td>Title</td>	<td>Description</td>'; 
		if(	$search_type == 'item'){ echo '<td>Price</td>'; }
		echo '</tr>';
		while ($row = mysqli_fetch_array($data)) {
		
			$date_posted = substr($row['DATE_POSTED'],0,10);
			$title = substr($row['TITLE'],0,50);
			$description = substr($row['DESCRIPTION'],0,70);
			
			echo "<tr>
				<td> $date_posted </td>
				<td> $title </td>
				<td> $description </td>";
				
			if(	$search_type == 'item'){ echo "<td> $row[PRICE] </td>"; }
			
			echo "</tr>";
		}
		echo '</table></div>';
	}
	else{
		echo '<p align="center">No search results found</p>';
	}
	
}

?>






</body>
</html>