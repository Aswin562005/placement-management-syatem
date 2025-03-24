<?php 
include '../db/config.php';

function validate_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $announcement_id = $_POST['announcement_id'];
        $results = $_POST['results'];

        foreach ($results as $stu_rollno => $result) {
            $result = $result == 'Pending' || $result == 'Not Selected' ? 'Not Selected' : 'Selected';
            $update_query = "UPDATE student_applications SET stu_status = '$result' WHERE announcement_id = '$announcement_id' AND stu_rollno = '$stu_rollno'";
            
            $response = $conn->query($update_query);
        }

        if($response) {
            echo "<script>alert('Successfully Updated.');</script>";
            header("location: student_applications.php?announcement={$announcement_id}");
        }

    }
} catch (Exception $e) {
    handleException($e);
}

$conn->close();
?>