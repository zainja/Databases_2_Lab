<?php
$id = $_REQUEST["id"];
/** @var $conn **/
require_once("../config.inc.php");
if(!$conn->query("DELETE FROM quiz WHERE quiz_id = $id")){
    echo("Failed to change state");
    die();
}
header("location: teacher_main.php");