<?php 
 require_once "dbconfig.php";
 require_once "datamodel.php";
 require_once "validate.php";

// Registration Handler
if (isset($_POST['registerUserBtn'])) {
    // Retrieve and sanitize input data
    $firstname = sanitizeInput($_POST['firstname']);
    $lastname = sanitizeInput($_POST['lastname']);
    $username = sanitizeInput($_POST['username']);
    $email = sanitizeInput($_POST['email']);
    $gender = sanitizeInput($_POST['gender']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate input fields
    if (!empty($firstname) && !empty($lastname) && !empty($username) && !empty($email) && !empty($gender) && !empty($password) && !empty($confirm_password)) {
        if ($password === $confirm_password) {
            if (validatePassword($password)) {
                // Hash the password
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

                // Use the insertNewAdmin function to handle the insertion
                $insertSuccess = insertNewAdmin($pdo, $firstname, $lastname, $username, $email, $gender, $hashedPassword);

                if ($insertSuccess) {
                    $_SESSION['register_message'] = "Registration successful!";
                    $_SESSION['message_type'] = "success";
                    header("Location: ../authentication/loginandregister.php");
                    exit();
                } else {
                    $_SESSION['register_message'] = "Username already Exist.Please try again";
                    $_SESSION['message_type'] = "error";
                    header("Location: ../authentication/loginandregister.php");
                }
            } else {
                $_SESSION['register_message'] = "Password must contain uppercase, lowercase, and numbers, and be at least 8 characters.";
                $_SESSION['message_type'] = "error";
                header("Location: ../authentication/loginandregister.php");
            }
        } else {
            $_SESSION['register_message'] = "Passwords do not match!";
            $_SESSION['message_type'] = "error";
            header("Location: ../authentication/loginandregister.php");
        }
    } else {
        $_SESSION['register_message'] = "All fields are required!";
        $_SESSION['message_type'] = "error";
        header("Location: ../authentication/loginandregister.php");
    }
}


// Login Handler
if (isset($_POST['loginUserBtn'])) {
    // Sanitize user input
    $username = sanitizeInput($_POST['username']);
    $password = $_POST['password']; // Get the plain text password

    // Validate input
    if (!empty($username) && !empty($password)) {
        // Attempt to login
        $loginResult = loginAdmin($pdo, $username, $password);

        if ($loginResult === true) {
            // Login successful, set session variables
            $_SESSION['username'] = $username; // Store username in session
            header("Location: ../index.php");
            exit();
        } elseif ($loginResult === 'incorrect_password') {
            // Password did not match
            $_SESSION['login_message'] = "Incorrect password. Please try again.";
            $_SESSION['message_type'] = "error";
        } elseif ($loginResult === 'username_not_exist') {
            // Username not found
            $_SESSION['login_message'] = "Username does not exist.";
            $_SESSION['message_type'] = "error";
        }
    } else {
        $_SESSION['login_message'] = "All fields are required!";
        $_SESSION['message_type'] = "error";
    }

    // Redirect back to the login page after processing
    header("Location: ../authentication/loginandregister.php");
    exit();
}


// Logout handler
if (isset($_GET['logoutAUser'])) {
    // Unset all session variables
    session_unset();
    session_destroy();
    
    // Set headers to prevent back navigation after logout
    header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
    header("Pragma: no-cache"); // HTTP 1.0.
    header("Expires: 0"); // Proxies.

    // Redirect to the login page
    header('Location: ../authentication/loginandregister.php');
    exit();
}

// Client Inserting handle form
if (isset($_POST['insertClientBtn'])) {
    // Retrieve the current admin ID from the session (assuming it's stored in session)
    $adminId = $_SESSION['admin_id']; // Adjust based on how you store the admin ID

    // Call the insertClient function
    try {
        $success = insertClient($pdo, $_POST['ClientName'], $_POST['Email'], $_POST['PhoneNumber'], $_POST['Address'], $_POST['City'], $_POST['ZipCode'], $adminId);
        if ($success) {
            // Redirect or display success message
            header("Location: ../views/clientlist.php");
            exit();
        }
    } catch (Exception $e) {
        // Handle exception (e.g., log it, show error message)
        echo "Error: " . $e->getMessage();
    }
}

// Client Editing handle form
if (isset($_POST['editClientBtn'])) {
    // Ensure ClientID is passed
    if (isset($_POST['ClientID'])) {
        $clientID = $_POST['ClientID'];
        $clientName = $_POST['ClientName'];
        $email = $_POST['Email'];
        $phoneNumber = $_POST['PhoneNumber'];
        $address = $_POST['Address'];
        $city = $_POST['City'];
        $zipcode = $_POST['ZipCode'];

        // Retrieve the current admin ID from the session
        $adminId = $_SESSION['admin_id'];

        // Call the updateClient function with UpdatedBy and auto-updated UpdatedAt
        $query = updateClient($pdo, $clientID, $clientName, $email, $phoneNumber, $address, $city, $zipcode, $adminId);

        if ($query) {
            header("Location: ../views/clientlist.php?message=Client+Edited+successfully"); // Redirect after successful edit
            exit(); // Always exit after a redirect
        } else {
            echo "Edit failed"; // Handle error if query fails
        }
    } else {
        echo "Client ID is missing.";
    }
}



// Client deleting handle form
if (isset($_POST['deleteClientBtn']) && isset($_GET['ClientID'])) {
    $clientID = $_GET['ClientID'];

    // Call delete function
    $query = deleteClient($pdo, $clientID);

    if ($query) {
        header("Location: ../views/clientlist.php?message=Client+deleted+successfully");
        exit();
    } else {
        echo "Deletion failed";
    }
}





// Staff Insertion Handling
if (isset($_POST['insertStaffBtn'])) {
    // Retrieve the current admin ID from the session
    $adminId = $_SESSION['admin_id']; // Adjust based on how you store the admin ID

    // Retrieve the staff information from the form
    $firstName = $_POST['staffFirstName'];
    $lastName = $_POST['staffLastName'];
    $email = $_POST['staffEmail'];
    $phoneNumber = $_POST['staffPhone'];
    $position = $_POST['staffPosition'];

    // Call the insertStaff function
    try {
        $success = insertStaff($pdo, $firstName, $lastName, $email, $phoneNumber, $position, $adminId);
        if ($success) {
            // Redirect or display success message
            header("Location: ../views/stafflist.php"); // Redirect to a staff list page
            exit();
        }
    } catch (Exception $e) {
        // Handle exception (e.g., log it, show error message)
        echo "Error: " . $e->getMessage();
    }
}

// Staff Editing Handling
if (isset($_POST['editStaffBtn'])) {
    // Ensure StaffID is passed
    if (isset($_POST['StaffID'])) {
        $staffID = $_POST['StaffID'];
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $email = $_POST['email'];
        $phoneNumber = $_POST['phoneNumber'];
        $position = $_POST['position'];

        // Retrieve the current admin ID from the session
        $adminId = $_SESSION['admin_id'];

        // Call the updateStaff function with UpdatedBy and auto-updated UpdatedAt
        $query = updateStaff($pdo, $staffID, $firstName, $lastName, $email, $phoneNumber, $position, $adminId);

        if ($query) {
            header("Location: ../views/stafflist.php?message=Staff+Edited+successfully"); // Redirect after successful edit
            exit(); // Always exit after a redirect
        } else {
            echo "Edit failed"; // Handle error if query fails
        }
    } else {
        echo "Staff ID is missing.";
    }
}




// Handle staff deletion
if (isset($_POST['deleteStaffBtn'])) {
    $query = deleteStaff($pdo, $_GET['StaffID']);

    if ($query) {
        header("Location: ../views/stafflist.php?message=Staff+deleted+successfully");
        exit();
    } else {
        echo "Deletion failed";
    }
}

// Handle project insertion
if (isset($_POST['insertProjectBtn'])) {
    // Retrieve the current admin ID from the session
    $adminId = $_SESSION['admin_id']; // Adjust based on how you store the admin ID

    // Retrieve the project information from the form
    $clientID = $_POST['ClientID'];
    $staffID = $_POST['StaffID'];
    $dateFiled = $_POST['DateFiled'];
    $projectSpecification = $_POST['ProjectSpecification'];
    $priorityLevel = $_POST['PriorityLevel'];
    $status = $_POST['Status'];
    $dueDate = $_POST['DueDate'];
    $remainingDays = $_POST['RemainingDays'];
    $remarks = $_POST['Remarks'];

    // Call the insertProject function
    try {
        $query = insertProject($pdo, $clientID, $staffID, $dateFiled, $projectSpecification, 
            $priorityLevel, $status, $dueDate, $remainingDays, $remarks, $adminId);

        if ($query) {
            // Redirect to the index page or a success message
            header("Location: ../views/projectlist.php");
            exit();
        } else {
            // Handle the case where insertion failed
            echo "Insertion failed";
        }
    } catch (Exception $e) {
        // Handle exception (e.g., log it, show error message)
        echo "Error: " . $e->getMessage();
    }
}

// Handle project update
if (isset($_POST['updateProjectBtn'])) {
    // Ensure ProjectID is passed in the URL
    if (isset($_GET['ProjectID'])) {
        $project_id = intval($_GET['ProjectID']);

        // Validate project ID
        if ($project_id <= 0) {
            die("Invalid project ID.");
        }

        // Retrieve form data
        $clientID = isset($_POST['ClientID']) ? intval(trim($_POST['ClientID'])) : 0; // Client ID from form
        $staffID = isset($_POST['StaffID']) ? intval(trim($_POST['StaffID'])) : 0; // Staff ID from form
        $dateFiled = isset($_POST['DateFiled']) ? trim($_POST['DateFiled']) : ''; // Date filed from form
        $projectSpecification = isset($_POST['ProjectSpecification']) ? trim($_POST['ProjectSpecification']) : '';
        $priorityLevel = isset($_POST['PriorityLevel']) ? trim($_POST['PriorityLevel']) : '';
        $status = isset($_POST['Status']) ? trim($_POST['Status']) : '';
        $dueDate = isset($_POST['DueDate']) ? trim($_POST['DueDate']) : '';
        $remainingDays = isset($_POST['RemainingDays']) ? intval(trim($_POST['RemainingDays'])) : 0; // Ensure it's an integer
        $remarks = isset($_POST['Remarks']) ? trim($_POST['Remarks']) : '';

        // Validate required fields (you can customize this based on your requirements)
        $errors = [];
        if ($clientID <= 0) {
            $errors[] = "Valid Client ID is required.";
        }
        if ($staffID <= 0) {
            $errors[] = "Valid Staff ID is required.";
        }
        if (empty($dateFiled)) {
            $errors[] = "Date Filed is required.";
        }
        if (empty($projectSpecification)) {
            $errors[] = "Project Specification is required.";
        }
        if (empty($priorityLevel)) {
            $errors[] = "Priority Level is required.";
        }
        if (empty($status)) {
            $errors[] = "Status is required.";
        }
        if (empty($dueDate)) {
            $errors[] = "Due Date is required.";
        }
        if ($remainingDays < 0) {
            $errors[] = "Remaining Days cannot be negative.";
        }

        // If there are validation errors, handle them
        if (!empty($errors)) {
            foreach ($errors as $error) {
                echo "<p>$error</p>";
            }
            exit; // Stop further execution if there are errors
        }

        // Retrieve the current admin ID from the session
        $adminId = $_SESSION['admin_id'];

        // Call the updateProject function with all required parameters
        $query = updateProject($pdo, $project_id, $clientID, $staffID, $dateFiled, 
            $projectSpecification, $priorityLevel, $status, $dueDate, $remainingDays, $remarks, $adminId);

        if ($query) {
            header("Location: ../views/projectlist.php?message=Project+updated+successfully"); // Redirect after successful update
            exit(); // Always exit after a redirect
        } else {
            echo "Failed to update the project."; // Handle error if query fails
        }
    } else {
        echo "Project ID is missing."; // Handle error if ProjectID is not provided
    }
}

// Handle project deletion
if (isset($_POST['deleteProjectBtn'])) {
    $query = deleteProject($pdo, $_GET['ProjectID']); // Call deleteProject function directly with ProjectID from URL

    if ($query) {
        header("Location: ../views/projectlist.php?message=Project+deleted+successfully");
        exit();
    } else {
        echo "Deletion failed. Please try again.";
    }
}

 







?>