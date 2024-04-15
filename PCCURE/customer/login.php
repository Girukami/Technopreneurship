<?php
    $page_title = 'Login';
    include_once '../class/user.class.php';
    include_once '../includes/customer/header.php';

    if(isset($_GET['success_message'])){
        $success_message = $_GET['success_message'];
    }

    if(isset($_POST['login'])){
        if(!empty($_POST['email']) && !empty($_POST['password'])){
            $email = htmlentities($_POST['email']);
            $password = htmlentities($_POST['password']);

            $customer = new Customer;
            $user = new User;

            if($customer->login($email, $password)){
                $customer = $customer->login($email,$password);
                // echo $customer['customer_id'];

                if($user->getInfo($customer['customer_id'], 'customer')){
                    $user = $user->getInfo($customer['customer_id'], 'customer');

                    $_SESSION['customer_id'] = $user['customer_id'];
                    $_SESSION['user_id'] = $user['user_id'];
                    $_SESSION['user_type'] = $user['user_type'];

                    header('location: home.php');
                }
                else{
                    $error_message = 'Login failed';
                }
            }
            else{
                $error_message = 'Invalid username or password';
            }
        }
        else{
            $error_message = 'Please fill up all fields';
        }
    }
?>

<section class="login">
    <form class="login-cont" method="post">
        <?php
            if(isset($error_message) || isset($success_message)){
        ?>
                <div class="popups customer <?= isset($error_message) ? '' : 'success' ?>"><p><?= isset($error_message) ? $error_message : $success_message ?></p></div>
        <?php
                unset($_GET['success_message']);
                unset($_GET['error_message']);
            }
        ?>

        <div class="heading">
            <img src="../images/icons/logo/12.png" />

            <p>Login</p>
        </div>

        <div class="inputs">
            <div class="email">
                <label for="email">Email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    placeholder="Enter email" />
            </div>

            <div class="password">
                <label for="password">Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Enter password" />
            </div>
        </div>

        <div class="actions">
            <div class="remember">
                <input type="checkbox" name="remember" id="checkbox" />
                <label for="checkbox">Remember me</label>
            </div>

            <div class="buttons">
                <input type="submit" name="login" value="Login" class="login-btn"/>

                <div class="text-w-line">
                    <p>or</p>
                    <span></span>
                </div>

                <a href="signup.php" class="signup-btn">Sign up</a>
            </div>

            <a href="#" class="forgot">Forgot password?</a>
        </div>
    </form>
</section>

<?php
    include_once '../includes/customer/footer.php';
?>