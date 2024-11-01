<?php
// Include necessary files for database configuration and data handling
require_once '../core/dbconfig.php'; // Database connection
require_once '../core/datamodel.php'; // Data model functions
require_once '../core/handleform.php'; // Handle form

// Fetch all staff for display
$staff = getAllStaff($pdo);

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
    <title>Document</title>
    <link rel="stylesheet" href="../styles/viewstyle.css"> <!-- Linking to the CSS file -->

</head>
<body>

<!-- Button to open the modal -->
<button id="openClientModal">Add Staff</button>

<!-- Modal Structure -->
<div id="clientModal" class="modal">
    <div class="modal-content">
        <span class="close-button">&times;</span>
        <!-- Staff Form -->
        <form method="POST" action="../core/handleform.php" id="staffForm">
            <h2>Staff Information</h2>
            <div class="form-group">
                <label for="staffFirstName">First Name:</label>
                <input type="text" id="staffFirstName" name="staffFirstName" required>
            </div>
            <div class="form-group">
                <label for="staffLastName">Last Name:</label>
                <input type="text" id="staffLastName" name="staffLastName" required>
            </div>
            <div class="form-group">
                <label for="staffEmail">Email:</label>
                <input type="email" id="staffEmail" name="staffEmail" required>
            </div>
            <div class="form-group">
                <label for="staffPhone">Phone Number:</label>
                <input type="text" id="staffPhone" name="staffPhone">
            </div>
            <div class="form-group">
                <label for="staffPosition">Position:</label>
                <input type="text" id="staffPosition" name="staffPosition">
            </div>
            <button type="submit" name="insertStaffBtn">Submit Staff</button>
        </form>
    </div>
</div>

    <!-- Staff Table -->
    <h2>Staff</h2>
        <table>
            <thead>
                <tr>
                    <th>Staff ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Position</th>
                    <th>Added by </th> 
                    <th>Last Updated by</th> 
                    <th>Added at</th>
                    <th>Last Updated at</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($staff) > 0): ?>
                    <?php foreach ($staff as $staffMember): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($staffMember['StaffID']); ?></td>
                            <td><?php echo htmlspecialchars($staffMember['FirstName']); ?></td>
                            <td><?php echo htmlspecialchars($staffMember['LastName']); ?></td>
                            <td><?php echo htmlspecialchars($staffMember['Email']); ?></td>
                            <td><?php echo htmlspecialchars($staffMember['PhoneNumber']); ?></td>
                            <td><?php echo htmlspecialchars($staffMember['Position']); ?></td>
                            <td><?php echo htmlspecialchars($staffMember['CreatedBy']); ?></td> <!-- Display Created By -->
                            <td><?php echo htmlspecialchars($staffMember['UpdatedBy']); ?></td> <!-- Display Updated By -->
                            <td><?php echo htmlspecialchars($staffMember['CreatedAt']); ?></td> <!-- Display Created At -->
                            <td><?php echo htmlspecialchars($staffMember['UpdatedAt']); ?></td> <!-- Display Updated At -->
                            <td>
                                <form action="../operation/update/editstaff.php" method="GET" style="display:inline;">
                                    <input type="hidden" name="StaffID" value="<?php echo htmlspecialchars($staffMember['StaffID']); ?>">
                                    <button type="submit" class="edit-btn">Edit</button>
                                </form>
                                <form action="../operation/delete/deletestaff.php" method="GET" style="display:inline;">
                                    <input type="hidden" name="StaffID" value="<?php echo htmlspecialchars($staffMember['StaffID']); ?>">
                                    <button type="submit" class="delete-btn">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">No staff found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script src="../javascript/modal.js"></script> <!-- Link to your external JavaScript file -->
    <a href="../index.php">Return</a>

</body>
</html>