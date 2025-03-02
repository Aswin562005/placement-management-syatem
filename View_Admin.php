<?php 
session_start();
include_once 'connect.php';
$query = "select * from Administrator;";
$fty_result = mysqli_query($conn,$query);
?>
<!DOCTYPE html>
<html>
<head>
<title>View Admin</title>
<link rel="stylesheet" href="View_admin.css">
</head>
<body>
<h2 style="text-align: center;font-family: cursive;font-size: 40px;color: rgb(241, 206, 7);background-color: rgb(146, 21, 17);margin-top: -5px">Placement Management System</h1><br><br>
    <div style="text-align: right;margin-top: -110px;margin-right: 140px;font-size: 22px;font-weight: bold;color: white;"><a href="javascript:history.back()" style="color: white;" onclick="window.alert('You will be navigated to dashboard')">Dashboard</a></div>
    <div style="text-align: right;margin-top: -26px;margin-right: 40px;font-size: 22px;font-weight: bold;color: white;"><a href="login.html" style="color: white;" onclick="window.alert('You will be logged out of the system')">Logout</a></div>
    <?php
        $html = "<table class='htmltable'>";

        $html.="<tr> <th>Admin ID</th> <th>Name</th> <th>Email ID</th> <th>Phone no</th> </tr>";

        while($row = mysqli_fetch_row($fty_result))
        {
            $html.="<tr>";
            $html .= "<td>" . $row[0] . "</td>"; 
            $html .= "<td>" . $row[3] . "</td>"; 
            $html .= "<td>" . $row[1] . "</td>";
            $html .= "<td>" . $row[2] . "</td>";
            $html .= "</tr>";
        }
        $html .= "</table>";

        echo $html;

    ?>
</body>
</html>