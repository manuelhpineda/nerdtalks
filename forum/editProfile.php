<?php
require "header.php";
require 'includes/dbh.inc.php';

?>

<section>
    <div class="container">
        <?php
        if (isset($_SESSION['u_id'])) {
            $user_id = $_SESSION['u_id'];
            $sql = "SELECT * FROM users WHERE user_id = '$user_id';";
            $results = mysqli_query($conn, $sql);
            if ($row = mysqli_fetch_assoc($results)) {

                $sqlImg = "SELECT * FROM profileimg WHERE userid = '$user_id';";
                $resultImg = mysqli_query($conn, $sqlImg);
                if ($rowImg = mysqli_fetch_assoc($resultImg)) {
                    echo '<div>';
                    if ($rowImg['status'] < 1) {
                        echo '<img src="uploads/profile'.$user_id.'.jpg?"'.mt_rand().'>';
                    } else {
                        echo '<img src="uploads/avatar.png">';
                    }
                    echo '</div>';
                }

            } else {
                echo 'sql error';
            }

            echo '<h1>Upload your profile picture</h1>
        <form action="includes/upload.inc.php" method="post" enctype="multipart/form-data">
            <input type="file" name="file">
            <button type="submit" name="upload">Upload</button>
        </form>';
        } else {
            header('location: index.php');
        }
        ?>

    </div>

    <div class="container">
        <form action="includes/updateProfile.inc.php" method="post" class="register-form">

            <?php
            $sql = "SELECT * FROM users WHERE user_id = '$user_id';";
            $results = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($results);
            ?>

            <?php echo '<input type="hidden" name="user_id" value="'.$user_id.'">'; ?>

            <label for="username">Username</label><br>
            <?php echo '<input type="text" id="username" name="username" value="'. $row['user_name'] .'"><br>'; ?>

            <label for="mail">Email</label><br>
            <?php echo '<input type="email" id="mail" name="mail" value="'. $row['user_email'] .'"><br>'; ?>

            <label for="pwd">Password (leave empty to keep the original password)</label><br>
            <?php echo '<input type="password" id="pwd" name="pwd"><br>'; ?>

            <label for="fname">First Name</label><br>
            <?php echo '<input type="text" id="fname" name="fname" value="'. $row['first_name'] .'"><br>'; ?>

            <label for="lname">Last Name</label><br>
            <?php echo '<input type="text" id="lname" name="lname" value="'. $row['last_name'] .'"><br>'; ?>

            <button type="submit" name="submit">Update Profile</button>
        </form>
    </div>
</section>
