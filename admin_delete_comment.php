<?php 
include_once 'header.php';
include_once 'Item.php';
include_once 'Service.php';
?>

<?php
is_valid_session();
is_admin_user();
?>

<?php
if (!empty($_GET)) {   
	extract($_GET);

	if ($post_type == "item") {
		$query = "DELETE FROM sconnect_item_bid WHERE id = $comment_id";
		$result = mysqli_query($ch, $query) or die("QUERY ERROR:" . mysqli_error($ch));
	}
	elseif ($post_type == "service") {
		$query = "DELETE FROM sconnect_service_comment WHERE id = $comment_id";
		$result = mysqli_query($ch, $query) or die("QUERY ERROR:" . mysqli_error($ch));
	}
	$return_url = "view_post.php?action=view&search_type=" . $post_type . "&id=" . $post_id;
	header("location:" . $return_url);
}
 
?>

<?php include_once 'footer.php'; ?>