<?php 
session_start();
include_once 'connect.php';
$query = "SELECT a.admin_name, a.ADMIN_PHONE_NO, an.date_of_visit, an.message from announcement as an join administrator as a on an.admin_id = a.admin_id order by an.date_of_visit desc;";
$fty_result = mysqli_query($conn,$query);
?>
<!DOCTYPE html>
<html>
<head>
<title>View Announcement</title>
<link rel="stylesheet" href="View_announcement.css">
</head>
<body>
<h2 style="text-align: center;font-family: cursive;font-size: 40px;color: rgb(241, 206, 7);background-color: rgb(146, 21, 17);margin-top: -5px">Placement Management System</h1><br><br>
    <div style="text-align: right;margin-top: -110px;margin-right: 140px;font-size: 22px;font-weight: bold;color: white;"><a href="javascript:history.back()" style="color: white;" onclick="window.alert('You will be navigated to dashboard')">Dashboard</a></div>
    <div style="text-align: right;margin-top: -26px;margin-right: 40px;font-size: 22px;font-weight: bold;color: white;"><a href="login.html" style="color: white;" onclick="window.alert('You will be logged out of the system')">Logout</a></div>
    <?php
        $html = "<table class='htmltable'>";

        $html.="<tr> <th>Admin Name</th> <th>Admin Phone No</th> <th>Date of Announcement</th> <th>Announcement Description</th> </tr>";

        while($row = mysqli_fetch_row($fty_result))
        {
            $html.="<tr>";
            for($x = 0;$x<4;$x++)
            { $html .= "<td>" . $row[$x] . "</td>"; }
            $html .= "</tr>";
        }
        $html .= "</table>";

        echo $html;

    ?>
</body>
</html>