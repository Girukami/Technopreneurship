<?php
    $page_title = 'Customer | Home';
    include_once '../class/service.class.php';
    include_once '../includes/customer/header.php';
    include_once '../includes/customer/navbar.php';

    $services = new Service;
?>

<section class="home">
    <?php
        if(isset($_GET['success_message']) || isset($_GET['error_message'])){
    ?>
            <div class="popups <?php if(isset($_GET['success_message'])){ echo 'success'; } else{ echo 'error'; } ?>"><p><?php if(isset($_GET['success_message'])){ echo $_GET['success_message']; } else{ echo $_GET['error_message']; } ?></p><img src="../images/icons/random/close.svg" class="close"></div>
            <script src="../script/popups.js"></script>

    <?php
            unset($_GET['success_message']);
            unset($_GET['error_message']);
        }

        if($services->getAll() === 'empty'){
            echo '<div class="empty"><p>No services available as of now.</p></div>';
        }
        else{
            foreach($services->getAll() as $service){
    ?>
                    <a href="service-info.php?service_id=<?= $service['service_id'] ?>" class="products">
                        <img src="../images/uploads/services/<?= $service['image'] ?>">

                        <div class="description">
                            <div>
                                <!-- <span>Name: </span> -->
                                <p><?= $service['name'] ?></p>
                            </div>

                            <div>
                                <!-- <span>Price: </span> -->
                                <p>₱<?= $service['price'] ?></p>
                            </div>
                        </div>
                    </a>
    <?php
            }
        }
    ?>
</section>

<?php
    include_once '../includes/customer/footer.php';
?>