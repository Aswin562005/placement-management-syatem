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
<?php $title='Report'; include '../include/header.php' ?>

<body>
    <?php include '../include/sidebar.php'; ?>

    <div class="main-content">
        <header>
            <h1>Student Report</h1>
        </header>

        <div class="row">
            <form class="my-3">
                <label>
                    Enter Student Rollno : 
                    <input type="number" name="rollno" class="form-control" autofocus=true>
                </label>
                <button type="submit" class="btn btn-primary">Generate</button>
            </form>
            <?php
            if (isset($_GET['rollno']) || !empty($_GET['rollno'])) { 
                $rollno = $_GET['rollno'];
                $studentQuery = "SELECT s.stu_name, s.stu_email, d.dept_name  FROM student AS s JOIN department AS d ON d.dept_id = s.dept_id WHERE stu_rollno = '$rollno'"; // Adjust LIMIT as needed for specific student
                $studentResult = $conn->query($studentQuery);
                if ($studentResult->num_rows > 0) {
                    $studentData = $studentResult->fetch_assoc();
                    $studentApplicationsQuery = "SELECT COUNT(*) AS total_applied FROM student_applications WHERE stu_rollno = '$rollno'";
                    $studentApplicationsResult = $conn->query($studentApplicationsQuery);
                    $studentApplicationsData = $studentApplicationsResult->fetch_assoc()['total_applied'];
            ?>
            <div class="student-summary">
                <!-- <h3>Student Report</h3> -->
                <p><strong>Student Name:</strong> <?php echo $studentData['stu_name']; ?></p>
                <p><strong>Department Name:</strong> <?php echo $studentData['dept_name']; ?></p>
                <p><strong>Email:</strong> <?php echo $studentData['stu_email']; ?></p>
                <p><strong>Total Companies Applied:</strong> <?php echo $studentApplicationsData; ?></p>
            </div>

            <div class="report-table">
                <table border="1" cellpadding="10" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Company Name</th>
                            <th>Job Role</th>
                            <th>Status</th>
                            <th>Date of Visit</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT c.cmp_name, a.job_role, sa.stu_status, a.date_of_visit FROM student_applications AS sa JOIN announcement AS a ON  sa.announcement_id = a.announcement_id JOIN company AS c ON a.cmp_id = c.cmp_id WHERE sa.stu_rollno = '$rollno'";
                        $result = $conn->query($query);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                        <td>{$row['cmp_name']}</td>
                                        <td>{$row['job_role']}</td>
                                        <td>{$row['stu_status']}</td>
                                        <td>{$row['date_of_visit']}</td>
                                        </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4'>No data available</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php } else {
            echo "This Rollno is Exist.";
        } }?>
    </div>

</body>
</html>