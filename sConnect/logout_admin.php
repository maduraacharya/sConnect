<?php
    session_start();
    if(isset($_SESSION['admin'])) {
        unset($_SESSION['admin']);
        header('Location: http://localhost:8888/sConnect/sConnect/login_admin.php');
        exit();
    }
    ?>

