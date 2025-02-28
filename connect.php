<?php
    $servername='localhost';
    $username='root';
    $password='root'; // Ensure this is correct
    $dbname = "placement";
    try {
        // ...existing code...
        $conn= new mysqli($servername, $username, $password, $dbname);
    } catch (\Throwable $th) {
        // ...existing code...
        die('Could not Connect MySql Server:' . $th);
    }
    // ...existing code...
?>