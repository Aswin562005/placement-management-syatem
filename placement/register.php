<?php

    if (!isset($_GET['announcement'])) {
        echo "Invalid Request";
        exit;        
    }
?>
<?php include '../include/checksession.php'; ?>
<?php 
    if($_SESSION['user_type'] != 'student')
    {
        header("location: ../auth/index.php");
        exit;
    }  
?>
<?php include '../db/config.php'; ?>
<?php
    $announcement_id = $_GET['announcement'];
    $query = "SELECT s.stu_rollno, s.stu_name, s.stu_mobileno, s.stu_email,d.dept_name FROM student AS S JOIN department AS d ON s.dept_id = d.dept_id where stu_email='$login_email';";
    $row = $conn->query($query)->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<?php $title='Register Interview'; include '../include/header.php' ?>

<style>
    body {
        background: url('../img/interview-hall.webp') no-repeat center center fixed;
        background-size: cover;
        background-color: #ecf0f1;
        font-family: Arial, sans-serif;
    }
    .form-container {
        max-width: 500px;
        margin: 50px auto;
        background: rgba(255, 255, 255, 0.8); /* Add transparency to the form background */
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        backdrop-filter: blur(10px);
    }
    .form-container h2 {
        margin-bottom: 20px;
        font-size: 24px;
        font-weight: bold;
        text-align: center;
    }
    .btn-primary {
        width: 100%;
    }
</style>

<body>
    <div class="container">
        <div class="form-container">
            <h2>Register for Interview</h2>
            <form action="register_interview.php" method="post" name="registerForm" id="registerForm">

                <input type="hidden" name="announcement" value="<?php echo $announcement_id; ?>">
        
                <div class="mb-3">
                    <label for="rollno" class="form-label">Roll No</label>
                    <input type="text" class="form-control" id="rollno" name="rollno" placeholder="Enter your roll number" value="<?php echo $row['stu_rollno']; ?>" readonly>
                </div>
        
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" value="<?php echo $row['stu_name']; ?>" readonly>
                </div>
        
                <div class="mb-3">
                    <label for="dept" class="form-label">Department</label>
                    <input type="text" class="form-control" id="dept" name="dept" placeholder="Enter your department" value="<?php echo $row['dept_name']; ?>" readonly>
                </div>
        
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" value="<?php echo $row['stu_email']; ?>">
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label">Phone No</label>
                    <input type="number" class="form-control" id="phone" name="phone" placeholder="Enter your phone no" value="<?php echo $row['stu_mobileno']; ?>">
                </div>
        
                <button type="submit" class="btn btn-primary">Submit</button>
        
            </form>
        </div>
    </div>

    <script>
        $("#registerForm").submit(function (e) {
            e.preventDefault();
            let formData = new FormData(document.querySelector("#registerForm"));
            startLoader();
            fetch('register_interview.php', {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                stopLoader();
                console.log(data)
                alert(data.message);
                window.location = '../student/dashboard.php';
            })
            .catch(error => {
                stopLoader();
                console.error("Error:", error);
            });
        });
    </script>
</body>

</html>