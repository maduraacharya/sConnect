<?php include_once 'header.php'; ?>
 <body>
 <br>
 <h3>My Favorites</h3>
 <br>
 <h3>Items for Sale</h3>
 <br> 
 <?php
   $session_user_id = $_SESSION['user']['user_id'];
   $search_type = "item";
   $query = "SELECT 
   				sconnect_user_favorites.id as favorite_id,
   				sconnect_item.id as post_id,
   				sconnect_item.title,
   				sconnect_item.description,
   				sconnect_item.price,
   				date_format(sconnect_item.date_posted, '%M %e, %Y') AS date_posted
   			FROM sconnect_user_favorites, sconnect_item
   			WHERE sconnect_user_favorites.user_id = $session_user_id 
   			AND sconnect_user_favorites.post_id = sconnect_item.id
   			AND sconnect_user_favorites.post_type = 'Item'
   			ORDER BY date_posted DESC";
   $data = mysqli_query($ch, $query)
     or die('Error retrieving activity history for Items.');
 
   if( mysqli_num_rows($data) < 1 ){
    echo '<p>No records</p>';
   }
   else{
     echo '<table width=750px style="margin-left:25px" border="1" cellspacing="0" cellpadding="0">
		<tr>
          <th width=200px>Title</th>
          <th width=300px>Description</th> 
          <th width=50px align=right>Price</th>
          <th width=150px align=center>Date Posted</th>
          <th width=50px align=center>Action</th>
		</tr>';
     while ($row = mysqli_fetch_array($data)) {
             
       echo "<tr>
         <td> <a href='view_post.php?action=view&search_type=$search_type&id=" . $row['post_id'] . "'> $row[title] </td>
         <td> $row[description] </td>
         <td align=right> $row[price] </td>
         <td align=center> $row[date_posted]</td>
         <td align=center> <a href='delete_favorite.php?favorite_id=" . $row['favorite_id'] . "'>Remove</td>
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
   				sconnect_user_favorites.id as favorite_id,
   				sconnect_service.id as post_id,
   				sconnect_service.title,
   				sconnect_service.description,
   				sconnect_service.price,
   				date_format(sconnect_service.date_posted, '%M %e, %Y') AS date_posted
   			FROM sconnect_user_favorites, sconnect_service
   			WHERE sconnect_user_favorites.user_id = $session_user_id 
   			AND sconnect_user_favorites.post_id = sconnect_service.id
   			AND sconnect_user_favorites.post_type = 'Service'
   			ORDER BY date_posted DESC";
   $data = mysqli_query($ch, $query)
     or die('Error retrieving activity history for Items.');
 
   if( mysqli_num_rows($data) < 1 ){
    echo '<p>No records</p>';
   }
   else{
     echo '<table width=750px style="margin-left:25px" border="1" cellspacing="0" cellpadding="0">
		<tr>
          <th width=200px>Title</th>
          <th width=300px>Description</th>
          <th width=50px align=right>Price</th> 
          <th width=150px align=center>Date Posted</th>
          <th width=50px align=center>Action</th>
		</tr>';
     while ($row = mysqli_fetch_array($data)) {
             
       echo "<tr>
        <td> <a href='view_post.php?action=view&search_type=$search_type&id=" . $row['post_id'] . "'> $row[title] </td>
         <td padding=5px> $row[description] </td>
         <td align=right> $row[price] </td>
         <td align=center> $row[date_posted]</td>
         <td align=center> <a href='delete_favorite.php?favorite_id=" . $row['favorite_id'] . "'>Remove</td>
         </tr>";
     }  
     echo '</table>';
   }
 ?>
 
</body>
</html>

<?php include_once 'footer.php'; ?>
