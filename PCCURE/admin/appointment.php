<?php
    $page_title = 'appointment List';
    include_once '../includes/admin/header.php';
    include_once '../includes/admin/navbar.php';
    include_once '../class/appointment.class.php';

    $appointment = new Appointment;
?>

<div class="order">
<?php
    if($appointment->getAllStatus($_SESSION['user_type']) === 'empty'){
        echo '<div class="empty"><p>No appointments has been made</p></div>';
    }
    else{
        foreach($appointment->getAllStatus($_SESSION['user_type']) as $appointment_status){
    ?>
        <div class="label">
            <p><?= $appointment_status['status'] ?></p>
        </div>

        <div class="orders">
            <?php
                foreach($appointment->getAllByStatus($_SESSION['user_type'], $appointment_status['status']) as $appointment_info){
                    $appointment_id = $appointment_info['appointment_id'];
            ?>
                    <a href="<?php if($appointment_status['status'] === 'reviewing'){ echo 'checkout.php?appointment_id=' . $appointment_id; } else { echo 'appointment-info.php?appointment_id=' . $appointment_id; } ?>">
                        <img src="../images/uploads/services/<?= $appointment_info['image'] ?>" style="width: 100px; height: 100px;">

                        <div class="details">
                            <p>Name: <?= $appointment_info['name'] ?></p>
                            <p>Cost: ₱<?= $appointment_info['price'] ?></p>
                            <p>Date & Time: <?= $appointment_info['date'] ?></p>
                        </div>

                        <p class="payment-status"> <?= ucwords($appointment_info['status']) ?></p>
                    </a>
            <?php
                }
            ?>
        </div>
    <?php
        }
    }
    ?>
</div>

<?php
    include_once '../includes/admin/header.php';
?>