<?php
$host = "localhost";
$user = "root";  // Change according to your DB credentials
$password = "";  // Add your database password if required
$database = "placement";  // Your database name

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
