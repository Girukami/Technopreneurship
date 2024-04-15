<?php
    $page_title = 'Customer List';
    include_once '../includes/admin/header.php';
    include_once '../includes/admin/navbar.php';
    include_once '../class/customer.class.php';

    $customers = new Customer;
?>

<div class="order">
<?php
    if($customers->getAll() === 'empty'){
        echo '<div class="empty"><p>No customer accounts yet.</p></div>';
    }
    else{
        foreach($customers->getAll() as $customer){
    ?>
        <div class="orders">
            <!-- <a href="customer-info.php?customer_id=' . $order_id; } else { echo 'order-info.php?order_id=' . $order_id; } ?>"> -->
            <a href="customer-info.php?customer_id=<?= $customer['customer_id'] ?>">
                <img src="../images/icons/random/profile-cust-list.svg" style="width: 100px; height: 100px;">

                <div class="details">
                    <p>Name: <?= $customer['last_name'] . ', ' . $customer['first_name'] . ' ' . $customer['middle_name'] ?></p>
                    <p>Address: <?= $customer['address'] ?></p>
                    <p>Contact Number: <?= $customer['contact_num'] ?></p>
                </div>
            </a>
        </div>
    <?php
        }
    }
    ?>
</div>

<?php
    include_once '../includes/admin/header.php';
?>