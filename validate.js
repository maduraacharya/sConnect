
function PopupCenter(pageURL, title,w,h) {
	var left = (screen.width/2)-(w/2);
	var top = (screen.height/2)-(h/2);
	var targetWin = window.open (pageURL, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
}

function newPopup(url) {
	popupWindow = window.open(url,'popUpWindow','height=350,width=500,left=10,top=10,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no,status=yes');
}

function validateLoginForm()
{
	var validationStatus = true;
	var userName = document.forms["login"]["username"].value;
	var password = document.forms["login"]["password"].value;
	
	if (userName == null || userName == "") {
		document.getElementById("username_error").innerHTML = 'Username is required';
		validationStatus = false;
	}
	else {
		document.getElementById("username_error").innerHTML = '';
	}
	
	if (password == null || password == "") {
		document.getElementById("password_error").innerHTML = 'Password is required';
		validationStatus = false;
	}
	else {
		document.getElementById("password_error").innerHTML = '';
	}
	
	if (validationStatus == true) {
		document.forms["login"].submit();
	}
	
	return validationStatus;
}

function validateRegisterForm()
{
	var validationStatus = true;
	var firstName = document.forms["register"]["firstname"].value;
	var lastName = document.forms["register"]["lastname"].value;
	var userName = document.forms["register"]["username"].value;
	var password = document.forms["register"]["password"].value;
	var confirmPassword = document.forms["register"]["confirm_password"].value;
	var contactEmail = document.forms["register"]["email"].value;
	
	if (firstName == null || firstName == "") {
		document.getElementById("firstname_error").innerHTML = 'First name is required';
		validationStatus = false;
	}
	else {
		document.getElementById("firstname_error").innerHTML = '';
	}
	
	if (lastName == null || lastName == "") {
		document.getElementById("lastname_error").innerHTML = 'Last name is required';
		validationStatus = false;
	}
	else {
		document.getElementById("lastname_error").innerHTML = '';
	}
	
	if (userName == null || userName == "") {
		document.getElementById("username_error").innerHTML = 'Username is required';
		validationStatus = false;
	}
	else {
		document.getElementById("username_error").innerHTML = '';
	}
	
	if (password == null || password == "") {
		document.getElementById("password_error").innerHTML = 'Password is required';
		validationStatus = false;
	}
	else {
		document.getElementById("password_error").innerHTML = '';
	}
	
	if (confirmPassword == null || confirmPassword == "") {
		document.getElementById("confirm_password_error").innerHTML = 'Confirm password is required';
		validationStatus = false;
	}
	else {
		if (password.length > 0 && confirmPassword.length > 0) {
			if (password != confirmPassword) {
				document.getElementById("confirm_password_error").innerHTML = 'Password does not match';
				validationStatus = false;
			}
			else {
				document.getElementById("confirm_password_error").innerHTML = '';
			}
		}
		else {
			document.getElementById("confirm_password_error").innerHTML = '';
		}
	}
	
	if (contactEmail == null || contactEmail == "") {
		document.getElementById("email_error").innerHTML = 'Contact email is required';
		validationStatus = false;
	}
	else {
	
		var atPos = contactEmail.indexOf("@");
		var dotPos = contactEmail.lastIndexOf(".");
		if (atPos < 1 || dotPos < atPos + 2 || dotPos + 2 >= contactEmail.length) {
				document.getElementById("email_error").innerHTML = 'Not a valid email address';
				validationStatus = false;
		}
		else {
			document.getElementById("email_error").innerHTML = '';
		}
		
	}
	
	if (validationStatus == true) {
		document.forms["register"].submit();
	}
	return validationStatus;
}


function validateForgotPasswordForm()
{
	var validationStatus = true;
	var contactEmail = document.forms["forgot_password"]["email"].value;
	
	if (contactEmail == null || contactEmail == "") {
		document.getElementById("email_error").innerHTML = 'Contact email is required';
		validationStatus = false;
	}
	else {
		var atPos = contactEmail.indexOf("@");
		var dotPos = contactEmail.lastIndexOf(".");
		if (atPos < 1 || dotPos < atPos + 2 || dotPos + 2 >= contactEmail.length) {
				document.getElementById("email_error").innerHTML = 'Not a valid email address';
				validationStatus = false;
		}
		else {
			document.getElementById("email_error").innerHTML = '';
		}
	}
	
	if (validationStatus == true) {
		document.forms["forgot_password"].submit();
	}
	return validationStatus;
}


function validateChangePasswordForm()
{
	var validationStatus = true;
	var userName = document.forms["change_password"]["username"].value;
	var oldPassword = document.forms["change_password"]["old_password"].value;
	var password = document.forms["change_password"]["password"].value;
	var confirmPassword = document.forms["change_password"]["confirm_password"].value;
	
	if (userName == null || userName == "") {
		document.getElementById("username_error").innerHTML = 'Username is required';
		validationStatus = false;
	}
	else {
		document.getElementById("username_error").innerHTML = '';
	}
	
	if (oldPassword == null || oldPassword == "") {
		document.getElementById("old_password_error").innerHTML = 'Password is required';
		validationStatus = false;
	}
	else {
		document.getElementById("old_password_error").innerHTML = '';
	}
	
	if (password == null || password == "") {
		document.getElementById("password_error").innerHTML = 'New password is required';
		validationStatus = false;
	}
	else {
		document.getElementById("password_error").innerHTML = '';
	}
	
	if (confirmPassword == null || confirmPassword == "") {
		document.getElementById("confirm_password_error").innerHTML = 'Confirm password is required';
		validationStatus = false;
	}
	else {
		if (password.length > 0 && confirmPassword.length > 0) {
			if (password != confirmPassword) {
				document.getElementById("confirm_password_error").innerHTML = 'Password does not match';
				validationStatus = false;
			}
			else {
				document.getElementById("confirm_password_error").innerHTML = '';
			}
		}
		else {
			document.getElementById("confirm_password_error").innerHTML = '';
		}
	}
	
	if (validationStatus == true) {
		document.forms["change_password"].submit();
	}
	return validationStatus;
}

function validateEditProfileForm()
{
	var validationStatus = true;
	var firstName = document.forms["edit_profile"]["firstname"].value;
	var lastName = document.forms["edit_profile"]["lastname"].value;
	var userName = document.forms["edit_profile"]["username"].value;
	var contactEmail = document.forms["edit_profile"]["email"].value;
	
	if (firstName == null || firstName == "") {
		document.getElementById("firstname_error").innerHTML = 'First name is required';
		validationStatus = false;
	}
	else {
		document.getElementById("firstname_error").innerHTML = '';
	}
	
	if (lastName == null || lastName == "") {
		document.getElementById("lastname_error").innerHTML = 'Last name is required';
		validationStatus = false;
	}
	else {
		document.getElementById("lastname_error").innerHTML = '';
	}
	
	if (userName == null || userName == "") {
		document.getElementById("username_error").innerHTML = 'Username is required';
		validationStatus = false;
	}
	else {
		document.getElementById("username_error").innerHTML = '';
	}
	
	if (contactEmail == null || contactEmail == "") {
		document.getElementById("email_error").innerHTML = 'Contact email is required';
		validationStatus = false;
	}
	else {
	
		var atPos = contactEmail.indexOf("@");
		var dotPos = contactEmail.lastIndexOf(".");
		if (atPos < 1 || dotPos < atPos + 2 || dotPos + 2 >= contactEmail.length) {
				document.getElementById("email_error").innerHTML = 'Not a valid email address';
				validationStatus = false;
		}
		else {
			document.getElementById("email_error").innerHTML = '';
		}
		
	}
	
	if (validationStatus == true) {
		document.forms["edit_profile"].submit();
	}
	return validationStatus;
}




function validatePostForm()
{
	var validationStatus = true;
	var title = document.forms["post"]["title"].value;
	var description = document.forms["post"]["description"].value;
	var price = document.forms["post"]["price"].value;
	
	var postTypes = document.getElementsByName('post_type');

	for (var i = 0, length = postTypes.length; i < length; i++) {
		if (postTypes[i].checked) {
			postType = postTypes[i].value;
			break;
		}
	}
	
	if (title == null || title == "") {
		document.getElementById("title_error").innerHTML = 'Title is required';
		validationStatus = false;
	}
	else {
		document.getElementById("title_error").innerHTML = '';
	}
	
	if (description == null || description == "") {
		document.getElementById("description_error").innerHTML = 'Description is required';
		validationStatus = false;
	}
	else {
		document.getElementById("description_error").innerHTML = '';
	}
	
	if (price == null || price == "") {
		if (postType == "item") {
			document.getElementById("price_error").innerHTML = 'Price is required';
			validationStatus = false;
		}
		else {
			document.getElementById("price_error").innerHTML = '';
		}
	}
	else {
		if (isNaN(price)) {
			document.getElementById("price_error").innerHTML = 'Not a valid numeric';
		}
		else {
			document.getElementById("price_error").innerHTML = '';
		}
	}
	
	if (validationStatus == true) {
		document.forms["post"].submit();
	}
	return validationStatus;
}
