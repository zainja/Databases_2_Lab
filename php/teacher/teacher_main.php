<?php
session_start();
if (!isset($_SESSION["teacher_id"])) {
    header("Location: teacher_login.php");
}
?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../bootstrap-4.4.1-dist/css/bootstrap.css">
    <title> Teacher | Main Portal</title>
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
            <li class="nav-item text-white">
                <a class="nav-link text-black-50" href="./create_quiz_form.php">Create Quiz</a>
            </li>
            <li class="nav-item text-white">
                <a class="nav-link text-black-50" href="../about_us.php">About us</a>
            </li>
        </ul>
        <a class="btn btn-outline-danger my-2 my-sm-0" href="logout_teacher.php">Logout</a>
    </div>
</nav>
<div class="container mt-5">
    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Available</th>
            <th scope="col">Duration</th>
            <th scope="col">Delete</th>
            <th scope="col">Edit</th>
            <th scope="col"> Toggle availability</th>
        </tr>
        </thead>
        <tbody>
        <?php
        /** @var $conn * */
        require_once("../config.inc.php");
        $teacher_id = $_SESSION["teacher_id"];
        if ($query = $conn->query("SELECT quiz_id, name, author, available, duration FROM quiz WHERE author = $teacher_id")) {
            while ($row = $query->fetch_row()) {
                $available = $row[3] == 1 ? "yes" : "no";
                $row_vals = "<tr> 
                                <th scope='row'> $row[0]</th>
                                <td>$row[1]</td>
                                <td>$available</td>
                                <td>$row[4]</td>
                                <td><a href='delete_quiz.php?id=$row[0]'>Delete Quiz</a></td>
                                <td><a href='edit_quiz.php?id=$row[0]'>Edit Quiz</a></td>
                                <td><a href='toggle_available.php?available=$row[3]&id=$row[0]'>Change Availability</a></td>
                            </tr>";
                echo($row_vals);
            }
        } else {
            echo("Failed to execute username is not found");
            header("location: logout_teacher.php");

        }
        ?>
        </tbody>
    </table>
</div>

</body>
</html>
