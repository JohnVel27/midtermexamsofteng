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
    <title>Delete Client</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<?php 
    // Ensure ClientID is provided via GET and is a valid integer
    if (isset($_GET['ClientID']) && is_numeric($_GET['ClientID'])) {
        $clientID = $_GET['ClientID'];
        $getClientByID = getClientByID($pdo, $clientID); 
        
        // Check if the client exists
        if ($getClientByID) {
?>
            <h1>Are you sure you want to delete this client?</h1>
            <div class="container" style="border-style: solid; height: 400px; padding: 20px;">
                <h2>Client Name: <?php echo htmlspecialchars($getClientByID['ClientName']); ?></h2>
                <h2>Email: <?php echo htmlspecialchars($getClientByID['Email']); ?></h2>
                <h2>Phone Number: <?php echo htmlspecialchars($getClientByID['PhoneNumber']); ?></h2>
                <h2>Address: <?php echo htmlspecialchars($getClientByID['Address']); ?></h2>
                <h2>City: <?php echo htmlspecialchars($getClientByID['City']); ?></h2>
                <h2>Zip Code: <?php echo htmlspecialchars($getClientByID['ZipCode']); ?></h2>

                <!-- Confirmation Form for Deletion -->
                <div class="deleteBtn" style="float: right; margin-right: 10px;">
                    <form action="../../core/handleform.php?ClientID=<?php echo $_GET['ClientID']; ?>" method="POST">
                        <input type="submit" name="deleteClientBtn" value="Delete" style="background-color: red; color: white; border: none; padding: 10px 15px; cursor: pointer; border-radius: 5px;">
                    </form>          
                </div>  
            </div>

<?php 
        } else {
            // If client is not found, display a message
            echo "<h2>Client not found.</h2>";
        }
    } else {
        // If ClientID is invalid or missing
        echo "<h2>Invalid Client ID.</h2>";
    }
?>
</body>
</html>