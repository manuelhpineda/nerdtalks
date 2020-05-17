<?php
session_start();
include 'dbh.inc.php';

if (isset($_POST['upload'])) {
    $id = $_SESSION['u_id'];

    $file = $_FILES['file'];

    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];
    $fileType = $file['type'];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array('jpg','jpeg', 'png');

    if (in_array($fileActualExt, $allowed)) {
        if ($fileError === 0) {
            if ($fileSize < 1000000) {
                $fileNameNew = "profile".$id."." . $fileActualExt;
                $sql = "UPDATE profileimg SET status = 0 WHERE userid = '$id';";
                mysqli_query($conn, $sql);
                $fileDestination = '../uploads/'.$fileNameNew;
                move_uploaded_file($fileTmpName, $fileDestination);
                header("location: ../editProfile.php?uploadsuccess");
            } else {
                echo "File is too big!";
            }
        } else {
            echo "There is an error with this file!";
        }
    } else {
        echo "You cannot upload files of this type";
    }
}
