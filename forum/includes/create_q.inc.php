<?php

if (isset($_POST['new-submit'])) {

    require 'dbh.inc.php';

    $q_title = $_POST['q_title'];
    $q_cat = $_POST['q_cat'];
    $q_body = $_POST['q_body'];
    $q_by = $_POST['q_by'];
    $q_date = date('Y-m-d H:i:s');

    if (empty($q_title) || empty($q_cat) || empty($q_body)) {
        header("Location: ../index.php?error=emptyfields&cques=" . $q_cat);
    } else {

        $sql = "INSERT INTO questions (question_cat, question_by, question_title, question_body, question_date) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../index.php?error=sqlerror");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, 'iisss', $q_cat, $q_by, $q_title, $q_body, $q_date);
            mysqli_stmt_execute($stmt);
            header("Location: ../index.php?post=success");
            exit();
        }
    }

} else {
    header("Location: ../index.php");
    exit();

}


