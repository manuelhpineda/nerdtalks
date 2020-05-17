<?php

if (isset($_POST['submit'])) {

    require "dbh.inc.php";

    $id = $_POST['user_id'];
    $username = $_POST['username'];
    $email = $_POST['mail'];
    $password = $_POST['pwd'];
    $lname = $_POST['fname'];
    $fname = $_POST['lname'];

    if (empty($username) || empty($email) || empty($lname) || empty($fname)) {
        header("Location: ../editProfile.php?error=emptyfields&uid=1");
        exit();
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        header("Location: ../editProfile.php?error=invaliduidmail3");
        exit();
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../editProfile.php?error=invalidmail&uid=4");
        exit();
    } elseif (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        header("Location: ../editProfile.php?error=invaliduid&mail=5");
        exit();
    } else {

        //checks if the username is taken
        $sql = "SELECT * FROM users WHERE user_name = '$username';";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            header("Location: ../editProfile.php?error=usernameTaken");
        } else {
            $sql = "UPDATE users SET user_name = '$username', user_email = '$email', first_name = '$fname', last_name = '$lname' WHERE user_id = '$id';";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                //checks if the password is being changed
                if (!empty($password)) {
                    $hashPwd = password_hash($password, PASSWORD_DEFAULT);
                    $sql = "UPDATE users SET user_password = '$hashPwd' WHERE user_id = '$id';";
                    $result = mysqli_query($conn, $sql);
                    if ($result) {
                        header("Location: ../editProfile.php?success");
                        exit();
                    } else {
                        header("Location: ../editProfile.php?error=passwordNotCHanged");
                        exit();
                    }
                }
            } else {
                header("Location: ../editProfile.php?error=".$id);
            }

        }
    }

}
