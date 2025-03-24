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
    <?php $title='Announcement'; include '../include/header.php' ?>
    <link rel="stylesheet" href="css/style.css" />

<body>
    <?php include '../include/sidebar.php'; ?>
    
    <div class="main-content">
        <header>
            <h1>Announcements</h1>
        </header>

        <div class="row">
            <?php
                $currentDate = date('Y') . '-' . date('m'). '-' . date('d');
                $announcement_query = "SELECT an.*, c.* FROM announcement AS an JOIN company AS c ON an.cmp_id=c.cmp_id WHERE date_of_visit >= '$currentDate';";
                $result = $conn->query($announcement_query);
                $student_result = $conn->query("SELECT stu_rollno FROM student WHERE stu_email = '$login_email';")->fetch_assoc();

                function displayAnnouncement($conn, $row, $student_result) {
                    $query = "SELECT * FROM student_applications WHERE announcement_id = '{$row['announcement_id']}' AND stu_rollno = '{$student_result['stu_rollno']}';";
                    $result = $conn->query($query);

                    return "
                            <div class='col-6'>
                                <div class='card announcement-card shadow'>
                                    <div class='card-header announcement-header'>
                                        <h3>{$row['cmp_name']} <span class='fs-5'>( {$row['job_role']} )</span></h3>
                                        <small>Posted on: {$row['post_date']}</small>
                                    </div>
                                    <div class='card-body'>
                                        <p class='card-text'>Date of visit : {$row['date_of_visit']}</p>
                                        <p class='card-text'>Venue : {$row['venue']}</p> 
                                        <p>Eligible Criteria : {$row['eligible_criteria']}</p>" .
                                        ($row['message'] || $row['salary_pkg'] ? "
                                            <div class='collapse' id='collapseExample-{$row['announcement_id']}'>".
                                                ($row['salary_pkg'] ? "<p class='card-text'>Salary Package : {$row['salary_pkg']}</p>" : "") . 
                                                ($row['message'] ? "<p class='card-text'>Description : {$row['message']}</p>" : "") .
                                            "</div>" : "").
                                    "</div>
                                    <div class='card-footer announcement-footer'>".
                                    ($row['message'] || $row['salary_pkg'] ? "
                                            <a data-bs-toggle='collapse' href='#collapseExample-{$row['announcement_id']}' role='button'>More details</a>
                                        " : "" ).
                                        ($result->num_rows > 0 ? "<a href='#' class='btn btn-primary btn-sm'>Registered</a>"
                                        :"<a href='/placement-management-syatem/placement/register.php?announcement={$row['announcement_id']}' class='btn btn-primary btn-sm entroll-btn'>Entroll Now</a>"
                                        ).
                                    "</div>
                                </div>
                            </div>";
                }

                while ($row = $result->fetch_assoc()) {
                    $fetch_query = "SELECT s.*,d.dept_name FROM student AS s JOIN department AS d ON s.dept_id = d.dept_id WHERE stu_rollno = '{$student_result['stu_rollno']}';";
                    $dept_name = $conn->query($fetch_query)->fetch_assoc()['dept_name'];
                    $eligible_departments = explode(',', $row['eligible_criteria']);
                    for($i=0; $i<count($eligible_departments); $i++){
                        if((strtolower($eligible_departments[$i]) == 'all') || (strtolower($dept_name) == strtolower($eligible_departments[$i]))) {
                            echo displayAnnouncement($conn, $row, $student_result);
                            break; 
                        }
                    }
                }
            ?>

        </div>
    </div>

</body>
</html>
