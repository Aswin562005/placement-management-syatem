<?php
include '../db/config.php';

function handleException($message) {
    error_log("Error: " . $message);
    echo json_encode(["status" => "error", "message" => $message]);
    exit();
}

function executeQuery($conn, $sql, $params, $types) {
    $stmt = $conn->prepare($sql);
    if (!$stmt) handleException("System error! Please try again later.");
    
    $stmt->bind_param($types, ...$params);
    if (!$stmt->execute()) {
        if ($conn->errno == 1062) handleException("This Roll Number already exists! Please enter a unique Roll Number.");
        handleException("Unexpected error! Please try again.");
    }
    return $stmt;
}

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $action = $_POST['action'];
        $rollno = $_POST['rollno'];

        switch ($action) {
            case "add":
                $params = [
                    $_POST['rollno'], $_POST['name'], $_POST['email'], $_POST['phone'], 
                    $_POST['dob'], $_POST['gender'],$_POST['address'],$_POST['department_id'], $_POST['section'], 
                    $_POST['year_of_study'], $_POST['ug_or_pg']
                ];
                $sql = "INSERT INTO student (stu_rollno, stu_name, stu_email, stu_mobileno, stu_dob,stu_gender,stu_address, dept_id, stu_section, stu_batch, ug_or_pg)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = executeQuery($conn, $sql, $params, "sssssisss");
                echo json_encode(["status" => "success", "message" => "Student added successfully!"]);
                $stmt->close();
                break;

            case "view":
                $sql = "SELECT s.*, d.dept_name FROM student AS s JOIN department AS d ON s.dept_id = d.dept_id WHERE s.stu_rollno = ?";
                $stmt = executeQuery($conn, $sql, [$rollno], "s");
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                echo "
                    <p><strong>Roll No : </strong> {$row['stu_rollno']}</p>
                    <p><strong>Name : </strong> {$row['stu_name']}</p>
                    <p><strong>Department : </strong> {$row['dept_name']}</p>
                    <p><strong>Section : </strong> {$row['stu_section']}</p>
                    <p><strong>DOB : </strong> {$row['stu_dob']}</p>
                    <p><strong>Gender : </strong> {$row['stu_gender']}</p>
                    <p><strong>Address : </strong> {$row['stu_address']}</p>
                    <p><strong>Email : </strong> {$row['stu_email']}</p>
                    <p><strong>Mobileno : </strong> {$row['stu_mobileno']}</p>
                    <p><strong>UG or PG : </strong> {$row['ug_or_pg']}</p>
                    <p><strong>Batch : </strong> {$row['stu_batch']}</p>
        
                ";
                $stmt->close();
                break;

            case "edit":
                $params = [
                    $_POST['name'], $_POST['email'], $_POST['phone'], $_POST['dob'],$_POST['gender'],
                    $_POST['address'], $_POST['department_id'], $_POST['section'], $_POST['year_of_study'], 
                    $_POST['ug_or_pg'], $rollno
                ];
                $sql = "UPDATE student SET stu_name=?, stu_email=?, stu_mobileno=?, stu_dob=?, stu_gender=?,stu_address=?, dept_id=?, stu_section=?, stu_batch=?, ug_or_pg=? WHERE stu_rollno=?";
                $stmt = executeQuery($conn, $sql, $params, "ssssssisss");
                if ($stmt->affected_rows > 0) {
                    echo json_encode(["status" => "success", "message" => "Student details updated successfully!"]);
                } else {
                    handleException("No changes made.");
                }
                $stmt->close();
                break;

            case "delete":
                $sql = "DELETE FROM student WHERE stu_rollno = ?";
                $stmt = executeQuery($conn, $sql, [$rollno], "s");
                echo json_encode(["status" => "success", "message" => "Student deleted successfully!"]);
                $stmt->close();
                break;

            default:
                handleException("Invalid action.");
        }
    }
} catch (Exception $e) {
    handleException($e->getMessage());
}

$conn->close();
?>
