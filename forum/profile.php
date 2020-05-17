<?php
require "header.php";
require 'includes/dbh.inc.php';


$current_user = $_SESSION['u_id'];

if (isset($_POST['check'])) {
    $current_question = $_POST['question_id'];
    $sql = "UPDATE questions SET question_status = 'solved' WHERE question_id = $current_question";
    if (mysqli_query($conn, $sql)) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}

if (isset($_POST['uncheck'])) {
    $current_question = $_POST['question_id'];
    $sql = "UPDATE questions SET question_status = 'unsolved' WHERE question_id = $current_question";
    mysqli_query($conn, $sql);
}

if (isset($_POST['trash'])) {
    $current_question = $_POST['question_id'];
    $sql = "UPDATE questions SET question_status = 'deleted' WHERE question_id = $current_question";
    mysqli_query($conn, $sql);
}

?>

    <section>

        <div class="container">
            <div class="user-header">
                <div class="user-avatar">
                    <?php
                    //Gets the user profile picture
                    $imgId = $_SESSION['u_id'];
                    $sqlImg = "SELECT * FROM profileimg WHERE userid = '$imgId';";
                    $resultImg = mysqli_query($conn, $sqlImg);
                    if ($rowImg = mysqli_fetch_assoc($resultImg)) {
                        if ($rowImg['status'] < 1) {
                            echo '<img src="uploads/profile'.$imgId.'.jpg" alt="profile picture">';
                        } else {
                            echo '<img src="uploads/avatar.png" alt="profile picture">';
                        }
                    }
                    ?>
                </div>
                <div class="user-name">
                    <?php echo '<h1>'. $_SESSION['u_name'] .'</h1>';?>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="user-cards-ctn">

                <?php
                $sql = "SELECT * FROM questions INNER JOIN users ON questions.question_by = users.user_id
                    WHERE questions.question_by = $current_user
                    ORDER BY question_date DESC";

                $result = mysqli_query($conn, $sql);

                while ($row = mysqli_fetch_assoc($result)) {
                if ($row['question_status'] === 'unsolved' || $row['question_status'] === 'solved') {

                $timeAgo = get_timeago(strtotime($row['question_date']));
                $question = $row['question_id'];
                $sqlN = "SELECT answers.question_id FROM answers INNER JOIN questions ON answers.question_id = questions.question_id WHERE answers.question_id = $question";
                $resultN = mysqli_query($conn, $sqlN);
                $numberOfAnswers = mysqli_num_rows($resultN);

                //echo '<div class="card" onclick="goToQuestion(' . $row['question_id'] . ')">';
                echo '<div class="card">';
                ?>
                <div class="card-title">
                    <?php echo '<h2>' . $row['question_title'] . '</h2>'; ?>
                </div>
                <div class="card-body">
                    <?php echo '<p>' . $row['question_body'] . '</p>'; ?>
                    <form method="post">
                        <?php
                        echo '<input type="hidden" name="question_id" value="' . $row['question_id'] . '">';
                        if ($row['question_status'] === 'unsolved') {
                            echo '<button class="check-btn unchecked" type="submit" name="check"><i class="fas fa-check"></i></button>';
                        } else {
                            echo '<button class="check-btn unchecked" type="submit" name="uncheck"><i class="fas fa-check-double"></i></button>';
                        }
                        ?>

                        <button class="check-btn trash" type="submit" name="trash"><i class="fas fa-trash"></i></button>
                    </form>
                </div>
                <div class="card-footer">
                    <?php echo '<p>' . $timeAgo . '</p>'; ?>
                    <div class="num-comments">
                        <i class="far fa-comment-alt"></i>
                        <?php echo '<p>' . $numberOfAnswers . ' replies</p>'; ?>
                    </div>
                </div>
            </div>

            <?php
            }
            }
            ?>

        </
        >
        </div>

    </section>


<?php
require "footer.php";
