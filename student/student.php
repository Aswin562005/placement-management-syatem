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
    <?php $title='Students'; include '../include/header.php' ?>

    <body>
        <?php include '../include/sidebar.php'; ?>
        <?php include 'view_student.php'; ?>
        <?php include 'add_student.php'; ?>
        <?php include 'edit_student.php'; ?>
        <div class="main-content">
            <header>
                <h1>Students</h1>
                <button class="add-btn" data-bs-toggle="modal" data-bs-target="#addStudentModal">Add Student</button>
            </header>

            <!-- Alert Box for Messages -->
            <div id="messageBox" class="alert d-none my-3"></div>

            <table id="studentTable">
                <thead>
                    <tr>
                        <th>Rollno</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Department</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT s.*, d.dept_name FROM student AS s JOIN department AS d ON s.dept_id = d.dept_id;";
                    $result = $conn->query($sql);

                    while ($row = $result->fetch_assoc()) {
                        echo "<tr data-name='{$row['stu_name']}' data-email='{$row['stu_email']}' data-phone='{$row['stu_mobileno']}' data-dept-id='{$row['dept_id']}' data-section='{$row['stu_section']}' data-dob='{$row['stu_dob']}' data-gender='{$row['stu_gender']}' data-address='{$row['stu_address']}' data-year-of-study='{$row['stu_batch']}' data-ug-or-pg='{$row['ug_or_pg']}'>
                                <td>{$row['stu_rollno']}</td>
                                <td>{$row['stu_name']}</td>
                                <td>{$row['stu_email']}</td>
                                <td>{$row['dept_name']}</td>
                                <td class='actions'>
                                    <button class='btn btn-sm btn-info view-btn' data-id='{$row['stu_rollno']}'>View</button>
                                    <button class='btn btn-sm edit-btn btn-warning' data-id='{$row['stu_rollno']}'>Edit</button>
                                    <button class='btn btn-sm delete-btn btn-danger' data-id='{$row['stu_rollno']}'>Delete</button>
                                </td>
                            </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- JavaScript -->
        <script>
            $(document).ready(function () {
                
                $("#studentTable").DataTable({
                    columnDefs: [
                        {
                            targets: [2, 3, 4],
                            orderable: false
                        },
                        {
                            target: 4,
                            searchable: false,
                        }
                    ]
                });

                handleFormSubmit("#addStudentForm", "student_actions.php", "#addStudentModal");
                handleFormSubmit("#editStudentForm", "student_actions.php", "#editStudentModal");

                handleButtonClick("student_actions.php", "#studentTable", ".view-btn", "view", function (data) {
                    stopLoader();
                    $("#studentDetails").html(data);
                    $("#viewStudentModal").modal("show");
                });

                handleButtonClick("student_actions.php", "#studentTable", ".delete-btn", "delete", function (response) {
                    stopLoader();
                    let data = JSON.parse(response);
                    alert(data.message);
                    location.reload();
                });

                $("#studentTable").on('click', ".edit-btn", function() {
                    let row = $(this).closest("tr");
                    let studentRollno = $(this).data("id");

                    $("#editRollno").val(studentRollno);
                    $("#editName").val(row.attr("data-name"));
                    $("#editDepartment").val(row.attr("data-dept-id"));
                    $("#editSection").val(row.attr("data-section"));
                    $("#editEmail").val(row.attr("data-email"));
                    $("#editPhone").val(row.attr("data-phone"));
                    $("#editDob").val(row.attr("data-dob"));
                    $(`input[name='gender'][value='${row.attr("data-gender")}']`).prop('checked', true);
                    $("#editAddress").val(row.attr("data-address"));
                    $("#editYearOfStudy").val(row.attr("data-year-of-study"));
                    $(`input[name='ug_or_pg'][value='${row.attr("data-ug-or-pg")}']`).prop('checked', true);

                    $("#editStudentModal").modal("show");
                });

                function showMessage(message, type) {
                    $("#messageBox").removeClass("d-none alert-success alert-danger").addClass(`alert alert-${type}`).text(message);
                    setTimeout(() => { $("#messageBox").addClass("d-none"); }, 3000);
                }
            });
        </script>
    </body>
</html>
