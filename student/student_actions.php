<?php
include '../db/config.php';
try{
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $action = $_POST['action'];

        if ($action == "add") {
            $rollno = $_POST['rollno'];
            $name = $_POST['name'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $dob = $_POST['dob'];
            $gender = $_POST['gender'];
            $department = $_POST['department_id'];
            $section = $_POST['section'];
            $year_of_study = $_POST['year_of_study'];
            $ug_or_pg = $_POST['ug_or_pg'];
            // $address = $_POST['address'];
            // echo "$rollno $name $email $phone $dob $gender $department $section $year_of_study $ug_or_pg";

            // insert into student values(201, 'dharun', 1, 'B', '2003-10-18', '9856452135', 'dharun@gmail.com', '2022', 'UG');

            // $sql = "INSERT INTO student (stu_rollno, stu_name, stu_email, stu_mobileno, stu_dob, dept_id, stu_section, stu_batch, ug_or_pg)
            //         VALUES ('$rollno', '$name', '$email', '$phone', '$dob', '$department', '$section', '$year_of_study', '$ug_or_pg')";

            // if ($conn->query($sql)) {
            //     echo "Student Added Successfully!";
            // } else {
            //     echo "Error: " . $conn->error;
            // }

            $sql = "INSERT INTO student (stu_rollno, stu_name, stu_email, stu_mobileno, stu_dob, dept_id, stu_section, stu_batch, ug_or_pg)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                echo "system";
                throw new Exception("System error! Please try again later.");
            }

            $stmt->bind_param("sssssisss", $rollno, $name, $email, $phone, $dob, $department, $section, $year_of_study, $ug_or_pg);

            if (!$stmt->execute()) {
                if ($conn->errno == 1062) { 
                    throw new Exception("Error: This Roll Number already exists! Please enter a unique Roll Number.");
                } elseif ($conn->errno == 1452) { 
                    throw new Exception("Error: Selected Department does not exist.");
                } else { 
                    throw new Exception("Unexpected error! Please try again.");
                }
            }
            echo json_encode(["status" => "success", "message" => "Student added successfully!"]);
            $stmt->close();
        }

        elseif ($action == "view") {
            $rollno = $_POST['rollno'];
            $view_student_query = "select s.*, d.dept_name from student as s join department as d on s.dept_id = d.dept_id where s.stu_rollno = $rollno;";
            $result = $conn->query($view_student_query);
            $row = $result->fetch_assoc();
            echo "
                <p><strong>Roll No : </strong> {$row['stu_rollno']}</p>
                <p><strong>Name : </strong> {$row['stu_name']}</p>
                <p><strong>Department : </strong> {$row['dept_name']}</p>
                <p><strong>Section : </strong> {$row['stu_section']}</p>
                <p><strong>DOB : </strong> {$row['stu_dob']}</p>
                <p><strong>Email : </strong> {$row['stu_email']}</p>
                <p><strong>Mobileno : </strong> {$row['stu_mobileno']}</p>
                <p><strong>UG or PG : </strong> {$row['ug_or_pg']}</p>
                <p><strong>Batch : </strong> {$row['stu_batch']}</p>
                ";
        } 

        elseif ($action == "edit") {
            $rollno = $_POST['rollno'];
            $name = $_POST['name'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $dob = $_POST['dob'];
            $gender = $_POST['gender'];
            $department = $_POST['department_id'];
            $section = $_POST['section'];
            $year_of_study = $_POST['year_of_study'];
            $ug_or_pg = $_POST['ug_or_pg'];

            $sql = "UPDATE students SET stu_name=?, stu_email=?, stu_mobileno=?, stu_dob=?, dept_id=?, stu_section=?, stu_batch=?, ug_or_pg=? WHERE stu_rollno=?";
            $stmt = $conn->prepare($sql);

            if (!$stmt) {
                throw new Exception("System error! Please try again later.");
            }

            $stmt->bind_param("ssssissss", $name, $email, $phone, $dob, $department, $section, $year_of_study, $ug_or_pg, $rollno);

            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    echo json_encode(["status" => "success", "message" => "Student details updated successfully!"]);
                } else {
                    throw new Exception("No changes made or student not found.");
                }
            } else {
                throw new Exception("Error updating student. Please try again.");
            }

            $stmt->close();
        }
        
        elseif ($action == "delete") {
            $rollno = $_POST['rollno'];
            $sql = "DELETE FROM student WHERE stu_rollno = $rollno;";

            if ($conn->query($sql)) {
                echo "Student Deleted Successfully!";
            } else {
                echo "Error: " . $conn->error;
            }
        }
    }
}
catch (Exception $e) {
    error_log("Error: " . $e->getMessage());
    // Show user-friendly error message
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
$conn->close();
?>
