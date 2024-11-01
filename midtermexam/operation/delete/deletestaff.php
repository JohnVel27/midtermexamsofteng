<?php 
require_once '../../core/dbconfig.php'; 
require_once '../../core/datamodel.php'; 

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to login page if not authenticated
    header("Location: ../../authentication/loginandregister.php");
    
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Staff</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<?php 
    // Ensure StaffID is provided via GET and is a valid integer
    if (isset($_GET['StaffID']) && is_numeric($_GET['StaffID'])) {
        $staffID = $_GET['StaffID'];
        $getStaffByID = getStaffByID($pdo, $staffID); 
        
        // Check if the staff member exists
        if ($getStaffByID) {
?>
            <h1>Are you sure you want to delete this staff member?</h1>
            <div class="container" style="border-style: solid; height: 400px; padding: 20px;">
                <h2>First Name: <?php echo htmlspecialchars($getStaffByID['FirstName']); ?></h2>
                <h2>Last Name: <?php echo htmlspecialchars($getStaffByID['LastName']); ?></h2>
                <h2>Email: <?php echo htmlspecialchars($getStaffByID['Email']); ?></h2>
                <h2>Phone Number: <?php echo htmlspecialchars($getStaffByID['PhoneNumber']); ?></h2>
                <h2>Position: <?php echo htmlspecialchars($getStaffByID['Position']); ?></h2>

                <!-- Confirmation Form for Deletion -->
                <div class="deleteBtn" style="float: right; margin-right: 10px;">
                    <form action="../../core/handleform.php?StaffID=<?php echo $_GET['StaffID']; ?>" method="POST">
                        <input type="submit" name="deleteStaffBtn" value="Delete" style="background-color: red; color: white; border: none; padding: 10px 15px; cursor: pointer; border-radius: 5px;">
                    </form>          
                </div>  
            </div>

<?php 
        } else {
            // If staff member is not found, display a message
            echo "<h2>Staff member not found.</h2>";
        }
    } else {
        // If StaffID is invalid or missing
        echo "<h2>Invalid Staff ID.</h2>";
    }
?>
</body>
</html>