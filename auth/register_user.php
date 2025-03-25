<?php
include '../db/config.php';

function handleException($message) {
  echo json_encode(['error' => $message]);
  exit();
}

function respond($message) {
  echo json_encode(["status" => "success", "message" => $message]);
  exit;
}

function executeQuery($conn, $sql, $params, $types) {
  $stmt = $conn->prepare($sql);
  if (!$stmt) handleException("System error! Please try again later.");
  
  $stmt->bind_param($types, ...$params);
  if (!$stmt->execute()) {
    handleException("Unexpected error! Please try again.");
  }
  return $stmt;
}

function hashPassword($password) {
  return password_hash($password, PASSWORD_BCRYPT);
}

function checkStudentEmail($conn, $email_id) {
  $check_query = "SELECT * FROM student WHERE stu_email = '$email_id'";
  $check_result = $conn->query($check_query);
  return $check_result->fetch_assoc();
}

function checkUserEmail($conn, $email_id) {
  $check_query = "SELECT * FROM users WHERE email = '$email_id'";
  $check_result = $conn->query($check_query);
  return $check_result->fetch_assoc();
}

function registerUser($conn, $email_id, $password, $type_of_user) {
  $insert_query = "INSERT INTO users (email, password_, type_of_user) VALUES ('$email_id', '$password', '$type_of_user')";
  if ($conn->query($insert_query)) {
    respond('Registered Successfully...');
  }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['signup_user'])) {
  try {
    $email_id = $_POST['register_email'];
    $password = hashPassword($_POST['register_password']); // Hash the password
    $type_of_user = "Student";

    $check_row = checkStudentEmail($conn, $email_id);
    if($check_row){
      $user_row = checkUserEmail($conn, $email_id);
      if($user_row) {
        respond('Already registered with this email.');
      } else {
        registerUser($conn, $email_id, $password, $type_of_user);
      }
    } else {
      respond('Please enter a valid Email ID');
    }
    $conn->close();
  }
  catch (Exception $e) {
    handleException($e->getMessage());
  }
  exit(); // Ensure no further output is sent
}
?>
