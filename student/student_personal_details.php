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

<style>
    body {
        background: #f4f4f9;
        font-family: 'Arial', sans-serif;
    }
    .main-content {
        padding: 20px;
    }
    .profile-card {
        max-width: 600px;
        margin: 50px auto;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }
    .profile-header {
        background: linear-gradient(135deg, #6a11cb, #2575fc);
        color: #fff;
        padding: 20px;
        text-align: center;
    }
    .profile-header h1 {
        margin: 0;
        font-size: 24px;
    }
    .profile-body {
        padding: 20px;
    }
    .profile-body .info-group {
        margin-bottom: 15px;
    }
    .profile-body .info-group label {
        font-weight: bold;
        display: block;
        margin-bottom: 5px;
    }
    .profile-body .info-group input {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        background: #f9f9f9;
    }
</style>


    <?php include '../include/sidebar.php'; ?>
    <div class="main-content">
        <div class="profile-card">
            <div class="profile-header">
                <h1>Student Profile</h1>
            </div>
            <div class="input-group mb-3">
                <label class="input-group-text">Name : </label>
                <input type="text" class="form-control" value="<?php echo $row['stu_name']; ?>" readonly>
            </div>

            <div class="input-group mb-3">
                <label class="input-group-text">
                    Department : 
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

            <form action="student_actions.php" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <input type="hidden" name="action" value="upload_cv">
                    <input type="hidden" name="rollno" value="<?php echo $row['stu_rollno']; ?>">
                    <label>Upload CV <?php echo "( "; echo isset($row['stu_cv']) ? $row['stu_cv'] : ""; echo " )";  ?></label>
                    <input type="file" name="cv" class="form-control" accept=".pdf, .docx" required>
                </div>
                <button type="submit" class="btn btn-primary">Upload</button>
                <?php 
                    if(isset($row['stu_cv'])){
                    ?>
                        <a href="<?php echo $row['stu_cv']; ?>" download class='btn btn-primary'>Download CV</a> 
                <?php }?>

            </form>
        </div>
    </div>
    <?php include '../include/footer.php'; ?>
          
</body>
</html>