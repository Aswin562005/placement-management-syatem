<?php include '../include/checksession.php'; ?>
<?php 
     if($_SESSION['user_type'] != 'student')
     {
         header("location: ../auth/index.php");
         exit;
     }  
?>