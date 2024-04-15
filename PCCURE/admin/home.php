<?php
    $page_title = 'Admin | Home';
    include_once '../class/service.class.php';
    include_once '../includes/admin/header.php';
    include_once '../includes/admin/navbar.php';

    $services = new Service;
?>

<section class="home admin">
    <a href="create-edit.php" class="create-btn">Create New Service</a>

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
            echo '<div class="empty"><p>No services has been made yet.</p></div>';
        }
        else{
            foreach($services->getAll() as $service){
    ?>
                <a href="service-info.php?service_id=<?= $service['service_id'] ?>" class="products">
                    <img src="../images/uploads/services/<?= $service['image'] ?>">

                    <div class="description">
                            <div>
                                <p><?= $service['name'] ?></p>
                            </div>

                            <div>
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
    include_once '../includes/admin/footer.php';
?>