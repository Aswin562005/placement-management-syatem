<?php
session_start();
$login_email = $_SESSION['login_user_email'];
if(!isset($login_email) || empty($login_email))
{
    header("location: ../auth/index.php");
    exit;
}
?>