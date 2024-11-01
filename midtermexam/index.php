<?php
// Include necessary files for database configuration and data handling
require_once 'core/dbconfig.php'; // Database connection
require_once 'core/datamodel.php'; // Data model functions
require_once 'core/handleform.php'; // Handle form

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to login page if not authenticated
    header("Location: authentication/loginandregister.php");
    
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles/dashboard.css"> <!-- Link to your CSS file -->
</head>
<body>
    <div class="dashboard">
        <aside class="sidebar">
            <h2>Dashboard</h2>
            <ul>
                <li><a href="#home">Home</a></li>
                <li><a href="views/clientlist.php">Client List</a></li>
                <li><a href="views/stafflist.php">Staff List</a></li>
                <li><a href="views/adminlist.php">Admin List</a></li>
                <li><a href="views/projectlist.php">Project List</a></li>
                <li><a href="core/handleform.php?logoutAUser=1">Logout</a></li>
            </ul>
        </aside>
        <main class="main-content">
            <?php if (isset($_SESSION['message'])) { ?>
                <h1 style="color: red;"><?php echo $_SESSION['message']; ?></h1>
            <?php } unset($_SESSION['message']); ?>

            <?php if (isset($_SESSION['username'])) { ?>
                <h1>Hello, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1> <!-- Display username -->
            <?php } else { ?>
                <h1>Welcome to the Dashboard</h1>
            <?php } ?>
        </main>
    </div>
</body>
</html>
