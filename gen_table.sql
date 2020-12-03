create table if not exists question
(
    question_number int auto_increment
        primary key,
    question_text varchar(255) null,
    choice_a varchar(255) null,
    choice_b varchar(255) null,
    choice_c varchar(255) null,
    choice_d varchar(255) null,
    answer varchar(255) not null
);

create table if not exists student
(
    student_id varchar(255) not null
        primary key,
    firstname varchar(50) not null,
    lastname varchar(50) not null,
    password_hash varchar(255) not null
);

create table if not exists teacher
(
    teacher_id varchar(255) not null
        primary key,
    firstname varchar(50) not null,
    lastname varchar(50) not null,
    password_hash varchar(255) not null
);

create table if not exists quiz
(
    quiz_id int auto_increment
        primary key,
    name varchar(50) not null,
    author varchar(255) null,
    available tinyint(1) default 0 null,
    duration int not null,
    constraint quiz_ibfk_1
        foreign key (author) references teacher (teacher_id)
            on update cascade on delete set null
);

create table if not exists question_quiz
(
    quiz_id int not null,
    question_number int not null,
    primary key (quiz_id, question_number),
    constraint question_quiz_ibfk_1
        foreign key (quiz_id) references quiz (quiz_id)
            on update cascade on delete cascade,
    constraint question_quiz_ibfk_2
        foreign key (question_number) references question (question_number)
            on update cascade on delete cascade
);

create index question_number
    on question_quiz (question_number);

create index author
    on quiz (author);

create table if not exists student_quiz
(
    quiz_id int null,
    student_id varchar(255) null,
    attempt_date timestamp default CURRENT_TIMESTAMP not null,
    attempt_id int auto_increment
        primary key,
    grade int null,
    constraint student_quiz_ibfk_1
        foreign key (quiz_id) references quiz (quiz_id)
            on update cascade on delete cascade,
    constraint student_quiz_ibfk_2
        foreign key (student_id) references student (student_id)
            on update cascade on delete cascade
);

create index quiz_id
    on student_quiz (quiz_id);

create index student_id
    on student_quiz (student_id);