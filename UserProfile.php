<?php

class UserProfile
{
    // property declarations
    private $user_id; // unique identifier
    private $first_name; // student first name
    private $last_name; // student last name
    private $student_id; // also login username
    private $login_pwd; // login password
    private $contact_email; // student's contact email
    private $contact_phone; // student's contact phone
    private $date_created; // when student registered
    private $date_modified; // record last modified

    // method declarations
	public function setAttributes($first_name, $last_name, $student_id, $login_pwd, $contact_email, $contact_phone) {
		$this->first_name = $first_name;
		$this->last_name = $last_name;
		$this->student_id = $student_id;
		$this->login_pwd = $login_pwd;
		$this->contact_email = $contact_email;
		$this->contact_phone = $contact_phone;
	}
	
	public function setUserID($user_id) {
		$this->user_id = $user_id;
	}
	
	public function setFirstName($first_name) {
		$this->first_name = $first_name;
	}
	
	public function setLastName($last_name) {
		$this->last_name = $last_name;
	}
	
	public function setStudentID($student_id) {
		$this->student_id = $student_id;
	}
	
	public function setLoginPassword($login_pwd) {
		$this->login_pwd = $login_pwd;
	}
	
	public function setContactEmail($contact_email) {
		$this->contact_email = $contact_email;
	}
	
	public function setContactPhone($contact_phone) {
		$this->contact_phone = $contact_phone;
	}
	
	public function getUserID() {
		return $this->user_id;
	}
	
	public function getFirstName() {
		return $this->first_name;
	}
	
	public function getLastName() {
		return $this->last_name;
	}
	
	public function getStudentID() {
		return $this->student_id;
	}
	
	public function getLoginPassword() {
		return $this->login_pwd;
	}
	
	public function getContactEmail() {
		return $this->contact_email;
	}
	
	public function getContactPhone() {
		return $this->contact_phone;
	}
	
	public function fetchAsArray($ch, $user_id) {
		$query = "SELECT user_id, first_name, last_name, student_id, login_pwd, contact_email, contact_phone
					FROM sconnect_user WHERE user_id = $user_id";
		$result = mysqli_query($ch, $query) or die("Query Error:" . mysqli_error($ch));
		if (mysqli_num_rows($result) > 0) { 
			$row = mysqli_fetch_assoc($result);
		}
		else {
			die("Error in fetching user profile: User does not exist");
		}
		return $row;
	}
	
	public function fetch($ch, $user_id) {
		$row = $this->fetchAsArray($ch, $user_id);
		$_SESSION['user'] = $row;
		extract($row);
		$this->setUserID($user_id);
		$this->setFirstName($first_name);
		$this->setLastName($last_name);
		$this->setStudentID($student_id);
		$this->setLoginPassword($login_pwd);
		$this->setContactEmail($contact_email);
		$this->setContactPhone($contact_phone);
	}
	
	public function insert($ch) {
		$query = "INSERT INTO sconnect_user (first_name, last_name, student_id, login_pwd, contact_email, contact_phone) 
				  VALUES ('$this->first_name', '$this->last_name', '$this->student_id', '$this->login_pwd', '$this->contact_email', '$this->contact_phone')";
		if (!mysqli_query($ch, $query)) {
			die("Query Error:" . mysqli_error($ch));
			
		}
	}
	
	public function update($ch) {
		$query = "UPDATE sconnect_user SET  
					first_name = '$this->first_name',
					last_name = '$this->last_name',
					student_id = '$this->student_id',
					login_pwd = '$this->login_pwd',
					contact_email = '$this->contact_email',
					contact_phone = '$this->contact_phone'
				  WHERE user_id = $this->user_id";
					
		if (!mysqli_query($ch, $query)) {
			die("Query Error:" . mysqli_error($ch));	
		}
	}
	
	public function delete($ch) {
		$q = "DELETE FROM sconnect_user WHERE USER_ID = $this->user_id";
		if (!mysqli_query($ch, $q)) {
			die("Query Error:" . mysqli_error($ch));
		}
	}
	
	public function login($ch) {
		$query = "SELECT user_id, first_name, last_name, student_id, login_pwd, contact_email, contact_phone
					FROM sconnect_user WHERE student_id = '$this->student_id' AND login_pwd = '$this->login_pwd'";
		$result = mysqli_query($ch, $query) or die("QUERY ERROR:" . mysqli_error($ch));
		if (mysqli_num_rows($result) > 0) { 
			$row = mysqli_fetch_assoc($result);
			$_SESSION['user'] = $row;
			$this->setUserID($row['user_id']);
			$this->setFirstName($row['first_name']);
			$this->setLastName($row['last_name']);
			$this->setContactEmail($row['contact_email']);
			$this->setContactPhone($row['contact_phone']);
			header('location:index.php');
		}
		else {
			die("Login Error: Incorrect username or password");
		}
	}
	
}
?>
