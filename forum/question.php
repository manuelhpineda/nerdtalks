<?php

require "header.php";
require "includes/dbh.inc.php";

$q_id = 0;
if ($_GET['question']) {
    global $q_id;
    $q_id = $_GET['question'];
}
?>

    <section>

<!--        questions-->
        <div class="container">
            <!--this is the title of the page-->
            <div class="qp-question-title-ctn">
                <a href="index.php"><i class="fas fa-angle-left"></i></a>
                <?php

                $get_question_query = "SELECT * FROM questions INNER JOIN users ON questions.question_by = users.user_id
                    WHERE questions.question_id = $q_id
                    ORDER BY question_date DESC";

                $result = mysqli_query($conn, $get_question_query);

                if (!$row = mysqli_fetch_assoc($result)) {
                    echo '<h2 class="qp-question-title">Question not found</h2>';
                } else {
                    $imgId = $row['question_by'];
                $timeago = get_timeago(strtotime($row['question_date']));
                echo '<h2 class="qp-question-title">' . $row['question_title'] . '</h2>';
                ?>
            </div>
            <!--the question section-->
            <div class="qp-question-card">
                <div class="avatar-ctn">
                    <a href="#" class="qp-avatar">
                        <?php
                        //Gets the user profile picture
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
                    </a>
                </div>
                <div class="qp-body">
                    <div class="qp-header">
                        <?php
                        echo '<h4>' . $row['user_name'] . '</h4>';
                        echo '<p>' . $timeago . '</p>';
                        ?>
                    </div>
                    <div class="qp-content">
                        <?php
                        echo '<p>' . $row['question_body'] . '</p>';
                        ?>
                    </div>
                </div>
                <?php
                }
                ?>
            </div>

        </div>

<!--answers-->
        <div class="container">
            <?php

            $sql = "SELECT * FROM answers INNER JOIN users ON answers.answer_by = users.user_id
                    WHERE answers.question_id = $q_id
                    ORDER BY answers.answer_date DESC";

            $result = mysqli_query($conn, $sql);

            while ($row2 = mysqli_fetch_assoc($result)) {
                $timeago = get_timeago(strtotime($row2['answer_date']));
                $imgId = $row2['user_id'];
                ?>
                <div class="qp-question-card answer-card">
                    <a href="#" class="qp-avatar">
                        <?php
                        //Gets the user profile picture
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
                    </a>
                    <div class="qp-body">
                        <div class="qp-header">
                            <?php
                            echo '<h4>' . $row2['user_name'] . '</h4>';
                            echo '<p>' . $timeago . '</p>';
                            ?>
                        </div>
                        <div class="qp-content">
                            <?php
                            echo '<p>' . $row2['answer_body'] . '</p>';
                            ?>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>

<!--answer form-->
        <div class="container">

            <?php
            if (isset($_SESSION['loggedin'])) {
                ?>
                <form action="includes/newcomment.inc.php" method="post" class="register-form small-txt-area">
                    <?php
                    echo '<input type="hidden" name="question_id" value="' . $row['question_id'] . '">';
                    echo '<input type="hidden" name="answer_by" value="' . $_SESSION['u_id'] . '">';
                    ?>
                    <label for="mytextarea">Write a Response</label><br>
                    <textarea style="width: 80%" name="answer" id="mytextarea" placeholder="Enter your response..."></textarea>
                    <button type="submit" name="new-comment" class="login-submit">Submit Response</button>
                </form>
                <?php
            } else {
                ?>
                <form class="register-form border-top">
                    <h1>Login to answer</h1>
                </form>
                <?php
            }
            ?>
        </div>

    </section>


<?php
require "footer.php";

