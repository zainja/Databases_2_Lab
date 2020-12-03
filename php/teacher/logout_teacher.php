<?php
session_start();
if(!isset($_SESSION["teacher_id"])){
    die();
}
session_destroy();
header("Location: ../index.php");