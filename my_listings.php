<?php include_once 'header.php'; ?>

<?php
is_valid_session();
?>

 <h2>My Listings</h2>
 <br>
 <div style="margin-left:75px">
 <h3>Items for Sale</h3>
 <br> 
 <?php
   $session_user_id = $_SESSION['user']['user_id'];
   $search_type = "item";
   $query = "SELECT 
   				sconnect_item.id,
   				sconnect_item.title,
   				sconnect_item.description,
   				sconnect_item.price,
   				date_format(sconnect_item.date_posted, '%M %e, %Y') AS date_posted
   			FROM sconnect_item 
   			WHERE sconnect_item.seller_user_id = $session_user_id 
   			ORDER BY date_posted DESC";
   $data = mysqli_query($ch, $query)
     or die('Error retrieving activity history for Items.');
 
   if( mysqli_num_rows($data) < 1 ){
    echo '<p>No records</p>';
   }
   else{
     echo '<table width=700px border="1" cellspacing="0" cellpadding="0">
		<tr>
          <th width=200px>Title</th>
          <th width=300px>Description</th> 
          <th width=50px align=right>Price</th>
          <th width=150px align=center>Date Posted</th>
		</tr>';
     while ($row = mysqli_fetch_array($data)) {
             
       echo "<tr>
         <td> <a href='view_post.php?action=view&search_type=$search_type&id=" . $row['id'] . "'> $row[title] </td>
         <td> $row[description] </td>
         <td align=right> $row[price] </td>
         <td align=center> $row[date_posted]</td>
         </tr>";
     }  
     echo '</table>';
   }
 ?>
 
 <br>
 <h3>Services</h3>
 <br>
 <?php
   $session_user_id = $_SESSION['user']['user_id'];
   $search_type = "service";
   $query = "SELECT 
   				sconnect_service.id,
   				sconnect_service.title,
   				sconnect_service.description,
   				sconnect_service.price,
   				date_format(sconnect_service.date_posted, '%M %e, %Y') AS date_posted
   			FROM sconnect_service
   			WHERE sconnect_service.seller_user_id = $session_user_id 
   			ORDER BY date_posted DESC";
   $data = mysqli_query($ch, $query)
     or die('Error retrieving activity history for Items.');
 
   if( mysqli_num_rows($data) < 1 ){
    echo '<p>No records</p>';
   }
   else{
     echo '<table width=700px border="1" cellspacing="0" cellpadding="0">
		<tr>
          <th width=200px>Title</th>
          <th width=300px>Description</th>
          <th width=50px align=right>Price</th> 
          <th width=150px align=center>Date Posted</th>
		</tr>';
     while ($row = mysqli_fetch_array($data)) {
             
       echo "<tr>
        <td> <a href='view_post.php?action=view&search_type=$search_type&id=" . $row['id'] . "'> $row[title] </td>
         <td padding=5px> $row[description] </td>
         <td align=right> $row[price] </td>
         <td align=center> $row[date_posted]</td>
         </tr>";
     }  
     echo '</table>';
     echo '<br>';
   }
 ?>

<?php include_once 'footer.php'; ?>