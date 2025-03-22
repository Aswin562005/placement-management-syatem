<?php
include '../db/config.php';

function respond($status, $message) {
    echo json_encode(["status" => $status, "message" => $message]);
    exit;
}

function validate_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $announcement_id = $_POST['announcement'];
        $rollno = $_POST['rollno'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];

        $check_query = "SELECT * FROM student_applications WHERE announcement_id = '$announcement_id' AND stu_rollno = '$rollno';";
        $result = $conn->query($check_query);
        if ($result->num_rows > 0) {
            respond('error', 'You are already Registered for this Interview.');
        }

        $query = "INSERT INTO student_applications (announcement_id, stu_rollno, stu_email, stu_mobileno) VALUES ('$announcement_id', '$rollno', '$email', '$phone');";
        if($conn->query($query)){
            respond('success', 'Registered Successfully.');
        }
    }
} catch (Exception $e) {
    respond("error", $e->getMessage());
}

$conn->close();
?>
