<?php
    if(!isset($_GET['customer_id'])){
        header('location: home.php');
    }

    include_once '../class/service.class.php';
    include_once '../class/customer.class.php';
    $customer = new Customer;
    $customer_id = $_GET['customer_id'];

    if(!$customer->getInfo($customer_id)){
        header('location: home.php?error_message=An error has been occured, please try again later.');
    }
    
    $customer_info = $customer->getInfo($customer_id);
    $page_title = 'Customer Info';
    include_once '../includes/admin/header.php';
    include_once '../includes/admin/navbar.php';

    if(isset($_POST['delete'])){
        if($customer->delete($customer_id)){
            $success_message = 'User successfully deleted.';
        }
    }

    if(isset($success_message)){
        header('location: home.php?success_message=' . $success_message);
    }
?>

<form class="product-info" method="post">
    <div class="img-cont user-info">
        <img src="../images//icons/random/profile-cust-list.svg">
    </div>

    <div class="right-side">
        <div class="info">
            <div>
                <p class="name">
                    <?= $customer_info['last_name'] . ', ' . $customer_info['first_name'] . ' ' . $customer_info['middle_name'] ?>
                </p>
            </div>

            <div>
                <span>Contact number: </span>
                <p>
                    <?= $customer_info['contact_num'] ?>
                </p>
            </div>

            <div>
                <span>Address: </span>
                <p>
                    <?= $customer_info['address'] ?>
                </p>
            </div>
        </div>

        <div class="buttons">
            <a href="edit-customer.php?customer_id=<?= $customer_info['customer_id'] ?>">Edit user info</a>

            <button type="button" class="action-btn">Delete user</button>
        </div>
    </div>

    <div class="modal">
        <p>Do you really want to delete this user?</p>

        <div class="buttons">
            <button type="button">Cancel</button>
            <input type="submit" name="delete" value="Delete user">
        </div>
    </div>

    <span class="overlay"></span>
</form>

<script src="../script/create-edit-ls.js"></script>

<?php
    include_once '../includes/customer/footer.php';
?>