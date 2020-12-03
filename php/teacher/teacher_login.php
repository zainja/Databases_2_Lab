<?php session_start();
?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../bootstrap-4.4.1-dist/css/bootstrap.css">
    <title> Teacher | Login</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand text-black" href="teacher_main.php">University of Manchester Quizzes | Teacher Portal</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link text-black-50" href="./teacher_register.php">Teacher Register <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link text-black" href="#">Teacher Login <span class="sr-only">(current)</span></a>
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
            login($conn);
        }
    } else {
        echo("
            <div>
               <p>You are already logged in</p>
               <a class='btn btn-danger' href='logout_teacher.php'> Logout </a>
               <a class='btn btn-info' href='teacher_main.php'> Teacher Main Page</a>
            </div>");
    }
    ?>
</div>
</body>
</html>
<?php
function login($conn)
{
    $teacher_id = $_POST["teacher_id"];
    $password = $_POST["password"];
    $query = $conn->prepare("SELECT * FROM teacher WHERE teacher_id = ?");
    if (!$query) {
        echo("Connection Error");
        return;
    }
    if (!$query->bind_param("s", $teacher_id)) {
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
    $_SESSION["teacher_id"] = $row["teacher_id"];
    $_SESSION["teacher_first_name"] = $row["firstname"];
    $_SESSION["teacher_last_name"] = $row["lastname"];

    header("Location: ./teacher_main.php");

}

?>

<?php
function form()
{
    ?>
    <form method="post" action="teacher_login.php">
        <div class="form-group">
            <label for="teacher_id_input">Teacher ID</label>
            <input type="text"
                   class="form-control"
                   id="teacher_id_input"
                   name="teacher_id"
                   placeholder="Enter Teacher ID">
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
    <a href="teacher_register.php" class="text-primary"> Don't have an account? Register</a>
    <?php
}

?>

