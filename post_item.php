<?php 
include_once 'header.php';
include_once 'Item.php';
?>

<?php
is_valid_session();
?>

<h2>Create Post</h2>
<br /> 
<?php

 $post_type = 'item';
 
 if (!empty($_POST)) { 
	if (empty($errors)) {
		extract($_POST); 
	 
		if (isset( $_POST['post_type']))
			$post_type =$_POST['post_type'];
		
		if (isset( $_POST['post_category']))
			$post_category = $_POST['post_category'];
			
		$form_title = mysqli_real_escape_string($ch, trim($_POST['title']));
		$form_price = mysqli_real_escape_string($ch, trim($_POST['price']));
		$form_description = mysqli_real_escape_string($ch, trim($_POST['description']));

		if (!empty($_FILES)) {
			if (!empty($_FILES)) {
				$upload_file_status = validate_image($_FILES);
				if ($upload_file_status == "SUCCESS") {
					$image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
					$image_name = addslashes($_FILES['image']['name']);
					$image_type = $_FILES['image']['type'];
				}
				elseif ($upload_file_status == "NO_FILE_TO_UPLOAD") {
					$image = '';
					$image_name = '';
					$image_type = '';
				}
				else {
					die ($upload_file_status);
				}
			}
			else {
				$image = '';
				$image_name = '';
				$image_type = '';
			}
		}
	
		$bool_form_okay = true;
		if (strlen($form_title) == 0 || strlen($post_type) == 0 || (strlen($form_price) == 0 && $post_type == 'Item'))
			$bool_form_okay = false;
		if (strlen($form_title) > 100 )
			$bool_form_okay = false;
	 
		if (strlen($form_price) > 0) {
			$regex_price = '/(^\d{0,5}$)|(^\d{0,5}\.\d{2}$)/';
			$preg_price = preg_match( $regex_price, $form_price);
			if( $preg_price == 0 ){
				$bool_form_okay = false; 
			}
		}
		if( $bool_form_okay == false )
			echo 'Enter Valid Data<br />';
		
		$seller_user_id = $_SESSION['user']['user_id'];
		if ($bool_form_okay) {
			if ($post_type == 'item') {
				$item = new Item();
				$item->setAttributes($form_title, $form_description, $form_price, $seller_user_id, $post_category, $image_name, $image, $image_type);
				$item->insert($ch);
				$post_id = $item->getID();			
			}
			else{
				$service = new Service();
				$service->setAttributes($form_title, $form_description, $form_price, $seller_user_id, $post_category);
				$service->insert($ch);
				$post_id = $service->getID();
			}
			$open_post_url = 'location:view_post.php?action=view&search_type=' . $post_type . '&id=' . $post_id;
			header($open_post_url);
		} 
	}
 }

if (!empty($_GET)) {   	
	switch ($_GET['action']) {
	case "show_category":
		$post_type = $_GET['post_type'];
	}
}

?>
	
 <form name="post" method="post" action="post_item.php" enctype="multipart/form-data">
 	<?php
 	if ($post_type == 'item') {
 	?>
		<table border=0 width=100% cellspacing=7 cellpadding=0>
		<tr>
		<td width=10% align=right valign=top font-size=13px>Posting Type: </td>
		<td width=40% align=left font-size=13px>
		<input type="radio" name="post_type" value="item" checked="checked" onclick="location.href='post_item.php?action=show_category&post_type=item'"> Item for Sale<br>
 		<input type="radio" name="post_type" value="service" onclick="location.href='post_item.php?action=show_category&post_type=service'"> Service<br>
		</td>
		</tr>
		<tr>
		<td width=10% align=right valign=top font-size=13px>Item Category: </td>
		<td width=40% align=left font-size=13px>
		<input type="radio" name="post_category" value="Books"> Books<br>
 		<input type="radio" name="post_category" value="Cellphones"> Cellphones<br>
 		<input type="radio" name="post_category" value="Electronics"> Electronics<br>
 		<input type="radio" name="post_category" value="Software"> Software<br>
 		<input type="radio" name="post_category" value="Others"> Others<br>
		</td>
		</tr>
		<tr>
		<td width=10% align=right font-size=13px>Title: </td><td width=40% align=left font-size=13px><input type="text" name="title"><span id="title_error" style="color:red"></span></td>
		</tr>
		<tr>
		<td width=10% align=right valign=top font-size=13px>Description: </td><td width=40% align=left font-size=13px><textarea name="description"></textarea><span id="description_error" style="color:red"></span></td>
		</tr>
		<tr>	
		<td width=10% align=right valign=top font-size=13px>Price: </td><td width=40% align=left font-size=13px><input type="text" name="price" value=""><span id="price_error" style="color:red"></span><br><span style="font-size: 0.8em">(enter in US Dollars)</span></td>
		</tr>
		<tr>
		<td width=10% align=right font-size=13px>Add Image: </td><td width=40% align=left font-size=13px><input type="file" name="image"></td>
		</tr>
		<tr>
		<td width=10% align=right font-size=13px></td><td width=40% align=left font-size=13px><input type="button" name="post_item" value="Post" onclick="validatePostForm()"></td>
		</table>
		
 	<?php
 	}
 	else {
 	?>		
		<table border=0 width=100% cellspacing=7 cellpadding=0>
		<tr>
		<td width=10% align=right valign=top font-size=13px>Posting Type: </td>
		<td width=40% align=left font-size=13px>
		<input type="radio" name="post_type" value="item" onclick="location.href='post_item.php?action=show_category&post_type=item'"> Item for Sale<br>
 		<input type="radio" name="post_type" value="service" checked="checked" onclick="location.href='post_item.php?action=show_category&post_type=service'"> Service<br>
		</td>
		</tr>
		<tr>
		<td width=10% align=right valign=top font-size=13px>Item Category: </td>
		<td width=40% align=left font-size=13px>
		<input type="radio" name="post_category" value="Carpool"> Carpool<br>
 		<input type="radio" name="post_category" value="Tutoring"> Tutoring<br>
 		<input type="radio" name="post_category" value="Shopping"> Shopping<br>
 		<input type="radio" name="post_category" value="Others"> Others<br>
		</td>
		</tr>
		<tr>
		<td width=10% align=right font-size=13px>Title: </td><td width=40% align=left font-size=13px><input type="text" name="title"><span id="title_error" style="color:red"></span></td>
		</tr>
		<tr>
		<td width=10% align=right valign=top font-size=13px>Description: </td><td width=40% align=left font-size=13px><textarea name="description"></textarea><span id="description_error" style="color:red"></span></td>
		</tr>
		<tr>	
		<td width=10% align=right valign=top font-size=13px>Price: </td><td width=40% align=left font-size=13px><input type="text" name="price" value=""><span style="font-size: 0.8em">(optional)</span><span id="price_error" style="color:red"></span><br><span style="font-size: 0.8em">(enter in US Dollars)</span></td>
		</tr>
		<tr>
		<td width=10% align=right font-size=13px></td><td width=40% align=left font-size=13px><input type="button" name="post_item" value="Post" onclick="validatePostForm()"></td>
		</table>
 	<?php 
 	}
 	?>
 </form>

<?php include_once 'footer.php'; ?>