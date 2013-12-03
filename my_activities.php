<?php include_once 'header.php'; ?>

<?php
is_valid_session();
?>

 <h2>My Activities</h2>
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
   				sconnect_item_bid.bid_amount,
   				sconnect_item_bid.message_to_seller,
   				date_format(sconnect_item_bid.date_comment_added, '%M %e, %Y') AS date_comment_added
   			FROM sconnect_item_bid, sconnect_item 
   			WHERE sconnect_item_bid.buyer_user_id = $session_user_id 
   			AND sconnect_item_bid.item_id = sconnect_item.id
   			ORDER BY date_comment_added DESC";
   $data = mysqli_query($ch, $query)
     or die('Error retrieving activity history for Items.');
 
   if( mysqli_num_rows($data) < 1 ){
    echo '<p>No records</p>';
   }
   else{
     echo '<table width=800px border="1" cellspacing="0" cellpadding="0">
		<tr>
          <th width=100px>Title</th>
          <th width=200px>Description</th> 
          <th width=50px align=right>Price</th>
          <th width=50px align=right>Bid Amount</th>
          <th width=250px>Comment</th>
          <th width=150px align=center>Date Commented</th>
		</tr>';
     while ($row = mysqli_fetch_array($data)) {
             
       echo "<tr>
         <td> <a href='view_post.php?action=view&search_type=$search_type&id=" . $row['id'] . "'> $row[title] </td>
         <td> $row[description] </td>
         <td align=right> $row[price] </td>
         <td align=right> $row[bid_amount]</td>
         <td> $row[message_to_seller]</td>
         <td align=center> $row[date_comment_added]</td>
         </tr>";
     }  
     echo '</table>';
   }
 ?>
 
 <br><br>
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
   				sconnect_service_comment.comment,
   				date_format(sconnect_service_comment.date_comment_added, '%M %e, %Y') AS date_comment_added
   			FROM sconnect_service_comment, sconnect_service
   			WHERE sconnect_service_comment.buyer_user_id = $session_user_id 
   			AND sconnect_service_comment.service_id = sconnect_service.id
   			ORDER BY date_comment_added DESC";
   $data = mysqli_query($ch, $query)
     or die('Error retrieving activity history for Items.');
 
   if( mysqli_num_rows($data) < 1 ){
    echo '<p>No records</p>';
   }
   else{
     echo '<table width=800 border="1" cellspacing="0" cellpadding="5">
		<tr>
          <th width=100px>Title</th>
          <th width=200px>Description</th>
          <th width=50px align=right>Price</th> 
          <th width=300px>Comment</th>
          <th width=150px align=center>Date Commented</th>
		</tr>';
     while ($row = mysqli_fetch_array($data)) {
             
       echo "<tr>
        <td> <a href='view_post.php?action=view&search_type=$search_type&id=" . $row['id'] . "'> $row[title] </td>
         <td padding=5px> $row[description] </td>
         <td align=right> $row[price] </td>
         <td> $row[comment]</td>
         <td align=center> $row[date_comment_added]</td>
         </tr>";
     }  
     echo '</table>';
     echo '<br>';
   }
 ?>
 </div>
<?php include_once 'footer.php'; ?>