<?php session_start(); ?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../bootstrap-4.4.1-dist/css/bootstrap.css">
    <title> Teacher | Register</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand text-black" href="../index.php">University of Manchester Quizzes</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link text-black" href="#">Teacher Register <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link text-black-50" href="./teacher_login.php">Teacher Login <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item text-white">
                <a class="nav-link text-black-50" href="../about_us.php">About us</a>
            </li>
        </ul>
    </div>
</nav>
<div class="container pt-5">
    <?php
    if (!isset($_SESSION["teacher_id"])) {
        form();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            /** @var $conn **/
            require_once("../config.inc.php");
            register($conn);
        }
    } else {
        echo("
            <div>
               <p>You are already registered</p>
               <a class='btn btn-danger' href='logout_teacher.php'> Logout </a>
               <a class='btn btn-info' href='teacher_login.php'>Login</a>
            </div>");

    }
    ?>
</div>

<?php
function form()
{
    ?>
    <form method="post" action="teacher_register.php">
        <div class="form-group">
            <label for="teacher_id_input">Teacher ID</label>
            <input type="text"
                   class="form-control"
                   id="teacher_id_input"
                   name="teacher_id"
                   placeholder="Enter Teacher ID">
        </div>
        <div class="form-group">
            <label for="first_name_input">First Name</label>
            <input type="text"
                   class="form-control"
                   id="first_name_input"
                   name="first_name"
                   required
                   placeholder="Enter First Name">
        </div>
        <div class="form-group">
            <label for="last_name_input">Last Name</label>
            <input type="text"
                   class="form-control"
                   id="last_name_input"
                   required
                   name="last_name"
                   placeholder="Enter Last Name">
        </div>
        <div class="form-group">
            <label for="password_input">Password</label>
            <input type="password"
                   class="form-control"
                   id="password_input"
                   name="password"
                   required
                   placeholder="Password">
        </div>
        <div class="form-group">
            <label for="password_confirm_input">Confirm Password</label>
            <input type="password"
                   class="form-control"
                   id="password_confirm_input"
                   name="confirm_password"
                   required
                   placeholder="Confirm Password">
        </div>

        <button type="submit" class="btn btn-primary" name="reg_teacher">Register</button>
    </form>
    <a href="teacher_login.php" class="text-primary"> Already have an account? login</a>

    <?php
}

?>
<?php
function register($conn)
{
    $teacher_id = $_POST["teacher_id"];
    $first_name = $_POST["first_name"];
    $lastname = $_POST["last_name"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    if ($password != $confirm_password) {
        echo("Passwords do not match");
    } else {
        $h_password = password_hash($password, PASSWORD_DEFAULT);
        $reg = $conn->prepare("INSERT INTO teacher (teacher_id, firstname, lastname, password_hash) VALUES (?, ?,?, ?)");
        if (!$reg) {
            echo("Connection Error");
            return;
        }
        if (!$reg->bind_param("ssss", $teacher_id, $first_name, $lastname, $h_password)) {
            echo("Failed to bind params");
            return;
        }
        if (!$reg->execute()) {
            echo("Failed to execute username is already in the system");
            return;
        }
        $_SESSION["teacher_id"] = $teacher_id;
        $_SESSION["teacher_first_name"] = $first_name;
        $_SESSION["teacher_last_name"] = $lastname;
        header("Location: ./teacher_main.php");
    }
}

?>
</body>
</html>
