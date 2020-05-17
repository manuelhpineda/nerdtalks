<?php
require "header.php";

if (isset($_SESSION['u_id'])) {
    header('Location: index.php?pageError=already logged in');
}

?>

<div class="register-form-container">
    <h2>Welcome Back</h2>
    <p>you can sign in using your username or email.</p>

    <?php
    if (isset($_GET['error'])) {
        if ($_GET['error'] == "emptyfields") {
            echo '<p class="errormsg">Please fill in all the fields</p>';
        } elseif ($_GET['error'] == "wrongpwd" || $_GET['error'] == "wrongpwd2") {
            echo '<p class="errormsg">Wrong password</p>';
        } elseif ($_GET['error'] == "nouser") {
            echo '<p class="errormsg">No user with that account, please register</p>';
        } elseif ($_GET['error'] == "banned") {
            echo '<p class="errormsg">account issues</p>';
            echo '<script type="text/javascript">alert("Your account has been disabled")</script>';
        }
    }
    if (isset($_GET['signup'])) {
        if ($_GET['signup'] == "success") {
            echo '<p class="successmsg">Registration Successful</p>';
        }
    }
    ?>

    <form action="includes/login.inc.php" method="post" class="register-form">

        <label for="mail">Username</label><br>
        <input type="text" id="mail" name="mailuid" placeholder="Enter your username"><br>

        <label for="pwd">Password</label><br>
        <input type="password" id="pwd" name="pwdLogin" placeholder="Enter your password"><br>

        <button type="submit" name="login-submit">Login Now</button>
    </form>

    <p>Don't have an account? <a href="signup.php">Register Now</a></p>
    <p>Forgot your password? <a href="resetpwd.php">Reset it</a></p>
</div>

<?php
require "footer.php";