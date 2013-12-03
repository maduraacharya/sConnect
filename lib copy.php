<?php
include_once 'MySQLDatabase.php';
include_once 'UserProfile.php';
include_once 'Item.php';
include_once 'Service.php';

function outputErrors($errors) {
	if (!empty($errors)) { 
		foreach($errors as $k => $error) { 
			echo "<p>$k: $error </p>"; 
		}
}
}

function validate_image($files) {
	$error_message = 'SUCCESS';
	$allowed_file_extensions = array("gif", "jpeg", "jpg", "png");
	$temp = explode(".", $files["image"]["name"]);
	$file_extension = strtolower(end($temp));

	if ((($files["image"]["type"] == "image/gif")
	|| ($files["image"]["type"] == "image/jpeg")
	|| ($files["image"]["type"] == "image/jpg")
	|| ($files["image"]["type"] == "image/pjpeg")
	|| ($files["image"]["type"] == "image/x-png")
	|| ($files["image"]["type"] == "image/png"))
	&& in_array($file_extension, $allowed_file_extensions))
	{
		if ($files["image"]["error"] > 0)
		{
			if ($files["image"]["error"] == 4) {
				$error_message = "NO_FILE_TO_UPLOAD";
			}
			else {
				$error_message = "Error occurred while uploading the file";
			}
		}
	}
	else
	{
		if ($files["image"]["error"] == 4) {
			$error_message = "NO_FILE_TO_UPLOAD";
		}
		else {
			$error_message =  "Invalid image file. Accepted file types are: gif, jpeg, jpg, png and allowed max file size is " . ini_get("upload_max_filesize");
		}
	}
	return $error_message;
}

function is_admin_user() {
	if (isset($_SESSION['user'])) {
		if ($_SESSION['user']['role'] != 'admin') {
			die("You do not have privileges to access this feature.");
		}
	}
	else {
		header('location:login.php');
	}
}

function is_valid_session() {
	if (!isset($_SESSION['user'])) {
		header('location:login.php');
	}
}

function show_profile($type=false, $ch=false) { 

	if ($type == "update") :

		$user_profile = new UserProfile();
		$row = $user_profile->fetchAsArray($ch, $_GET['user_id']);
		extract($row);

	?>
		<h2>Edit Profile</h2>
		<br>
		<form name="edit_profile" method="post" action=""> 
		<table border=0 width=100% cellspacing=7 cellpadding=0> 
		<tr>
		<td width=20% align=right font-size=13px> </td><td align=left><input type="hidden" name="user_id" value="<?= $user_id; ?>"  /></td>
		</tr>
		 <tr>
		<td width=20% align=right font-size=13px>First Name: </td><td align=left><input type="text" name="firstname" value="<?= $first_name; ?>" /><sup><font color="red">*</font></sup><span id="firstname_error" style="color:red"></span></td>
		</tr>
		 <tr>
		<td width=20% align=right font-size=13px>Last Name: </td><td align=left><input type="text" name="lastname" value="<?= $last_name; ?>" /><sup><font color="red">*</font></sup><span id="lastname_error" style="color:red"></span></td>
		</tr>
		 <tr>
		<td width=20% align=right valign=top font-size=13px>Username: </td><td align=left><input type="text" name="username" value="<?= $student_id; ?>"/><sup><font color="red">*</font></sup><span id="username_error" style="color:red"></span><br><span style="font-size: 0.8em">(Enter Student ID)</span></td>
		</tr>
		 <tr>
		<td width=20% align=right font-size=13px>Contact Email: </td><td align=left><input type="text" name="email" value="<?= $contact_email; ?>"/><sup><font color="red">*</font></sup><span id="email_error" style="color:red"></span></td>
		</tr>
		 <tr>
		<td width=20% align=right font-size=13px>Contact Phone: </td><td align=left><input type="text" name="phoneno" value="<?= $contact_phone; ?>"/></td>
		</tr>
		<tr height=50>
		<td width=20%></td><td align=left><input type="button" value="Update Profile" onclick="validateEditProfileForm()"> 
		<input type="button" value="Cancel" onclick='location.href="manage_profile.php"'></td>
		</tr>
		</table>
		</form>
	<?php	
	endif;

}


