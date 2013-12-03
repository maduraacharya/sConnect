<?php
session_start();
?>
<html>
<script type="text/javascript">eraseCookie("sConnectProfileToggleStatus")</script>
</html>
<?php
unset($_SESSION['user']);
header('location:login.php');
?>
