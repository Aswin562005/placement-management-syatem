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
    <?php $title='Companies'; include '../include/header.php' ?>
<body>
    <?php include '../include/sidebar.php' ?>
    <?php include 'view_company.php'; ?>
    <?php include 'add_company.php'; ?>
    <?php include 'edit_company.php'; ?>
    <?php include '../include/loader.php'; ?>

    <div class="main-content">
        <header>
            <h1>Companies</h1>
            <button class="add-btn" data-bs-toggle="modal" data-bs-target="#addCompanyModal">Add Company</button>
        </header>
        <table id="companyTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Industry</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM company;";
                $result = $conn->query($sql);
                $count = 1;

                while ($row = $result->fetch_assoc()) {
                    echo "<tr data-cmp-name='{$row['cmp_name']}' data-cmp-email='{$row['cmp_email']}' data-cmp-industry='{$row['cmp_industry']}' data-cmp-location='{$row['cmp_location']}' data-cmp-website='{$row['cmp_website']}'>
                            <td>{$count}</td>
                            <td>{$row['cmp_name']}</td>
                            <td>{$row['cmp_email']}</td>
                            <td>{$row['cmp_industry']}</td>
                            <td class='actions'>
                                <button class='btn btn-sm btn-info view-btn' data-id='{$row['cmp_id']}'>View</button>
                                <button class='btn btn-sm edit-btn btn-warning' data-id='{$row['cmp_id']}'>Edit</button>
                                <button class='btn btn-sm btn-danger delete-btn' data-id='{$row['cmp_id']}'>Delete</button>
                            </td>
                        </tr>";
                    $count++;
                }
                ?>
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function () {
            $("#companyTable").DataTable({
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
                    startLoader();
                    fetch(url, {
                        method: "POST",
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        stopLoader();
                        $(modalId).modal("hide");
                        alert(data.message);
                        location.reload();
                    })
                    .catch(error => {
                        stopLoader();
                        console.error("Error:", error);
                    });
                });
            }

            handleFormSubmit("#addCompanyForm", "company_actions.php", "#addCompanyModal");
            handleFormSubmit("#editCompanyForm", "company_actions.php", "#editCompanyModal");

            function handleButtonClick(buttonClass, action, callback) {
                $(buttonClass).click(function () {
                    let companyId = $(this).data("id");
                    startLoader();
                    if (action == "delete") {
                            if (!confirm('Are you  want to delete this company record ?')) {
                                stopLoader();
                                return;
                            }
                        }
                    $.post("company_actions.php", { action: action, id: companyId }, callback);
                });
            }

            handleButtonClick(".view-btn", "view", function (data) {
                stopLoader();
                $("#companyDetails").html(data);
                $("#viewCompanyModal").modal("show");
            });

            handleButtonClick(".delete-btn", "delete", function (response) {
                stopLoader();
                alert(response);
                location.reload();
            });

            $(".edit-btn").click(function() {
                let row = $(this).closest("tr");
                let companyId = $(this).data("id");

                $("#editID").val(companyId);
                $("#editName").val(row.attr("data-cmp-name"));
                $("#editIndustry").val(row.attr("data-cmp-industry"));
                $("#editEmail").val(row.attr("data-cmp-email"));
                $("#editLocation").val(row.attr("data-cmp-location"));
                $("#editWebsite").val(row.attr("data-cmp-website"));

                $("#editCompanyModal").modal("show");
            });
        });
    </script>
</body>
</html>
