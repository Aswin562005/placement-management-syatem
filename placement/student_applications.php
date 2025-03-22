<?php

    if (!isset($_GET['announcement']) || empty($_GET['announcement'])) {
        header("location: ./index.php");
        exit;        
    }
?>
<?php include '../include/checksession.php'; ?>
<?php 
     if($_SESSION['user_type'] != 'admin')
     {
         header("location: ../auth/index.php");
         exit;
     }  
?>
<?php include '../db/config.php'; ?>
<?php 
    $announcement_id = $_GET['announcement'];
    $sql = "SELECT sa.stu_rollno ,s.stu_name, d.dept_name, sa.stu_email, sa.stu_mobileno FROM student_applications AS sa JOIN student AS s ON sa.stu_rollno = s.stu_rollno JOIN announcement AS a ON sa.announcement_id = a.announcement_id JOIN department AS d ON d.dept_id = s.dept_id WHERE sa.announcement_id = '$announcement_id';";
    $result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<?php $title='Student Applications'; include '../include/header.php' ?>
<link rel="stylesheet" href="css/style.css" />

<body>
    <?php include '../include/sidebar.php'; ?>

    <div class="main-content">
        <header>
            <h1>Student Applications</h1>
        </header>

        <table id="companyTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>RollNO</th>
                    <th>Name</th>
                    <th>Department</th>
                    <th>Email</th>
                    <th>Phone No</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if($result->num_rows > 0){
                    $count = 1;

                    while ($row = $result->fetch_assoc()) {
                        echo "<tr data-cmp-name='{$row['stu_name']}'>
                                <td>{$count}</td>
                                <td>{$row['stu_rollno']}</td>
                                <td style='text-transform: captalize();'>{$row['stu_name']}</td>
                                <td>{$row['dept_name']}</td>
                                <td>{$row['stu_email']}</td>
                                <td>{$row['stu_mobileno']}</td>
                            </tr>";
                        $count++;
                    }
                } else {
                    echo "<tr> <td colspan=6>No Students are registered.</td> </tr>"; 
                }
                ?>
            </tbody>
        </table>

    </div>

    <script src="../js/global.js"></script>
</body>
</html>