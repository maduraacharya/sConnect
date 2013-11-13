<?php include 'header.php'; ?>

<?php
 

if(!empty($_POST)) {
	if (empty($errors)){
		if (isset($_POST['USER_ID'])) {
			updateProfile($_POST, $ch);
		} else {
			addProfile($_POST, $ch);

		}
	}
}


if (!empty($_GET)) {
	switch ($_GET['action']) {
		case "update":
			showForm("update" , $ch);
		}
}
		else {
			showForm();
		}
?>



<?= showprofile($ch); ?>  

<?php include 'footer.php'; ?>
