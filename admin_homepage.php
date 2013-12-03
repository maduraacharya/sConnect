 <?php
 
      session_start();
if( !isset( $_SESSION['admin'] )){
  header('Location: login_admin.php');
 }

?>
  
  <!doctype html>
  <html>
 @@ -24,6 +29,9 @@
  </div>
  
  <div id="nav">
 <a href="admin_stats.php">Stats</a></br>
 <a href="logout_admin.php">Logout</a></br>
 
 <a href="admin_stats.php">Stats</a><br>
 <a href="admin_delete.php">Delete Post</a><br>
 <br>
 <a href="logout_admin.php">Logout</a><br>
  </div>