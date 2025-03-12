<?php
include '../db/config.php';

function respond($status, $message) {
    echo json_encode(["status" => $status, "message" => $message]);
    exit;
}

function validate_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

function hashPassword($password) {
    return password_hash($password, PASSWORD_BCRYPT);
}

function handle_add($conn) {
    $name = validate_input($_POST['name']);
    $dob = validate_input($_POST['dob']);
    $email = validate_input($_POST['email']);
    $phone = validate_input($_POST['phone']);
    $gender = validate_input($_POST['gender']);
    $password = hashPassword($dob);
    $type_of_user = 'Admin';

    $insert_administrtor_query = "INSERT INTO administrator (admin_name, admin_email, admin_mobileno, admin_dob, admin_gender) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insert_administrtor_query);

    if (!$stmt) {
        throw new Exception("System error! Please try again later.");
    }

    $stmt->bind_param("sssss", $name, $email, $phone, $dob, $gender);

    if (!$stmt->execute()) throw new Exception("Unexpected error! Please try again.");
    
    $insert_admin_query = "INSERT INTO users (email, password_, type_of_user) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($insert_admin_query);

    if (!$stmt) throw new Exception("System error! Please try again later.");

    $stmt->bind_param("sss", $email, $password, $type_of_user);
    if($stmt->execute()){
        respond("success", "Admin created successfully!");
    } else {
        throw new Exception("Unexpected error! Please try again.");
    }

    $stmt->close();
}

function handle_view($conn) {
    $id = validate_input($_POST['id']);
    $view_admin_query = "SELECT * FROM administrator WHERE admin_id = ?";
    $stmt = $conn->prepare($view_admin_query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    echo "
        <p><strong>Admin Name : </strong> {$row['admin_name']}</p>
        <p><strong>Date Of Birth : </strong> {$row['admin_dob']}</p>
        <p><strong>Admin Email : </strong> {$row['admin_email']}</p>
        <p><strong>Admin Phone No : </strong> {$row['admin_mobileno']}</p>
        <p><strong>Gender : </strong> {$row['admin_gender']}</p>
    ";
    $stmt->close();
}

function handle_edit($conn) {
    $id = validate_input($_POST['id']);
    $name = validate_input($_POST['name']);
    $email = validate_input($_POST['email']);
    $industry = validate_input($_POST['industry']);
    $location = validate_input($_POST['location']);
    $website = validate_input($_POST['website']);
    

    $sql = "UPDATE company SET cmp_name = ?, cmp_email = ?, cmp_industry = ?, cmp_location = ?, cmp_website = ? WHERE cmp_id = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception("System error! Please try again later.");
    }

    $stmt->bind_param("sssssi", $name, $email, $industry, $location, $website ,$id);

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

    $fetch_admin_query = "SELECT * FROM administrator where admin_id=?";
    $stmt = $conn->prepare($fetch_admin_query);

    if (!$stmt) throw new Exception("System error! Please try again later.");

    $stmt->bind_param("s", $id);

    if(!$stmt->execute()) throw new Exception("Unexpected error! Please try again.");

    $result = $stmt->get_result();
    if($result) {
        $row = $result->fetch_assoc();
        if($row) {
            $delete_user_query = "DELETE FROM users WHERE email=?;";
            $stmt = $conn->prepare($delete_user_query);

            if (!$stmt) throw new Exception("System error! Please try again later.");

            $stmt->bind_param("s", $row['admin_email']);

            if(!$stmt->execute()) throw new Exception("Unexpected error! Please try again.");
        }
    }

    $sql = "DELETE FROM administrator WHERE admin_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
       echo "Admin removed successfully!";
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
                // handle_edit($conn);
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
