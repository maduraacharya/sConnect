<?php include_once 'header.php'; ?>

<?php
is_valid_session();
?>

<h2>Manage Profile</h2>
<br>
<form method="post" action="">
<table border=0 width=50% cellspacing=7 cellpadding=0> 
<tr>
<td width=40% align=right font-size=13px><a href="edit_profile.php?action=update&user_id=<?= $_SESSION['user']['user_id']; ?>">Edit profile</a></td>
</tr>
<tr>
<td width=40% align=right font-size=13px><a href="change_password.php">Change Password</a></td>
</tr>
<tr>
<td width=40% align=right font-size=13px><a href="delete_account.php?&user_id=<?= $_SESSION['user']['user_id']; ?>">Delete Account</a></td>
</tr>
<tr>
<td width=40% align=right font-size=13px><a href="logout.php">Log Out</a></td>
</tr>
</table>
</form>

<?php include_once 'footer.php'; ?>
