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
<?php $title='Student Applications'; include '../include/header.php' ?>
<link rel="stylesheet" href="css/style.css" />

<body>
    <?php include '../include/sidebar.php'; ?>

    <div class="main-content">
        <header>
            <h1>Student Applications</h1>
        </header>

        <?php include 'filter.php' ?>

        <?php
            if (isset($_GET['announcement']) || !empty($_GET['announcement'])) { 
                $announcement_id = $_GET['announcement'];
                $sql = "SELECT sa.stu_rollno ,s.stu_name, d.dept_name, sa.stu_email, sa.stu_mobileno, sa.stu_status FROM student_applications AS sa JOIN student AS s ON sa.stu_rollno = s.stu_rollno JOIN announcement AS a ON sa.announcement_id = a.announcement_id JOIN department AS d ON d.dept_id = s.dept_id WHERE sa.announcement_id = '$announcement_id';";
                $result = $conn->query($sql);  
        ?>
        <form method="post" action="update_result.php">
            <input type="hidden" name="announcement_id" value="<?php echo $announcement_id; ?>" >
            <table id="studentApplicationsTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>RollNO</th>
                        <th>Name</th>
                        <th>Department</th>
                        <th>Email</th>
                        <th>Phone No</th>
                        <th>Result</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if($result->num_rows > 0){
                        $count = 1;
    
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr data-cmp-name='{$row['stu_name']}'>
                                    <td> {$count} </td>
                                    <td>{$row['stu_rollno']}</td>
                                    <td>{$row['stu_name']}</td>
                                    <td>{$row['dept_name']}</td>
                                    <td>{$row['stu_email']}</td>
                                    <td>{$row['stu_mobileno']}</td>
                                    <td>
                                        <select name='results[{$row['stu_rollno']}]'>
                                            <option value='Pending'" . ($row['stu_status'] == "Pending" ? 'selected' : '') . "> Pending </option>
                                            <option value='Selected'" . ($row['stu_status'] == "Selected" ? 'selected' : '') . "> Selected </option>
                                            <option value='Not Selected'" . ($row['stu_status'] == "Not Selected" ? 'Not selected' : '') . "> Not Selected </option>
                                        </select> 
                                    </td>
                                </tr>";
                            $count++;
                        }
                    } else {
                        // echo "<tr> <td colspan=7>No Students are registered.</td> </tr>"; 
                    }
                    ?>
                </tbody>
            </table>
        <?php
            if($result->num_rows > 0){
                    echo "<button type='submit' class='btn btn-primary' name='status'> Update Result </button>";
                } ?>
        </form>
        <?php } ?>
    </div>

    <script>
        $(document).ready(function () {
            $("#studentApplicationsTable").DataTable({
                columnDefs: [
                    {
                        targets: [3, 4, 5, 6],
                        orderable: false
                    },
                    {
                        target: 0,
                        searchable: false,
                    }
                ]
            });
        });
    </script>

</body>
</html>