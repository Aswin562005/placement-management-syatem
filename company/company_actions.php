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
    $website = validate_input($_POST['website']);

    $check_email_query = "SELECT * FROM company WHERE cmp_email = '$email';";
    if($conn->query($check_email_query)->num_rows > 0){
        respond('success', 'The Company Email is already exist.');
    }

    $sql = "INSERT INTO company (cmp_name, cmp_email, cmp_industry, cmp_location, cmp_website) VALUES ('$name', '$email', '$industry', '$location', '$website');";
    if ($conn->query($sql)) {
        respond("success", "Company added successfully!");
    }
}

function handle_view($conn) {
    $id = validate_input($_POST['id']);
    $view_company_query = "SELECT * FROM company WHERE cmp_id = '$id'";
    $result = $conn->query($view_company_query);
    $row = $result->fetch_assoc();
    echo "
        <p><strong>Company Id : </strong> {$row['cmp_id']}</p>
        <p><strong>Company Name : </strong> {$row['cmp_name']}</p>
        <p><strong>Company Email : </strong> {$row['cmp_email']}</p>
        <p><strong>Industry : </strong> {$row['cmp_industry']}</p>
        <p><strong>Location : </strong> {$row['cmp_location']}</p>
        <p><strong>Website URL : </strong> <a href='{$row['cmp_website']}'>{$row['cmp_name']}</a></p>
    ";
}

function handle_edit($conn) {
    $id = validate_input($_POST['id']);
    $name = validate_input($_POST['name']);
    $email = validate_input($_POST['email']);
    $industry = validate_input($_POST['industry']);
    $location = validate_input($_POST['location']);
    $website = validate_input($_POST['website']);

    $result = $conn->query("SELECT * FROM company WHERE cmp_id='$id';");
    $row = $result->fetch_assoc();
    $old_email = $row['cmp_email'];
    if ($row['cmp_name'] === $name && $old_email === $email && $row['cmp_industry'] === $industry && $row['cmp_location'] === $location && $row['cmp_website'] === $website) {
        respond('success', 'No changes made.');
    }
    if($old_email != $email) {
        $check_email_query = "SELECT * FROM company WHERE cmp_email = '$email';";
        $check__email_result = $conn->query($check_email_query);
    
        if($check__email_result->num_rows != 0){
            respond('success', 'The Company Email is already exist.');
        }
    }

    $sql = "UPDATE company SET cmp_name = '$name', cmp_email = '$email', cmp_industry = '$industry', cmp_location = '$location', cmp_website = '$website' WHERE cmp_id = '$id';";
    if($conn->query($sql)){
        respond("success", "Comapny Details Updated Successfully.");
    }
}

function handle_delete($conn) {
    $id = validate_input($_POST['id']);
    $sql = "DELETE FROM company WHERE cmp_id = '$id'";
    if ($conn->query($sql)) {
        respond("success", "Company deleted successfully!");
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
