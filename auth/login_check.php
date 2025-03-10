<?php
include '../db/config.php';

session_start();
if(isset($_POST['login_user']))
{ 
    $myemail = mysqli_real_escape_string($conn,$_POST['user_email']);
    $password = mysqli_real_escape_string($conn,$_POST['user_password']);
     
    $sql = "SELECT email, password_, type_of_user FROM users WHERE email = '$myemail'";

    $result = mysqli_query($conn,$sql);
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);

    $count = mysqli_num_rows($result);

    if($count == 1 && password_verify($password, $row['password_'])) 
    {   
        $usertype = $row['type_of_user'];
        $_SESSION['login_user_email'] = $myemail;
        $_SESSION['user_type'] = $usertype;

        if($usertype == "admin")
            echo json_encode(['status' => 'success', 'redirect' => '../admin/dashboard.php', 'message' => 'Login Successful']); 
        elseif ($usertype == "student")
            echo json_encode(['status' => 'success', 'redirect' => '../student/dashboard.php', 'message' => 'Login Successful']);
    }
    else 
    {
        echo json_encode(['status' => 'error', 'message' => 'Invalid Credentials. Try Again.']);
    }

    mysqli_close($conn);
}
?>