<?php
    session_start();

    if(!isset($_SESSION['logged_in'])){
        header('location: customer/start.php');
    }
    else{
        header('location: customer/home.php');
    }
?>