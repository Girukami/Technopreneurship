<?php
    if(!isset($_GET['service_id'])){
        header('location: home.php');
    }

    include_once '../class/service.class.php';
    include_once '../class/appointment.class.php';
    $service = new Service;
    $service_id = $_GET['service_id'];

    if(!$service->getOne($service_id)){
        header('location: home.php?error_message=An error has been occured, please try again.');
    }
    
    $service_info = $service->getOne($service_id);
    $page_title = $service_info['name'];
    include_once '../includes/admin/header.php';
    include_once '../includes/admin/navbar.php';

    if(isset($_POST['delete'])){
        if($service->deleteservice($service_id)){
            $success_message = 'service successfully deleted.';
        }
    }

    if(isset($success_message)){
        header('location: home.php?success_message=' . $success_message);
    }
?>

<form class="product-info" method="post">
    <div class="img-cont">
        <img src="../images//uploads/services/<?= $service_info['image'] ?>">
    </div>

    <div class="right-side">
        <div class="info">
            <div>
                <p class="name">
                    <?= $service_info['name'] ?>
                </p>
            </div>

            <div class="description">
                <div>
                    <span>Price: ₱</span>
                    <p>
                        <?= $service_info['price'] ?>
                    </p>
                </div>
            </div>

            <p class="desc-text"><?= $service_info['description'] ?></p>
        </div>

        <div class="buttons">
            <a href="create-edit.php?service_id=<?= $service_info['service_id'] ?>">Edit Service Info</a>

            <button type="button" class="action-btn">Delete Service</button>
            <a href = "home.php"> Back </a>
    </div>

    <div class="modal">
        <p>Do you really want to delete this service?</p>

        <div class="buttons">
            <button type="button">Cancel</button>
            <input type="submit" name="delete" value="Delete service">

            
        </div>

        

    </div>

    <span class="overlay"></span>
</form>

<script src="../script/create-edit-ls.js"></script>

<?php
    include_once '../includes/customer/footer.php';
?>