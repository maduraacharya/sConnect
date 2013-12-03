<?php
session_start();
include_once 'lib.php';
include_once 'UserFavorite.php';
$ch = dbConnect();
$errors = [];

is_valid_session();

if (!empty($_GET)) {
	extract($_GET);
	$user_id = $_SESSION['user']['user_id'];
	$user_favorite = new UserFavorite();
	$user_favorite->setAttributes($user_id, $post_id, $post_type);
	$user_favorite->insert($ch);
	
	if ( $post_type == 'Item' ) {
		$return_url = 'view_post.php?action=view&search_type=item&id=' . $post_id;
	}
	else {
		$return_url = 'view_post.php?action=view&search_type=service&id=' . $post_id;
	}
	
	header("location:" . $return_url);
}

?>