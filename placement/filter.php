<?php
    function validate_input($data) {
        return htmlspecialchars(stripslashes(trim($data)));
    }

    if(isset($_POST['find'])){
        $company_id = validate_input($_POST['company_id']);
        $date_of_visit = validate_input($_POST['date_of_visit']);
        $job_role = validate_input($_POST['job_role']);
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