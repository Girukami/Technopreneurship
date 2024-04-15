<?php
    $page_title = 'Sign up';
    include_once '../class/user.class.php';
    include_once '../includes/customer/header.php';

    if(isset($_POST['signup'])){
        if(!empty($_POST['fname']) && !empty($_POST['mname']) && !empty($_POST['lname']) && !empty($_POST['email']) && !empty($_POST['cnum']) && 
        !empty($_POST['address']) && !empty($_POST['password']) && !empty($_POST['password2'])){
            $fname = htmlentities($_POST['fname']);
            $mname = htmlentities($_POST['mname']);
            $lname = htmlentities($_POST['lname']);
            $email = htmlentities($_POST['email']);
            $cnum = htmlentities($_POST['cnum']);
            $address = htmlentities($_POST['address']);
            $password = htmlentities($_POST['password']);
            $password2 = htmlentities($_POST['password2']);

            $customer = new Customer;
            $user = new User;

            if($password === $password2){
                if($customer->signup($fname, $mname, $lname, $email, $cnum, $address, $password)){
                    header('location: login.php?success_message=Registration Successful. Please login to proceed.');
                }
                else{
                    $error_message = 'An unexpected error occured, please try again.';
                }
            }
            else{
                $error_message = 'Password didn\'t matched';
            }
        }
        else{
            $error_message = 'Please fill up all fields';
        }
    }
?>

<section class="login signup">
    <form class="login-cont" method="post">
        <?php
            if(isset($error_message)){
                echo '<div class="popups customer"><p>' . $error_message . '</p></div>';
            }
        ?>

        <div class="heading">
            <img src="../images/icons/logo/12.png" />

            <p>Sign up</p>
        </div>

        <div class="inputs">
            <div>
                <label for="fname">First Name</label>
                <input
                    type="text"
                    id="fname"
                    name="fname"
                    placeholder="Enter first name" />
            </div>

            <div>
                <label for="mname">Middle Name</label>
                <input
                    type="text"
                    id="mname"
                    name="mname"
                    placeholder="Enter middle name" />
            </div>

            <div>
                <label for="lname">Last Name</label>
                <input
                    type="text"
                    id="lname"
                    name="lname"
                    placeholder="Enter last name" />
            </div>

            <div>
                <label for="email">Email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    placeholder="Enter email" />
            </div>

            <div>
                <label for="cnum">Contact Number</label>
                <input
                    type="text"
                    id="cnum"
                    name="cnum"
                    placeholder="Enter contact number" />
            </div>

            <div>
                <label for="address">Address</label>
                <input
                    type="text"
                    id="address"
                    name="address"
                    placeholder="Enter complete address" />
            </div>

            <div>
                <label for="password">Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Enter password" />
            </div>

            <div>
                <label for="password2">Confirm Password</label>
                <input
                    type="password"
                    id="password2"
                    name="password2"
                    placeholder="Re-enter password" />
            </div>
        </div>

        <div class="actions">
            <div class="buttons">
                <input type="submit" class="signup-btn" name="signup" value="Sign up" />
                
                <div class="text-w-line">
                    <p>or</p>
                    <span></span>
                </div>
                
                <a href="login.php" class="login-btn">Login</a>
            </div>
        </div>
    </form>
</section>

<?php
    include_once '../includes/customer/footer.php';
?>