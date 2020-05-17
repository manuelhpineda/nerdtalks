<?php
require "includes/dbh.inc.php";
session_start();

function get_timeago($ptime)
{
    $estimate_time = time() - $ptime;

    if ($estimate_time < 1) {
        return 'Just now';
    }

    $condition = array(
        12 * 30 * 24 * 60 * 60 => 'year',
        30 * 24 * 60 * 60 => 'month',
        24 * 60 * 60 => 'day',
        60 * 60 => 'hr',
        60 => 'min',
        1 => 'sec'
    );

    foreach ($condition as $secs => $str) {
        $d = $estimate_time / $secs;

        if ($d >= 1) {
            $r = round($d);
            return $r . ' ' . $str . ($r > 1 ? 's' : '') . ' ago';
        }
    }

}

?>

<!Doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!--    css libraries-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css"
          integrity="sha256-h20CPZ0QyXlBuAw7A+KluUYx/3pK+c7lYEpqLTlxjYQ=" crossorigin="anonymous"/>

    <link rel="stylesheet" href="assets/css/forumstyle.css?<?= filemtime("assets/css/forumstyle.css") ?>"/>
    <title>Nerd Talks</title>

</head>
<body>

<header>
    <div class="head-container">
        <a href="index.php" class="head-logo">
            <img src="assets/img/logo-complete.svg" alt="logo">
        </a>

        <label class="search" for="inpt_search">
            <i class="fas fa-search"></i>
            <input type="text" id="inpt_search" placeholder="Search for category, topic or question">
        </label>

        <nav>

            <?php
            if (isset($_SESSION['loggedin'])) {
                $id = $_SESSION['u_id'];
                $user = $_SESSION['u_name'];
                $userLvl = $_SESSION['u_lvl'];
                ?>
                <a href="">
                    <i class="fas fa-bell"></i>
                </a>
                <div class="ctn-avatar">
                    <div class="dropdown">
                        <div class="avatar">
                            <?php
                            $sqlImg = "SELECT * FROM profileimg WHERE userid = '$id';";
                            $resultImg = mysqli_query($conn, $sqlImg);
                            if ($rowImg = mysqli_fetch_assoc($resultImg)) {
                                if ($rowImg['status'] < 1) {
                                    echo '<img src="uploads/profile'.$id.'.jpg" alt="profile picture">';
                                } else {
                                    echo '<img src="uploads/avatar.png" alt="profile picture">';
                                }
                            }
                            ?>
                        </div>
                        <ul id="dropM">
                            <?php
                            if ($userLvl > 0) {
                                echo '<li><a href="adminpanel/admin.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>';
                            }
                            ?>

                            <li><a href="profile.php"><i class="fas fa-user"></i> Profile</a></li>
                            <li><a href="editProfile.php"><i class="fas fa-users-cog"></i> Edit Profile</a></li>
                            <li>
                                <form action="includes/logout.inc.php" method="post">
                                    <button type="submit" name="logout-submit">
                                        <i class="fas fa-sign-out-alt"></i>  logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>

                </div>
                <?php
            } else {
                echo '<a href="signup.php" class="header-btn">Signup</a>';
                echo '<a href="login.php" class="header-btn">Login</a>';
            }
            ?>


        </nav>

    </div>
</header>



