<?php
    $page_title = 'Login';
    include_once '../class/user.class.php';
    include_once '../includes/admin/header.php';

    if(isset($_POST['login'])){
        if(!empty($_POST['email']) && !empty($_POST['password'])){
            $email = htmlentities($_POST['email']);
            $password = htmlentities($_POST['password']);

            $admin = new Admin;
            $user = new User;

            if($admin->login($email, $password)){
                $admin = $admin->login($email, $password);

                if($user->getInfo($admin['admin_id'], 'admin')){
                    $user = $user->getInfo($admin['admin_id'], 'admin');

                    $_SESSION['admin_id'] = $user['admin_id'];
                    $_SESSION['user_id'] = $user['user_id'];
                    $_SESSION['user_type'] = $user['user_type'];

                    header('location: home.php');
                }
                else{
                    $error_message = 'Login failed';
                }

                
            }
            else{
                $error_message = 'Invalid email or password.';
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
            if(isset($error_message)){
                echo '<div class="popups"><p>' . $error_message . '</p></div>';
            }
        ?>


        <div class="heading">
            <img src="../images/icons/logo/12.png" />
            <!-- <img src="../images/icons/logo/Logo.png" /> -->

            <p>Login</p>
        </div>

        <div class="inputs">
            <div class="email">
                <label for="email">Email</label>

                <input type="email" id="email" name="email" placeholder="Enter email" />
            </div>

            <div class="password">
                <label for="password">Password</label>

                <input type="password" id="password" name="password" placeholder="Enter password" />
            </div>
        </div>

        <div class="actions">
            <div class="remember">
                <input type="checkbox" name="remember" id="checkbox" />

                <label for="checkbox">Remember me</label>
            </div>

            <div class="buttons">
                <input type="submit" name="login" value="Login" />
            </div>
        </div>
    </form>
</section>

<?php
    include_once '../includes/admin/footer.php';
?>