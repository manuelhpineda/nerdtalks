<?php
    require "header.php";
?>

<div class="register-form-container">
    <h2>Reset Password</h2>
    <p>enter the email your account was created with.</p>

    <form action="includes/reset-request.inc.php" method="post" class="register-form">

        <label for="mail">Username</label><br>
        <input type="email" id="mail" name="mailuid" placeholder="Enter your username"><br>

        <button type="submit" name="reset-request-submit">Receive Confirmation</button>
    </form>

</div>