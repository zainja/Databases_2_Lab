CREATE DATABASE IF NOT EXISTS University;

USE University;

CREATE TABLE teacher  (
    teacher_id varchar(255),
    firstname varchar(50) not null ,
    lastname varchar(50) not null ,
    password_hash varchar(255) not null ,
    primary key (teacher_id)
);
CREATE TABLE student (
                         student_id varchar(255),
                         firstname varchar(50) not null ,
                         lastname varchar(50) not null ,
                         password_hash varchar(255) not null ,
                         primary key (student_id)
);
CREATE TABLE quiz (
    quiz_id int auto_increment,
    name varchar(50) not null ,
    author varchar(255),
    available boolean default false,
    duration int not null ,
    primary key (quiz_id),
    foreign key (author) references teacher(teacher_id)
        on delete set null
        on update cascade
);
CREATE TABLE student_quiz
(
    quiz_id      int,
    student_id   varchar(255),
    attempt_date not null timestamp default CURRENT_TIMESTAMP,
    attempt_id   int auto_increment,
    grade int,
    foreign key (quiz_id) references quiz (quiz_id)
        on delete cascade
        on update cascade,
    foreign key (student_id) references student (student_id)
        on delete cascade
        on update cascade
);

CREATE TABLE question (
    question_number int auto_increment,
    question_text varchar(255),
    choice_a varchar(255),
    choice_b varchar(255),
    choice_c varchar(255),
    choice_d varchar(255),
    primary key (question_number)
);
CREATE TABLE question_quiz(
    quiz_id int,
    question_number int,
    primary key (quiz_id, question_number),
    foreign key (quiz_id) references quiz(quiz_id) on delete cascade
        on update cascade,
    foreign key (question_number) references question(question_number) on delete cascade
        on update cascade
);
