<?php
    session_start(); //to make session available in this page
    unset($_SESSION['customer_id']); //to avoid different user accessing pages that are not ment for them
    
    include_once '../class/admin.class.php'; //admin class

    if($page_title !== 'Login'){
        //check if all required session has set, if not then redirect to logout
        if(!isset($_SESSION['admin_id']) || !isset($_SESSION['user_id']) || !isset($_SESSION['user_type'])){
            if($_SESSION['user_type'] !== 'admin'){ //if user is not an admin, redirect to customer login
                header('location: ../customer/logout.php?error_message="Please login"');
            }
    
            header('location: logout.php?error_message="Please login"');
        }
    
        $admin = new Admin; //creates class
        $admin = $admin->getInfo($_SESSION['admin_id']); //retrieve admin informations in database
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        <?= $page_title ?>
    </title>

    <link rel="stylesheet" href="../style/main.css">
</head>

<body>
    <div class="container">