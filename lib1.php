<?php

function outputErrors($errors) {
	if (!empty($errors)) { 
		foreach($errors as $k => $error) { 
			echo "<p>$k: $error </p>"; 
		}
}
} 

function updateProfile($profile, $ch) {
	extract($profile);
	$q = "UPDATE sconnect_user set FIRST_NAME = '$firstname' , LAST_NAME = '$lastname', STUDENT_ID = '$username', CONTACT_EMAIL = '$email', CONTACT_PHONE =  '$phoneno' WHERE USER_ID = $profile[USER_ID]";
	if (!mysqli_query($ch, $q)) {
		die("Query Error:" . mysqli_error($ch));
	}
	echo "<p style='color:green'>Profile Updated</p>";
}

function addprofile($profile, $ch) { 
	extract($profile);
	$q = "INSERT INTO sconnect_user (FIRST_NAME, LAST_NAME, STUDENT_ID, login_pwd, CONTACT_EMAIL, CONTACT_PHONE) VALUES ('$firstname', '$lastname', '$username', '$pw1', '$email', '$phoneno')";
	if (!mysqli_query($ch, $q)) {
		die("Query Error:" . mysqli_error($ch));
	}
	echo "<p style='color:green'>Prodfile Added</p>";
}

function showprofile($ch) {
	$q = "SELECT * FROM sconnect_user where user_id = " . $_SESSION['user']['USER_ID'];
	$results = mysqli_query($ch, $q);
	$row = mysqli_fetch_assoc($results);

	?>
	<h2>Your Account</h2>
	<form method="post" action="">
	<table>
	<tr>
	<td><a href="manage_profile.php?action=update&USER_ID=<?= $row['USER_ID']; ?>">Edit profile</a></td>
	</tr>
	<tr>
	<td><a href="change_password">Change Password</a></td>
	</tr>
	<tr>
	<td><a href="delete_account.php?&USER_ID=<?= $row['USER_ID']; ?>">Delete Account</a></td>
	</tr>
	<tr>
	<td><a href="logout.php">Log Out</a></td>
	</tr>
	
	</table>
	</form>
	<?php
}

function showform($type=false, $ch=false) { 

	if ($type == "update") :

	$q = "SELECT * FROM sconnect_user WHERE USER_ID = $_GET[USER_ID]";
	$result = mysqli_query($ch, $q);
	$profile = mysqli_fetch_assoc($result);
	extract($profile); 

	?>
		<form method="post" action=""> 
		<input type="hidden" name="USER_ID" value="<?= $profile['USER_ID']; ?>"  /> <br /> 
		First Name:<input type="text" name="firstname" value="<?= $profile['FIRST_NAME']; ?>" /><br />
		Last Name:<input type="text" name="lastname" value="<?= $profile['LAST_NAME']; ?>" /><br />
		User Name:<input type="text" name="username" value="<?= $profile['STUDENT_ID']; ?>"/><br />
		Email ID:<input type="text" name="email" value="<?= $profile['CONTACT_EMAIL']; ?>"/><br />
		Contact No:<input type="text" name="phoneno" value="<?= $profile['CONTACT_PHONE']; ?>"/><br />
		<button type="submit">Update Profile</button>
		<button type="cancel"><a href="manage_profile.php">Cancel</a></button>
		</form>
<?php	
endif;

}

function show_item_list($ch) {
$q = "SELECT * FROM sconnect_item";
$results = mysqli_query($ch, $q);
echo "<table border='1px'>";
echo "<tr>";
echo "<th>Seller User ID</th>"; 
echo "<th>Date Posted</th>";
echo "<th>Title</th>";
echo "<th>Description</th>";
echo "<th>Price</th>";
echo "<th>Action</th>";
echo "</tr>";



while ($row = mysqli_fetch_assoc($results)) {
	echo "<tr>";
	echo "<td>" . $row['seller_user_id'] . "</td>";
	echo "<td>" . $row['date_posted'] . "</td>";
	echo "<td>$" . $row['title'] . "</td>";
	echo "<td>" . $row['description'] . "</td>";
	echo "<td>" . $row['price'] . "</td>";
	echo "<td><a href='view_post.php?action=view&seller_user_id=" . $row['seller_user_id'] . "'>View</a></td>";
	echo "</tr>";

}
echo "</table>";

}

