<?php include '../db/config.php'; ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Students | Placement Cell</title>
        <link rel="stylesheet" href="../css/bootstrap/bootstrap.min.css">
        <link rel="stylesheet" href="../css/global.css" />
        <link rel="stylesheet" href="../css/sidebar.css" />
        <link rel="stylesheet" href="css/student.css" />
        <script src="../js/jquery-3.7.1.min.js"></script>
  </head>
  <body>
    <?php include '../include/sidebar.php'; ?>
    <?php include 'view_student.php'; ?>
    <?php include 'add_student.php'; ?>
    <?php include 'edit_student.php'; ?>
    
    <div class="main-content">
      <header>
        <h1>Students</h1>
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addStudentModal">Add Student</button>
      </header>

      <!-- Alert Box for Messages -->
      <div id="messageBox" class="alert d-none my-3"></div>

      <table>
        <thead>
          <tr>
            <th>Rollno</th>
            <th>Name</th>
            <th>Email</th>
            <th>Departmrent</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $sql = "select s.*, d.dept_name from student as s join department as d on s.dept_id = d.dept_id;";
          $result = $conn->query($sql);

          while ($row = $result->fetch_assoc()) {
              echo "<tr data-name='{$row['stu_name']}' data-email='{$row['stu_email']}' data-phone='{$row['stu_mobileno']}' data-dept-id='{$row['dept_id']}' data-section='{$row['stu_section']}' data-dob='{$row['stu_dob']}' data-year-of-study='{$row['stu_batch']}' data-ug-or-pg='{$row['ug_or_pg']}'>
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
    

    <script src="../js/bootstrap/bootstrap.min.js"></script>
    <!-- JavaScript -->
    <script>
        $(document).ready(function () {
            // Add Student
          $("#addStudentForm").submit(function (e) {
              e.preventDefault();
              let formData = new FormData(document.querySelector("#addStudentForm"));

              fetch("student_actions.php", {
                  method: "POST",
                  body: formData
              })
              .then(response => response.json())
              .then(data => {
                  $("#addStudentModal").modal("hide");
                  if (data.status == 'success') {
                    alert(data.message);
                  }
                  if (data.status == 'error') {
                    alert(`${data.status} : ${data.message}`)
                  }
                  location.reload();
              })
              .catch(error => console.error("Error:", error));
          });

          // View Student
          $(".view-btn").click(function () {
              let studentRollno = $(this).data("id");
              $.post("student_actions.php", { action: "view", rollno: studentRollno }, function (data) {
                  $("#studentDetails").html(data);
                  $("#viewStudentModal").modal("show");
              });
          });

          // Delete Student
          $(".delete-btn").click(function () {
              if (confirm("Are you sure?")) {
                let studentRollno = $(this).data("id");
                $.post("student_actions.php", { action: "delete", rollno: studentRollno }, function (response) {
                  alert(response);
                  location.reload();
                  // showMessage(response, "danger");
                  // setTimeout(() => location.reload(), 1500);
                  });
              }
          });

          $(".edit-btn").click(function() {
            console.log('hii');
            let row = $(this).closest("tr");
            let studentRollno = $(this).data("id");
            console.log(row.attr("data-name"), row.attr("deptid"));
            
            $("#editRollno").val(studentRollno);
            $("#editName").val(row.attr("data-name"));
            $("#editDepartment").val(row.attr("data-dept-id"));
            $("#editSection").val(row.attr("data-section"));
            $("#editEmail").val(row.attr("data-email"));
            $("#editPhone").val(row.attr("data-phone"));
            $("#editDob").val(row.attr("data-dob"));
            $("#editYearOfStudy").val(row.attr("data-year-of-study"));
            $("#editStudentModal").modal("show");
          });

          // Handle form submission
          $("#editStudentForm").submit(function(event) {
              event.preventDefault();

              let formData = $(this).serialize();

              $.ajax({
                  url: "student_actions.php",
                  type: "POST",
                  data: formData,
                  success: function(response) {
                      $("#editMessageBox").html(response.message).css("color", response.status === "success" ? "green" : "red");

                      if (response.status === "success") {
                          // setTimeout(() => location.reload(), 1000);
                      }
                  },
                  error: function(xhr, status, error) {
                      console.log(error);
                  }
              });
          });
          
          function showMessage(message, type) {
            $("#messageBox").removeClass("d-none alert-success alert-danger").addClass(`alert alert-${type}`).text(message);
            setTimeout(() => { $("#messageBox").addClass("d-none"); }, 3000);
          }
        });
    </script>
  </body>
</html>
