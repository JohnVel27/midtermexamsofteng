<?php

require_once '../core/datamodel.php'; // Data model functions
require_once '../core/handleform.php'; // Handle form

// Fetch all staff and client for display
$clients = getAllClients($pdo);
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
    <title>Project List</title>
    <link rel="stylesheet" href="../styles/viewstyle.css"> <!-- Linking to the CSS file -->
</head>
<body>
    
<!-- Button to Open the Modal -->
<button id="openProjectModal">Add New Project</button>

<!-- The Modal -->
<div id="projectModal" class="modal">
    <div class="modal-content">
        <span class="close-button">&times;</span>
        <h2>Project Information</h2>
        <form action="../core/handleform.php" method="POST" id="insert-project-form">
            <div class="ClientID">
                <label for="clientID">Client Name:</label>
                <select id="clientID" name="ClientID" required>
                    <option value="">Select Client</option>
                    <?php foreach ($clients as $client): ?>
                        <option value="<?php echo htmlspecialchars($client['ClientID']); ?>">
                            <?php echo htmlspecialchars($client['ClientName']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="StaffID">
                <label for="staffID">Staff Name:</label>
                <select id="staffID" name="StaffID" required>
                    <option value="">Select Staff</option>
                    <?php foreach ($staff as $staffMember): ?>
                        <option value="<?php echo htmlspecialchars($staffMember['StaffID']); ?>">
                            <?php echo htmlspecialchars($staffMember['FirstName'] . ' ' . $staffMember['LastName']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="DateFiled">
                <label for="dateFiled">Date Filed:</label>
                <input type="date" id="dateFiled" name="DateFiled" required>
            </div>

            <div class="ProjectSpecification">
                <label for="projectSpecification">Project Specification:</label>
                <textarea id="projectSpecification" name="ProjectSpecification" rows="4" required></textarea>
            </div>

            <div class="Prioritylevel">
                <label for="priorityLevel">Priority Level:</label>
                <select id="priorityLevel" name="PriorityLevel" required>
                    <option value="">Select Priority Level</option>
                    <option value="High">High</option>
                    <option value="Medium">Medium</option>
                    <option value="Low">Low</option>
                </select>
            </div>

            <div class="Status">
                <label for="status">Status:</label>
                <select id="status" name="Status" required>
                    <option value="">Select Status</option>
                    <option value="In progress">In progress</option>
                    <option value="Completed">Completed</option>
                    <option value="Pending">Pending</option>
                </select>
            </div>

            <div class="DueDate">
                <label for="dueDate">Due Date:</label>
                <input type="date" id="dueDate" name="DueDate" required>
            </div>

            <div class="RemainingDays">
                <label for="remainingDays">Remaining Days:</label>
                <input type="number" id="remainingDays" name="RemainingDays" required>
            </div>

            <div class="Remarks">
                <label for="remarks">Remarks:</label>
                <textarea id="remarks" name="Remarks" rows="4"></textarea>
            </div>

            <button type="submit" name="insertProjectBtn">Submit Project</button>
        </form>
    </div>
</div>

<!-- Project List Table -->
    <h2>Project List</h2>
    <table>
        <thead>
            <tr>
                <th>Project ID</th>
                <th>ClientID</th>
                <th>StaffID</th>
                <th>Date Filed</th>
                <th>Project Specification</th>
                <th>Priority Level</th>
                <th>Status</th>
                <th>Due Date</th>
                <th>Remaining Days</th>
                <th>Remarks</th>
                <th>Created By</th>
                <th>Updated By</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Assuming you have a function to fetch all projects
            $projects = getAllProjects($pdo);
            if (count($projects) > 0): 
                foreach ($projects as $project): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($project['ProjectID']); ?></td>
                        <td><?php echo htmlspecialchars($project['ClientID']); // Fetch client name based on ClientID ?></td>
                        <td><?php echo htmlspecialchars($project['StaffID']); // Fetch staff name based on StaffID ?></td>
                        <td><?php echo htmlspecialchars($project['DateFiled']); ?></td>
                        <td><?php echo htmlspecialchars($project['ProjectSpecification']); ?></td>
                        <td><?php echo htmlspecialchars($project['PriorityLevel']); ?></td>
                        <td><?php echo htmlspecialchars($project['Status']); ?></td>
                        <td><?php echo htmlspecialchars($project['DueDate']); ?></td>
                        <td><?php echo htmlspecialchars($project['RemainingDays']); ?></td>
                        <td><?php echo htmlspecialchars($project['Remarks']); ?></td>
                        <td><?php echo htmlspecialchars($project['CreatedBy']); // Fetch admin name based on CreatedBy ?></td>
                        <td><?php echo htmlspecialchars($project['UpdatedBy']); // Fetch admin name based on UpdatedBy ?></td>
                        <td><?php echo htmlspecialchars($project['CreatedAt']); ?></td>
                        <td><?php echo htmlspecialchars($project['UpdatedAt']); ?></td>
                        <td>
                            <form action="../operation/update/editproject.php" method="GET" style="display:inline;">
                                <input type="hidden" name="ProjectID" value="<?php echo htmlspecialchars($project['ProjectID']); ?>">
                                <button type="submit" class="edit-btn">Edit</button>
                            </form>
                            <form action="../operation/delete/deleteproject.php" method="GET" style="display:inline;">
                                <input type="hidden" name="ProjectID" value="<?php echo htmlspecialchars($project['ProjectID']); ?>">
                                <button type="submit" class="delete-btn">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="15">No projects found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    </div>

<script src="../javascript/projectmodal.js"></script> <!-- Link to your external JavaScript file -->
<a href="../index.php">Return</a>

</body>
</html>