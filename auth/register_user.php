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
  $check_query = "SELECT * FROM student WHERE stu_email = ?";
  $stmt = $conn->prepare($check_query);
  if (!$stmt) throw new Exception("System error! Please try again later.");
  
  $stmt->bind_param('s', $email_id);
  if (!$stmt->execute()) {
    throw new Exception("Unexpected error! Please try again.");
  }

  $check_result = $stmt->get_result();
  return $check_result->fetch_assoc();
}

function checkUserEmail($conn, $email_id) {
  $check_query = "SELECT * FROM users WHERE email = ?";
  $stmt = $conn->prepare($check_query);
  if (!$stmt) throw new Exception("System error! Please try again later.");
  
  $stmt->bind_param('s', $email_id);
  if (!$stmt->execute()) {
    throw new Exception("Unexpected error! Please try again.");
  }

  $check_result = $stmt->get_result();
  return $check_result->fetch_assoc();
}

function registerUser($conn, $email_id, $password, $type_of_user) {
  $insert_query = "INSERT INTO users (email, password_, type_of_user) VALUES (?, ?, ?)";
  $stmt = $conn->prepare($insert_query);
  if (!$stmt) throw new Exception("System error! Please try again later.");
  $stmt->bind_param("sss", $email_id, $password, $type_of_user);

  if ($stmt->execute()) {
    respond('Registered Successfully...');
  } else {
    throw new Exception("Unexpected error! Please try again.");
  }
  $stmt->close();
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
