<?php include_once 'header.php'; ?>
<?php
    if( isset( $_POST['admin_login'])) {
      	$form_admin_first_name = trim($_POST["student_id"]);
        $form_admin_password = mysqli_real_escape_string($ch, trim($_POST["login_pwd"]));

        $query_admin_validation = "SELECT USER_ID FROM SCONNECT_USER WHERE student_id = '". $form_admin_first_name . "' AND LOGIN_PWD = '" .
        $form_admin_password . "'";
        $data = mysqli_query($ch, $query_admin_validation)
                or die('Error querying database.');
            
       
        if (mysqli_num_rows($data) == 1) {
            
           
            $row = mysqli_fetch_array($data);
            $_SESSION['admin'] = $row['student_id'];
            
            header('Location:admin_login.php');
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
    </style>
    
    <title>sConnect Admin Login</title>
    
    </head>
    <body>
    
    <?php
    $name = $nameErr = $pwd = $pwdErr = "";
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if (empty($_POST["student_id"]))
        {$nameErr = "Name is required";}
        else
        {$name = trim($_POST["student_id"]);}
        
        if (empty($_POST["login_pwd"]))
        {$pwdErr = "password is required";}
        else
        {$pwd = trim($_POST["login_pwd"]);}
    }
  
    ?>
    
    <h2> Administrator login </h2>
        <div align="center">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" > <br><br>
                Username: &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <input type="text" name="student_id" size=50>  
                    <span class="error">*<?php echo $nameErr;?></span> <br><br>
                Password: &nbsp; &nbsp; &nbsp; &nbsp; <input type="password" name="login_pwd" size=50>
                    <span class="error">* <?php echo $pwdErr;?></span> <br><br>
                <input type="submit" name="admin_login" value="Log In">
            </form>
    
        <div id="bottom content">
            <a href="forgot_password_admin.php">Forgot Password</a></br>
        </div>
    
    </div>
    </body>
    </html>
    
    <?php include_once 'footer.php'; ?>