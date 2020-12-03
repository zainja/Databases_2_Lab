<?php
session_start();
if (!isset($_SESSION["teacher_id"])) {
    header("Location: teacher_login.php");
}
/** @var $conn * */
require_once("../config.inc.php");
$quiz_id = $_REQUEST["id"];
$name = $_POST["quiz_name"];
$duration = $_POST["quiz_duration"];
$available = $_POST["available"] == "on" ? 1 : 0;
$questions = $_POST["question"];
if (!$quiz_meta_query = $conn->query("UPDATE quiz SET name='$name', available='$available', duration='$duration'
WHERE quiz_id ='$quiz_id'")) {
    echo("Connection Error" . $conn->error);
    die();
}
foreach ($questions as $key => $value) {
    $question_text = $value[0];
    $choice_a = $value[1];
    $choice_b = $value[2];
    $choice_c = $value[3];
    $choice_d = $value[4];
    $answer = $value[5];
    if (!$question_update_query =
        $conn->query("UPDATE question SET question_text='$question_text',
                    choice_a='$choice_a', choice_b='$choice_b', choice_c='$choice_c', choice_d='$choice_d', answer='$answer'
                    WHERE question_number='$key'")) {
        echo("Connection Error". $conn->error);
        die();
    }
    header("location: teacher_main.php");
}