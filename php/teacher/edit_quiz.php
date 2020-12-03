<?php
session_start();

$quiz_id = $_REQUEST["id"];
/** @var $conn * */
require_once("../config.inc.php");
if (!isset($_SESSION["teacher_id"])) {
    header("location: ../index.php");
}
?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../bootstrap-4.4.1-dist/css/bootstrap.css">
    <title> Teacher | Main Portal</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand text-black" href="teacher_main.php">University of Manchester Quizzes | Teacher Portal</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item text-white">
                <a class="nav-link text-black-50" href="./create_quiz_form.php">Create Quiz</a>
            </li>
            <li class="nav-item text-white">
                <a class="nav-link text-black-50" href="#">About us</a>
            </li>
        </ul>
        <a class="btn btn-outline-danger my-2 my-sm-0" href="logout_teacher.php">Logout</a>
    </div>
</nav>
<div class="container mt-5">
    <form method="post" action="edit_quiz_submit.php?id=<?php echo $quiz_id ?>">
        <?php
        if ($quiz_meta = $conn->query("SELECT quiz_id, name, author, available, duration FROM quiz WHERE quiz_id = $quiz_id")) {
            $result = $quiz_meta->fetch_assoc();
            $quiz_available = $result["available"] == 1 ? "checked" : "";
            $quiz_meta_html = "
        <div class='form - group'>
            <label for='quiz_name'>Quiz Name</label>
            <input type='text'
                   class='form-control'
                   id='quiz_name'
                   required
                   value='" . $result["name"] . "'
                   name='quiz_name'
                   maxlength='255'
                   placeholder='Enter Quiz name'>
        </div>
        <div class='form-group'>
            <label for='quiz_duration'>Duration in minutes</label>
            <input type='number'
                   required
                   class='form-control'
                   id='quiz_duration'
                   name='quiz_duration'
                   value='" . $result["duration"] . "'
                   placeholder='30'>
        </div>
        <div class='form-group'>
            <input type='checkbox' class='check-input' id='check_available' name='available' $quiz_available>
            <label class='form-check-label' for='check_available'>Quiz Available</label>
        </div>
        ";
            echo $quiz_meta_html;
        }
        $question_html = "";
        $count = 1;
        if ($questions_query = $conn->query("SELECT q.question_number as q_number, question_text, choice_a, choice_b, choice_c, choice_d, answer FROM quiz qz
                                         INNER JOIN question_quiz qq on qz.quiz_id = qq.quiz_id
                                         INNER JOIN question q on qq.question_number = q.question_number
                                         WHERE qz.quiz_id = $quiz_id")) {
            while ($result = $questions_query->fetch_assoc()) {
                $q_number = $result["q_number"];
                $question_html .=
                    "<div class='form-group'>
                       
                         <div class='d-flex justify-content-between'>
                           <label for='question_$count\_text' style='width: 10%'>Question $count</label>
                           <a  href='delete_question.php?q=$q_number' class='text-danger'>Delete Question</a>
                        </div>
                        <input type='text' 
                        required
                        value='" . $result["question_text"] . "'
                        placeholder='Question $count title' 
                        id='question_$count\_text' 
                        name='question[$q_number][0]' 
                        class='form-control'>
                    </div>
                    <div class='form-group'>
            <label for='question_$count\_A'>Choice A</label>
            <input type='text'
                   required
                   placeholder='Choice A'
                   name='question[$q_number][1]'
                   id='question_$count\_A'
                   value='" . $result["choice_a"] . "'
                   class='form-control'
            >
        </div>
        <div class='form-group'>
            <label for='question_$count\_B'>Choice B</label>
            <input type='text'
                   required
                   placeholder='Choice B'
                   value='" . $result["choice_b"] . "'
                   id='question_$count\_B'
                   name='question[$q_number][2]'
                   class='form-control'
            >
        </div>
        <div class='form-group'>
            <label for='question_$count\_C'>Choice C</label>
            <input type='text'
                   required
                   placeholder='Choice C'
                   id='question_$count\1_C'
                   name='question[$q_number][3]'
                   value='" . $result["choice_c"] . "'
                   class='form-control'
            >
        </div>
        <div class='form-group'>
            <label for='question_$count\_D'>Choice D</label>
            <input type='text'
                   required
                   placeholder='Choice D'
                   id='question_$count\_D'
                   name='question[$q_number][4]'
                   value='" . $result["choice_d"] . "'
                   class='form-control'
            >
        </div>
        <div class='form-group'>
            <label>Answer</label>
            <div class='form-check'>
                <input class='form-check-input' type='radio' id='input_$count\_answerA' name='question[$count][5]' value='A' checked>
                <label class='form-check-label' for='input_$count\_answerA' > A </label>
            </div>
            <div class='form-check'>
                <input class='form-check-input' type='radio' id='input_$count\_answerB' name='question[$count][5]' value='B'>
                <label class='form-check-label' for='input_1_answerB'> B </label>
            </div>
            <div class='form-check'>
                <input class='form-check-input' type='radio' id='input_$count\_answerC' name='question[$count][5]' value='C'>
                <label class='form-check-label' for='input_$count\_answerC'> C </label>
            </div>
            <div class='form-check'>
                <input class='form-check-input' type='radio' id='input_$count\_answerD' name='question[$count][5]' value='D'>
                <label class='form-check-label' for='input_$count\_answerD'> D </label>
            </div>
        </div>
        <hr>
";
                $count++;
            }
        }
        echo $question_html;
        ?>
        <button class="btn btn-primary" type="submit">Submit Quiz</button>
    </form>
</div>


</body>
</html>
