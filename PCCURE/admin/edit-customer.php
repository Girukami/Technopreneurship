<?php
    include_once '../class/customer.class.php';
    
    $customer = new Customer;
    
    if(isset($_GET['customer_id'])){
        $page_title = 'Edit user info';
        
        $customer_id = $_GET['customer_id'];
        
        if($customer->getInfo($customer_id)){
            $customer_info = $customer->getInfo($customer_id);
        }
        else{
            header('location: home.php?error_message=An error has been occured, please try again later.');
        }
    }
    else{
        header('location: home.php?error_message=An error has been occured, please try again later.');
    }

    include_once '../includes/admin/header.php';
    include_once '../includes/admin/navbar.php';

    if(isset($_POST['save_edit'])){
        $fname = htmlentities($_POST['fname']);
        $mname = htmlentities($_POST['mname']);
        $lname = htmlentities($_POST['lname']);
        $contact_num = htmlentities($_POST['contact_num']);
        $address = htmlentities($_POST['address']);
        
        if(!empty($fname) && !empty($mname) && !empty($lname) && !empty($contact_num) && !empty($address)){
            if($customer->saveEdit(ucwords($fname), ucwords($mname),  ucwords($lname), $contact_num, $address, $customer_id)){
                $success_message = 'New user info has been saved successfully.';
            }
        }
        else{
            $error_message = 'Please fill up all fields.';
        }
    }

    if(isset($success_message)){
        header('location: home.php?success_message=' . $success_message);
    }
?>

<form class="product-info edit" method="post">
    <?php
        if(isset($error_message)){
    ?>
            <div class="popups error"><p><?= $error_message ?></p><img src="../images/icons/random/close.svg" class="close"></div>
            <script src="../script/popups.js"></script>

    <?php
            unset($error_message);
        }
    ?>

    <div class="img-cont user-info">
        <img src="../images/icons/random/profile-cust-list.svg">
    </div>

    <div class="right-side">
        <div class="info">
            <div class="user-info-inputs-cont">
                <span>First name: </span>
                <input type="text" name="fname" placeholder="Enter first name" value="<?= $customer_info['first_name'] ?>">
                
                <span>Middle name: </span>
                <input type="text" name="mname" placeholder="Enter middle name" value="<?= $customer_info['middle_name'] ?>">
                
                <span>Last name: </span>
                <input type="text" name="lname" placeholder="Enter last name" value="<?= $customer_info['last_name'] ?>">
            </div>

            <div class="description user-desc-inputs-cont">
                <div>
                    <span>Contact number: </span>

                    <input type="text" name="contact_num" placeholder="Enter contact numer" value="<?= $customer_info['contact_num'] ?>">
                </div>

                <div>
                    <span>Address: </span>

                    <input type="text" name="address" placeholder="Enter address" value="<?= $customer_info['address'] ?>">
                </div>
            </div>
        </div>

        <button type="button" class="action-btn">Save Info</button>
    </div>

    <div class="modal">
        <p>Save new user info?</p>

        <div class="buttons">
            <button type="button">Cancel</button>
            <input type="submit" name="save_edit" value="Save">
        </div>
    </div>

    <span class="overlay"></span>
</form>

<script src="../script/create-edit-ls.js"></script>

<?php
    include_once '../includes/admin/footer.php';
?>