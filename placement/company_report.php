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
            <h1>Company Report</h1>
        </header>

        <div class="row">
            <form class="my-3">
                <label>
                    Enter Company Name : 
                    <input type="text" name="company" class="form-control" autofocus=true>
                </label>
                <button type="submit" class="btn btn-primary">Generate</button>
            </form>
            <?php
            if (isset($_GET['company']) || !empty($_GET['company'])) { 
                $cmp_name = strtolower($_GET['company']);
                $companyQuery = "SELECT * FROM company WHERE LOWER(cmp_name) = '$cmp_name' LIMIT 1"; // Adjust LIMIT as needed for specific company
                $companyResult = $conn->query($companyQuery);
                if ($companyResult->num_rows > 0) {
                    $companyData = $companyResult->fetch_assoc();
            ?>
            <div class="company-summary">
                <!-- <h3>company Report</h3> -->
                <p><strong>Company Name : </strong> <?php echo $companyData['cmp_name']; ?></p>
                <p><strong>Industry : </strong> <?php echo $companyData['cmp_industry']; ?></p>
                <p><strong>Email : </strong> <?php echo $companyData['cmp_email']; ?></p>
                <p><strong>Location : </strong> <?php echo $companyData['cmp_location']; ?></p>
            </div>

            <div class="report-table">
                <table border="1" cellpadding="10" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Job Role</th>
                            <th>Venue</th>
                            <th>Date of Visit</th>
                            <th>Total Regisered</th>
                            <th>Total Selected</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT a.job_role, a.venue, a.date_of_visit, COUNT(*) as TotalRegistered, sum(case when sa.stu_status = 'Selected' then 1 else 0 end) as TotalSelected FROM student_applications as sa JOIN announcement AS a ON sa.announcement_id = a.announcement_id JOIN company AS c ON a.cmp_id = c.cmp_id WHERE c.cmp_id = '{$companyData['cmp_id']}' group by a.date_of_visit, c.cmp_id, a.job_role, a.venue;";
                        $result = $conn->query($query);
                        if ($result->num_rows > 0) {
                            $count = 1;
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                        <td>{$count}</td>
                                        <td>{$row['job_role']}</td>
                                        <td>{$row['venue']}</td>
                                        <td>{$row['date_of_visit']}</td>
                                        <td>{$row['TotalRegistered']}</td>
                                        <td>{$row['TotalSelected']}</td>
                                    </tr>";
                                $count++;
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
            echo "This Company Doesn't Exist.";
        } }?>
    </div>

</body>
</html>