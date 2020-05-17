<?php

if (isset($_POST['submit'])) {

    require "../includes/dbh.inc.php";


    $id = $_POST['user_id'];
    $username = $_POST['username'];
    $email = $_POST['mail'];
    $password = $_POST['pwd'];
    $lname = $_POST['fname'];
    $fname = $_POST['lname'];
    $user_lvl = $_POST['lvl'];
    $lvl = 0;

    if (!empty($user_lvl)) {
        if (strtolower($user_lvl) === 'admin') {
            $lvl = 1;
        } elseif (strtolower($user_lvl) === 'user') {
            $lvl = 0;
        } else {
            $lvl = 0;
        }
    }

    if (empty($username) || empty($email) || empty($lname) || empty($fname)) {
        header("Location: admin.php?error=emptyfields&uid=1");
        exit();
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        header("Location: admin.php?error=invaliduidmail3");
        exit();
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: admin.php?error=invalidmail&uid=4");
        exit();
    } elseif (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        header("Location: admin.php?error=invaliduid&mail=5");
        exit();
    } else {

        //checks if the username is taken
        $sql = "SELECT * FROM users WHERE user_name = '$username';";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            header("Location: admin.php?error=usernameTaken");
        } else {
            $sql = "UPDATE users SET user_name = '$username', user_email = '$email', first_name = '$fname', last_name = '$lname', user_lvl = '$lvl' WHERE user_id = '$id';";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                //checks if the password is being changed
                if (!empty($password)) {
                    $hashPwd = password_hash($password, PASSWORD_DEFAULT);
                    $sql = "UPDATE users SET user_password = '$hashPwd' WHERE user_id = '$id';";
                    $result = mysqli_query($conn, $sql);
                    if ($result) {
                        header("Location: admin.php?success");
                        exit();
                    } else {
                        header("Location: admin.php?error=passwordNotCHanged");
                        exit();
                    }
                }
            } else {
                header("Location: admin.php?error=".$id);
            }

        }
    }

}
