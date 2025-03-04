<?php
include '../db/config.php';

function respond($status, $message) {
    echo json_encode(["status" => $status, "message" => $message]);
    exit;
}

function validate_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

function handle_add($conn) {
    $admin_id = validate_input($_POST['admin_id']);
    $cmp_id = validate_input($_POST['company_id']);
    $date_of_visit = validate_input($_POST['date_of_visit']);
    $venue = validate_input($_POST['venue']);
    $job_role = validate_input($_POST['job_role']);
    $salary_pkg = validate_input($_POST['salary_pkg']);
    $description = validate_input($_POST['description']);


    $sql = "INSERT INTO announcement (admin_id, cmp_id, date_of_visit, venue, job_role, salary_pkg, message) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception("System error! Please try again later.");
    }

    $stmt->bind_param("iisssss", $admin_id, $cmp_id, $date_of_visit, $venue, $job_role, $salary_pkg, $description);

    if ($stmt->execute()) {
        respond("success", "Announcement Post successfully!");
    } else {
        throw new Exception("Unexpected error! Please try again.");
    }
    $stmt->close();
}

function handle_edit($conn) {
    $id = validate_input($_POST['id']); 
    $admin_id = validate_input($_POST['admin_id']);
    $cmp_id = validate_input($_POST['company_id']);
    $date_of_visit = validate_input($_POST['date_of_visit']);
    $venue = validate_input($_POST['venue']);
    $job_role = validate_input($_POST['job_role']);
    $salary_pkg = validate_input($_POST['salary_pkg']);
    $description = validate_input($_POST['description']);

    $sql = "UPDATE announcement SET admin_id = ?, cmp_id = ?, date_of_visit = ?, venue = ?, job_role = ?, salary_pkg = ?, message =? WHERE announcement_id = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception("System error! Please try again later.");
    }

    $stmt->bind_param("iisssssi", $admin_id, $cmp_id, $date_of_visit, $venue, $job_role, $salary_pkg, $description, $id);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            respond("success", "Announcement updated successfully!");
        } else {
            throw new Exception("No changes made.");
        }
    } else {
        throw new Exception("Unexpected error! Please try again.");
    }
    $stmt->close();
}

function handle_delete($conn) {
    $id = validate_input($_POST['id']);
    $sql = "DELETE FROM announcement WHERE announcement_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
       echo "Announcement deleted successfully!";
    } else {
        throw new Exception("Error: " . $stmt->error);
    }
    $stmt->close();
}

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $action = validate_input($_POST['action']);

        switch ($action) {
            case "add":
                handle_add($conn);
                break;
            case "edit":
                handle_edit($conn);
                break;
            case "delete":
                handle_delete($conn);
                break;
            default:
                throw new Exception("Invalid action.");
        }
    }
} catch (Exception $e) {
    error_log("Error: " . $e->getMessage());
    respond("error", $e->getMessage());
}

$conn->close();
?>
