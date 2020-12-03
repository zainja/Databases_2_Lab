<?php
session_start();
$quiz_id = $_REQUEST["id"];
/** @var $conn * */
require_once("../config.inc.php");
if (!isset($_SESSION["student_id"])) {
    header("location: ../index.php");
}
?>


<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../bootstrap-4.4.1-dist/css/bootstrap.css">
    <title> Student | Main page</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-dark">
    <a class="navbar-brand text-white" href="student_main.php">University of Manchester Quizzes | Student Portal</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item text-white">
                <a class="nav-link text-white-50" href="../about_us.php">About us</a>
            </li>
        </ul>
        <a class="btn btn-outline-danger my-2 my-sm-0" href="logout_student.php">Logout</a>
    </div>
</nav>
<div class="container mt-5">
    <?php
    if ($query = $conn->query("SELECT quiz_id, name, author, available, duration FROM quiz qz
                        WHERE qz.quiz_id = $quiz_id")) {
        while ($row = $query->fetch_assoc()) {
            $available = $row["available"] == 1 ? "Yes" : "No";
            $quiz_header = "
            <div class='bg-light p-3 rounded'>
                <h2 class='display-4'>" . $row["name"] . "</h2>
                <h5> Quiz Id:" . $row["quiz_id"] . "</h5>
                <h5>Teacher: " . $row["name"] . "</h5>
                <h5>Available: " . $available . "</h5>
                <h5>Duration: " . $row["duration"] . "</h5>
            </div>
            ";
            echo $quiz_header;
        }

    }
    $query->close();
    ?>
    <?php
    echo "<form class='p-3' method='post' action='submit_quiz.php?id=$quiz_id'> "?>
        <?php
        $question_count = 0;
        $field_count = 1;
        if ($query = $conn->query("SELECT q.question_number as q_number, question_text, choice_a, choice_b, choice_c, choice_d, answer FROM quiz qz
                                         INNER JOIN question_quiz qq on qz.quiz_id = qq.quiz_id
                                         INNER JOIN question q on qq.question_number = q.question_number
                                         WHERE qz.quiz_id = $quiz_id")) {

            while ($row = $query->fetch_assoc()) {
                $question_number = $row["q_number"];
                $question = "
                <div class='mb-2'>
                   <h5>" . $field_count . ". " . $row["question_text"] . "</h5>
                   <div class='form-check'>
                    <input class='form-check-input' type='radio' id='q_A_$question_number' name='question[$question_number]' checked value='" . $row["choice_a"] . "'>
                    <label class='form-check-label' for='q_A_$question_number'>" . $row["choice_a"] . "</label>
                   </div>
                   
                   <div class='form-check'>
                    <input class='form-check-input' type='radio' id='q_B_$question_number' name='question[$question_number]' value='" . $row["choice_b"] . "'>
                    <label class='form-check-label' for='q_B_$question_number'>" . $row["choice_b"] . "</label>
                   </div>
                   
                   <div class='form-check'>
                    <input class='form-check-input' type='radio' id='q_C_$question_number' name='question[$question_number]' value='" . $row["choice_c"] . "'>
                    <label class='form-check-label' for='q_C_$question_number'>" . $row["choice_c"] . "</label>
                   </div>
                   
                   <div class='form-check'>
                    <input class='form-check-input' type='radio' id='q_D_$question_number' name='question[$question_number]' value='" . $row["choice_d"] . "'>
                    <label class='form-check-label' for='q_D_$question_number'>" . $row["choice_d"] . "</label>
                   </div>
                   <hr/>
                </div>
            ";
                echo $question;
                $question_count++;
                $field_count++;
            }
        }
        ?>
        <button class="btn btn-primary" type="submit">Submit quiz!</button>
    </form>
</div>
</body>
</html>
