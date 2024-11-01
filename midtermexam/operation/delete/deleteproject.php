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
    <title>Delete Project</title>
</head>
<body>

<?php 
    // Ensure ProjectID is provided via GET and is a valid integer
    if (isset($_GET['ProjectID']) && is_numeric($_GET['ProjectID'])) {
        $projectID = $_GET['ProjectID'];
        $getProjectByID = getProjectByID($pdo, $projectID); 
        
        // Check if the project exists
        if ($getProjectByID) {
?>
            <h1>Are you sure you want to delete this project?</h1>
            <div class="container" style="border-style: solid; height: 400px; padding: 20px;">
                <h2>Project Name: <?php echo htmlspecialchars($getProjectByID['ProjectSpecification']); ?></h2>
                <h2>Priority Level: <?php echo htmlspecialchars($getProjectByID['PriorityLevel']); ?></h2>
                <h2>Status: <?php echo htmlspecialchars($getProjectByID['Status']); ?></h2>
                <h2>Due Date: <?php echo htmlspecialchars($getProjectByID['DueDate']); ?></h2>

                <!-- Confirmation Form for Deletion -->
                <div class="deleteBtn" style="float: right; margin-right: 10px;">
                    <form action="../../core/handleform.php?ProjectID=<?php echo $_GET['ProjectID']; ?>" method="POST">
                        <input type="submit" name="deleteProjectBtn" value="Delete" style="background-color: red; color: white; border: none; padding: 10px 15px; cursor: pointer; border-radius: 5px;">
                    </form>          
                </div>  
            </div>

<?php 
        } else {
            // If project is not found, display a message
            echo "<h2>Project not found.</h2>";
        }
    } else {
        // If ProjectID is invalid or missing
        echo "<h2>Invalid Project ID.</h2>";
    }
?>
</body>
</html>
