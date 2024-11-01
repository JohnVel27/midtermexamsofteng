<?php
// Include necessary files for database configuration and data handling
require_once '../../core/datamodel.php'; // Data model functions
require_once '../../core/handleform.php';

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to login page if not authenticated
    header("Location: ../../authentication/loginandregister.php");
    
}

// Fetch all staff and client for display
$clients = getAllClients($pdo);
$staff = getAllStaff($pdo);

// Get the project ID from the query string
$project_id = isset($_GET['ProjectID']) ? intval($_GET['ProjectID']) : 0;

// Fetch the project details for the given project ID
$project = null;
if ($project_id) {
    $sql = "SELECT * FROM projects WHERE ProjectID = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$project_id]);
    $project = $stmt->fetch();
}

if (!$project) {
    die("Project not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Project</title>
    <link rel="stylesheet" href="../../styles/editprojectstyles.css">
</head>
<body>
<h1>Edit Project for Client</h1>

<form action="../../core/handleform.php?ProjectID=<?php echo htmlspecialchars($project_id); ?>" method="POST" id="edit-project-form">
    <div class="ClientID">
        <label for="clientID">Client Name:</label>
        <select id="clientID" name="ClientID" required>
            <option value="">Select Client</option>
            <?php foreach ($clients as $client): ?>
                <option value="<?php echo htmlspecialchars($client['ClientID']); ?>" <?php echo $client['ClientID'] == $project['ClientID'] ? 'selected' : ''; ?>>
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
                <option value="<?php echo htmlspecialchars($staffMember['StaffID']); ?>" <?php echo $staffMember['StaffID'] == $project['StaffID'] ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($staffMember['FirstName'] . ' ' . $staffMember['LastName']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="DateFiled">
        <label for="dateFiled">Date Filed:</label>
        <input type="date" id="dateFiled" name="DateFiled" value="<?php echo htmlspecialchars($project['DateFiled']); ?>" required>
    </div>

    <div class="ProjectSpecification">
        <label for="ProjectSpecification">Project Specification:</label>
        <textarea id="ProjectSpecification" name="ProjectSpecification" rows="4" required><?php echo htmlspecialchars($project['ProjectSpecification']); ?></textarea>
    </div>

    <div class="PriorityLevel">
        <label for="priorityLevel">Priority Level:</label>
        <select id="priorityLevel" name="PriorityLevel" required>
            <option value="High" <?php echo $project['PriorityLevel'] == 'High' ? 'selected' : ''; ?>>High</option>
            <option value="Medium" <?php echo $project['PriorityLevel'] == 'Medium' ? 'selected' : ''; ?>>Medium</option>
            <option value="Low" <?php echo $project['PriorityLevel'] == 'Low' ? 'selected' : ''; ?>>Low</option>
        </select>
    </div>

    <div class="Status">
        <label for="status">Status:</label>
        <select id="status" name="Status" required>
            <option value="In progress" <?php echo $project['Status'] == 'In progress' ? 'selected' : ''; ?>>In progress</option>
            <option value="Completed" <?php echo $project['Status'] == 'Completed' ? 'selected' : ''; ?>>Completed</option>
            <option value="Pending" <?php echo $project['Status'] == 'Pending' ? 'selected' : ''; ?>>Pending</option>
        </select>
    </div>

    <div class="DueDate">
        <label for="dueDate">Due Date:</label>
        <input type="date" id="dueDate" name="DueDate" value="<?php echo htmlspecialchars($project['DueDate']); ?>" required>
    </div>

    <div class="RemainingDays">
        <label for="remainingDays">Remaining Days:</label>
        <input type="number" id="remainingDays" name="RemainingDays" value="<?php echo htmlspecialchars($project['RemainingDays']); ?>" required>
    </div>

    <div class="Remarks">
        <label for="remarks">Remarks:</label>
        <textarea id="remarks" name="Remarks" rows="4"><?php echo htmlspecialchars($project['Remarks']); ?></textarea>
    </div>

    <button type="submit" name="updateProjectBtn">Update Project</button>
</form>

</body>
</html>