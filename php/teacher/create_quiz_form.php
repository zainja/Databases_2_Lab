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
<script>
    let number_of_questions = 1

</script>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand text-black" href="teacher_main.php">University of Manchester Quizzes | Teacher Portal</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active text-white">
                <a class="nav-link text-black" href="./create_quiz_form.php">Create Quiz</a>
            </li>
            <li class="nav-item text-white">
                <a class="nav-link text-black-50" href="../about_us.php">About us</a>
            </li>
        </ul>
        <a class="btn btn-outline-danger my-2 my-sm-0" href="logout_teacher.php">Logout</a>
    </div>
</nav>
<div class="container mt-5">
    <form method="post" action="submit_quiz.php" id="quiz_form">
        <div class="form-group">
            <label for="quiz_name">Quiz Name</label>
            <input type="text"
                   class="form-control"
                   id="quiz_name"
                   required
                   name="quiz_name"
                   maxlength="255"
                   placeholder="Enter Quiz name">
        </div>
        <div class="form-group">
            <label for="quiz_duration">Duration in minutes</label>
            <input type="number"
                   required
                   class="form-control"
                   id="quiz_duration"
                   name="quiz_duration"
                   placeholder="30">
        </div>
        <div class="form-group">
            <input type="checkbox" class="check-input" id="check_available" name="available">
            <label class="form-check-label" for="check_available">Quiz Available</label>
        </div>
        <div class="form-group">
            <label for="question_1_text">Question 1</label>
            <input type="text"
                   required
                   placeholder="Question 1 title"
                   id="question_1_text"
                   name="question[1][0]"
                   class="form-control"
            >
        </div>
        <div class="form-group">
            <label for="question_1_A">Choice A</label>
            <input type="text"
                   required
                   placeholder="Choice A"
                   name="question[1][1]"
                   id="question_1_A"
                   class="form-control"
            >
        </div>
        <div class="form-group">
            <label for="question_1_B">Choice B</label>
            <input type="text"
                   required
                   placeholder="Choice B"
                   id="question_1_B"
                   name="question[1][2]"
                   class="form-control"
            >
        </div>
        <div class="form-group">
            <label for="question_1_C">Choice C</label>
            <input type="text"
                   required
                   placeholder="Choice C"
                   id="question_1_C"
                   name="question[1][3]"
                   class="form-control"
            >
        </div>
        <div class="form-group">
            <label for="question_1_D">Choice D</label>
            <input type="text"
                   required
                   placeholder="Choice D"
                   id="question_1_D"
                   name="question[1][4]"
                   class="form-control"
            >
        </div>
        <div class="form-group">
            <label>Answer</label>
            <div class="form-check">
                <input class="form-check-input" type="radio" id="input_1_answerA" name="question[1][5]" value="A" checked>
                <label class="form-check-label" for="input_1_answerA" > A </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" id="input_1_answerB" name="question[1][5]" value="B">
                <label class="form-check-label" for="input_1_answerB"> B </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" id="input_1_answerC" name="question[1][5]" value="C">
                <label class="form-check-label" for="input_1_answerC"> C </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" id="input_1_answerD" name="question[1][5]" value="D">
                <label class="form-check-label" for="input_1_answerD"> D </label>
            </div>
        </div>
        <hr>
        <button id="add_question_btn" onclick="add_question()" class="btn btn-info" type="button"> Add Question</button>
        <script>
            function add_question() {
                console.log("Eds");
                number_of_questions += 1
                let form = document.getElementById("quiz_form")
                let choices = ["A", "B", "C", "D"]
                let current_question = number_of_questions;

                let current_question_input_field = document.createElement("input")
                current_question_input_field.setAttribute("class", "form-control")
                current_question_input_field.setAttribute("type", "text")
                current_question_input_field.setAttribute("placeholder", `Question ${current_question} text`)
                current_question_input_field.setAttribute("id", `question_${current_question}_text`)
                current_question_input_field.setAttribute("name", `question[${current_question}][0]`)
                current_question_input_field.setAttribute("required", "true")
                let current_question_label = document.createElement("label")
                current_question_label.setAttribute("for", `question_${current_question}_text`)
                current_question_label.innerText = `Question ${current_question}`
                let question_text_container = document.createElement("div")
                question_text_container.setAttribute("class", "form-group")
                question_text_container.appendChild(current_question_label);
                question_text_container.appendChild(current_question_input_field);
                form.insertBefore(question_text_container, document.getElementById("add_question_btn"))
                let count = 1
                choices.forEach(c => {
                    let choice_label = document.createElement("label")
                    choice_label.setAttribute("for", `question_${current_question}_${c}`)
                    choice_label.innerText = `Choice ${c}`
                    let choice_input_field = document.createElement("input")
                    choice_input_field.setAttribute("class", "form-control")
                    choice_input_field.setAttribute("type", "text")
                    choice_input_field.setAttribute("placeholder", `Choice ${c}`)
                    choice_input_field.setAttribute("id", `question_${current_question}_${c}`)
                    choice_input_field.setAttribute("name", `question[${current_question}][${count}]`)
                    choice_input_field.setAttribute("required", "true")

                    let choice_container = document.createElement("div")
                    choice_container.setAttribute("class", "form-group")
                    choice_container.appendChild(choice_label)
                    choice_container.appendChild(choice_input_field)
                    form.insertBefore(choice_container, document.getElementById("add_question_btn"))
                    count += 1
                })
                let answer_container = document.createElement("div")
                answer_container.setAttribute("class", "form-group")
                let answer_label = document.createElement("label")
                answer_label.innerText = "Answer"
                answer_container.appendChild(answer_label)
                choices.forEach(c_radio => {
                    let choice_radio = document.createElement("input")
                    choice_radio.setAttribute("type" , "radio")
                    choice_radio.setAttribute("id", `input_${current_question}_answer${c_radio}`)
                    choice_radio.setAttribute("name", `question[${current_question}][5]`)
                    choice_radio.setAttribute("class", "form-check-input")
                    choice_radio.setAttribute("value", c_radio)
                    if(c_radio === "A"){
                        choice_radio.setAttribute("checked", "true")
                    }
                    let choice_label = document.createElement("label")
                    choice_label.setAttribute("for", `input_${current_question}_answer${c_radio}`)
                    choice_label.setAttribute("class", `form-check-label`)
                    choice_label.innerText = c_radio
                    let choice_container = document.createElement("div")
                    choice_container.setAttribute("class", "form-check")
                    choice_container.appendChild(choice_radio)
                    choice_container.appendChild(choice_label)
                    answer_container.appendChild(choice_container)
                })
                form.insertBefore(answer_container, document.getElementById("add_question_btn"))

                let separator = document.createElement("hr")
                form.insertBefore(separator, document.getElementById("add_question_btn"))

            }
        </script>
        <button type="submit" class="btn btn-primary">Submit quiz</button>
    </form>
</div>

</body>

</html>