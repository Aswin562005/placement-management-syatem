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

            <!-- Filtering Student -->
            <label>Filter by Department and Section : 
                <select name="departmentFilter">
                    <option value="">Select Department</option>
                    <?php
                        $dept_query = "SELECT * FROM department";
                        $dept_result = $conn->query($dept_query);
                        while ($dept = $dept_result->fetch_assoc()) {
                            echo "<option value='{$dept['dept_name']}'>{$dept['dept_name']}</option>";
                        }
                    ?>
                </select>
                <select name="sectionFilter">
                    <option value="">Select Section</option>
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="C">C</option>
                    <option value="D">D</option>
                </select>
            </label>
            <!-- End Filtering Student -->

            <!-- Student Table -->
            <table id="studentTable">
                <thead>
                    <tr>
                        <th>Rollno</th>
                        <th>Name</th>
                        <th>Department</th>
                        <th>Section</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT s.*, d.dept_name FROM student AS s JOIN department AS d ON s.dept_id = d.dept_id;";
                    $result = $conn->query($sql);

                    while ($row = $result->fetch_assoc()) {
                        echo "<tr data-name='{$row['stu_name']}' data-email='{$row['stu_email']}' data-phone='{$row['stu_mobileno']}' data-gender='{$row['stu_gender']}' data-address='{$row['stu_address']}' data-dept-id='{$row['dept_id']}' data-section='{$row['stu_section']}' data-dob='{$row['stu_dob']}' data-year-of-study='{$row['stu_batch']}' data-ug-or-pg='{$row['ug_or_pg']}'>
                                <td>{$row['stu_rollno']}</td>
                                <td>{$row['stu_name']}</td>
                                <td>{$row['dept_name']}</td>
                                <td>{$row['stu_section']}</td>
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
            <!-- End Student Table -->

        </div>

        <script src="../js/bootstrap/bootstrap.min.js"></script>
        <!-- JavaScript -->
        <script>
            $(document).ready(function () {
                var studentTable = $("#studentTable").DataTable({
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

                function handleFormSubmit(formId, url, modalId) {
                    $(formId).submit(function (e) {
                        e.preventDefault();
                        let formData = new FormData(document.querySelector(formId));

                        fetch(url, {
                            method: "POST",
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            $(modalId).modal("hide");
                            alert(data.message);
                            location.reload();
                        })
                        .catch(error => console.error("Error:", error));
                    });
                }

                handleFormSubmit("#addStudentForm", "student_actions.php", "#addStudentModal");
                handleFormSubmit("#editStudentForm", "student_actions.php", "#editStudentModal");

                function handleButtonClick(buttonClass, action, callback) {
                    $(buttonClass).click(function () {
                        let studentRollno = $(this).data("id");
                        $.post("student_actions.php", { action: action, rollno: studentRollno }, callback);
                    });
                }

                handleButtonClick(".view-btn", "view", function (data) {
                    $("#studentDetails").html(data);
                    $("#viewStudentModal").modal("show");
                });

                handleButtonClick(".delete-btn", "delete", function (response) {
                    console.dir(response)
                    alert(response);
                    location.reload();
                });

                $(".edit-btn").click(function() {
                    let row = $(this).closest("tr");
                    let studentRollno = $(this).data("id");

                    $("#editRollno").val(studentRollno);
                    $("#editName").val(row.attr("data-name"));
                    $("#editDepartment").val(row.attr("data-dept-id"));
                    $("#editSection").val(row.attr("data-section"));
                    $("#editEmail").val(row.attr("data-email"));
                    $("#editPhone").val(row.attr("data-phone"));
                    $("#editDob").val(row.attr("data-dob"));
                    $("#editGender").val(row.attr("data-gender"));
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
