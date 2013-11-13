<?php include 'header.php'; ?>

<?php
if (!empty($_POST)) { //check that form was submitted
	if (empty($errors)) {
		extract($_POST);

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
