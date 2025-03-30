<!-- Purpose: Sidebar for the placement cell dashboard. -->
<div class="sidebar" id="sidebar">
    <h2>Placement Cell</h2>
    <ul>
        <?php 
            if($_SESSION['user_type'] == 'admin') { ?>

                <li><a href="/placement-management-syatem/admin/dashboard.php">Dashboard</a></li>
                <li><a href="/placement-management-syatem/admin/admin.php">Admins</a></li>
                <li><a href="/placement-management-syatem/student/student.php">Students</a></li>
                <li><a href="/placement-management-syatem/company/company.php">Companies</a></li>
                <li><a href="/placement-management-syatem/announcement/announcement.php">Announcements</a></li>
                <li><a href="/placement-management-syatem/placement/student_applications.php">Student Applications</a></li>
                <li><a href="/placement-management-syatem/placement/report.php">Report</a></li>
        <?php } elseif ($_SESSION['user_type'] == 'student') { ?>
                <li><a href="/placement-management-syatem/student/dashboard.php">Dashboard</a></li>
                <li><a href="/placement-management-syatem/student/student_personal_details.php">Student</a></li>
                <li><a href="/placement-management-syatem/company/company_details.php">Companies</a></li>
                <li><a href="/placement-management-syatem/announcement/announcement_details.php">Announcements</a></li>
                <li><a href="/placement-management-syatem/student/notifications.php">Interview Status</a></li>
        <?php }
        ?>
    </ul>
    <a href="/placement-management-syatem/auth/logout.php" class="logout">Logout</a>
</div>