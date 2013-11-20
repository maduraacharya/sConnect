<?php

    // Start the session
    session_start();
    
    if( isset( $_POST['admin_login'])) {
        
        // process form
        require('connectvars.php');
        
        // connect to database
        $db_connection = mysqli_connect( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if(mysqli_connect_errno($db_connection)) {
            echo "failed to connect to mysql, please try again later";
        }
        
        // get data from admin login form
        $form_admin_first_name = trim($_POST["admin_name"]);
        $form_admin_password = mysqli_real_escape_string($db_connection, trim($_POST["login_pwd"]));
        
        // query user table with the admin name and password entered
        $query_admin_validation = "SELECT * FROM SCONNECT_USER WHERE FIRST_NAME = '". $form_admin_first_name . "' AND LOGIN_PWD = '" .
        $form_admin_password . "'";
        $data = mysqli_query($db_connection, $query_admin_validation)
		or die('Error querying database.');
	    
        // process query
        if (mysqli_num_rows($data) == 1) {
            
            // set session variables
            $row = mysqli_fetch_array($data);
            $_SESSION['admin'] = $row; // ['USER_ID'];
            
			header('Location: admin_homepage.php');
            // header('Location: http://localhost:8888/sConnect/sConnect/admin_homepage.php');
            exit();
        }
        else {
            echo 'Login failed. Admin name or password does not exist.<br />';
        }
    }
    ?>


<!DOCTYPE html>
<html>
<head>
<style>
.error {color: #FF0000;}

body{
	
}

.admin_login_content {

	background-color:white;

	border-style:solid;
	border-width:1px;
	
	width:50%;
	margin-left:auto;
	margin-right:auto;
	margin-top: 100px;
	
	padding-bottom:20px;

}

</style>
<title>sConnect Admin Login</title>
</head>
    <body>
    
    <?php
    // define variables
    $name = $nameErr = $pwd = $pwdErr = "";
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if (empty($_POST["admin_name"]))
        {$nameErr = "Name is required";}
        else
        {$name = trim($_POST["admin_name"]);}
        
        if (empty($_POST["login_pwd"]))
        {$pwdErr = "password is required";}
        else
        {$pwd = trim($_POST["login_pwd"]);}
    }
    //TODO: NEED TO ADJUST THE SPACING BETWEEN HTML belows
    ?>
    
	<div class="admin_login_content">
    <h2 align="center"> Administrator login </h2>
        <div align="center">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" > <br><br>
                First name: &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <input type="text" name="admin_name" size=50>
                    <span class="error">* <?php echo $nameErr;?></span> <br><br>
                Password: &nbsp; &nbsp; &nbsp; &nbsp; <input type="password" name="login_pwd" size=50>
                    <span class="error">* <?php echo $pwdErr;?></span> <br><br><br>
                <input type="submit" name="admin_login" value="Log In">
            </form>
    
        <div id="bottom content">
            <?php // <a href="forgot_password_admin.php">Forgot Password</a></br> ?>
        </div>
		</div>
	</div>
	
    </body>
    </html>