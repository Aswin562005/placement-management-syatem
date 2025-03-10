<?php
session_start();
if(!isset($_SESSION['login_user_email']) || empty($_SESSION['login_user_email']))
{
    header("location: ../auth/index.php");
    exit;
}
?>