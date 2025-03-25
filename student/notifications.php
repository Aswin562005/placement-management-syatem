<?php include '../include/checksession.php'; ?>
<?php 
     if($_SESSION['user_type'] != 'student')
     {
         header("location: ../auth/index.php");
         exit;
     }  
?>
<?php include '../db/config.php'; ?>


<!DOCTYPE html>
<html lang="en">
    <?php $title='Notifications'; include '../include/header.php' ?>
    <style>
        span {
            font-size: 1.2rem;
            font-weight: bold;
        }
        .border-start-danger{
            border-left: 5px solid var(--bs-danger) !important;
        }
        .border-start-danger > span {
            color: var(--bs-danger);
        }
        .border-start-success{
            border-left: 5px solid var(--bs-success) !important;
        }
        .border-start-success > span {
            color: var(--bs-success);
        }
        .border-start-warning{
            border-left: 5px solid var(--bs-warning) !important;
        }
        .border-start-warning > span {
            color: var(--bs-warning);
        }
    </style>
    <body>
        <?php include '../include/sidebar.php'; ?>
        <?php include 'view_student.php'; ?>
        <?php include 'add_student.php'; ?>
        <?php include 'edit_student.php'; ?>
        <div class="main-content">
            <header>
                <h1>Interview Status</h1>
            </header>

            <div class="status">
                <?php
                    $student_result = $conn->query("SELECT stu_rollno FROM student WHERE stu_email = '$login_email';")->fetch_assoc();

                    $query = "SELECT * FROM student_applications AS sa JOIN announcement AS a ON  sa.announcement_id = a.announcement_id JOIN company AS c ON a.cmp_id = c.cmp_id WHERE sa.stu_rollno = '{$student_result['stu_rollno']}';";
                    $result = $conn->query($query);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            if ($row['stu_status'] == 'Pending') {
                                echo "<div class='alert alert-light border-start-warning mt-3'> <span> Pending : </span> {$row['cmp_name']} ( {$row['job_role']} ) and Appilied on : {$row['applied_on']} </div>";
                            } else if ($row['stu_status'] == 'Selected') {
                                echo "<div class='alert alert-light border-start-success mt-3'> <span> Selected : </span> {$row['cmp_name']} ( {$row['job_role']} ) and Appilied on : {$row['applied_on']}  </div>";
                            } else {
                                echo "<div class='alert alert-light border-start-danger mt-3'> <span> Not Selected :</span> {$row['cmp_name']} ( {$row['job_role']} ) and Appilied on : {$row['applied_on']} </div>";
                            }
                        }
                    } else {
                        echo "<p>You are no Interview applied.</p>";
                    }
                ?>
            </div>


        </div>

    </body>
</html>
