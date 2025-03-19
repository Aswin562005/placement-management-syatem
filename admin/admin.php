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
    <?php $title='Admins'; include '../include/header.php' ?>

    <body>
        <?php include '../include/sidebar.php'; ?>
        <?php include 'view_admin.php'; ?>
        <?php include 'add_admin.php'; ?>
        <?php include 'edit_admin.php'; ?>
        <div class="main-content">
            <header>
                <h1>Admins</h1>
                <button class="add-btn" data-bs-toggle="modal" data-bs-target="#addAdminModal">Add Admin</button>
            </header>

            <!-- Alert Box for Messages -->
            <div id="messageBox" class="alert d-none my-3"></div>

            <table id="adminTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone No</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM administrator;";
                    $result = $conn->query($sql);
                    $count = 1;

                    while ($row = $result->fetch_assoc()) {
                        echo "<tr data-name='{$row['admin_name']}' data-email='{$row['admin_email']}' data-phone='{$row['admin_mobileno']}' data-dob='{$row['admin_dob']}' data-gender='{$row['admin_gender']}' >
                                <td>{$count}</td>
                                <td>{$row['admin_name']}</td>
                                <td>{$row['admin_email']}</td>
                                <td>{$row['admin_mobileno']}</td>
                                <td class='actions'>
                                    <button class='btn btn-sm btn-info view-btn' data-id='{$row['admin_id']}'>View</button>
                                    <button class='btn btn-sm edit-btn btn-warning' data-id='{$row['admin_id']}'>Edit</button>
                                    <button class='btn btn-sm delete-btn btn-danger' data-id='{$row['admin_id']}'>Delete</button>
                                </td>
                            </tr>";
                            $count++;
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <script src="../js/bootstrap/bootstrap.min.js"></script>
        <!-- JavaScript -->
        <script>
            $(document).ready(function () {
                $("#adminTable").DataTable({
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

                handleFormSubmit("#addAdminForm", "admin_actions.php", "#addAdminModal");
                handleFormSubmit("#editAdminForm", "admin_actions.php", "#editAdminModal");

                handleButtonClick("admin_actions.php", ".view-btn", "view", function (data) {
                    stopLoader();
                    $("#adminDetails").html(data);
                    $("#viewAdminModal").modal("show");
                });

                handleButtonClick("admin_actions.php", ".delete-btn", "delete", function (response) {
                    stopLoader();
                    let res = JSON.parse(response);
                    alert(res.message);
                    location.reload();
                });

                $(".edit-btn").click(function() {
                    let row = $(this).closest("tr");
                    let adminId = $(this).data("id");

                    $("#editID").val(adminId);
                    $("#editName").val(row.attr("data-name"));
                    $("#editDob").val(row.attr("data-dob"));
                    $(`input[name='gender'][value='${row.attr("data-gender")}']`).prop('checked', true);
                    $("#editEmail").val(row.attr("data-email"));
                    $("#editPhone").val(row.attr("data-phone"));
                    $("#editAdminModal").modal("show");
                });

                function showMessage(message, type) {
                    $("#messageBox").removeClass("d-none alert-success alert-danger").addClass(`alert alert-${type}`).text(message);
                    setTimeout(() => { $("#messageBox").addClass("d-none"); }, 3000);
                }
            });
        </script>
    </body>
</html>
