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
    
<?php $title='Students'; include '../include/header.php' ?>

<body>
    <?php include '../include/sidebar.php'; ?>
    <div class="main-content">
        <header>
            <h1>Student</h1>
        </header>

        <!-- Alert Box for Messages -->
        <div id="messageBox" class="alert d-none my-3"></div>
        <?php
            $sql = "SELECT s.*, d.dept_name FROM student AS s JOIN department AS d ON s.dept_id = d.dept_id WHERE stu_email = '$login_email';";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
        ?>

        <div class="container my-3">
            <div class="input-group mb-3">
                <label class="input-group-text">Roll No : </label>
                <input type="text" class="form-control" value="<?php echo $row['stu_rollno']; ?>" readonly>
            </div>
            <div class="input-group mb-3">
                <label class="input-group-text">Name : </label>
                <input type="text" class="form-control" value="<?php echo $row['stu_name']; ?>" readonly>
            </div>

            <div class="input-group mb-3">
                <label class="input-group-text">
                    Department Name : 
                </label>
                <input type="text" class="form-control" value="<?php echo $row['dept_name']; ?>" readonly>
            </div>

            <div class="input-group mb-3">
                <label class="input-group-text">
                    Section : 
                </label>
                <input type="text" class="form-control" value="<?php echo $row['stu_section']; ?>" readonly>
            </div>

            <div class="input-group mb-3">
                <label class="input-group-text">
                    Date Of Birth : 
                </label>
                <input type="text" class="form-control" value="<?php echo $row['stu_dob']; ?>" readonly>
            </div>

            <div class="input-group mb-3">
                <label class="input-group-text">
                    Gender : 
                </label>
                <input type="text" class="form-control" value="<?php echo $row['stu_gender']; ?>" readonly>
            </div>

            <div class="input-group mb-3">
                <label class="input-group-text">
                    Email ID : 
                </label>
                <input type="text" class="form-control" value="<?php echo $row['stu_email']; ?>" readonly>
            </div>

            <div class="input-group mb-3">
                <label class="input-group-text">
                    Mobile No : 
                </label>
                <input type="text" class="form-control" value="<?php echo $row['stu_mobileno']; ?>" readonly>
            </div>

            <div class="input-group mb-3">
                <label class="input-group-text">
                    Address : 
                </label>
                <input type="text" class="form-control" value="<?php echo $row['stu_address']; ?>" readonly>
            </div>

            <div class="input-group mb-3">
                <label class="input-group-text">
                    Batch : 
                </label>
                <input type="text" class="form-control" value="<?php echo $row['stu_batch']; ?>" readonly>
            </div>

            <div class="input-group mb-3">
                <label class="input-group-text">
                    UG or PG : 
                </label>
                <input type="text" class="form-control" value="<?php echo $row['ug_or_pg']; ?>" readonly>
            </div>

        </div>
    </div>

    <script src="../js/bootstrap/bootstrap.min.js"></script>
    <!-- JavaScript -->

</body>

</html>