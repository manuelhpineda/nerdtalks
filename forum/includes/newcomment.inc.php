<?php

if (isset($_POST['new-comment'])) {
    require 'dbh.inc.php';

    $answer_by = $_POST['answer_by'];
    $question_id = $_POST['question_id'];
    $answer_body = $_POST['answer'];
    $answerDate = date('Y-m-d H:i:s');

    if (empty($answer_body) || empty($answer_by) || empty($question_id)) {
        header("Location: ../question.php?question=".$question_id."&error=invalidform");
        exit();
    } else {

        $sql = "INSERT INTO answers (question_id, answer_by, answer_body, answer_date) VALUES (?,?,?,?)";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../question.php?question=".$question_id."&error=sqlerror");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, 'iiss', $question_id, $answer_by, $answer_body, $answerDate);
            mysqli_stmt_execute($stmt);
            header("Location: ../question.php?question=".$question_id."&status=successful");
            exit();
        }
    }

} else {
    header("Location: ../index.php");
    exit();
}