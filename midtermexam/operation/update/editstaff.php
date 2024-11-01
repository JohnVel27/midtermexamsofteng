<?php 
require_once '../../core/dbconfig.php'; 
require_once '../../core/datamodel.php';

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to login page if not authenticated
    header("Location: ../../authentication/loginandregister.php");
    
}

// Assume $staff is retrieved from the database based on staffID
if (isset($_GET['StaffID']) && is_numeric($_GET['StaffID'])) {
    $staffID = $_GET['StaffID'];
    $staffMember = getStaffByID($pdo, $staffID); // Ensure the function name matches exactly

    if (!$staffMember) {
        echo "Staff not found.";
        exit();
    }
} else {
    echo "Invalid Staff ID.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Staff Data</title>
    <link rel="stylesheet" href="../../styles/edit.css"> 
</head>
<body>

<div class="container">
    <h2 class="form-title">Edit Staff Data</h2>

    <form action="../../core/handleform.php" method="POST" id="edit-staff-form">
        <input type="hidden" name="StaffID" value="<?php echo htmlspecialchars($staffMember['StaffID']); ?>">

        <label for="firstName">First Name:</label>
        <input type="text" id="firstName" name="firstName" value="<?php echo htmlspecialchars($staffMember['FirstName']); ?>" required>

        <label for="lastName">Last Name:</label>
        <input type="text" id="lastName" name="lastName" value="<?php echo htmlspecialchars($staffMember['LastName']); ?>" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($staffMember['Email']); ?>" required>

        <label for="phoneNumber">Phone Number:</label>
        <input type="text" id="phoneNumber" name="phoneNumber" value="<?php echo htmlspecialchars($staffMember['PhoneNumber']); ?>" required>

        <label for="position">Position:</label>
        <input type="text" id="position" name="position" value="<?php echo htmlspecialchars($staffMember['Position']); ?>" required>

        <button type="submit" name="editStaffBtn" class="submit-btn">Update Staff</button>
    </form>
</div>

</body>
</html>
