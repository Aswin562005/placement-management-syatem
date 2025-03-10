<?php
if(isset($_POST['signup_user']))
{    
  $email_id = $_POST['register_email'];
  $password_ = $_POST['register_password'];

  $check_query = "SELECT * FROM student WHERE stu_email = ?";

  $stmt = $conn->prepare($check_query);

  if (!$stmt) handleException("System error! Please try again later.");
  $stmt->bind_param('s', $email_id);
  if ($stmt->num_rows > 0) {
    # code...
  }
  echo $stmt->num_rows > 0;
}
?>