<?php

require_once '../core/datamodel.php'; // Data model functions
require_once '../core/handleform.php'; // Handle form

// Fetch all staff and client for display
$clients = getAllClients($pdo);

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
    <title>Client List</title>
    <link rel="stylesheet" href="../styles/viewstyle.css"> <!-- Linking to the CSS file -->
</head>
<body>
<button id="openClientModal">Add Client</button> <!-- Button to open modal -->

<!-- Modal Structure -->
<div id="clientModal" class="modal">
    <div class="modal-content">
        <span class="close-button">&times;</span>
        <form method="POST" action="../core/handleform.php" id="clientForm">
            <h2>Client Information</h2>
            <div class="form-group">
                <label for="clientName">Client Name:</label>
                <input type="text" name="ClientName" id="clientName" required>
            </div>
            <div class="form-group">
                <label for="clientEmail">Email:</label>
                <input type="email" name="Email" id="clientEmail" required>
            </div>
            <div class="form-group">
                <label for="clientPhone">Phone Number:</label>
                <input type="text" name="PhoneNumber" id="clientPhone" required>
            </div>
            <div class="form-group">
                <label for="clientAddress">Address:</label>
                <input type="text" name="Address" id="clientAddress" required>
            </div>
            <div class="form-group">
                <label for="clientCity">City:</label>
                <input type="text" name="City" id="clientCity" required>
            </div>
            <div class="form-group">
                <label for="clientZipCode">Zip Code:</label>
                <input type="text" name="ZipCode" id="clientZipCode" required>
            </div>
            <button type="submit" name="insertClientBtn">Submit Client</button>
        </form>
    </div>
</div>


<!-- Clients Table -->
<h2>Clients</h2>
<table>
    <thead>
        <tr>
            <th>Client ID</th>
            <th>Client Name</th>
            <th>Email</th>
            <th>Phone Number</th>
            <th>Address</th>
            <th>City</th>
            <th>Zip Code</th>
            <th>Added by </th> 
            <th>Last Updated by</th> 
            <th>Added at</th>
            <th>Last Updated at</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($clients) > 0): ?>
            <?php foreach ($clients as $client): ?>
                <tr>
                    <td><?php echo htmlspecialchars($client['ClientID']); ?></td>
                    <td><?php echo htmlspecialchars($client['ClientName']); ?></td>
                    <td><?php echo htmlspecialchars($client['Email']); ?></td>
                    <td><?php echo htmlspecialchars($client['PhoneNumber']); ?></td>
                    <td><?php echo htmlspecialchars($client['Address']); ?></td>
                    <td><?php echo htmlspecialchars($client['City']); ?></td>
                    <td><?php echo htmlspecialchars($client['ZipCode']); ?></td>
                    <td><?php echo htmlspecialchars($client['CreatedBy']); ?></td> <!-- Display Created By -->
                    <td><?php echo htmlspecialchars($client['UpdatedBy']); ?></td> <!-- Display Updated By -->
                    <td><?php echo htmlspecialchars($client['CreatedAt']); ?></td> <!-- Display Created At -->
                    <td><?php echo htmlspecialchars($client['UpdatedAt']); ?></td> <!-- Display Updated At -->
                    <td>
                        <form action="../operation/update/editclient.php" method="GET" style="display:inline;">
                            <input type="hidden" name="ClientID" value="<?php echo htmlspecialchars($client['ClientID']); ?>">
                            <button type="submit" class="edit-btn">Edit</button>
                        </form>
                        <form action="../operation/delete/deleteclient.php" method="GET" style="display:inline;">
                            <input type="hidden" name="ClientID" value="<?php echo htmlspecialchars($client['ClientID']); ?>">
                            <button type="submit" class="delete-btn">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="12" style="text-align:center;">No clients found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
    <script src="../javascript/modal.js"></script> <!-- Link to your external JavaScript file -->
    <a href="../index.php">Return</a>
</body>
</html>