function show_item($ch=false, $id=false) {
	
	$item = new Item();
	$row = $item->fetchAsArray($ch, $id);
	extract($row);
?>
	<h2>Item for Sale</h2>
	<br>
	<form method="post" action="" enctype="multipart/form-data"> 
	<input type="hidden" name="id" value="<?= $id; ?>"  />
	
	<?php if (($seller_user_id == $_SESSION['user']['user_id']) || ($_SESSION['user']['role'] == 'admin')) { ?>		
		<table border=0 width=100% cellspacing=7 cellpadding=0> 
		<tr>
		<td width=20% align=right font-size=13px>Category: </td><td width=20% align=left font-size=13px><?= $category; ?></td>
		</tr>
		<tr>
		<td width=20% align=right font-size=13px>Title: </td><td width=40% align=left font-size=13px><input type="text" name="title" value="<?= $title; ?>"></td>
		</tr>
		<tr>
		<td width=20% align=right font-size=13px>Posted By: </td><td width=40% align=left font-size=13px><?= $first_name .' '. $last_name; ?></td>
		<td width=20% align=right font-size=13px>On: </td><td width=20% align=left font-size=13px><?= $date_posted; ?></td>
		</tr>
		<tr>
		<td width=20% align=right valign=top font-size=13px>Description: </td><td width=40% align=left font-size=13px><textarea name="description"><?= $description; ?></textarea></td>
		</tr>
		<tr>	
		<td width=20% align=right font-size=13px>Price: </td><td width=40% align=left font-size=13px><input type="text" name="price" value="<?= $price; ?>"></td>
		</tr>
		<tr>
		<td width=20% align=right valign=top font-size=13px>Image: </td><td width=40% align=left font-size=13px><img src="data:image/jpeg;base64, <?= base64_encode( $image ) ?> " /></td>
		</tr>
		<tr>
		<td width=20% align=right font-size=13px>Change Image: </td><td width=40% align=left font-size=13px><input type="file" name="image" value="Choose File" ></td>
		</tr>
		<tr>
		<td width=20% align=right font-size=13px></td><td width=20% align=left font-size=13px><input type="submit" name="btnUpdateItem" value="Update Post" /> <input type="submit" name="btnDeleteItem" value="Delete Post" /></td>
		</tr>
		</table>
		<br>
	<?php 
	}
	else { 
	?>
		<table border=0 width=100% cellspacing=7 cellpadding=0>
		<tr>
		<td width=20% align=right font-size=13px>Category: </td><td width=20% align=left font-size=13px><?= $category; ?></td>
		</tr>
		<tr>
		<td width=20% align=right font-size=13px>Title: </td><td width=40% align=left font-size=13px><?= $title; ?></td>
		</tr>
		<tr>
		<td width=20% align=right font-size=13px>Posted By: </td><td width=40% align=left font-size=13px><?= $first_name .' '. $last_name; ?></td>
		<td width=20% align=right font-size=13px>On: </td><td width=20% align=left font-size=13px><?= $date_posted; ?>
		</tr>
		<tr>
		<td width=20% align=right valign=top font-size=13px>Description: </td><td width=40% align=left font-size=13px><?= $description; ?></td>
		</tr>
		<tr>	
		<td width=20% align=right font-size=13px>Price: </td><td width=40% align=left font-size=13px><?= $price; ?></td>
		</tr>
		<tr>
		<td width=20% align=right valign=top font-size=13px>Image: </td><td width=40% align=left font-size=13px><img src="data:image/jpeg;base64, <?= base64_encode( $image ) ?> " /></td>
		</tr>
		<tr>
		<td width=20% valign="top" align=right font-size=13px></td><td width=40% align=left font-size=13px><input type="button" name="btnAddItemToFavorite" value="Add to Favorites" onclick="location.href='create_favorite.php?post_id=<?= $id; ?>&post_type=Item'"/></td>
		</tr>
		</table>
		<br>
		
	<?php } ?>
	
	<?php if ($seller_user_id != $_SESSION['user']['user_id']) { ?>
	<fieldset>
	<legend>Reply:</legend>
		<table border=0 width=100% cellspacing=7 cellpadding=0> 
		<tr>
		<td width=20% align=right font-size=13px>Bid Price: </td><td width=40% align=left font-size=13px><input type="text1" name="bidprice" /></td>
		</tr>
		<tr>
		<td width=20% valign="top" align=right font-size=13px>Message to Seller: </td><td width=40% align=left font-size=13px><textarea name="comments"></textarea></td>
		</tr>
		<tr>
		<td width=20% valign="top" align=right font-size=13px></td><td width=40% align=left font-size=13px><input type="submit" name="btnPlaceBid" value="Place Bid" /></td>
		</tr>
		</table>
		<br>
	</fieldset>
	<?php } ?>
	
	<?php 
	$query = "SELECT sconnect_user.FIRST_NAME, sconnect_user.LAST_NAME,  sconnect_item_bid.bid_amount, sconnect_item_bid.message_to_seller, 
			date_format(sconnect_item_bid.date_comment_added, '%M %e, %Y at %h:%i %p') AS date_comment_added, 
			sconnect_item_bid.buyer_user_id, sconnect_item_bid.id AS comment_id
		  FROM sconnect_item_bid JOIN sconnect_user ON (sconnect_user.user_id = sconnect_item_bid.buyer_user_id) 
		  AND sconnect_item_bid.item_id = $id";
	$results = mysqli_query($ch, $query); ?>
	<?php 
	echo "<br />";
	echo "<b style=\"margin-left:10px;\">Comments: </b>"; 
	echo "<br />";
	echo "<br />";
	echo "<div style=\"width:550px; margin-left:10px;\">";
	while ($row = mysqli_fetch_assoc($results)) {  
		$popupURL = 'send_email.php?action=send&id=' . $id . '&buyer_user_id=' . $row['buyer_user_id'];
		echo "<table width=550px border='0px'>";
		echo "<tr>";
		echo "<td width=30% style=\"color:#AF7A5E;\">" . $row['FIRST_NAME'] . " " . $row['LAST_NAME'] . "</td>";  
		echo "<td width=50% align=left style=\"color:#AF7A5E;\">" . $row['date_comment_added'] . "</td>";  
		echo "</tr>";
		echo "<tr height=10>";
		echo "</tr>";
		echo "<tr>";
		echo "<td>Bid Amount: $" . $row['bid_amount'] . "</td>"; 
		//echo "<td>" . $row['bid_amount'] . "</td>";  
		echo "</tr>";
		echo "<tr>";
		echo "<td colspan=2>" . $row['message_to_seller'] . "</td>";
		echo "</tr>";
		if ($_SESSION['user']['role'] == 'admin') {
			echo "<tr>";
			echo "<td width=30% align=left><input type=\"button\" name=\"btnDeleteItemComment\" value=\"Delete Comment\" onclick=\"location.href='admin_delete_comment.php?post_type=item&post_id=$id&comment_id=$row[comment_id]'\"/></td>";
			echo "</tr>";
		} 
		echo "</table>";
		?>
		<?php if ($seller_user_id == $_SESSION['user']['user_id']) { ?>
			<button onclick="PopupCenter('<?= $popupURL ?>', 'Send Email', 300, 200)">Accept Bid</button><br /><br />
		<?php } ?>
		<?php
		echo "<hr width=560px />"; ?>  <br />
		<?php			
	} 	
	?>
	</div>
	</form> 
<?php	
}

