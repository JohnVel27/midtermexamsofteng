<?php
// Include necessary files for database configuration and data handling
require_once '../core/dbconfig.php'; // Database connection
require_once '../core/datamodel.php'; // Data model functions
require_once '../core/handleform.php'; // Handle form

// Fetch all admin accounts for display
$admins = getAllAdmins($pdo);

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to login page if not authenticated
    header("Location: ../authentication/loginandregister.php");
    
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Accounts</title>
    <link rel="stylesheet" href="../styles/viewstyle.css"> <!-- Link to your CSS file -->
</head>
<body>
    <h2>User Accounts</h2>
    <table>
        <thead>
            <tr>
                <th>Admin ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Username</th>
                <th>Email</th>
                <th>Gender</th>
                <th>Date Added</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($admins) > 0): ?>
                <?php foreach ($admins as $admin): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($admin['admin_id']); ?></td>
                        <td><?php echo htmlspecialchars($admin['firstname']); ?></td>
                        <td><?php echo htmlspecialchars($admin['lastname']); ?></td>
                        <td><?php echo htmlspecialchars($admin['username']); ?></td>
                        <td><?php echo htmlspecialchars($admin['email']); ?></td>
                        <td><?php echo htmlspecialchars($admin['gender']); ?></td>
                        <td><?php echo htmlspecialchars($admin['date_added']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" style="text-align:center;">No admin accounts found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <a href="../index.php">Return</a>
</body>
</html>
