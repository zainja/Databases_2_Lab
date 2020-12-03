<?php
$available = $_REQUEST["available"];
$id = $_REQUEST["id"];
/** @var $conn **/
require_once("../config.inc.php");
$new_available = $available == 1 ? 0: 1;
if(!$conn->query("UPDATE quiz SET available = $new_available WHERE quiz_id = $id")){
    echo("Failed to change state");
    die();
}
header("location: teacher_main.php");