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
                $currentMonth = date('m');
                $currentYear = date('Y');
                $announcement_query = "SELECT an.*, c.* FROM announcement AS an JOIN company AS c ON an.cmp_id=c.cmp_id WHERE MONTH(an.post_date) = $currentMonth AND YEAR(an.post_date) = $currentYear;";
                $result = $conn->query($announcement_query);

                function displayAnnouncement($row) {
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
                                        "<a href='#' class='btn btn-primary btn-sm entroll-btn'>Entroll Now</a>
                                    </div>
                                </div>
                            </div>";
                }

                while ($row = $result->fetch_assoc()) {
                    $fetch_query = "SELECT d.dept_name FROM student AS s JOIN department AS d ON s.dept_id = d.dept_id;";
                    $dept_name = $conn->query($fetch_query)->fetch_assoc()['dept_name'];
                    $eligible_departments = explode(',', $row['eligible_criteria']);

                    for($i=0; $i<count($eligible_departments); $i++){
                        if(($row['eligible_criteria'] == 'all') || ($dept_name == $eligible_departments[$i])) {
                            echo displayAnnouncement($row);
                            break; 
                        }
                    }

                }
            ?>

        </div>
    </div>

</body>
</html>
