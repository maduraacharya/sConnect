<?php

// Start the session
  session_start();
  
// note: please 1) delete the 1st line below and 2) set $session_user_id = to the right session variable 
  $_SESSION['user_id'] = 2;
  $session_user_id = $_SESSION['user_id'];
  
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
<title>sConnect</title>
</head>
<body>

<br><br><br>
<p align="center"><b>sConnect Current items and Services for sale</b></p>


<p><b>Items for Sale</b></p>

<?php

// get data from db
	$query = "SELECT * FROM SCONNECT_ITEM WHERE SELLER_USER_ID = $session_user_id AND DATE_SOLD IS NULL ORDER BY DATE_POSTED DESC";
	$data = mysqli_query($con, $query)
		or die('Error querying database.');

	
// display data
	if( mysqli_num_rows($data) < 1 ){
		echo '<p>No items for sale.</p>';
	}
	else{
		echo '<table border="1" cellspacing="0" cellpadding="5"><tr>
				<td>Date posted</td> <td>Title</td>	<td>Description</td> <td>Price</td> </tr>';
		while ($row = mysqli_fetch_array($data)) {
		
			$date_posted = substr($row['DATE_POSTED'],0,10);
			$title = substr($row['TITLE'],0,50);
			$description = substr($row['DESCRIPTION'],0,70);
						
			echo "<tr>
				<td> $date_posted </td>
				<td> $title </td>
				<td> $description </td>
				<td> $row[PRICE] </td>
				</tr>";
		}	
		echo '</table>';
	}
?>

<p><b>Services offered</b></p>

<?php

// get data from db
	$query = "SELECT * FROM SCONNECT_SERVICE WHERE SELLER_USER_ID = $session_user_id ORDER BY DATE_POSTED DESC";
	$data = mysqli_query($con, $query)
		or die('Error querying database.');

// display data
	if( mysqli_num_rows($data) < 1 ){
		echo '<p>No services posted.</p>';
	}
	else{
		echo '<table border="1" cellspacing="0" cellpadding="5"><tr>
				<td>Date posted</td> <td>Title</td>	<td>Description</td> </tr>';
		while ($row = mysqli_fetch_array($data)) {
		
			$date_posted = substr($row['DATE_POSTED'],0,10);
			$title = substr($row['TITLE'],0,50);
			$description = substr($row['DESCRIPTION'],0,70);
						
			echo "<tr>
				<td> $date_posted </td>
				<td> $title </td>
				<td> $description </td>
				</tr>";
		}	
		echo '</table>';
	}

?>

</body>
</html>