function show_service($ch=false, $id=false) {

	$service = new Service();
	$row = $service->fetchAsArray($ch, $id);
	extract($row);

?>
	<h2>Service</h2>
	<br>
	<form method="post" action=""> 
	<input type="hidden" name="id" value="<?= $id; ?>"  />
	
	<?php if (($seller_user_id == $_SESSION['user']['user_id']) || ($_SESSION['user']['role'] == 'admin')) { ?>
		<table border=0 width=100% cellspacing=7 cellpadding=0> 
		<tr>
		<td width=20% align=right font-size=13px>Category: </td><td width=20% align=left font-size=13px><?= $category; ?></td>
		</tr>
		<tr>
		<td width=20% align=right font-size=13px>Title: </td><td width=40% align=left font-size=13px><input type="text" name="title" value="<?= $title; ?>"></td>
		</tr>
		<tr>
		<td width=20% align=right font-size=13px>Posted By: </td><td width=40% align=left font-size=13px><?= $first_name .' '. $last_name; ?></td>
		<td width=20% align=right font-size=13px>On: </td><td width=20% align=left font-size=13px><?= $date_posted; ?></td>
		</tr>
		<tr>
		<td width=20% align=right valign=top font-size=13px>Description: </td><td width=40% align=left font-size=13px><textarea name="description"><?= $description; ?></textarea></td>
		</tr>
		<tr>	
		<td width=20% align=right font-size=13px>Price: </td><td width=40% align=left font-size=13px><input type="text" name="price" value="<?= $price; ?>"></td>
		</tr>
		<tr>
		<td width=20% align=right font-size=13px></td><td width=20% align=left font-size=13px><input type="submit" name="btnUpdateService" value="Update Post" /> <input type="submit" name="btnDeleteService" value="Delete Post" /></td>
		</tr>
		</table>
		<br>
		
	<?php 
	}
	else { 
	?>
		<table border=0 width=100% cellspacing=7 cellpadding=0> 
		<tr>
		<td width=20% align=right font-size=13px>Category: </td><td width=20% align=left font-size=13px><?= $category; ?></td>
		</tr>
		<tr>
		<td width=20% align=right font-size=13px>Title: </td><td width=40% align=left font-size=13px><?= $title; ?></td>
		</tr>
		<tr>
		<td width=20% align=right font-size=13px>Posted By: </td><td width=40% align=left font-size=13px><?= $first_name .' '. $last_name; ?></td>
		<td width=20% align=right font-size=13px>On: </td><td width=20% align=left font-size=13px><?= $date_posted; ?>
		</tr>
		<tr>
		<td width=20% align=right valign=top font-size=13px>Description: </td><td width=40% align=left font-size=13px><?= $description; ?></td>
		</tr>
		<tr>	
		<td width=20% align=right font-size=13px>Price: </td><td width=40% align=left font-size=13px><?= $price; ?></td>
		</tr>
		<tr>
		<td width=20% valign="top" align=right font-size=13px></td><td width=40% align=left font-size=13px><input type="button" name="btnAddToFavorite" value="Add to Favorites" onclick="location.href='create_favorite.php?post_id=<?= $id; ?>&post_type=Service'"/></td>
		</tr>
		</table>
		<br>
	<?php } ?>
	
	<?php if ($seller_user_id != $_SESSION['user']['user_id']) { ?>
	<fieldset>
	<legend>Reply:</legend>
		<table border=0 width=100% cellspacing=7 cellpadding=0> 
		<tr>
		<td width=20% valign="top" align=right font-size=13px>Comment: </td><td width=40% align=left font-size=13px><textarea name="comments"></textarea></td>
		</tr>
		<tr>
		<td width=20% valign="top" align=right font-size=13px></td><td width=40% align=left font-size=13px><input type="submit" name="btnSubmit" value="Submit" /></td>
		</tr>
		</table>
		<br>
	</fieldset>
	<?php } ?>
	<?php 
	$query = "SELECT sconnect_user.FIRST_NAME, sconnect_user.LAST_NAME, sconnect_service_comment.comment, 
			date_format(sconnect_service_comment.date_comment_added, '%M %e, %Y at %h:%i %p') AS date_comment_added, 
			sconnect_service_comment.buyer_user_id, sconnect_service_comment.id AS comment_id
		  FROM sconnect_service_comment JOIN sconnect_user ON (sconnect_user.user_id = sconnect_service_comment.buyer_user_id) 
		  AND sconnect_service_comment.service_id = $id";
	$results = mysqli_query($ch, $query); ?>
	<?php 
	echo "<br />";
	echo "<b style=\"margin-left:10px;\">Comments: </b>"; 
	echo "<br />";
	echo "<br />";
	echo "<div style=\"width:550px; margin-left:10px;\">"; 
	while ($row = mysqli_fetch_assoc($results)) {  
		$popupURL = 'send_email.php?action=send&id=' . $id . '&buyer_user_id=' . $row['buyer_user_id'];
		echo "<table width=66% border='0px'>";
		echo "<tr>";
		echo "<td width=30% style=\"color:#AF7A5E;\">" . $row['FIRST_NAME'] . " " . $row['LAST_NAME'] . "</td>";  
		echo "<td width=50% align=left style=\"color:#AF7A5E;\">" . $row['date_comment_added'] . "</td>"; 
		echo "</tr>";
		echo "<tr height=10>";
		echo "</tr>";
		echo "<tr>";
		echo "<td colspan=2>" . $row['comment'] . "</td>";
		echo "</tr>";
		if ($_SESSION['user']['role'] == 'admin') {
			echo "<tr>";
			echo "<td width=30% align=left><input type=\"button\" name=\"btnDeleteServiceComment\" value=\"Delete Comment\" onclick=\"location.href='admin_delete_comment.php?post_type=service&post_id=$id&comment_id=$row[comment_id]'\"/></td>";
			echo "</tr>";
		}
		echo "</table>";
		?>
		<?php if ($seller_user_id == $_SESSION['user']['user_id']) { ?>
			<button onclick="PopupCenter('<?= $popupURL ?>', 'Send Email', 300, 200)">Reply</button><br /><br />
		<?php } ?>
		<?php
		echo "<hr width=560px />"; ?>  <br />
		<?php		
	} 	
	?>
	</div>
	</form>
<?php	

}

?>
<?php 
function dbConnect() {
	$mysql_database = new MySQLDatabase();
	$ch = $mysql_database->dbConnect();
	
	/*$host ="localhost";
	$user = "sconnect";
	$pw = "sconnect";
	$db = "sconnect";

	$ch = mysqli_connect($host, $user, $pw, $db);
	if (!$ch) {
		die('DB ERROR: ' . mysqli_connect_errno() . " " . mysqli_connect_error());
	}
	*/
	return  $ch;
}

?>