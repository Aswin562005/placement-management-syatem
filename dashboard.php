<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Placement Cell Dashboard</title>
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/sidebar.css" />
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>
    <?php include 'include/sidebar.php'; ?>
    <div class="main-content">
        <header>
            <h1>Dashboard</h1>
            <div class="header-right">
                <span>Welcome, Admin</span>
                <button id="theme-toggle">Toggle Theme</button>
            </div>
        </header>
        <div class="cards">
            <div class="card">
                <h3>Total Students</h3>
                <p>1200</p>
            </div>
            <div class="card">
                <h3>Companies Registered</h3>
                <p>300</p>
            </div>
            <div class="card">
                <h3>Job Offers</h3>
                <p>500</p>
            </div>
        </div>
    </div>
    <script src="js/global.js"></script>
</body>
</html>
