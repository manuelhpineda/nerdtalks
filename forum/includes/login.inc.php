<?php

if (isset($_POST['login-submit'])) {

    require 'dbh.inc.php';

    $mailuid = $_POST['mailuid'];
    $password = $_POST['pwdLogin'];

    if (empty($mailuid) || empty($password)) {
        header("Location: ../login.php?error=emptyfields");
        exit();

    } else {
        //checks if the password is correct
        $sql = "SELECT * FROM users WHERE user_name=? OR user_email=?;";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../login.php?error=sqlerror");
            exit();

        } else {

            mysqli_stmt_bind_param($stmt, "ss", $mailuid, $mailuid);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($row = mysqli_fetch_assoc($result)) {
                $pwdCheck = password_verify($password, $row['user_password']);

                if ($pwdCheck == false) {
                    header("Location: ../login.php?error=wrongpwd");
                    exit();

                } else if ($pwdCheck == true) {
                    if ($row['user_status'] === "active") {
                        session_start();
                        $_SESSION['loggedin'] = TRUE;
                        $_SESSION['u_id'] = $row['user_id'];
                        $_SESSION['u_name'] = $row['user_name'];
                        $_SESSION['u_lvl'] = $row['user_level'];

                        header("Location: ../index.php?login=success");
                        exit();

                    } else if ($row['user_status'] === "banned") {
                        header("Location: ../login.php?error=banned");
                        exit();
                    }

                } else {
                    header("Location: ../login.php?error=wrongpwd2");
                    exit();

                }

            } else {
                header("Location: ../login.php?error=nouser");
                exit();

            }

        }
    }

} else {
    header("Location: ../index.php");
    exit();
}
