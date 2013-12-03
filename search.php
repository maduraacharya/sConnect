<?php include_once 'header.php'; ?>

<?php
$user_search_text = '';
if (!empty($_POST)) {
	$user_search_text = $_POST['search_text'];
}
?>

<h2>Search</h2>
<br><br>
<p align="center"><b>sConnect Search</b></p>

<div align="center">
<form method="post" action="">
 <?php if (empty($_POST)) { ?>
 	<select name="category" id="category" class="input" onchange="document.getElementById('text_content').value=this.options[this.selectedIndex].text">
	  <optgroup label="Items">
		<option value="item.All Items">All Items</option>
		<option value="item.Books">Books</option>
		<option value="item.Cellphones">Cellphones</option>
		<option value="item.Electronics">Electronics</option>
		<option value="item.Software">Software</option>
		<option value="item.Others">Others</option>
	  </optgroup>
	  <optgroup label="Services">
		<option value="service.All Services">All Services</option>
		<option value="service.Carpool">Carpool</option>
		<option value="service.Tutoring">Tutoring</option>
		<option value="service.Shopping">Shopping</option>
		<option value="service.Others">Others</option>
	  </optgroup>
	</select>
 <?php 
 }
 else {
 ?>
	<select font-size=11px name="category" id="category" class="input" onchange="document.getElementById('selected_category').value = this.options[this.selectedIndex].text">
	  <optgroup label="Items">
		<option value="item.All Items"<?php if ('item.All Items' == $_POST['category']) { echo " selected =\"selected\""; } ?>>All Items</option>
		<option value="item.Books"<?php if ('item.Books' == $_POST['category']) { echo " selected =\"selected\""; } ?>>Books</option>
		<option value="item.Cellphones"<?php if ('item.Cellphones' == $_POST['category']) { echo " selected =\"selected\""; } ?>>Cellphones</option>
		<option value="item.Electronics"<?php if ('item.Electronics' == $_POST['category']) { echo " selected =\"selected\""; } ?>>Electronics</option>
		<option value="item.Software"<?php if ('item.Software' == $_POST['category']) { echo " selected =\"selected\""; } ?>>Software</option>
		<option value="item.Others"<?php if ('item.Others' == $_POST['category']) { echo " selected =\"selected\""; } ?>>Others</option>
	  </optgroup>
	  <optgroup label="Services">
		<option value="service.All Services"<?php if ('service.All Services' == $_POST['category']) { echo " selected =\"selected\""; } ?>>All Services</option>
		<option value="service.Carpool"<?php if ('service.Carpool' == $_POST['category']) { echo " selected =\"selected\""; } ?>>Carpool</option>
		<option value="service.Tutoring"<?php if ('service.Tutoring' == $_POST['category']) { echo " selected =\"selected\""; } ?>>Tutoring</option>
		<option value="service.Shopping"<?php if ('service.Carpool' == $_POST['category']) { echo " selected =\"selected\""; } ?>>Carpool</option>
		<option value="service.Others"<?php if ('service.Others' == $_POST['category']) { echo " selected =\"selected\""; } ?>>Others</option>
	  </optgroup>
	</select>
 <?php } ?>
<input type="hidden" name="selected_category" id="selected_category" value="" />
&nbsp;
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
 
	$search_selection = $_POST['category'];
	$search_types = explode(".", $search_selection);
	$search_type = $search_types[0];
	$search_subtype = $search_types[1];

    $search_text = mysqli_real_escape_string($ch, trim($_POST['search_text']));
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
   } 
 	if (sizeof($search_array) > 0) {
 
		if ($search_type == 'item') {
		  $query = "SELECT id, title, description, price, date_format(date_posted, '%M %e, %Y') AS date_posted FROM SCONNECT_ITEM WHERE 1=1";
		}
		else {
		  $query = "SELECT id, title, description, price, date_format(date_posted, '%M %e, %Y') AS date_posted FROM SCONNECT_SERVICE WHERE 1=1";
		}
		if ($search_subtype != 'All Items' AND $search_subtype != 'All Services') {
			$query .= " AND CATEGORY = '$search_subtype'";
		}

		$query .= " AND (";
		foreach ($search_array as $index => $word) {
			if ($index != 0) {
				$query .= ' OR ';
		  	}
		  	$query .= "((DESCRIPTION LIKE '%$word%') OR (TITLE LIKE '%$word%'))";
		}
		$query .= ")";
	} // if( sizeof($search_array) > 0)
 	else {
		if ($search_type == 'item') {
			$query = "SELECT id, title, description, price, date_format(date_posted, '%M %e, %Y') AS date_posted FROM SCONNECT_ITEM WHERE 1=1";
		}
		else{
			$query = "SELECT id, title, description, price, date_format(date_posted, '%M %e, %Y') AS date_posted FROM SCONNECT_SERVICE WHERE 1=1";
		}
		if ($search_subtype != 'All Items' AND $search_subtype != 'All Services') {
			$query .= " AND CATEGORY = '$search_subtype'";
		}
	}

	$query .= " ORDER BY DATE_POSTED DESC";
   
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
          <th width=200px>Title</th>
          <th width=300px>Description</th> 
          <th width=50px align=right>Price</th>
          <th width=150px align=center>Date Posted</th>
		</tr>';
		
		while ($row = mysqli_fetch_array($data)) {
     
			extract($row);
    
       		echo "
			<tr>
         		<td> <a href='view_post.php?action=view&search_type=$search_type&id=" . $id . "'> $row[title] </td>
				<td> $row[description] </td>
				<td align=right> $row[price] </td>
				<td align=center> $row[date_posted]</td>
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