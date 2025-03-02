<?php include '../db/config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Announcements | Placement Cell</title>
    <link rel="stylesheet" href="../css/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/sidebar.css" />
    <link rel="stylesheet" href="css/style.css" />
</head>
<body>
    <?php include '../include/sidebar.php'; ?>
    
    <div class="main-content">
        <header>
            <h1>Announcements</h1>
            <div class="header-right">
                <button class="add-btn" data-bs-toggle="modal" data-bs-target="#addStudentModal">Add Announcement</button>
            </div>
        </header>

        <div class="row">

            <?php
                $currentMonth = date('m');
                $currentYear = date('Y');
                $sql = "SELECT * FROM announcement AS an JOIN company AS c ON an.cmp_id=c.cmp_id  WHERE MONTH(an.post_date) = $currentMonth AND YEAR(an.post_date) = $currentYear;";
                $result = $conn->query($sql);

                while ($row = $result->fetch_assoc()) {
                    echo "
                    <div class='col-6'>
                        <div class='card announcement-card shadow'>
                            <div class='card-header announcement-header'>
                                <h3>{$row['cmp_name']} <span class='fs-5'>( {$row['job_role']} )</span></h3>
                                <small>Posted on: {$row['post_date']}</small>
                            </div>
                            <div class='card-body'>
                                <p class='card-text'>Date of visit : {$row['date_of_visit']}</p>
                                <p class='card-text'>Venue : {$row['venue']}</p>
                                <p class='card-text'>Venue : {$row['salary_pkg']}</p>
                            </div>
                            <div class='card-footer announcement-footer'>
                                <button class='btn btn-primary btn-sm'>View</button>
                                <button class='btn btn-secondary btn-sm'>Edit</button>
                                <button class='btn btn-danger btn-sm'>Delete</button>
                            </div>
                        </div>
                    </div>";
                }
            ?>

        </div>
    </div>

    <script src="../js/global.js"></script>
</body>
</html>
