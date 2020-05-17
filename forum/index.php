<?php
require "header.php";
require 'includes/dbh.inc.php';

$cat = 0;


if ($_GET['category']) {
    global $cat;
    $cat = $_GET['category'];
}

function filter()
{
    global $cat;
    $filter_cat = $cat;

    if ($filter_cat === 0) {
        $questions_query = "SELECT * FROM questions INNER JOIN users ON questions.question_by = users.user_id
                    ORDER BY question_date DESC";
    } else {
        $questions_query = "SELECT * FROM questions INNER JOIN users ON questions.question_by = users.user_id
                    WHERE questions.question_cat = $filter_cat
                    ORDER BY question_date DESC";
    }
    return $questions_query;
}

?>

    <!--        this is the modal to ask a question-->
    <div id="myModal" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>New Question</h2>
            <p>Please fill the information below.</p>

            <form action="includes/create_q.inc.php" method="post" class="register-form no-bottom-padding">
                <label for="q_title">Title of Discussion</label><br>
                <input type="text" id="q_title" name="q_title" placeholder="Enter the Title of Discussion"><br>

                <label for="q_cat">Topics</label><br>
                <select id="q_cat" name="q_cat">
                    <?php
                    $sql = "SELECT cat_id, cat_name FROM categories";
                    $result = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<option value="' . $row['cat_id'] . '">' . $row['cat_name'] . '</option>';
                    }
                    ?>
                </select>

                <label for="q_body">Description</label><br>
                <textarea id="mytextarea" name="q_body" rows="8" placeholder="Enter the Description"></textarea>
                <?php
                $user_id = $_SESSION['u_id'];
                echo '<input type="hidden" id="q_by" name="q_by" value="' . $user_id . '"><br>';
                ?>

                <button type="submit" name="new-submit">New Question</button>

            </form>

        </div>

    </div>

    <section>
        <!--        forum title and info-->
        <div class="container">
            <div class="forum-title">
                <?php
                //get the current category
                if ($cat === 0) {
                    echo '<h2>Discussion Forum</h2>';
                } else {
                    $sql = "SELECT cat_id, cat_name FROM categories WHERE cat_id = $cat";

                    $result = mysqli_query($conn, $sql);

                    if ($row = mysqli_fetch_assoc($result)) {
                        echo '<h2>' . $row['cat_name'] . ' Discussion Forum</h2>';
                    }
                }
                ?>
                <p>There is no such thing as stupid question. Ask, Learn and Grow.</p>
            </div>
        </div>

        <div class="container-grid">
            <!--        question card-->

            <div class="question-card-ctn">
                <!--                <h4 class="q-sec-title">Top Questions</h4>-->

                <?php
                $sql = filter();
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                if ($row['question_status'] === 'unsolved' || $row['question_status'] === 'solved') {

                $timeAgo = get_timeago(strtotime($row['question_date']));

                $id = $row['question_by'];
                $question = $row['question_id'];
                $sqlN = "SELECT answers.question_id FROM answers INNER JOIN questions ON answers.question_id = questions.question_id WHERE answers.question_id = $question";
                $resultN = mysqli_query($conn, $sqlN);
                $numberOfAnswers = mysqli_num_rows($resultN);

                echo '<div class="card" onclick="goToQuestion(' . $row['question_id'] . ')">';
                ?>
                <div class="card-title">
                    <?php echo '<h2>' . $row['question_title'] . '</h2>'; ?>
                </div>

                <div class="card-body">
                    <?php
                    echo '<p>' . $row['question_body'] . '</p>';
                    if ($row['question_status'] === 'solved') {
                        echo '<button class="solved-btn">Solved</button>';
                    }
                    ?>
                </div>

                <div class="card-footer">
                    <div class="card-user">
                        <div class="card-avatar">
                            <?php
                            //Gets the user profile picture
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
                        <?php echo '<h4>Posted by <span>' . $row['user_name'] . '</span></h4>'; ?>
                    </div>
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

        </div>

        <!--        ask button-->
        <div class="ask-btn">
            <?php
            if (isset($_SESSION['u_id'])) {
                echo '<button id="myBtn"><i class="fas fa-plus"></i> Ask a question</button>';
            } else {
                echo '<button onclick="changeToLogin()"><i class="fas fa-lock"></i> Login to Ask</button>';
            }
            ?>
        </div>

        <!--        categories-->
        <div class="categories-ctn">
            <div class="categories-title">
                <p>All Discussions</p>
            </div>
            <ul>
                <li class='cat-item'>
                    <button onclick="location.href='?category=0'"><span
                                style="background-color: lightblue"></span>All
                    </button>
                </li>
                <?php

                $sql = "SELECT cat_id, cat_name, cat_color FROM categories";

                $result = mysqli_query($conn, $sql);

                while ($row = mysqli_fetch_assoc($result)) {
                    $color = $row['cat_color'];
                    $buttonUrl = "location.href='?category=" . $row['cat_id'] . "'";

                    echo '<li class="cat-item"><button onclick=' . $buttonUrl . '><span style="background-color: ' . $color . '"></span>' . $row['cat_name'] . '</button></li>';
                }
                ?>
            </ul>
        </div>

        </div>

    </section>

<?php
require "footer.php";