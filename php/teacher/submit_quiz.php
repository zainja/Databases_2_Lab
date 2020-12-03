<?php
session_start();
/** @var $conn **/
require_once("../config.inc.php");
$quiz_query = $conn->prepare("INSERT INTO quiz (name, author, available, duration) VALUES (? ,?, ?, ?)");
if (!$quiz_query) {
    echo("Error sending data");
    die();
}
$quiz_name = $_POST["quiz_name"];
$duration = intval($_POST["quiz_duration"]);
$available = $_POST["available"] == "on" ? 1 : 0;

if (!$quiz_query->bind_param("ssss", $quiz_name, $_SESSION["teacher_id"], $available, $duration)) {
    echo("Error binding the information");
    die();
}
if (!$quiz_query->execute()) {
    echo("Error posting the quiz");
    die();
}
$quiz_id = $quiz_query->insert_id;
$quiz_query->close();
foreach ($_POST["question"] as $q) {

    $answer = "";
    switch ($q[5]) {
        case "A":
            $answer = $q[1];
            break;
        case "B":
            $answer = $q[2];
            break;
        case "C":
            $answer = $q[3];
            break;
        default:
            $answer = $q[4];
            break;
    }
    $question_query = $conn->prepare("INSERT INTO question (question_text, choice_a, choice_b, choice_c, choice_d, answer) VALUES (?, ?, ?, ?, ?, ?)");
    if (!$question_query) {
        echo("Error sending data");
        die();
    }
    if (!$question_query->bind_param("ssssss", $q[0], $q[1], $q[2], $q[3], $q[4], $answer)) {
        echo("Error binding the information");
        die();
    }
    if (!$question_query->execute()) {
        echo("Error posting the questions");
        die();
    }
    $question_id = $question_query->insert_id;
    $question_query->close();

    $question_quiz_query = $conn->prepare("INSERT INTO question_quiz (quiz_id, question_number) VALUES (? ,?) ");
    if(!$question_quiz_query){
        echo("error inserting questions and quizzes");
        die();
    }

    if (!$question_quiz_query->bind_param("ss", $quiz_id, $question_id)) {
        echo("Error binding the information");
        die();
    }

    if(!$question_quiz_query->execute()){
        echo("Error posting the questions");
        die();
    }
    $question_quiz_query->close();

    header("location: teacher_main.php");
}