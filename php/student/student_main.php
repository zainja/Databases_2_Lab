<?php
session_start();
/** @var $conn * */
require_once("../config.inc.php");
if (!isset($_SESSION["student_id"])) {
    header("location: ../index.php");
}
?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../bootstrap-4.4.1-dist/css/bootstrap.css">
    <title> Student | Main page</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-dark">
    <a class="navbar-brand text-white" href="student_main.php">University of Manchester Quizzes | Student Portal</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item text-white">
                <a class="nav-link text-white-50" href="../about_us.php">About us</a>
            </li>
        </ul>
        <a class="btn btn-outline-danger my-2 my-sm-0" href="logout_student.php">Logout</a>
    </div>
</nav>

<div class="container mt-5">
    <h3 class="bg-dark text-white p-3">Available quizzes</h3>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">Quiz ID</th>
            <th scope="col">Title</th>
            <th scope="col">Teacher</th>
            <th scope="col">Duration</th>
            <th scope="col">Take!</th>
        </tr>
        </thead>
        <tbody>

        <?php
        if ($query = $conn->query("SELECT quiz_id, name, t.firstname, t.lastname, available, duration
                                         FROM quiz
                                            LEFT JOIN teacher t on t.teacher_id = quiz.author
                                          WHERE available = 1")) {
            while ($row = $query->fetch_row()) {
                $row_vals = "<tr>
                                <th scope='row'> $row[0]</th>
                                <td>$row[1]</td>
                                <td>$row[2] $row[3]</td>
                                <td>$row[5]</td>
                                <td><a href='take_quiz.php?id=$row[0]'>take the quiz!</a></td>
                            </tr>";
                echo $row_vals;
            }
        }
        $query->close();

        ?>
        </tbody>
    </table>

    <h3 class="bg-dark text-white p-3">Quizzes you took</h3>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">Quiz ID</th>
            <th scope="col">Title</th>
            <th scope="col">Teacher</th>
            <th scope="col">Duration</th>
            <th scope="col">Attempt Date</th>
            <th scope="col">Score</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if ($query = $conn->query("SELECT sq.quiz_id, q.name , t.firstname, t.lastname, duration, attempt_date, sq.grade
FROM student_quiz sq
INNER JOIN quiz q on sq.quiz_id = q.quiz_id
INNER JOIN teacher t on q.author = t.teacher_id
ORDER BY attempt_date DESC
")) {

            while ($row = $query->fetch_row()) {
                $row_vals = "<tr>
                                <th scope='row'> $row[0]</th>
                                <td>$row[1]</td>
                                <td>$row[2] $row[3]</td>
                                <td>$row[4]</td>
                                <td>$row[5]</td>
                                <td>$row[6]</td>
                            </tr>";
                echo $row_vals;
            }
        }

        ?>
        </tbody>
    </table>


</div>


</body>
</html>
