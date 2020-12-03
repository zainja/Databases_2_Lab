<?php session_start(); ?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../bootstrap-4.4.1-dist/css/bootstrap.css">
    <title> Student | Login</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-dark">
    <a class="navbar-brand text-white" href="../index.php">University of Manchester Quizzes</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link text-white-50" href="./student_register.php">Student Register <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link text-white" href="#">Student Login <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item text-white">
                <a class="nav-link text-white-50" href="../about_us.php">About us</a>
            </li>
        </ul>
    </div>
</nav>
<div class="container pt-5">
    <?php
    if (isset($_SESSION["student_id"])) {
        header("location: student_main.php");
    }
    form();
    /** @var $conn * */
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        require_once("../config.inc.php");
        login($conn);
    }
    ?>
    <a href="student_register.php" class="text-primary"> Don't have an account? Register</a>
</div>
</body>
</html>

<?php function form()
{ ?>
    <form method="post" action="student_login.php">
        <div class="form-group">
            <label for="student_id_input">Student ID</label>
            <input type="text"
                   class="form-control"
                   name="student_id"
                   id="student_id_input"
                   placeholder="Enter Student ID">
        </div>
        <div class="form-group">
            <label for="password_input">Password</label>
            <input type="password"
                   class="form-control"
                   id="password_input"
                   name="password"
                   placeholder="Password">
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
    </form>

<?php } ?>


<?php function login($conn)
{
    $student_id = $_POST["student_id"];
    $password = $_POST["password"];
    $query = $conn->prepare("SELECT * FROM student WHERE student_id = ?");
    if (!$query) {
        echo("Connection Error");
        return;
    }
    if (!$query->bind_param("s", $student_id)) {
        echo("Failed to bind params");
        return;
    }
    if (!$query->execute()) {
        echo("Failed to execute username is already in the system");
        return;
    }
    $result = $query->get_result();
    if (!($row = $result->fetch_array(MYSQLI_ASSOC))) {
        echo("Incorrect username or password");
        return;
    }
    $query->close();
    if (!password_verify($password, $row["password_hash"])) {
        echo("Incorrect username or password");
        return;
    }
    $_SESSION["student_id"] = $student_id;
    $_SESSION["student_first_name"] = $row["firstname"];
    $_SESSION["student_last_name"] = $row["lastname"];
    header("location: student_main.php");
} ?>
