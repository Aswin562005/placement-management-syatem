<?php include '../include/checksession.php'; ?>
<?php 
     if($_SESSION['user_type'] != 'admin')
     {
         header("location: ../auth/index.php");
         exit;
     }  
?>
<?php include '../db/config.php'; ?>
<?php
    if(isset($_POST['find'])){
        $company_id = $_POST['company_id'];
        $date_of_visit = $_POST['date_of_visit'];
        $job_role = $_POST['job_role'];
        $query = "SELECT announcement_id FROM announcement WHERE cmp_id = '$company_id' AND date_of_visit = '$date_of_visit' AND job_role = '$job_role';";
        $result = $conn->query($query);
        if ($result->num_rows == 1) {
            $announcement_id = $result->fetch_assoc()['announcement_id'];
            header("location: student_applications.php?announcement=$announcement_id");
        } else {
            echo "<script>alert('Please enter correct data.');</script>";
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<?php $title='Student Applications'; include '../include/header.php' ?>
<link rel="stylesheet" href="css/style.css" />

<body>
    <?php include '../include/sidebar.php'; ?>

    <div class="main-content">
        <header>
            <h1>Student Applications</h1>
        </header>

        <form class="my-3 d-flex justify-content-between align-items-center" method="post">
            <div class="m-3 input-group">
                <label class="input-group-text">Company</label>
                <select name="company_id" class="form-control" required>
                    <option value="">Select Company</option>
                    <?php
                        $cmp_query = "SELECT * FROM company";
                        $cmp_result = $conn->query($cmp_query);
                        while ($cmp = $cmp_result->fetch_assoc()) {
                            echo "<option value='{$cmp['cmp_id']}'>{$cmp['cmp_name']}</option>";
                        }
                    ?>
                </select>
            </div>   

            <div class="m-3 input-group">
                <label class="input-group-text">Date Of Visit</label>
                <input type='date' name="date_of_visit" class="form-control" required/>
            </div>   

            <div class="m-3 input-group">
                <label class="input-group-text">Job Role</label>
                <input type='text' name="job_role" class="form-control" required/>
            </div>   

            <button type="submit" class="btn btn-primary w-100" name="find"> Find Registered Students </button>
        </form>

    </div>

    <script src="../js/global.js"></script>
</body>
</html>