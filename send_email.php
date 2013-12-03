
<?php
session_start();
include_once 'lib.php';
$ch = dbConnect();
$errors = []; 
$errmsg_arr = array();

is_valid_session();

if (!empty($_POST)) {
	if (empty($errors)) {
		extract($_POST);
		
		$q = "SELECT * FROM sconnect_user WHERE user_id='$buyer_user_id'";
		$result = mysqli_query($ch, $q) or die("QUERY ERROR:" . mysqli_error($ch));
		if (mysqli_num_rows($result) >0) { 
			$user_record = mysqli_fetch_assoc($result);
			$email  = "brindha.sathish@gmail.com"; 
			$title   = "Offer Accepted"; 
			$message = $messagetobuyer; 
			mail($email, $title, $message); 
			echo "<p>Your message has been sent to the buyer.</p>";
		}
		
	}
	
}

if (!empty($_GET)) {
	$buyer_user_id = $_GET['buyer_user_id'];
		switch ($_GET['action']) {
			case "send":
			?>
				<form method="post" action="">
				<input type="hidden" name="buyer_user_id" value="<?= $buyer_user_id; ?>"  /> <br />
				Subject: <input type="text" name="subject" size=50>
				Message: <br /> <textarea name="messagetobuyer"></textarea> <br />
				<button type="submit" name="btnsend" value="Send">Send</button>
				</form>
			<?php
		}
}
 
?>



<?php
?>