function show_item($type=false, $ch=false, $id=false) {

	if ($type == "view") :

	$q = "SELECT sconnect_item.id, sconnect_item.seller_user_id, date_format(sconnect_item.date_posted, '%M %e, %Y') as date_posted, sconnect_item.title, sconnect_item.description, sconnect_item.price, sconnect_user.first_name, sconnect_user.last_name FROM sconnect_item, sconnect_user WHERE sconnect_item.seller_user_id = sconnect_user.user_id and sconnect_item.id = $id";
	$result = mysqli_query($ch, $q);
	if (mysqli_num_rows($result) == 0) {
		die ("Sorry! The requested data is not available or has just been deleted.");
	}
	$product = mysqli_fetch_assoc($result);
	extract($product); //no need of id
 

	?>
		<form method="post" action=""> 
		<input type="hidden" name="id" value="<?= $product['id']; ?>"  />
		
		<?php if ($product['seller_user_id'] == $_SESSION['user']['USER_ID']) { ?>
			Title: <input type="text" name="title" value="<?= $title; ?>" /><br /><br />
			Posted By: <?= $product['first_name'] .' '. $product['last_name']; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			Date Posted: <?= $date_posted; ?> <br /><br />	
			Description: <textarea name="description"><?= $description; ?></textarea> <br /><br />
			Price: <input type="text" name="price" value="<?= $price; ?>" /><br /><br />
			<input type="submit" name="btnUpdateItem" value="Update Post" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="submit" name="btnDeleteItem" value="Delete Post" /><br /><br />
		<?php 
		}
		else { 
		?>
			Title: <?= $title; ?> <br /><br />
			Posted By: <?= $product['first_name'] .' '. $product['last_name']; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			Date Posted: <?= $date_posted; ?> <br /><br />	
			Description: <?= $description ; ?> <br /><br />
			Price: <?= $price; ?><br /><br />
		<?php } ?>
		
		<?php if ($product['seller_user_id'] != $_SESSION['user']['USER_ID']) { ?>
		<fieldset>
  		<legend>Reply:</legend>
  			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  			Bid Price: <input type="text" name="bidprice" /><br />
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			Message to seller: <br />
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<textarea name="comments"></textarea> <br />
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="submit" name="btnPlaceBid" value="Place Bid" /><br /><br />
 		</fieldset>
 		<?php } ?>
 		
			<?php 
				$q = "select sconnect_user.FIRST_NAME, sconnect_user.LAST_NAME,  sconnect_item_bid.bid_amount, sconnect_item_bid.message_to_seller, date_format(sconnect_item_bid.date_comment_added, '%M %e, %Y at %h:%i %p') as date_comment_added, sconnect_item_bid.buyer_user_id from sconnect_item_bid JOIN sconnect_user ON (sconnect_user.USER_ID = sconnect_item_bid.buyer_user_id) AND sconnect_item_bid.item_id = $product[id]";
				$results = mysqli_query($ch, $q); ?>
				<?php 
				echo "<br />";
				echo "<b>Comments: </b>"; 
				echo "<br />";
				echo "<br />";
				 while ($row = mysqli_fetch_assoc($results)) {  
					$popupURL = 'send_email.php?action=send&id=' . $product['id'] . '&buyer_user_id=' . $row['buyer_user_id'];
					echo "<table width=66% border='0px'>";
					echo "<tr>";
					echo "<td width=30%> " . $row['FIRST_NAME'] . " " . $row['LAST_NAME'] . "</td>";  
					echo "<td width=36% align=right> " . $row['date_comment_added'] . "</td>";  
					echo "</tr>";
					echo "<tr height=10>";
					echo "</tr>";
					echo "<tr>";
					echo "<td><b>Bid Amount:</b></td>"; 
					echo "<td>" . $row['bid_amount'] . "</td>";  
					echo "</tr>";
					echo "<tr>";
					echo "<td colspan=2>" . $row['message_to_seller'] . "</td>";
					echo "</tr>";  
					echo "</table>";
					?>
					<?php if ($product['seller_user_id'] == $_SESSION['user']['USER_ID']) { ?>
						<button onclick="PopupCenter('<?= $popupURL ?>', 'Send Email', 300, 200)">Reply</button><br /><br />
					<?php } ?>
					<?php
					echo "<hr />"; ?>  <br />
					<?php			
				} 	
			?>
	</form> 
<?php	
endif;
}

