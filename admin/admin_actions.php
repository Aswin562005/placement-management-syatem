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

    $check_email_query = "SELECT * FROM administrator WHERE admin_email = '$email'";
    $check__email_result = $conn->query($check_email_query);

    if($check__email_result->num_rows != 0){
        respond('success', 'The Admin Email is already exist.');
    }

    $conn->begin_transaction();

    try {
        $insert_administrtor_query = "INSERT INTO administrator (admin_name, admin_email, admin_mobileno, admin_dob, admin_gender) VALUES ('$name', '$email', '$phone', '$dob', '$gender')";
        $add_user_query = "INSERT INTO users VALUES ('$email', '$password', '$type_of_user')";
        if ($conn->query($insert_administrtor_query)) {
            if($conn->query($add_user_query)){
                $conn->commit();
                respond('success', 'Admin added successfully');
            } 
        }
    } catch (Exception $e) {
        $conn->rollback();
        respond("error", $e->getMessage());
    }
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
    $dob = validate_input($_POST['dob']);
    $email = validate_input($_POST['email']);
    $phone = validate_input($_POST['phone']);
    $gender = validate_input($_POST['gender']);
    $password = hashPassword($dob);
    
    $fetch_admin_query = "SELECT * FROM administrator WHERE admin_id='$id'";
    $result_admin = $conn->query($fetch_admin_query);
    $row = $result_admin->fetch_assoc();
    $old_admin_email = $row['admin_email'];

    if ($row['admin_name'] === $name && $old_admin_email === $email && $row['admin_mobileno'] ===$phone && $row['admin_gender'] === $gender && $row['admin_dob'] === $dob) {
        respond('success', 'No changes made.');
    }
    if($old_admin_email != $email) {
        $check_email_query = "SELECT * FROM administrator WHERE admin_email = '$email';";
        $check__email_result = $conn->query($check_email_query);
    
        if($check__email_result->num_rows != 0){
            respond('success', 'The Admin Email is already exist.');
        }
    }
    
    $conn->begin_transaction();
    
    try {
        $update_admin_query = "UPDATE administrator SET admin_name = '$name', admin_email = '$email', admin_dob='$dob', admin_mobileno = '$phone', admin_gender = '$gender' WHERE admin_id = '$id'";
        $update_user_query = "UPDATE users SET email = '$email', password_ = '$password' WHERE email='$old_admin_email'";

        if ($conn->query($update_admin_query)) {
            if($conn->query($update_user_query)){
                $conn->commit();
                respond('success', 'Admin updeted successfully');
            } 
        }
    } catch (Exception $e) {
        $conn->rollback();
        respond("error", $e->getMessage());
    }
}

function handle_delete($conn) {
    $id = validate_input($_POST['id']);

    $fetch_admin_query = "SELECT admin_email FROM administrator where admin_id='$id'";
    $result_admin = $conn->query($fetch_admin_query);
    $admin_email = $result_admin->fetch_assoc()['admin_email'];

    $conn->begin_transaction();

    try {
        $delete_user_query = "DELETE FROM users WHERE email='$admin_email';";
        $delete_admin_query = "DELETE FROM administrator WHERE admin_email='$admin_email';";
        if ($conn->query($delete_user_query)) {
            if($conn->query($delete_admin_query)){
                $conn->commit();
                respond('success', 'Admin deleted successfully');
            }
        }
    } catch (Exception $e) {
        $conn->rollback();
        respond("error", $e->getMessage());
    }
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
    respond("error", $e->getMessage());
}

$conn->close();
?>
