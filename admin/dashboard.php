<?php include '../include/checksession.php'; ?>
<?php 
    if($_SESSION['user_type'] != 'admin')
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
        $currentYear = date('Y');
        $sql = "SELECT 
                    (SELECT COUNT(*) FROM company) AS total_companies, 
                    (SELECT COUNT(*) FROM student) AS total_students,
                    (SELECT COUNT(*) FROM student_applications WHERE stu_status = 'Selected') AS total_selected,
                    (SELECT admin_name FROM administrator WHERE admin_email = '$login_email') AS admin_name
                ";
        $result = $conn->query($sql);
        $data = $result->fetch_assoc();
        $total_students = $data['total_students'];
        $total_companies = $data['total_companies'];
        $total_selected = $data['total_selected'];
        $admin_name = $data['admin_name'];
    ?>
    <div class="main-content">
        <header>
            <h1>Dashboard</h1>
            <div class="header-right">
                <span style="padding-right: 10px;">Welcome, <?php echo $admin_name; ?></span>
                <!-- <button id="theme-toggle">Toggle Theme</button> -->
            </div>
        </header>
        <div class="cards">
            <div class="card">
                <h3>Total Students</h3>
                <p><?php echo $total_students; ?></p>
            </div>
            <div class="card">
                <h3>Companies Registered</h3>
                <p><?php echo $total_companies; ?></p>
            </div>
            <div class="card">
<<<<<<< HEAD
                <h3>Placed Students</h3>
                <p>50</p>
=======
                <h3>Selected Students in Interview </h3>
                <p><?php echo $total_selected; ?></p>
>>>>>>> a229b03607418bfce66338b46da1db3ff090138c
            </div>
        </div>
    </div>
    <script src="../js/global.js"></script>
</body>
</html>
