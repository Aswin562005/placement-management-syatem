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
    $name = validate_input($_POST['name']);
    $email = validate_input($_POST['email']);
    $industry = validate_input($_POST['industry']);
    $location = validate_input($_POST['location']);

    $sql = "INSERT INTO company (cmp_name, cmp_email, cmp_industry, cmp_location) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception("System error! Please try again later.");
    }

    $stmt->bind_param("ssss", $name, $email, $industry, $location);

    if ($stmt->execute()) {
        respond("success", "Company added successfully!");
    } else {
        throw new Exception("Unexpected error! Please try again.");
    }
    $stmt->close();
}

function handle_view($conn) {
    $id = validate_input($_POST['id']);
    $view_company_query = "SELECT * FROM company WHERE cmp_id = ?";
    $stmt = $conn->prepare($view_company_query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    echo "
        <p><strong>Company Id : </strong> {$row['cmp_id']}</p>
        <p><strong>Company Name : </strong> {$row['cmp_name']}</p>
        <p><strong>Company Email : </strong> {$row['cmp_email']}</p>
        <p><strong>Industry : </strong> {$row['cmp_industry']}</p>
        <p><strong>Location : </strong> {$row['cmp_location']}</p>
    ";
    $stmt->close();
}

function handle_edit($conn) {
    $id = validate_input($_POST['id']);
    $name = validate_input($_POST['name']);
    $email = validate_input($_POST['email']);
    $industry = validate_input($_POST['industry']);
    $location = validate_input($_POST['location']);

    $sql = "UPDATE company SET cmp_name = ?, cmp_email = ?, cmp_industry = ?, cmp_location = ? WHERE cmp_id = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception("System error! Please try again later.");
    }

    $stmt->bind_param("ssssi", $name, $email, $industry, $location, $id);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            respond("success", "Company details updated successfully!");
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
    $sql = "DELETE FROM company WHERE cmp_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
       echo "Company deleted successfully!";
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
            case "view":
                handle_view($conn);
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
