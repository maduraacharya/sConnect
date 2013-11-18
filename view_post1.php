<?php include 'header.php'; ?>

<?php
if (!empty($_POST)) { //check that form was submitted
	if (empty($errors)) {
		extract($_POST);
		if (isset($_POST['btnPlaceBid'])){
			$buyer_user_id = $_SESSION['user']['USER_ID'];
			$q = "INSERT INTO sconnect_item_bid (item_id, buyer_user_id, bid_amount, message_to_seller) VALUES ($id, $buyer_user_id, $bidprice, '$comments')";
			$result = mysqli_query($ch, $q) or die("QUERY ERROR:" . mysqli_error($ch));
		} elseif (isset($_POST['btnSubmit'])){
			$buyer_user_id = $_SESSION['user']['USER_ID'];
			$q = "INSERT INTO sconnect_service_comment (service_id, buyer_user_id, comment) VALUES ($id, $buyer_user_id, '$comments')";
			$result = mysqli_query($ch, $q) or die("QUERY ERROR:" . mysqli_error($ch));
		}
		elseif (isset($_POST['btnUpdateItem'])){
			$q = "UPDATE sconnect_item SET title = '$title', description = '$description', price = $price WHERE id = $id";
			$result = mysqli_query($ch, $q) or die("QUERY ERROR:" . mysqli_error($ch));
		}
		elseif (isset($_POST['btnDeleteItem'])){
			$q = "DELETE FROM sconnect_item WHERE id = $id";
			$result = mysqli_query($ch, $q) or die("QUERY ERROR:" . mysqli_error($ch));
		}
		elseif (isset($_POST['btnUpdateService'])){
			$q = "UPDATE sconnect_service SET title = '$title', description = '$description' WHERE id = $id";
			$result = mysqli_query($ch, $q) or die("QUERY ERROR:" . mysqli_error($ch));
		}
		elseif (isset($_POST['btnDeleteService'])){
			$q = "DELETE FROM sconnect_service WHERE id = $id";
			$result = mysqli_query($ch, $q) or die("QUERY ERROR:" . mysqli_error($ch));
		}
	}
}

if (!empty($_GET)) {   
	$id = $_GET['id'];
	$search_type = $_GET['search_type'];

	if ($search_type == "item") {
		switch ($_GET['action']) {
		case "view":
			show_item("view" , $ch, $id);
		}
	}
	else {
		switch ($_GET['action']) {
		case "view":
			show_service("view" , $ch, $id);
		}
	}
}
 
?>

<?php include 'footer.php'; ?>
