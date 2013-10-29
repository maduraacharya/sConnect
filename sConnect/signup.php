<?php
?>

<!DOCTYPE html>
<html>
<head>
<title>sConnect Sign up</title>
</head>

<body>

    <br><br><br>
    <p align="center"><b>sConnect Registration</b></p>
    
    <table width=740 align="center" cellpadding=10 cellspacing=0 border=1>
	<tr><td colspan=2 align="center"><b>Create your free account</b></td></tr>
    <tr>
    <td align="left"><img src="Logo.png" alt="Logo" height="320" width="300"></td>
    <td> 
	<form method="post" action="signup_proc.php" >
	&nbsp; &nbsp; &nbsp;First Name &nbsp; &nbsp; &nbsp;<input type="text" name="first_name" size=50><font color="#FF0000"><sup>*</sup></font>
    <br><br> &nbsp; &nbsp; &nbsp;Last Name  &nbsp; &nbsp; &nbsp;<input type="text" name="last_name" size=50>
    <br><br> &nbsp; &nbsp; &nbsp;Student ID &nbsp; &nbsp; &nbsp;<input type="text" name="student_id" size=50><font color="#FF0000"><sup>*</sup></font>
    <br><br> &nbsp; &nbsp; &nbsp;User name &nbsp; &nbsp; &nbsp;<input type="text" name="username" size=50><font color="#FF0000"><sup>*</sup></font>
    <br><br> &nbsp; &nbsp; &nbsp;Password &nbsp; &nbsp; &nbsp; &nbsp;<input type="text" name="login_pwd" size=50><font color="#FF0000"><sup>*</sup></font>
    <br><br> &nbsp; &nbsp; &nbsp;Email &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<input type="text" name="contact_email" size=50><font color="#FF0000"><sup>*</sup></font>
    <br><br> &nbsp; &nbsp; &nbsp;Phone no &nbsp; &nbsp; &nbsp; &nbsp;<input type="text" name="contact_phone" size=50>
	<input type="submit" name="signup" value="signup">
	</form>
	</td>
    </tr>
    <tr>
    <td height=10></td>
  <td  height=10> <p align="center"><?php // <input type="button" name="signup" value="signup"> ?></p></td></tr>
    
	</table>
   
  
</body>
</html>