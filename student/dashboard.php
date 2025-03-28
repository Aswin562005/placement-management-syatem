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
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Placement Cell Dashboard</title>
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/sidebar.css" />
    <link rel="stylesheet" href="../css/dashboard.css">
</head>
<body>
    <?php include '../include/sidebar.php'; ?>
    <?php 
        $studentResult = $conn->query("SELECT stu_rollno, stu_name FROM student WHERE stu_email = '$login_email'")->fetch_assoc();
        $rollno = $studentResult['stu_rollno'];
        $stu_name = $studentResult['stu_name'];
        $sql = "SELECT 
                    (SELECT COUNT(*) FROM student_applications WHERE stu_rollno = '$rollno') AS total_interviews, 
                    (SELECT COUNT(*) FROM student_applications WHERE stu_rollno = '$rollno' AND stu_status = 'Selected') AS offer_received,
                    (SELECT COUNT(*) FROM student_applications WHERE stu_rollno = '$rollno' AND stu_status = 'Pending') AS pending_interviews";
        $result = $conn->query($sql);
        $data = $result->fetch_assoc();
        $total_interviews = $data['total_interviews'];
        $offer_received = $data['offer_received'];
        $pending_interviews = $data['pending_interviews'];
    ?>
    <div class="main-content">
        <header>
            <h1>Dashboard</h1>
            <div class="header-right">
                <span style="padding-right: 10px;">Welcome, <?php echo $stu_name; ?></span>
            </div>
        </header>
        <div class="cards">
            <div class="card">
                <h3>Number of Interviews Attended</h3>
                <p><?php echo $total_interviews; ?></p>
            </div>
            <div class="card">
                <h3>Offers Received</h3>
                <p><?php echo $offer_received; ?></p>
            </div>
            <div class="card">
                <h3>Pending Interviews</h3>
                <p><?php echo $pending_interviews; ?></p>
            </div>
        </div>
    </div>
    <script src="../js/global.js"></script>
</body>
</html>
