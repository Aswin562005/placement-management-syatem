<?php
include '../db/config.php';


function respond($status, $message) {
    echo json_encode(["status" => $status, "message" => $message]);
    exit;
}

function validate_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

function handleException($message) {
    echo json_encode(["status" => "error", "message" => $message]);
    exit();
}

// Add Student 
function handle_add($conn) {
    $rollno = validate_input($_POST['rollno']);
    $name = validate_input($_POST['name']);
    $email =  validate_input($_POST['email']);
    $phone =  validate_input($_POST['phone']); 
    $dob = validate_input($_POST['dob']);
    $gender = validate_input($_POST['gender']);
    $address = validate_input($_POST['address']);
    $dept = validate_input($_POST['department_id']);
    $section =  validate_input($_POST['section']);
    $batch = validate_input($_POST['year_of_study']);
    $ug_or_pg = validate_input($_POST['ug_or_pg']);

    $check_rollno_query = "SELECT * FROM student WHERE stu_rollno = '$rollno';";
    if($conn->query($check_rollno_query)->num_rows > 0) {
        respond("success", "Duplicate Rollno Not Allowed.");
    } 

    $check_email_query = "SELECT * FROM student WHERE stu_email = '$email';";
    if($conn->query($check_email_query)->num_rows > 0){
        respond('success', 'The Student Email is already exist.');
    }
    
    $sql = "INSERT INTO student (stu_rollno, stu_name, stu_email, stu_mobileno, stu_dob, stu_gender, stu_address, dept_id, stu_section, stu_batch, ug_or_pg)
            VALUES ('$rollno', '$name', '$email', '$phone', '$dob', '$gender', '$address', '$dept', '$section', '$batch', '$ug_or_pg')";
    if($conn->query($sql)){
        respond("success", "Student added successfully.");
    }
}

// View Student
function handle_view($conn) {
    $rollno = $_POST['id'];
    $sql = "SELECT s.*, d.dept_name FROM student AS s JOIN department AS d ON s.dept_id = d.dept_id WHERE s.stu_rollno = '$rollno'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    echo "
        <p><strong>Roll No : </strong> {$row['stu_rollno']}</p>
        <p><strong>Name : </strong> {$row['stu_name']}</p>
        <p><strong>Department : </strong> {$row['dept_name']}</p>
        <p><strong>Section : </strong> {$row['stu_section']}</p>
        <p><strong>DOB : </strong> {$row['stu_dob']}</p>
        <p><strong>Gender : </strong> {$row['stu_gender']}</p>
        <p><strong>Email : </strong> {$row['stu_email']}</p>
        <p><strong>Mobileno : </strong> {$row['stu_mobileno']}</p>
        <p><strong>Address : </strong> {$row['stu_address']}</p>
        <p><strong>UG or PG : </strong> {$row['ug_or_pg']}</p>
        <p><strong>Batch : </strong> {$row['stu_batch']}</p>
    ";
}

// Upadate Student
function handle_edit($conn) {
    $rollno = validate_input($_POST['rollno']);
    $name = validate_input($_POST['name']);
    $email =  validate_input($_POST['email']);
    $phone =  validate_input($_POST['phone']); 
    $dob = validate_input($_POST['dob']);
    $gender = validate_input($_POST['gender']);
    $address = validate_input($_POST['address']);
    $dept = validate_input($_POST['department_id']);
    $section =  validate_input($_POST['section']);
    $batch = validate_input($_POST['year_of_study']);
    $ug_or_pg = validate_input($_POST['ug_or_pg']);

    $result = $conn->query("SELECT * FROM student WHERE stu_rollno='$rollno';");
    $row = $result->fetch_assoc();
    $old_email = $row['stu_email'];
    if ($row['stu_name'] === $name && $old_email === $email && $row['stu_mobileno'] === $phone && $row['stu_dob'] === $dob && $row['stu_gender'] === $gender && $row['stu_address'] === $address && $row['dept_id'] === $dept && $row['stu_section'] === $section && $row['stu_batch'] === $batch && $row['ug_or_pg'] === $ug_or_pg) {
        respond('success', 'No changes made.');
    }
    if($old_email != $email) {
        $check_email_query = "SELECT * FROM student WHERE stu_email = '$email';";
        $check__email_result = $conn->query($check_email_query);
    
        if($check__email_result->num_rows != 0){
            respond('success', 'The Student Email is already exist.');
        }
    }

    $sql = "UPDATE student SET stu_name='$name', stu_email='$email', stu_mobileno='$phone', stu_dob='$dob', stu_gender='$gender', stu_address='$address' , dept_id='$dept', stu_section='$section', stu_batch='$batch', ug_or_pg='$ug_or_pg' WHERE stu_rollno='$rollno';";
    if($conn->query($sql)){
        respond("success", "Student Details Updated Successfully.");
    }
}

// Delete Student
function handle_delete($conn) {
    $rollno = $_POST['id'];
    $sql = "DELETE FROM student WHERE stu_rollno = '$rollno'";
    if($conn->query($sql)) {
        respond("success", "Student deleted successfully.");
    }
}

function handle_upload_cv($conn) {
    $targetDir = 'uploads/';
    $rollno = validate_input($_POST['rollno']);
    $cvFileName = basename($_FILES['cv']['name']);
    $targetFilePath = $targetDir . $cvFileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
    if (!empty($_FILES['cv']['name'])) {
        $allowedTypes = array('pdf', 'docx');
        if(in_array($fileType, $allowedTypes)){
            if (move_uploaded_file($_FILES['cv']['tmp_name'], $targetFilePath)) {
                $query = "UPDATE student SET stu_cv = '$targetFilePath' WHERE stu_rollno = '$rollno';";
                if($conn->query($query)) {
                    echo "<script>CV Uploaded Successfully.</script>";
                    header("location: student_personal_details.php");
                }
            } else {
                echo "Upload Erorr ";
            }
        } else {
            echo "Only Allowed pdf ans doc format.";
        }
    }
}

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $action = $_POST['action'];

        switch ($action) {
            case "add":
                handle_add($conn);
                break;

            case "view":
                handle_view($conn);
                break;

            case "edit":
                handle_edit($conn);
                break;

            case "delete":
                handle_delete($conn);
                break;
            
            case 'upload_cv':
                handle_upload_cv($conn);
                break;

            default:
                handleException("Invalid action.");
        }
    }
} catch (Exception $e) {
    handleException($e);
}

$conn->close();
?>
