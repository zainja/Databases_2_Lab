<?php
session_start();
if(!isset($_SESSION["student_id"])){
    header("location: ../index.php");
}
session_destroy();
header("Location: ./student_login.php");