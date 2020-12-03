<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="bootstrap-4.4.1-dist/css/bootstrap.css">
    <title>Quiz University | Home</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-dark">
    <a class="navbar-brand text-white" href="#">University of Manchester Quizzes</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link text-white" href="#">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item text-white">
                <a class="nav-link text-white" href="about_us.php">About us</a>
            </li>
        </ul>
    </div>
</nav>

<div class="d-flex vh-100 bg-dark flex-wrap-reverse">
    <a class="w-50 vh-100 d-flex align-items-center justify-content-center"
         href="./student/student_register.php"
         style="background-image: url(assets/dollar-gill-Kyoshy7BJIQ-unsplash.jpg); background-size: cover; border-width: 0">
        <h1 class="display-1">Student</h1>
    </a>
    <a class="w-50 vh-100 d-flex align-items-center justify-content-center"
         href="./teacher/teacher_register.php"
         style="background-image: url(assets/tra-nguyen-TVSRWmnW8Us-unsplash.jpg); background-size: cover; border-width: 0">
        <h1 class="display-1 text-white">Teacher</h1>
    </a>
</div>

</body>
</html>