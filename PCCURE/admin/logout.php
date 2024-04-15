<?php
    session_start();

    session_destroy();

    if(isset($_GET['error_message'])){
        header('location: login.php?error_message=' . $_GET['error_message']);
    }

    header('location: login.php');
?>