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
        $sql = "SELECT 
                    (SELECT COUNT(*) FROM company) AS total_companies, 
                    (SELECT COUNT(*) FROM student) AS total_students,
                    (SELECT admin_name FROM administrator WHERE admin_email = '$login_email') AS admin_name
                ";
        $result = $conn->query($sql);
        $data = $result->fetch_assoc();
        $total_students = $data['total_students'];
        $total_companies = $data['total_companies'];
        $admin_name = $data['admin_name'];
    ?>
    <div class="main-content">
        <header>
            <h1>Dashboard</h1>
            <div class="header-right">
                <span>Welcome, <?php echo $admin_name; ?></span>
                <button id="theme-toggle">Toggle Theme</button>
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
                <h3>Job Offers</h3>
                <p>500</p>
            </div>
        </div>
    </div>
    <script src="../js/global.js"></script>
</body>
</html>