function show_service($type=false, $ch=false, $id=false) {

	if ($type == "view") :

	$q = "SELECT sconnect_service.id, sconnect_service.seller_user_id, date_format(sconnect_service.date_posted, '%M %e, %Y') as date_posted, sconnect_service.title, sconnect_service.description, sconnect_user.first_name, sconnect_user.last_name  FROM sconnect_service, sconnect_user WHERE sconnect_service.seller_user_id = sconnect_user.user_id and sconnect_service.id = $id";
	$result = mysqli_query($ch, $q);
	if (mysqli_num_rows($result) == 0) {
		die ("Sorry! The requested data is not available or has just been deleted.");
	}
	$product = mysqli_fetch_assoc($result);
	extract($product); //no need of id


	?>
		<form method="post" action=""> 
		<input type="hidden" name="id" value="<?= $product['id']; ?>"  />
		
		<?php if ($product['seller_user_id'] == $_SESSION['user']['USER_ID']) { ?>
			Title: <input type="text" name="title" value="<?= $title; ?>" /><br /><br />
			Posted By: <?= $product['first_name'] .' '. $product['last_name']; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			Date Posted: <?= $date_posted; ?> <br /><br />
			Description: <textarea name="description"><?= $description; ?></textarea> <br /><br />
			<input type="submit" name="btnUpdateService" value="Update Post" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="submit" name="btnDeleteService" value="Delete Post" /><br /><br />
		<?php 
		}
		else { 
		?>
			Title: <?= $title; ?> <br /><br />
			Posted By: <?= $product['first_name'] .' '. $product['last_name']; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			Date Posted: <?= $date_posted; ?> <br /><br />		
			Description: <?= $description ; ?> <br /><br />
		<?php } ?>
		
		<?php if ($product['seller_user_id'] != $_SESSION['user']['USER_ID']) { ?>
		<fieldset>
  		<legend>Comment:</legend>
  			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  			Comments: <br />
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<textarea name="comments"></textarea> <br />
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="submit" name="btnSubmit" value="Submit" /><br /><br />
 		</fieldset>
 		<?php } ?>
 			<?php 
				$q = "select sconnect_user.FIRST_NAME, sconnect_user.LAST_NAME, sconnect_service_comment.comment, date_format(sconnect_service_comment.date_comment_added, '%M %e, %Y at %h:%i %p') as date_comment_added, sconnect_service_comment.buyer_user_id from sconnect_service_comment JOIN sconnect_user ON (sconnect_user.USER_ID = sconnect_service_comment.buyer_user_id) AND sconnect_service_comment.service_id = $product[id]";
				$results = mysqli_query($ch, $q); ?>
				<?php 
				echo "<br />";
				echo "<b>Comments</b>"; 
				 while ($row = mysqli_fetch_assoc($results)) {  
					$popupURL = 'send_email.php?action=send&id=' . $product['id'] . '&buyer_user_id=' . $row['buyer_user_id'];
		 			echo "<table width=66% border='0px'>";
					echo "<tr>";
					echo "<td width=25%> " . $row['FIRST_NAME'] . " " . $row['LAST_NAME'] . "</td>";  
					echo "<td width=36% align=right> " . $row['date_comment_added'] . "</td>";  
					echo "</tr>";
					echo "<tr height=10>";
					echo "</tr>";
					echo "<tr>";
					echo "<td colspan=2>" . $row['comment'] . "</td>";
					echo "</tr>";  
					echo "</table>";
					?>
					<?php if ($product['seller_user_id'] == $_SESSION['user']['USER_ID']) { ?>
						<button onclick="PopupCenter('<?= $popupURL ?>', 'Send Email', 300, 200)">Reply</button><br /><br />
					<?php } ?>
					<?php
					echo "<hr />"; ?>  <br />
					<?php		
				} 	
			?>
	</form>
<?php	

endif;
}

?>
<?php 
function dbConnect() {
	$host ="localhost";
	$user = "sconnect";
	$pw = "sconnect";
	$db = "sconnect";

	$ch = mysqli_connect($host, $user, $pw, $db);
	if (!$ch) {
		die('DB ERROR: ' . mysqli_connect_errno() . " " . mysqli_connect_error());
	}
	return  $ch;
}

?>
