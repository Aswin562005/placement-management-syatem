use placement;

drop table if exists student_applications;
drop table if exists student_status;
drop table if exists users;
drop table if exists announcement;
drop table if exists administrator;
drop table if exists company;
drop table if exists student;
drop table if exists department;

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
    stu_gender enum('Male', 'Female', 'Others'),
    stu_address text,
    stu_mobileno varchar(15),
    stu_email varchar(225) unique,
    cgpa float,
    stu_batch varchar(50),
    ug_or_pg enum('UG', 'PG'),
    stu_cv varchar(255),
   
    foreign key (dept_id) references department(dept_id)
);

create table company(
	cmp_id int primary key not null auto_increment,
    cmp_name varchar(255) not null,
    cmp_email varchar(255) unique not null,
    cmp_industry varchar(255) not null,
    cmp_location varchar(255) not null,
    cmp_website varchar(255)
);

create table administrator(
	admin_id int primary key not null auto_increment,
    admin_name varchar(255) not null,
    admin_mobileno varchar(15) unique,
    admin_email varchar(255) unique,
    admin_dob date,
    admin_gender enum('Male', 'Female', 'Others')
);

create table announcement(
	announcement_id int primary key not null auto_increment,
    admin_id int not null,
    cmp_id int not null,
    job_role varchar(255),
    salary_pkg varchar(10),
    date_of_visit date not null,
    venue varchar(255) not null,
    eligible_criteria text not null,
    message text,
    post_date timestamp default current_timestamp not null,
    foreign key (cmp_id) references company(cmp_id),
    foreign key (admin_id) references administrator(admin_id)
);

create table users(
	email varchar(255),
    password_ varchar(255),
    type_of_user enum('admin', 'faculty', 'student') default 'student'
);

create table student_applications(
	ri_id int primary key not null auto_increment,
	stu_rollno int not null,
    stu_mobileno varchar(15),
    stu_email varchar(225),
    announcement_id int not null,
    stu_status enum('Pending', 'Selected', 'Not Selected') not null default 'Pending',
    applied_on timestamp default current_timestamp not null,
    foreign key (announcement_id) references announcement(announcement_id),
    foreign key (stu_rollno) references student(stu_rollno)
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
(201, 'dharun', 1, 'B', '2003-10-18','Male','Thirumangalam' ,'9856452135', 'dharun@gmail.com', '2022', 'UG',null,7.3),
(202, 'dhina', 1, 'B', '2003-10-18', 'Male','Thirumangalam' ,'9856451235', 'dhina@gmail.com', '2022', 'UG',null,8.2),
(203, 'gokul', 1, 'B', '2003-10-18','Male','Thirumangalam' , '9856452153', 'gokul@gmail.com', '2022', 'UG',null,6.3),
(205, 'hari', 1, 'B', '2003-10-18', 'Male','Thirumangalam' ,'9854652135', 'hari@gmail.com', '2022', 'UG',null,5.2),
(206, 'kabil', 1, 'B', '2003-10-18','Male','Thirumangalam' , '8956452135', 'kabil@gmail.com', '2022', 'UG',null,10.0),
(207, 'karthickraja', 1, 'B', '2003-10-18', 'Male','Thirumangalam' ,'9856425135', 'karthickraja@gmail.com', '2022', 'UG',null,9.8),
(208, 'karthickeyan', 1, 'B', '2003-10-18','Male','Thirumangalam' , '9854652135', 'karthickeyan@gmail.com', '2022', 'UG',null,9.2),
(209, 'krisnan', 1, 'B', '2003-10-18','Male','Thirumangalam' , '9586452135', 'krisnan@gmail.com', '2022', 'UG',null,8.9),
(210, 'monish', 1, 'B', '2003-10-18','Male','Thirumangalam' , '8564521359', 'monish@gmail.com', '2022', 'UG',null,6.7),
(101, 'dharun', 3, 'B', '2003-10-18','Male','Thirumangalam' ,'9856352135', 'dharun1@gmail.com', '2022', 'UG',null,8.3),
(102, 'dhina', 3, 'B', '2003-10-18', 'Male','Thirumangalam' ,'9856251235', 'dhina2@gmail.com', '2022', 'UG',null,6.5);

-- Inserting company details
insert into company values
(1, 'TCS', 'tcs@gmail.com', 'Software & hardware', 'chennai','https://www.tcs.com'),
(2, 'CVP', 'cvp@gmail.com', 'hardware', 'kovai','https://www.cvp.com'),
(3, 'KGIS', 'kgis@gmail.com', 'non-IT', 'kovai','https://www.kgis.com'),
(4, 'ZOHO', 'zoho@gmail.com', 'Software', 'chennai','https://www.zoho.com'),
(5, 'SPIC', 'spic@gmail.com', 'chymistry', 'chennai','https://www.SPIC.com');

-- Inserting admin 
insert into administrator values
(1, 'admin1', '9867032530', 'admin1@gmail.com', '2025-03-12', 'Male'),
(2, 'admin2', '9867032503', 'admin2@gmail.com', '2025-03-12', 'Female');

-- Inserting announcements 
insert into announcement (announcement_id, admin_id, cmp_id, job_role, salary_pkg, date_of_visit, venue, eligible_criteria, message) values
(1, 1, 1, 'Front-end web developer', '3LPA', '2025-05-02', 'Madurai', 'BCA', 'Demo Message'),
(2, 1, 1, 'Back-end web developer', '4.5LPA', '2025-05-02', 'Madurai', 'all', 'Demo Message'),
(3, 1, 2, 'Worker', '3LPA', '2025-05-02', 'Madurai', 'BCA,B.com', 'Demo Message'),
(4, 1, 3, 'Sales', '3LPA', '2025-05-02', 'Madurai', 'B.com,B.sc(IT)', 'Demo Message'),
(5, 1, 5, 'Production', '3LPA', '2025-05-02', 'Madurai', 'B.com,B.sc(IT), BBA', 'Demo Message');

insert into users values
('admin1@gmail.com', '$2y$10$RYzFjnj1fiYIgm1j4JO3BOiP37k10l2StRDsQIGQNYxF61wlruHJC', 'admin'),
('admin2@gmail.com', '$2y$10$RYzFjnj1fiYIgm1j4JO3BOiP37k10l2StRDsQIGQNYxF61wlruHJC', 'admin'); 
