<?php
session_start();
/** @var $conn **/
require_once("../config.inc.php");
$student_id = $_SESSION["student_id"];
$quiz_id = $_REQUEST["id"];
$questions = $_POST["question"];
$correct_answers = 0;
$total_questions = 0;
foreach ($questions as $key=>$value) {
    if($answer_query = $conn->query("SELECT answer FROM question WHERE question_number = $key")){
        while ($row = $answer_query->fetch_assoc()){
            if($row["answer"] == $value){
                $correct_answers ++;
            }
        }
    }
    $answer_query->close();
    $total_questions ++;
}

$grade = ($correct_answers / $total_questions) * 100;
if(!$quiz_query = $conn->query("INSERT INTO student_quiz (quiz_id, student_id, grade) 
VALUES ($quiz_id, $student_id, $grade)")){
    echo("Connection error $conn->error");
    die();
}
$conn->close();
header("location: student_main.php");