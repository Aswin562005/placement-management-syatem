<?php
    session_start();
    if (isset($_SESSION['login_user_email'])) {
        if ($_SESSION['user_type'] == "admin") {
            echo "<script>alert('You are already logged in as an admin')</script>";
            header("location: ../admin/dashboard.php");
        } elseif ($_SESSION['user_type'] == "student") {
            echo "<script>alert('You are already logged in as a student')</script>";
            header("location: ../student/dashboard.php");
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
    <?php //$title='Register & Login'; include '../include/header.php' ?>
    <link rel="stylesheet" href="./css/Login.css" />
    <script
     src="https://kit.fontawesome.com/64d58efce2.js"
     crossorigin="anonymous"></script>
<script src="../js/jquery-3.7.1.min.js"></script>


 <body>
  <div class="container">
   <div class="forms-container">
    <div class="signin-signup">

     <?php include 'register.php' ?>
     
     <?php include 'login.php' ?>
     
    </div>
   </div>
   <div class="panels-container">
    <div class="panel left-panel">
     <div class="content">
      <h3>Want to Register?</h3>
      <p>
       Click the Sign up button to register
      </p>
      <button class="btn transparent" id="sign-up-btn">Sign up</button>
     </div>
     <img src="img/log.svg" class="image" alt="" />
    </div>
    <div class="panel right-panel">
     <div class="content">
      <h3>Already have an account?</h3>
      <p>
       Click the log in Button
      </p>
      <button class="btn transparent" id="sign-in-btn">Sign in</button>
     </div>
     <img src="img/register.svg" class="image" alt="" />
    </div>
   </div>
  </div>
  <script src="./js/Login.js"></script>
 </body>
</html>
