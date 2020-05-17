<!Doctype html>
<html lang="en">
<head>
    <title>Nerd Talks</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link href="assets/css/forumstyle.css?<?= filemtime("css/style.css") ?>" rel="stylesheet" type="text/css"/>
</head>
<body>

<div class="register-form-container">
    <h2>New Password</h2>
    <p>Enter your password carefully</p>

    <?php
    $selector = $_GET["selector"];
    $validator = $_GET["validator"];

    if (empty($selector) || empty($validator)) {
        echo "Could not validate your request";
    } else {
        if (ctype_xdigit($selector) !== false && ctype_xdigit($validator) !== false) {
            ?>

            <form action="includes/reset-password.inc.php" method="post" class="register-form">
                <input type="hidden" name="selector" value="<?php echo $selector; ?>">
                <input type="hidden" name="validator" value="<?php echo $validator; ?>">

                <label for="pwd">Password</label><br>
                <input type="password" id="pwd" name="pwdLogin" placeholder="Enter your password"><br>

                <label for="pwd">Password</label><br>
                <input type="password" id="pwd" name="pwd-repeat" placeholder="Confirm password"><br>
                <button type="submit" name="reset-password-submit" class="formBtn">Reset Password</button>
            </form>

            <?php
        }
    }

    ?>
</div>

</body>
</html>