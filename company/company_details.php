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
    <?php $title='Companies'; include '../include/header.php' ?>
<body>
    <?php include '../include/sidebar.php' ?>
    <?php include 'view_company.php'; ?>
    <?php include '../include/loader.php'; ?>

    <div class="main-content">
        <header>
            <h1>Companies</h1>
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

            
            function handleButtonClick(buttonClass, action, callback) {
                $(buttonClass).click(function () {
                    let companyId = $(this).data("id");
                    startLoader();
                    $.post("company_actions.php", { action: action, id: companyId }, callback);
                });
            }

            handleButtonClick(".view-btn", "view", function (data) {
                stopLoader();
                $("#companyDetails").html(data);
                $("#viewCompanyModal").modal("show");
            });

        });
    </script>
</body>
</html>
