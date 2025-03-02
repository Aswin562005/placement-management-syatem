<<<<<<< HEAD
<?php
    $servername='localhost';
    $username='root';
    $password='';
    $dbname = "placement";
    $conn=mysqli_connect($servername,$username,$password,$dbname);
      if(!$conn)
      {
          die('Could not Connect MySql Server:' .mysql_error());
      }
=======
<?php
    $servername='localhost';
    $username='root';
    $password='';
    $dbname = "placement";
    $conn=mysqli_connect($servername,$username,$password,$dbname);
      if(!$conn)
      {
          die('Could not Connect MySql Server:' .mysql_error());
      }
>>>>>>> 1318045c0f052f89848fb4af1517e0deb13ee23c
?>