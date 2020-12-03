<?php session_start(); ?>
    <html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="../bootstrap-4.4.1-dist/css/bootstrap.css">
        <title> Student | Register</title>
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
                <li class="nav-item active">
                    <a class="nav-link text-white" href="#">Student Register <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link text-white-50" href="./student_login.php">Student Login <span class="sr-only">(current)</span></a>
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
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            /** @var $conn **/
            require_once("../config.inc.php");
            register_student($conn);
        }

        ?>
        <a href="student_login.php" class="text-primary"> Already have an account? login</a>
    </div>
    </body>
    </html>

<?php
    function register_student($conn){
        if($_POST["password"] != $_POST["confirm_password"]){
            echo("password don't match");
            return;
        }

        $student_id = $_POST["student_id"];
        $first_name = $_POST["first_name"];
        $last_name = $_POST["last_name"];
        $h_password = password_hash($_POST["password"], PASSWORD_DEFAULT);
        $register = $conn->prepare("INSERT INTO student (student_id, firstname, lastname, password_hash) VALUES (? ,? ,?, ?)");
        if(!$register){
            echo("Error preparing statements");
            return;
        }
        if(!$register->bind_param("ssss", $student_id, $first_name, $last_name, $h_password)){
            echo("Error binding variables");
            return;
        }
        if(!$register->execute()){
            echo("Failed student id is already in the system");
            return;
        }
        $_SESSION["student_id"] = $student_id;
        $_SESSION["student_first_name"] = $first_name;
        $_SESSION["student_last_name"] = $last_name;
        header("location: student_main.php");

    }
?>
<?php function form()
{ ?>
    <form method="post" action="student_register.php">
        <div class="form-group">
            <label for="student_id_input">Student ID</label>
            <input type="text"
                   class="form-control"
                   name="student_id"
                   required
                   id="student_id_input"
                   placeholder="Enter Student ID">
        </div>
        <div class="form-group">
            <label for="first_name_input">First Name</label>
            <input type="text"
                   class="form-control"
                   name="first_name"
                   required
                   id="first_name_input"
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
                   placeholder="Confirm Password">
        </div>
        <button type="submit" class="btn btn-primary">Register</button>
    </form>

<?php } ?>