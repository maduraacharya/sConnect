<?php

// Start the session
	session_start();
	$_SESSION['user_id'] = 2; // for testing

if( isset( $_POST['post_item'])) {

	// process form
	require('connectvars.php');
	
	// connect to db
	$con = mysqli_connect( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	if(mysqli_connect_errno($con)) {
		echo "failed to connect to mysql";
	}
	
	// get data from form
	$form_title = mysqli_real_escape_string($con, trim($_POST['title']));
    $form_price = mysqli_real_escape_string($con, trim($_POST['price']));
	$form_description = mysqli_real_escape_string($con, trim($_POST['description']));
	
	$form_item_type = '';
	if( isset( $_POST['item_type']))
		$form_item_type =$_POST['item_type'];
	
	// check that form answers are valid
	$bool_form_okay = true;
		
	if( strlen($form_title) == 0 || strlen($form_item_type) == 0 || (strlen($form_price) == 0 && $form_item_type == 'item'))
		$bool_form_okay = false;
	
	if( strlen($form_title) > 100 )
		$bool_form_okay = false;
	
	$regex_price = '/(^\d{0,3}$)|(^\d{0,3}\.\d{2}$)/';
	$preg_price = preg_match( $regex_price, $form_price);
	if( $preg_price == 0 ){
		$bool_form_okay = false;
		//echo 'you are a bad price!<br>';
	}
	
	
	if( $bool_form_okay == false )
		echo 'I am a liar!<br />';
	
	// if form is valid, enter data into db
	if( $bool_form_okay){
	
		if( $form_item_type == 'item'){
		$query = "INSERT INTO SCONNECT_ITEM (DATE_POSTED, DATE_SOLD, TITLE, DESCRIPTION, PRICE, SELLER_USER_ID, BUYER_USER_ID)
					VALUES( NOW(), NULL, '$form_title', '$form_description', '$form_price', '$_SESSION[user_id]', NULL)"; 	
		}
		else{
		$query = "INSERT INTO SCONNECT_SERVICE (DATE_POSTED, TITLE, DESCRIPTION, SELLER_USER_ID)
					VALUES( NOW(), '$form_title', '$form_description', '$_SESSION[user_id]')"; 	
		}
		
		$data = mysqli_query($con, $query)
			or die('Error querying database.');
			
		echo 'Item added<br>';	
	
	} // end: if( $bool_form_okay) 
	
	
}
	
?>


<!DOCTYPE html>
<html>
<head>
<title>sConnect</title>
</head>
<body>

<br><br><br>
    <p align="center"><b>Post an Item/ Service</b></p>
    	
	<div style="width:500px; margin:0px auto 100px;">
	<form method="post" action="post_item.php" >
    <br>Title : &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="title" size=50>
    <br><br>Price : &nbsp;$&nbsp;<input type="text" name="price" size=50>
	<br><span style="font-size: 0.8em">(may leave blank for services)</span>
	<br><br>Description :
	<br><textarea name="description" cols=50 rows=8></textarea>
	<br><br>This is an : &nbsp; &nbsp; &nbsp; &nbsp;
	<input type="radio" name="item_type" value="item">&nbsp item
	&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; <input type="radio" name="item_type" value="service">&nbsp service
	<br><br /><br><input type="submit" name="post_item" value="Post">
	</form>
	</div>
	

</body>
</html>