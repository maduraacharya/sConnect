<?php 
include_once 'header.php';
include_once 'Item.php';
include_once 'Service.php';
?>

<?php
is_valid_session();
?>

<?php
if (!empty($_POST)) { 
	if (empty($errors)) {
		extract($_POST); 
		if (isset($_POST['btnPlaceBid'])) {
			$buyer_user_id = $_SESSION['user']['user_id'];
			$comments = mysqli_real_escape_string($ch, trim($comments));
			$q = "INSERT INTO sconnect_item_bid (item_id, buyer_user_id, bid_amount, message_to_seller) VALUES ($id, $buyer_user_id, $bidprice, '$comments')";
			$result = mysqli_query($ch, $q) or die("QUERY ERROR:" . mysqli_error($ch));
		} 
		elseif (isset($_POST['btnSubmit'])) {
			$buyer_user_id = $_SESSION['user']['user_id'];
			$comments = mysqli_real_escape_string($ch, trim($comments));
			$q = "INSERT INTO sconnect_service_comment (service_id, buyer_user_id, comment) VALUES ($id, $buyer_user_id, '$comments')";
			$result = mysqli_query($ch, $q) or die("QUERY ERROR:" . mysqli_error($ch));
		}
		elseif (isset($_POST['btnUpdateItem'])) {
			$title = mysqli_real_escape_string($ch, trim($title));
			$description = mysqli_real_escape_string($ch, trim($description));
			if (!empty($_FILES)) {
				$upload_file_status = validate_image($_FILES);
				if ($upload_file_status == "SUCCESS") {
					$image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
					$image_name = addslashes($_FILES['image']['name']);
					$image_type = $_FILES['image']['type'];
					$image_name = mysqli_real_escape_string($ch, trim($image_name));
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
			$item = new Item();
			$item->fetch($ch, $id);
			$category = $item->getCategory();
			$seller_user_id = $item->getSellerUserID();
			$item->setAttributes($title, $description, $price, $seller_user_id, $category, $image_name, $image, $image_type);
			$item->update($ch);
		}
		elseif (isset($_POST['btnDeleteItem'])) {
			$item = new Item();
			$item->setID($id);
			$item->delete($ch);
		}
		elseif (isset($_POST['btnUpdateService'])) {
			$title = mysqli_real_escape_string($ch, trim($title));
			$description = mysqli_real_escape_string($ch, trim($description));
			$service = new Service();
			$service->fetch($ch, $id);
			$category = $service->getCategory();
			$seller_user_id = $service->getSellerUserID();
			$service->setAttributes($title, $description, $price, $seller_user_id, $category);
			$service->update($ch);
		}
		elseif (isset($_POST['btnDeleteService'])) {
			$service = new Service();
			$service->setID($id);
			$service->delete($ch);
		}
	}
}

if (!empty($_GET)) {   
	$id = $_GET['id'];
	$search_type = $_GET['search_type'];

	if ($search_type == "item") {
		switch ($_GET['action']) {
		case "view":
			show_item($ch, $id);
		}
	}
	else {
		switch ($_GET['action']) {
		case "view":
			show_service($ch, $id);
		}
	}
}
 
?>

<?php include_once 'footer.php'; ?>