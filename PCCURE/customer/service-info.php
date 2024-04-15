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
    include_once '../includes/customer/header.php';
    include_once '../includes/customer/navbar.php';

    if(isset($_POST['confirm'])){
        if(!empty($_POST['address']) && !empty($_POST['contact_num'])){
            $address = htmlentities($_POST['address']);
            $contact_num = htmlentities($_POST['contact_num']);

            $appointment = new Appointment;
            if($appointment_id = $appointment->addAppointmentService($customer['customer_id'], $service_id, $address, $contact_num)){
                header('location: home.php?success_message=Successfully set an appointment.');
            }

            $error_message = 'An error occured while setting an appointment.';
        }
        else{
            $error_message = 'Please fill up all fields.';
        }
    }
?>

<form class="product-info" method="post">
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
        <img src="../images/uploads/services/<?= $service_info['image'] ?>">
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
                    <span>Price: </span>
                    <p>₱<?= $service_info['price'] ?></p>
                </div>
            </div>

            <p class="desc-text"><?= $service_info['description'] ?></p>

            <div class="customer-info">
                <div>
                    <span>Address: </span>
                    
                    <input type="text" name="address" value="<?= $customer['address'] ?>">
                </div>
                
                <div>
                    <span>Contact number: </span>
                    
                    <input type="text" name="contact_num" class="contact_num" value="<?= $customer['contact_num'] ?>">
                </div>
            </div>
        </div>

        <button type="button" class="action-button" id="set_btn">Set Appointment</button>
        
    </div>

    <div class="modal">
        <p>Confirm appointment?</p>

        <div class="buttons">
            <button type="button">Cancel</button>
            <input type="submit" name="confirm" value="Confirm">
        </div>
    </div>

    <span class="overlay"></span>
</form>

<script src="../script/set_appointment.js"></script>

<?php
    include_once '../includes/customer/footer.php';
?>