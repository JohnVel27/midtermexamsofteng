<?php 
require_once '../../core/dbconfig.php'; 
require_once '../../core/datamodel.php'; 

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to login page if not authenticated
    header("Location: ../../authentication/loginandregister.php");
    
}


// Assume $client is retrieved from the database based on ClientID
if (isset($_GET['ClientID']) && is_numeric($_GET['ClientID'])) {
    $clientID = $_GET['ClientID'];
    $client = getClientByID($pdo, $clientID); // You should have this function to get client data

    if (!$client) {
        echo "Client not found.";
        exit();
    }
} else {
    echo "Invalid Client ID.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Client Data</title>
    <link rel="stylesheet" href="../../styles/edit.css"> 
</head>
<body>

<div class="container">
    <h2 class="form-title">Edit Client Data</h2>

    <form action="../../core/handleform.php" method="POST" id="edit-client-form">
        <input type="hidden" name="ClientID" value="<?php echo htmlspecialchars($client['ClientID']); ?>">

        <label for="clientName">Client Name:</label>
        <input type="text" id="clientName" name="ClientName" value="<?php echo htmlspecialchars($client['ClientName']); ?>" required>

        <label for="clientEmail">Email:</label>
        <input type="email" id="clientEmail" name="Email" value="<?php echo htmlspecialchars($client['Email']); ?>" required>

        <label for="clientPhone">Phone Number:</label>
        <input type="text" id="clientPhone" name="PhoneNumber" value="<?php echo htmlspecialchars($client['PhoneNumber']); ?>" required>

        <label for="clientAddress">Address:</label>
        <input type="text" id="clientAddress" name="Address" value="<?php echo htmlspecialchars($client['Address']); ?>" required>

        <label for="clientCity">City:</label>
        <input type="text" id="clientCity" name="City" value="<?php echo htmlspecialchars($client['City']); ?>" required>

        <label for="clientZipCode">Zip Code:</label>
        <input type="text" id="clientZipCode" name="ZipCode" value="<?php echo htmlspecialchars($client['ZipCode']); ?>" required>

        <button type="submit" name="editClientBtn" class="submit-btn">Edit</button>
    </form>
</div>

</body>
</html>