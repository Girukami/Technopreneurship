<?php
    include_once '../class/service.class.php';
    
    $service = new Service;
    
    if(isset($_GET['service_id'])){
        $page_title = 'Edit Service Info';
        
        $service_id = $_GET['service_id'];
        
        if($service->getOne($service_id)){
            $service_info = $service->getOne($service_id);
        }
        else{
            header('location: home.php?error_message=An error has been occured, please try again later.');
        }
    }
    else{
        $page_title = 'Create New Service';
    }

    include_once '../includes/admin/header.php';
    include_once '../includes/admin/navbar.php';

    if(isset($_POST['add_new'])){
        $name = htmlentities($_POST['name']);
        $price = htmlentities($_POST['price']);
        $description = htmlentities($_POST['description']);
        
        if(!empty($_FILES['image']) && !empty($name) && !empty($price) && !empty($description)){
            $img_name = $_FILES['image']['name'];
            $img_size = $_FILES['image']['size'];
            $tmp_name = $_FILES['image']['tmp_name'];
            $error = $_FILES['image']['error'];

            if($error === 0){
                if($img_size <= 35000000){
                    $img_ex = strtolower(pathinfo($img_name, PATHINFO_EXTENSION));
                    $allowed_exs = array('jpeg', 'png', 'jpg');

                    if(in_array($img_ex, $allowed_exs)){
                        $new_image_name = uniqid('IMG-', true) . '.' . $img_ex;
                        $img_upload_path = '../images/uploads/services/' . $new_image_name;

                        move_uploaded_file($tmp_name, $img_upload_path);

                        if($service->saveNewservice($new_image_name, ucwords($name), $price, $description)){
                            $success_message = 'New service has been successfully created.';
                            header('location: home.php?success_message=' . $success_message);
                        }
                    }
                    else{
                        $error_message = "You can't upload files of this type.";
                    }
                }
                else{
                    $error_message = 'Image size is too large.';
                }
            }
            else{
                $error_message = 'An unknown error occured, please try again.';
            }
        }
        else{
            $error_message = 'Please fill up all fields.';
        }
    }
    else if(isset($_POST['save_edit'])){
        $name = htmlentities($_POST['name']);
        $price = htmlentities($_POST['price']);
        $description = htmlentities($_POST['description']);
        
        if(!empty($_FILES['new_image']) && !empty($name) && !empty($price) && !empty($description)){
            $img_name = $_FILES['new_image']['name'];
            $img_size = $_FILES['new_image']['size'];
            $tmp_name = $_FILES['new_image']['tmp_name'];
            $error = $_FILES['new_image']['error'];

            if($error === 0){
                if($img_size <= 35000000){
                    $img_ex = strtolower(pathinfo($img_name, PATHINFO_EXTENSION));
                    $allowed_exs = array('jpeg', 'png', 'jpg');

                    if(in_array($img_ex, $allowed_exs)){
                        $new_image_name = uniqid('IMG-', true) . '.' . $img_ex;
                        $img_upload_path = '../images/uploads/services/' . $new_image_name;

                        move_uploaded_file($tmp_name, $img_upload_path);

                        if($service->saveEdit($service_id, $new_image_name, ucwords($name), $price, $description)){
                            $success_message = 'New service created successfully.';
                        }
                    }
                    else{
                        $error_message = "You can't upload files of this type.";
                    }
                }
                else{
                    $error_message = 'Image size is too large.';
                }
            }
            else{
                if($service->saveEdit($service_id, 'empty', ucwords($name), $price, $description)){
                    $success_message = 'New service info saved successfully.';
                }
            }
        }
        else{
            $error_message = 'Please fill up all fields.';
        }
    }
    else if(isset($_POST['delete'])){
        if($service->deleteservice($service_id)){
            $success_message = 'service successfully deleted.';
        }
    }

    if(isset($success_message)){
        header('location: home.php?success_message=' . $success_message);
    }
?>

<form class="product-info <?php if(isset($service_id)){ echo 'edit'; } else { echo 'create'; } ?> " method="post" enctype="multipart/form-data">
    <?php
        if(isset($error_message)){
    ?>
            <div class="popups error"><p><?= $error_message ?></p><img src="../images/icons/random/close.svg" class="close"></div>
            <script src="../script/popups.js"></script>

    <?php
            unset($error_message);
        }
    ?>

    <div class="img-cont">
        <?php
            if(isset($service_id)){
        ?>
            <img src="../images//uploads/services/<?= $service_info['image'] ?>">

            <div class="upload">
                <button type="button">Upload new image
                    <input type="file" name="new_image">
                </button>
            </div>
        <?php
            }
            else{
        ?>
            <div class="upload">
                <button type="button">Upload image
                    <input type="file" name="image">
                </button>
            </div>
        <?php
            }
        ?>
    </div>

    <div class="right-side">
        <div class="info">
            <div>
                <input type="text" name="name" placeholder="Service name"
                    value="<?php if(isset($service_id)){ echo $service_info['name']; } if(isset($_POST['name'])){ echo $_POST['name']; } ?>">
            </div>

            <div class="description">
                <div>
                    <span>Price: ₱</span>

                    <input type="number" name="price" min="1" placeholder="1.00"
                        value="<?php if(isset($service_id)){ echo $service_info['price']; } if(isset($_POST['price'])){ echo $_POST['price']; } ?>">
                </div>

                <div class="service_desc">
                    <span>Description: </span>
    
                    <textarea name="description"cols="30" rows="10"><?php if(isset($service_id)){ echo $service_info['description']; } if(isset($_POST['description'])){ echo $_POST['description']; } ?></textarea>
                </div>
            </div>
        </div>

        <button type="button" class="action-btn">Save Info</button>
    </div>

    <div class="modal">
        <p>
            <?php if(isset($service_id))  echo 'Save new service info?';  else  echo'Save this new service?'; ?>
        </p>

        <div class="buttons">
            <button type="button">Cancel</button>
            <input type="submit" name="<?php if(isset($service_id)){ echo 'save_edit'; } else{ echo 'add_new'; } ?>" value="Save Info">
        </div>
    </div>

    <span class="overlay"></span>
</form>

<script src="../script/create-edit-ls.js"></script>

<?php
    include_once '../includes/admin/footer.php';
?>