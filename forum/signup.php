<?php
require "header.php";

if (isset($_SESSION['u_id'])) {
    header('Location: index.php?pageError=already logged in');
}

?>

<div class="register-form-container">
    <h2>Create Your Account</h2>
    <p>Please fill the following with appropriate information to register for a NerdTalks account. <span
                style="color: #70cee7">Password must be 8
        characters.</span></p>

    <?php
    if (isset($_GET['error'])) {
        if ($_GET['error'] == "emptyfields") {
            echo "<p class='errormsg'>Please fill in all the fields</p>";
        } elseif ($_GET['error'] == "invaliduidmail") {
            echo "<p class='errormsg'>Username is taken</p>";
        } elseif ($_GET['error'] == "invalidmail") {
            echo "<p class='errormsg'>Invalid email</p>";
        } elseif ($_GET['error'] == "passwordcheck") {
            echo "<p class='errormsg'>Passwords do not match</p>";
        } elseif ($_GET['error'] == "passwordlen") {
            echo "<p class='errormsg'>Passwords do not match</p>";
        }
    }
    ?>

    <form action="includes/signup.inc.php" method="post" class="register-form">
        <label for="uid">Username</label><br>
        <input type="text" id="uid" name="uid" placeholder="Enter your username"><br>

        <label for="mail">Email Address</label><br>
        <input type="email" id="mail" name="mail" placeholder="Enter your email address"><br>

        <label for="pwd">Password</label><br>
        <input type="password" id="pwd" name="pwd" placeholder="Enter your password"><br>

        <label for="pwd-repeat">Confirm Password</label><br>
        <input type="password" id="pwd-repeat" name="pwd-repeat" placeholder="Confirm password"><br>

        <button type="submit" name="signup-submit">Register Now</button>
    </form>

    <p>Already have an account? <a href="login.php">Login</a></p>
</div>
