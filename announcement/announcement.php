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
    <?php $title='Announcement'; include '../include/header.php' ?>
    <link rel="stylesheet" href="css/style.css" />

<body>
    <?php include '../include/sidebar.php'; ?>
    <?php include 'add_announcement.php'; ?>
    <?php include 'edit_announcement.php'; ?>
    
    <div class="main-content">
        <header>
            <h1>Announcements</h1>
            <div class="header-right">
                <button class="add-btn" data-bs-toggle="modal" data-bs-target="#addAnnouncementModal">Post Announcement</button>
            </div>
        </header>

        <div class="row">
            <?php
                $currentMonth = date('m');
                $currentYear = date('Y');
                $sql = "SELECT * FROM announcement AS an JOIN company AS c ON an.cmp_id=c.cmp_id  WHERE MONTH(an.post_date) = $currentMonth AND YEAR(an.post_date) = $currentYear;";
                $result = $conn->query($sql);

                while ($row = $result->fetch_assoc()) {
                    
                    echo  "<div class='col-6'>
                                <div class='card announcement-card shadow' data-row='". json_encode($row) ."'>
                                    <div class='card-header announcement-header'>
                                        <h3>{$row['cmp_name']} <span class='fs-5'>( {$row['job_role']} )</span></h3>
                                        <small>Posted on: {$row['post_date']}</small>
                                    </div>
                                    <div class='card-body'>
                                        <p class='card-text'>Date of visit : {$row['date_of_visit']}</p>
                                        <p class='card-text'>Venue : {$row['venue']}</p> 
                                        <p>Eligible Criteria : {$row['eligible_criteria']}</p>" .
                                        ($row['message'] || $row['salary_pkg'] ? "
                                            <div class='collapse' id='collapseExample-{$row['announcement_id']}'>".
                                                ($row['salary_pkg'] ? "<p class='card-text'>Salary Package : {$row['salary_pkg']}</p>" : "") . 
                                                ($row['message'] ? "<p class='card-text'>Description : {$row['message']}</p>" : "") .
                                            "</div>" : "").
                                    "</div>
                                    <div class='card-footer announcement-footer'>".
                                    ($row['message'] || $row['salary_pkg'] ? "
                                            <a data-bs-toggle='collapse' href='#collapseExample-{$row['announcement_id']}' role='button'>More details</a>
                                        " : "" ).
                                        "<button class='btn btn-secondary btn-sm edit-btn' data-id='{$row['announcement_id']}'>Edit</button>
                                        <button class='btn btn-danger btn-sm delete-btn' data-id='{$row['announcement_id']}'>Delete</button>
                                    </div>
                                </div>
                            </div>";
                    
                    /* echo "
                        <div class='col-6'>
                            <div class='accordion announcement-card' id='accordion-{$row['announcement_id']}'>
                                <div class='accordion-item'>
                                    <h2 class='accordion-header shadow'>
                                    <button class='accordion-button' type='button' data-bs-toggle='collapse' data-bs-target='#collapse-{$row['announcement_id']}'>
                                        {$row['cmp_name']} <span class='fs-5'>( {$row['job_role']} )
                                    </button>
                                    </h2>
                                    <div id='collapse-{$row['announcement_id']}' class='accordion-collapse collapse' data-bs-parent='#accordion-{$row['announcement_id']}'>
                                        <div class='accordion-body'>
                                            <div class='card-body'>
                                                <p class='card-text'>Date of visit : {$row['date_of_visit']}</p>
                                                <p class='card-text'>Venue : {$row['venue']}</p>
                                                <p class='card-text'>Venue : {$row['salary_pkg']}</p>
                                                <div class='collapse' id='collapseExample-{$row['announcement_id']}'>
                                                    {$row['message']}
                                                </div>
                                            </div>
                                            <div class='card-footer announcement-footer'>
                                                <a data-bs-toggle='collapse' href='#collapseExample-{$row['announcement_id']}' role='button'>More details</a>
                                                <button class='btn btn-secondary btn-sm'>Edit</button>
                                                <button class='btn btn-danger btn-sm'>Delete</button>
                                            </div> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    "; */
                }
            ?>

        </div>
    </div>

    <script src="../js/global.js"></script>

    
    <script>
        $(document).ready(function () {
            new Choices('#choices-multiple', {
                removeItemButton: true,
                placeholder: true,
                placeholderValue: 'Select some options',
            });

            let editChoices = new Choices('#editEligibleCriteria', {
                removeItemButton: true,
                placeholder: true,
                placeholderValue: 'Select some options',
            });

            handleFormSubmit("#addAnnouncementForm", "Announcement_actions.php", "#addAnnouncementModal");
            handleFormSubmit("#editAnnouncementForm", "Announcement_actions.php", "#editAnnouncementModal");

            handleButtonClick("Announcement_actions.php",".delete-btn", "delete", function (response) {
                stopLoader();
                alert(response);
                location.reload();
            });

            $(".edit-btn").click(function() {
                let row = $(this).parents(".announcement-card")[0];
                let data = JSON.parse(row.getAttribute("data-row"));
                let AnnouncementId = $(this).data("id");
                let eligible_departments = data.eligible_criteria.split(',');

                $("#editID").val(AnnouncementId);
                $("#editAdminID").val(data.admin_id);
                $("#editCompany").val(data.cmp_id);
                $("#editDateOfVisit").val(data.date_of_visit);
                $("#editVenue").val(data.venue);

                editChoices.removeActiveItems();
                editChoices.setChoiceByValue(eligible_departments);
                
                $("#editJobRole").val(data.job_role);
                $("#editSalaryPkg").val(data.salary_pkg);
                $("#editDescription").val(data.message);

                $("#editAnnouncementModal").modal("show");
            });
        });
    </script>
</body>
</html>
