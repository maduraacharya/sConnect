<?php include_once 'header.php'; ?>

<?php
is_valid_session();
is_admin_user();

$user_search_text = '';
if (!empty($_POST)) {
	$user_search_text = $_POST['search_text'];
}
?>

<h2>Manage Users</h2>
<br><br>

<form method="post" action="">
<div align="center">
<label for="search_text">Enter Search Criteria: </label>
<input type="text" name="search_text" value="<?= $user_search_text; ?>" size=50>
&nbsp; 
<input type="submit" name="search_submit" value="Search">
</div>
<br>

<?php
if (!empty($_POST)) {

	if(mysqli_connect_errno($ch)) {
 	  echo "failed to connect to mysql";
 	}

    $search_text = mysqli_real_escape_string($ch, trim($_POST['search_text']));
    $search_text = str_replace(',', ' ', $search_text);
    $search_array = array();  

 	if ($search_text != '') {
 		$query = "SELECT 
 					user_id, 
 					first_name, 
 					last_name, 
 					student_id, 
 					login_pwd, 
 					contact_email, 
 					contact_phone, 
 					role, 
 					date_format(date_created, '%M %e, %Y') as date_created 
 				  FROM sconnect_user 
 				  WHERE role = 'user'
 				  AND MATCH (first_name, last_name, student_id, contact_email) AGAINST ('$search_text' IN NATURAL LANGUAGE MODE)";
	}
 	else {
 		$query = "SELECT user_id, first_name, last_name, student_id, login_pwd, contact_email, contact_phone, role, date_format(date_created, '%M %e, %Y') as date_created FROM sconnect_user WHERE role = 'user'";
	}

	$query .= " ORDER BY date_created DESC";
   
	$data = mysqli_query($ch, $query)
       or die('Error querying database.');
    
    $rec_count = mysqli_num_rows($data);
    $rec_limit = 5;
    $number_of_pages = ceil($rec_count / $rec_limit);
    
    if (isset($_POST{'page_number'} ) )
    {
    	if (isset($_POST['btnNext'])) {
        	$page = $_POST{'page_number'} + 1;
        	$offset = $rec_limit * $page ;
        }
        elseif (isset($_POST['btnPrev'])) {
        	$page = $_POST{'page_number'} - 1;
        	$offset = $rec_limit * $page ;
        }
        else {
        	$page = 0;
        	$offset = 0;
        }
    }
    else
    {
        $page = 0;
        $offset = 0;
    }
    $left_rec = $rec_count - ($page * $rec_limit);
    
    $query .= " LIMIT $offset, $rec_limit";
        
    $data = mysqli_query($ch, $query)
       or die('Error querying database.');
    
    echo '<div style="margin-left:75px" width=750px>';
        
	if( mysqli_num_rows($data) > 0) {
 		
 		echo '<h3>Search Results</h3>';
 		echo '<br>';
		echo '<table width=750px border="1" cellspacing="0" cellpadding="0">
		<tr>
          <th width=100px>First Name</th>
          <th width=100px>Last Name</th>
          <th width=100px>Student ID</th> 
          <th width=200px>Contact Email</th>
          <th width=100px>Contact Phone</th>
          <th width=150px align=center>Date Created</th>
          <th width=150px align=center>Action</th>
		</tr>';
		
		while ($row = mysqli_fetch_array($data)) {
     
			extract($row);
    
       		echo "
			<tr>
         		<td> $first_name </td>
				<td> $last_name </td>
				<td> $student_id </td>
				<td> $contact_email </td>
				<td> $contact_phone </td>
				<td align=center> $date_created </td>
				<td align=center><a href='admin_edit_profile.php?action=edit&user_id=$user_id'>Edit</a></td>
			</tr>";
     	}
     	echo '</table>';
     	echo '<br>';
     	echo '<table width=750px border="0" cellspacing="0" cellpadding="0">';
     	echo '<tr><td align=right>';
     	$page_number_display = 'Page ' . ($page + 1) . ' of ' . $number_of_pages;
     	echo "<input type=\"hidden\" name=\"page_number\" id=\"page_number\" value=\"$page\" />";
     	echo "$page_number_display ";
		
		if ( $page == 0 && $number_of_pages > 1) {
			echo "<input type=\"submit\" id=\"btnNext\" name=\"btnNext\" value=\"Next\">";
		}
		elseif (( $page > 0 ) && ( $left_rec > $rec_limit )) {
			$last = $page - 2;
			echo "<input type=\"submit\" id=\"btnPrev\" name=\"btnPrev\" value=\"Prev\"> | ";
			echo "<input type=\"submit\" id=\"btnNext\" name=\"btnNext\" value=\"Next\">";
		}
		elseif ( $left_rec <= $rec_limit && $page != 0) {
			$last = $page - 2;
			echo "<input type=\"submit\" id=\"btnPrev\" name=\"btnPrev\" value=\"Prev\">";
		}
		echo '</td></tr>';
		echo '</table>';
		echo '<br>';
	}
	else {
  		echo '<p>No matching records found</p>';
	}
	echo '</div>';
}
?>
</form>


 <?php include_once 'footer.php'; ?>