<?php
    session_start(); //to make session available in this page
    unset($_SESSION['admin_id']); //to avoid different user accessing pages that are not ment for them
    
    include_once '../class/customer.class.php'; //customer class

    if($page_title !== 'Login' && $page_title !== 'Sign up'){
        //check if all required session has set, if not then redirect to logout
        if(!isset($_SESSION['customer_id']) || !isset($_SESSION['user_id']) || !isset($_SESSION['user_type'])){
            if($_SESSION['user_type'] !== 'customer'){ //if user is not an customer, redirect to customer login
                header('location: ../admin/logout.php?error_message="Please login"');
            }
    
            header('location: logout.php?error_message="Please login"');
        }
    
        $customer = new Customer; //creates class
        $customer = $customer->getInfo($_SESSION['customer_id']); //retrieve customer informations in database
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