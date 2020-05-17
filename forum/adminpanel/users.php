<!--
=========================================================
* Paper Dashboard 2 - v2.0.1
=========================================================

* Product Page: https://www.creative-tim.com/product/paper-dashboard-2
* Copyright 2020 Creative Tim (https://www.creative-tim.com)

Coded by www.creative-tim.com

 =========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->

<?php

require "../includes/dbh.inc.php";
session_start();

$id = $_SESSION['u_id'];

if (isset($_POST)) {
    $user = $_POST['user'];
}


?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <link rel="apple-touch-icon" sizes="76x76" href="./assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="./assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <title>
        Nerd Talks Admin Panel
    </title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no'
          name='viewport'/>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet"/>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <!-- CSS Files -->
    <link href="./assets/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="./assets/css/paper-dashboard.css?v=2.0.1" rel="stylesheet"/>
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="./assets/demo/demo.css" rel="stylesheet"/>
</head>

<body class="">
<div class="wrapper ">

    <div class="sidebar" data-color="white" data-active-color="danger">
        <div class="logo">
            <a href="https://www.creative-tim.com" class="simple-text logo-normal">
                <div class="logo-image-big">
                    <img src="../assets/img/logo-complete.svg">
                </div>
            </a>
        </div>
        <div class="sidebar-wrapper">
            <ul class="nav">
                <li>
                    <a href="admin.php">
                        <i class="nc-icon nc-bank"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="active ">
                    <a href="#">
                        <i class="nc-icon nc-single-02"></i>
                        <p>Users Profile</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="main-panel" style="height: 100vh;">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-absolute fixed-top navbar-transparent">
            <div class="container-fluid">
                <div class="navbar-wrapper">
                    <div class="navbar-toggle">
                        <button type="button" class="navbar-toggler">
                            <span class="navbar-toggler-bar bar1"></span>
                            <span class="navbar-toggler-bar bar2"></span>
                            <span class="navbar-toggler-bar bar3"></span>
                        </button>
                    </div>
                    <a class="navbar-brand" href="javascript:;">Title</a>
                </div>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation"
                        aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-bar navbar-kebab"></span>
                    <span class="navbar-toggler-bar navbar-kebab"></span>
                    <span class="navbar-toggler-bar navbar-kebab"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navigation">
                    <form>
                        <div class="input-group no-border">
                            <input type="text" value="" class="form-control" placeholder="Search...">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <i class="nc-icon nc-zoom-split"></i>
                                </div>
                            </div>
                        </div>
                    </form>
                    <ul class="navbar-nav">
                        <li class="nav-item btn-rotate dropdown">
                            <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="nc-icon nc-bell-55"></i>
                                <p>
                                    <span class="d-lg-none d-md-block">Some Actions</span>
                                </p>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                                <form method="post" action="users.php">
                                    <?php
                                    echo '<input type="hidden" name="user" value="' . $id . '">';
                                    echo '<button type="submit" class="dropdown-item">My Profile</button>';
                                    ?>
                                </form>
                                <a class="dropdown-item" href="../index.php">Go to Forum</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- End Navbar -->
        <div class="content">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="description">Edit User</h3>


                    <div class="row">


                        <div class="col-md-4">

                            <div class="card card-user">
                                <div class="image">
                                    <img src="assets/img/damir-bosnjak.jpg" alt="...">
                                </div>
                                <div class="card-body">
                                    <div class="author">
                                        <a href="#">
                                            <?php
                                            //Get User Data
                                            $sql = "SELECT * FROM users WHERE user_id = '$user';";
                                            $result = mysqli_query($conn, $sql);
                                            $row = mysqli_fetch_assoc($result);

                                            //Gets the user profile picture
                                            $sqlImg = "SELECT * FROM profileimg WHERE userid = '$user';";
                                            $resultImg = mysqli_query($conn, $sqlImg);
                                            if ($rowImg = mysqli_fetch_assoc($resultImg)) {
                                                if ($rowImg['status'] < 1) {
                                                    echo '<img class="avatar border-gray" src="../uploads/profile' . $user . '.jpg" alt="profile picture">';
                                                } else {
                                                    echo '<img class="avatar border-gray" src="../uploads/avatar.png" alt="profile picture">';
                                                }
                                            }
                                            echo '<h5 class="title">' . $row['first_name'] . ' ' . $row['last_name'] . '</h5>';
                                            ?>
                                        </a>
                                        <?php
                                        $sql = "SELECT question_by FROM questions WHERE question_by = '$user';";
                                        $question_results = mysqli_query($conn, $sql);
                                        $question_row = mysqli_num_rows($question_results);

                                        echo '<p class="description">' . $row['user_name'] . '</p>';
                                        echo '<p class="description">' . $question_row . ' Questions Asked</p>';
                                        ?>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!--                        Edit user section-->

                        <div class="col-md-8">
                            <div class="card card-user">
                                <div class="card-header">
                                    <h5 class="card-title">Edit Profile</h5>
                                </div>
                                <div class="card-body">
                                    <form method="post" action="updateProfile.inc.php">
                                        <div class="row">

                                            <div class="col-md-3 pr-1">
                                                <div class="form-group">
                                                    <label>User Id (disabled)</label>
                                                    <?php echo '<input type="text" value="' . $user . '" class="form-control" disabled="">'; ?>
                                                </div>
                                            </div>
                                            <div class="col-md-4 px-1">
                                                <div class="form-group">
                                                    <label>Username</label>
                                                    <?php echo '<input type="text" class="form-control" placeholder="Username" name="username" value="' . $row['user_name'] . '">'; ?>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 pr-1">
                                                <div class="form-group">
                                                    <label>First Name</label>
                                                    <?php echo '<input type="text" class="form-control" placeholder="First Name" name="fname" value="' . $row['first_name'] . '">'; ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6 pl-1">
                                                <div class="form-group">
                                                    <label>Last Name</label>
                                                    <?php echo '<input type="text" class="form-control" placeholder="Last Name" name="lname" value="' . $row['last_name'] . '">'; ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Email Address</label>
                                                    <?php echo '<input type="email" class="form-control" placeholder="Email" name="mail" value="' . $row['user_email'] . '">'; ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Password (leave empty to keep the original password)</label>
                                                    <?php echo '<input type="password" class="form-control" placeholder="password" name="pwd">'; ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">

                                            <div class="col-md-4 pr-1">
                                                <label>change user level(admin, user)</label>
                                                <?php

                                                if ($row['user_level'] > 0) {
                                                    echo '<input type="text" class="form-control" placeholder="User level" name="lvl">';
                                                } else {
                                                    echo '<input type="text" class="form-control" placeholder="User level" name="lvl">';
                                                }

                                                ?>
                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="update ml-auto mr-auto">
                                                <button type="submit" name="submit" class="btn btn-primary btn-round">Update Profile</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>


                </div>
            </div>
        </div>
    </div>
</div>


<!--   Core JS Files   -->
<script src="./assets/js/core/jquery.min.js"></script>
<script src="./assets/js/core/popper.min.js"></script>
<script src="./assets/js/core/bootstrap.min.js"></script>
<script src="./assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
<!--  Google Maps Plugin    -->
<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
<!-- Chart JS -->
<script src="./assets/js/plugins/chartjs.min.js"></script>
<!--  Notifications Plugin    -->
<script src="./assets/js/plugins/bootstrap-notify.js"></script>
<!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
<script src="./assets/js/paper-dashboard.min.js?v=2.0.1" type="text/javascript"></script>
</body>

</html>
