<?php include '../db/config.php'; ?>
<!DOCTYPE html>
<html lang="en">
    <?php $title='Companies'; include '../include/header.php' ?>
<body>
    <?php include '../include/sidebar.php' ?>
    <?php include 'view_company.php'; ?>
    <?php include 'add_company.php'; ?>
    <?php include 'edit_company.php'; ?>

    <div class="main-content">
        <header>
            <h1>Companies</h1>
            <button class="add-btn" data-bs-toggle="modal" data-bs-target="#addCompanyModal">Add Company</button>
        </header>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
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

                while ($row = $result->fetch_assoc()) {
                    echo "<tr data-cmp-name='{$row['cmp_name']}' data-cmp-email='{$row['cmp_email']}' data-cmp-industry='{$row['cmp_industry']}' data-cmp-location='{$row['cmp_location']}'>
                            <td>{$row['cmp_id']}</td>
                            <td>{$row['cmp_name']}</td>
                            <td>{$row['cmp_email']}</td>
                            <td>{$row['cmp_industry']}</td>
                            <td class='actions'>
                                <button class='btn btn-sm btn-info view-btn' data-id='{$row['cmp_id']}'>View</button>
                                <button class='btn btn-sm edit-btn btn-warning' data-id='{$row['cmp_id']}'>Edit</button>
                                <button class='btn btn-sm btn-danger delete-btn' data-id='{$row['cmp_id']}'>Delete</button>
                            </td>
                        </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function () {
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

            handleFormSubmit("#addCompanyForm", "company_actions.php", "#addCompanyModal");
            handleFormSubmit("#editCompanyForm", "company_actions.php", "#editCompanyModal");

            function handleButtonClick(buttonClass, action, callback) {
                $(buttonClass).click(function () {
                    let companyId = $(this).data("id");
                    $.post("company_actions.php", { action: action, id: companyId }, callback);
                });
            }

            handleButtonClick(".view-btn", "view", function (data) {
                $("#companyDetails").html(data);
                $("#viewCompanyModal").modal("show");
            });

            handleButtonClick(".delete-btn", "delete", function (response) {
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

                $("#editCompanyModal").modal("show");
            });
        });
    </script>
</body>
</html>
