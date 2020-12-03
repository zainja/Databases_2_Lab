CREATE DATABASE IF NOT EXISTS University;

USE University;

CREATE TABLE teacher
(
    teacher_id    varchar(255),
    firstname     varchar(50)  not null,
    lastname      varchar(50)  not null,
    password_hash varchar(255) not null,
    primary key (teacher_id)
);
CREATE TABLE student
(
    student_id    varchar(255),
    firstname     varchar(50)  not null,
    lastname      varchar(50)  not null,
    password_hash varchar(255) not null,
    primary key (student_id)
);
CREATE TABLE quiz
(
    quiz_id   int auto_increment,
    name      varchar(50) not null,
    author    varchar(255),
    available boolean default false,
    duration  int         not null,
    primary key (quiz_id),
    foreign key (author) references teacher (teacher_id)
        on delete set null
        on update cascade
);
CREATE TABLE student_quiz
(
    quiz_id      int,
    student_id   varchar(255),
    attempt_date timestamp default CURRENT_TIMESTAMP not null,
    attempt_id   int auto_increment primary key,
    grade        int,
    foreign key (quiz_id) references quiz (quiz_id)
        on delete cascade
        on update cascade,
    foreign key (student_id) references student (student_id)
        on delete cascade
        on update cascade
);

CREATE TABLE question
(
    question_number int auto_increment,
    question_text   varchar(255),
    choice_a        varchar(255),
    choice_b        varchar(255),
    choice_c        varchar(255),
    choice_d        varchar(255),
    answer          varchar(255) not null,
    primary key (question_number)
);
CREATE TABLE question_quiz
(
    quiz_id         int not null,
    question_number int not null,
    primary key (quiz_id, question_number),
    foreign key (quiz_id) references quiz (quiz_id) on delete cascade
        on update cascade,
    foreign key (question_number) references question (question_number) on delete cascade
        on update cascade
);

CREATE TABLE deleted_quiz_log (
    teacher_id varchar(255),
    del_quiz_id int,
    delete_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP not null,
    primary key (teacher_id, del_quiz_id),
    foreign key (teacher_id) REFERENCES teacher(teacher_id)
                              on update cascade
                              on delete cascade
);

DELIMITER //
CREATE PROCEDURE GetAllStudentsWithBadScores()
BEGIN
    SELECT firstname, lastname, grade
    FROM student_quiz
             INNER JOIN student s on student_quiz.student_id = s.student_id
    WHERE grade < 40;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE GetAllStudentsWithBadScoreForGivenQuiz(IN q_id int)
BEGIN
    SELECT firstname, lastname, grade
    FROM student_quiz
             INNER JOIN student s on student_quiz.student_id = s.student_id
    WHERE quiz_id = q_id
      AND grade < 40;
END//
DELIMITER ;

CREATE trigger after_quiz_deletion
    AFTER DELETE ON quiz FOR EACH ROW
    BEGIN
    INSERT INTO deleted_quiz_log (teacher_id, del_quiz_id) VALUES (OLD.author, OLD.quiz_id);
    END;