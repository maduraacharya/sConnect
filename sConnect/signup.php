<?php
?>

<!DOCTYPE html>
<html>
<head>
<title>sConnect Sign up</title>
</head>

<body>

<?php

// process the form
if( isset($_POST['signup'] )) {

	$bool_form_is_ok = true;
	$bool_no_blank_values = true;
	$bool_contact_phone_is_ok = true;
	$bool_contact_email_is_ok = true;
	$bool_email_is_available = true;
	
	echo 'Form was submitted <br />';
	
	// check for blank fields
	
	foreach( $_POST as $key => $value){
		if( strlen(trim($value)) == 0) {
			// echo $key . ' is blank <br />';
			$bool_no_blank_values = false;
			break;
		}
	}
	
	if( $bool_no_blank_values == false) {
		echo 'Please make sure you have filled in all fields.<br />';
	}
	
	// check if phone number and email are ok
	
	$regex_phone = '/^\d{10,12}$/';
	$preg_phone = preg_match( $regex_phone, $_POST['contact_phone']);
	if( $preg_phone == 0 ){
		$bool_contact_phone_is_ok = false;
		echo 'Please check that phone number has been entered correctly.<br />';
	}
	
	$regex_email = '/^\w+@\w+.\w{3}$/';
	$preg_email = preg_match( $regex_email, $_POST['contact_email']);
	if( $preg_email == 0 ){
		$bool_contact_email_is_ok = false;
		echo 'Please check that email has been entered correctly.<br />';
	}
	
	// check if email already exists in db
	
	require 'connectvars.php';
	
		// connect to db
	$con = mysqli_connect( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	if(mysqli_connect_errno($con)) {
		echo "failed to connect to mysql";
	}
	
	$query = "SELECT USER_ID FROM SCONNECT_USER WHERE CONTACT_EMAIL = '". $_POST['contact_email'] ."'";
	$data = mysqli_query($con, $query);
	
	if (mysqli_num_rows($data) >= 1) {
		echo 'Email has already been taken <br />';
		$bool_email_is_available = false;
	}
	else
		echo 'Email is available <br />';
	
	// set $bool_form_is_ok to false if false
	if( $bool_no_blank_values == false || $bool_contact_phone_is_ok == false || $bool_contact_email_is_ok == false ||
		$bool_email_is_available == false){
			$bool_form_is_ok = false;
			echo 'Form is not okay <br />';
	}
	
	
	// add the user to user table if form is okay
	if( $bool_form_is_ok) {
		
		// insert form values into db
		$query = "INSERT INTO SCONNECT_USER (FIRST_NAME, LAST_NAME, STUDENT_ID, LOGIN_PWD, CONTACT_EMAIL,
			CONTACT_PHONE) VALUES( '$_POST[first_name]', '$_POST[last_name]', '$_POST[student_id]', 
			'$_POST[login_pwd]', '$_POST[contact_email]', '$_POST[contact_phone]')";  
		
		if (!mysqli_query($con,$query)) { die('Error: ' . mysqli_error($con)); }
		
		// confirm insert
		echo "1 record added <br />";
	
	}
	
	mysqli_close($con);
	
	
}  // end: if( isset($_POST['signup'] ))

?>

    <br><br><br>
    <p align="center"><b>sConnect Registration</b></p>
    
    <table width=740 align="center" cellpadding=10 cellspacing=0 border=1>
	<tr><td colspan=2 align="center"><b>Create your free account</b></td></tr>
    <tr>
    <td align="left"><img src="Logo.png" alt="Logo" height="320" width="300"></td>
    <td> 
	<form method="post" action="signup.php" >
	&nbsp; &nbsp; &nbsp;First Name &nbsp; &nbsp; &nbsp;<input type="text" name="first_name" size=50><font color="#FF0000"><sup>*</sup></font>
    <br><br> &nbsp; &nbsp; &nbsp;Last Name  &nbsp; &nbsp; &nbsp;<input type="text" name="last_name" size=50>
    <br><br> &nbsp; &nbsp; &nbsp;Student ID &nbsp; &nbsp; &nbsp;<input type="text" name="student_id" size=50><font color="#FF0000"><sup>*</sup></font>
    <br><br> &nbsp; &nbsp; &nbsp;User name &nbsp; &nbsp; &nbsp;<input type="text" name="username" size=50><font color="#FF0000"><sup>*</sup></font>
    <br><br> &nbsp; &nbsp; &nbsp;Password &nbsp; &nbsp; &nbsp; &nbsp;<input type="text" name="login_pwd" size=50><font color="#FF0000"><sup>*</sup></font>
    <br><br> &nbsp; &nbsp; &nbsp;Email &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<input type="text" name="contact_email" size=50><font color="#FF0000"><sup>*</sup></font>
    <br><br> &nbsp; &nbsp; &nbsp;Phone no &nbsp; &nbsp; &nbsp; &nbsp;<input type="text" name="contact_phone" size=50>
	
	</td>
    </tr>
    <tr>
    <td height=10></td>
  <td  height=10> <p align="center"><input type="submit" name="signup" value="signup"></p></td></tr>
    </form>
	</table>
   
  
</body>
</html>