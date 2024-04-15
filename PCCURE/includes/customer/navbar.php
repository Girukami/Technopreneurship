<header class="header">
    <nav>
        <a href="home.php" class="logo">
            <img src="../images/icons/logo/12.png">

            <p>PC GURU</p>
        </a>

        <div class="mid-content">
            <a href="home.php" class="<?php if($page_title === 'Customer | Home') echo 'active' ?>">Home</a>

            <a href="appointment.php" class="<?php if($page_title === 'Appointment List' || $page_title === 'Appointment Info') echo 'active' ?>">Appointment list</a>

            <div class="search">
                <input type="text" placeholder="Search...">

                <img src="../images/icons/random/search.svg">
            </div>
        </div>

        <div class="account">
            <img src="../images/icons/random/profile.svg">

            <p class="name">
                <?= $customer['last_name'] . ', ' . $customer['first_name'] . ' ' . $customer['middle_name'] ?>
            </p>

            <img src="../images/icons/random/arrowdown.svg">
        </div>

        <div class="action">
            <a href="#">Profile</a>
            <a href="logout.php">Logout</a>
        </div>

        <span class="nav-overlay"></span>
    </nav>
</header>
<script src="../script/navbar.js"></script>