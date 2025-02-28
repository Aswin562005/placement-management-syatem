
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Companies - Placement Cell</title>
        <link rel="stylesheet" href="../css/global.css" />
        <link rel="stylesheet" href="../css/sidebar.css" />
        <link rel="stylesheet" href="css/company.css">
    </head>
<body>
    <?php include '../include/sidebar.php'; ?>

    <div class="main-content">
        <header>
            <h1>Companies</h1>
            <button class="add-company-btn">Add Company</button>
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
                <tr>
                    <td>1</td>
                    <td>ABC Corp</td>
                    <td>contact@abccorp.com</td>
                    <td>Technology</td>
                    <td class="actions">
                        <button class="view-btn">View</button>
                        <button class="edit-btn">Edit</button>
                        <button class="delete-btn">Delete</button>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>XYZ Ltd</td>
                    <td>hr@xyzltd.com</td>
                    <td>Finance</td>
                    <td class="actions">
                        <button class="view-btn">View</button>
                        <button class="edit-btn">Edit</button>
                        <button class="delete-btn">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>
