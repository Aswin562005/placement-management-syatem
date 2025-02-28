use placement;

drop table if exists student_status;
drop table if exists student;
drop table if exists department;
drop table if exists announcement;
drop table if exists administrator;
drop table if exists faculty;
drop table if exists feedback;
drop table if exists users;
drop table if exists placement;
drop table if exists company;

create table department(
	dept_id int primary key not null auto_increment,
    dept_name varchar(50) not null
);

create table student(
	stu_rollno int primary key not null,
    stu_name varchar(255) not null,
    dept_id int,
    stu_section enum('A', 'B', 'C', 'D') default 'A',
    stu_dob date,
    stu_mobileno varchar(15),
    stu_email varchar(225) unique,
    stu_batch varchar(50),
    ug_or_pg enum('UG', 'PG'),
    foreign key (dept_id) references department(dept_id)
);

create table company(
	cmp_id int primary key not null auto_increment,
    cmp_name varchar(255) not null,
    cmp_email varchar(255) unique not null,
    cmp_industry varchar(255) not null,
    cmp_location varchar(255) not null
);

create table administrator(
	admin_id int primary key not null auto_increment,
    admin_name varchar(255) not null,
    admin_mobileno varchar(15) unique,
    admin_email varchar(255) unique
);

create table announcement(
	announcement_id int primary key not null auto_increment,
    admin_id int,
    cmp_id int,
    job_role varchar(255),
    salry_pkg varchar(10),
    date_of_visit date,
    venue varchar(255),
    message text,
    foreign key (cmp_id) references company(cmp_id),
    foreign key (admin_id) references administrator(admin_id)
);

create table users(
	email varchar(255),
    password varchar(255),
    type_of_user enum('admin', 'faculty', 'student') default 'student'
);

create table faculty(
	faculty_id int primary key not null auto_increment,
    faculty_name varchar(255) not null,
    faculty_mobileno varchar(15) unique,
    faculty_email varchar(255) unique
);

create table feedback(
	fb_id int primary key not null auto_increment,
    cmp_id int not null,
    student_knowledge int not null default 0,
    student_discipline int not null default 0,
    overall_rating int not null default 0,
    fb_message varchar(255),
    foreign key (cmp_id) references company(cmp_id)
);

create table student_status(
	ss_id int primary key not null auto_increment,
    stu_rollno int,
    cmp_id int,
    status enum('Pending', 'Selected', 'Not Selected'),
    foreign key (stu_rollno) references student(stu_rollno),
    foreign key (cmp_id) references company(cmp_id)
);

create table placement(
	placement_id int primary key not null auto_increment,
    cmp_id int,
    attentees long,
    recruited long,
    foreign key (cmp_id) references company(cmp_id)
);

-- Inserting Department details
insert into department values 
(1, 'BCA'),
(2, 'B.sc(CS)'),
(3, 'B.Com'),
(4, 'B.Com(CA)'),
(5, 'B.sc(IT)'),
(6, 'BBA');

-- Inserting student details
insert into student values
(201, 'dharun', 1, 'B', '2003-10-18', '9856452135', 'dharun@gmail.com', '2022', 'UG'),
(202, 'dhina', 1, 'B', '2003-10-18', '9856451235', 'dhina@gmail.com', '2022', 'UG'),
(203, 'gokul', 1, 'B', '2003-10-18', '9856452153', 'gokul@gmail.com', '2022', 'UG'),
(205, 'hari', 1, 'B', '2003-10-18', '9854652135', 'hari@gmail.com', '2022', 'UG'),
(206, 'kabil', 1, 'B', '2003-10-18', '8956452135', 'kabil@gmail.com', '2022', 'UG'),
(207, 'karthickraja', 1, 'B', '2003-10-18', '9856425135', 'karthickraja@gmail.com', '2022', 'UG'),
(208, 'karthickeyan', 1, 'B', '2003-10-18', '9854652135', 'karthickeyan@gmail.com', '2022', 'UG'),
(209, 'krisnan', 1, 'B', '2003-10-18', '9586452135', 'krisnan@gmail.com', '2022', 'UG'),
(210, 'monish', 1, 'B', '2003-10-18', '8564521359', 'monish@gmail.com', '2022', 'UG');

