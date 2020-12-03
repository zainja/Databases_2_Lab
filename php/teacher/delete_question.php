<?php
$question_number = $_REQUEST["q"];
/** @var $conn **/
require_once("../config.inc.php");
if(!$query = $conn->query("DELETE from question WHERE question_number=$question_number")){
    echo("Connection Error");
    die();
}
//header("location: edit_quiz.php?id=");
echo "<script>alert('Question deleted')
 window.history.back()</script>";