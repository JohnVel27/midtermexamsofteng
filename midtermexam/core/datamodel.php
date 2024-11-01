<?php 
require_once "dbconfig.php";

function insertNewAdmin($pdo, $firstname, $lastname, $username, $email, $gender, $hashedPassword) {
    // Check if the username already exists
    $checkAdminSql = "SELECT * FROM admin_accounts WHERE username = ?";
    $checkAdminSqlStmt = $pdo->prepare($checkAdminSql);
    $checkAdminSqlStmt->execute([$username]);

    if ($checkAdminSqlStmt->rowCount() == 0) {
        // Insert new admin account
        $sql = "INSERT INTO admin_accounts (firstname, lastname, username, email, gender, password) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);

        // Execute the query with the hashed password
        $executeQuery = $stmt->execute([$firstname, $lastname, $username, $email, $gender, $hashedPassword]);

        if ($executeQuery) {
            return true; // Return true if the insertion is successful
        } else {
            $_SESSION['register_message'] = "An error occurred with the query"; // Error message if query fails
        }
    } else {
        $_SESSION['register_message'] = "Admin already exists"; // Message if the username already exists
    }
    return false; // Return false if the insertion fails or admin exists
}





function loginAdmin($pdo, $username, $password) {
    // Check if the username exists
    $query = "SELECT * FROM admin_accounts WHERE username = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC); // Fetch user data

    if ($user) {
        // User exists, verify the password
        if (password_verify($password, $user['password'])) {
            // Password is correct
            $_SESSION['admin_id'] = $user['admin_id']; // Store admin ID in session for future use
            return true; // Login successful
        } else {
            return 'incorrect_password'; // Password is incorrect
        }
    } else {
        return 'username_not_exist'; // Username does not exist
    }
}

function getAllAdmins($pdo) {
    $sql = "SELECT * FROM admin_accounts"; // Change table name to admin_accounts
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute();

    if ($executeQuery) {
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all results as an associative array
    }

    return []; // Return an empty array if the query fails
}
// fetch the record in row
function getAdminByID($pdo, $admin_id) {
    $sql = "SELECT * FROM admin_accounts WHERE admin_id = ?"; // Change table name to admin_accounts
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$admin_id]);

    if ($executeQuery) {
        return $stmt->fetch(PDO::FETCH_ASSOC); // Fetch a single result as an associative array
    }

    return null; // Return null if the query fails or no record is found
}

//fetch the username
function getAdminUsernameByID($pdo, $admin_id) {
    $sql = "SELECT username FROM admin_accounts WHERE admin_id = ?"; // Select only the username
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$admin_id]);

    if ($executeQuery) {
        return $stmt->fetchColumn(); // Fetch the username directly
    }

    return null; // Return null if the query fails or no record is found
}


//Create the Client 
function insertClient($pdo, $ClientName, $Email, $PhoneNumber, $Address, $City, $ZipCode, $adminId) {
    // Prepare the SQL statement. CreatedAt is set automatically, UpdatedAt remains NULL on insert.
    $sql = "INSERT INTO Clients (ClientName, Email, PhoneNumber, Address, City, ZipCode, CreatedBy, UpdatedBy, CreatedAt, UpdatedAt) 
            VALUES (?, ?, ?, ?, ?, ?, ?, NULL, CURRENT_TIMESTAMP, NULL)";
    $stmt = $pdo->prepare($sql);

    // Execute the query with the provided values
    $executeQuery = $stmt->execute([$ClientName, $Email, $PhoneNumber, $Address, $City, $ZipCode, $adminId]);

    // Return the last inserted ID or false on failure
    return $executeQuery ? $pdo->lastInsertId() : false; 
}

//Updated the Client
function updateClient($pdo, $ClientID, $ClientName, $Email, $PhoneNumber, $Address, $City, $ZipCode, $adminId) {
    $sql = "UPDATE Clients SET 
                ClientName = ?, 
                Email = ?, 
                PhoneNumber = ?, 
                Address = ?, 
                City = ?, 
                ZipCode = ?, 
                UpdatedBy = ?, 
                UpdatedAt = CURRENT_TIMESTAMP 
            WHERE ClientID = ?";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$ClientName, $Email, $PhoneNumber, $Address, $City, $ZipCode, $adminId, $ClientID]);
}



// Delete a client
function deleteClient($pdo, $ClientID) {
    $sql = "DELETE FROM clients WHERE ClientID = ?";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$ClientID]);

    return $executeQuery; // Return true or false based on execution result
}

// Get all Clients
function getAllClients($pdo) {
    $sql = "
        SELECT 
            c.ClientID, 
            c.ClientName, 
            c.Email, 
            c.PhoneNumber, 
            c.Address, 
            c.City, 
            c.ZipCode, 
            ca.username AS CreatedBy,      -- Fetching username for CreatedBy
            ua.username AS UpdatedBy,       -- Fetching username for UpdatedBy
            c.CreatedAt, 
            c.UpdatedAt
        FROM 
            Clients c
        LEFT JOIN 
            admin_accounts ca ON c.CreatedBy = ca.admin_id  -- Adjust to match the actual column name for admin ID in admin_accounts
        LEFT JOIN 
            admin_accounts ua ON c.UpdatedBy = ua.admin_id  -- Adjust to match the actual column name for admin ID in admin_accounts
    ";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}



// Get a client by ID
function getClientByID($pdo, $ClientID) {
    $sql = "SELECT * FROM clients WHERE ClientID = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$ClientID]);

    if ($stmt->rowCount() > 0) { // Check if any rows were returned
        return $stmt->fetch();
    }
    return false; // Return false if no client is found
}


// Insert a new staff member
function insertStaff($pdo, $firstName, $lastName, $email, $phoneNumber, $position, $adminId) {
    // Prepare the SQL statement. CreatedAt is set automatically, UpdatedAt remains NULL on insert.
    $sql = "INSERT INTO staff (FirstName, LastName, Email, PhoneNumber, Position, CreatedBy, UpdatedBy, CreatedAt, UpdatedAt) 
            VALUES (?, ?, ?, ?, ?, ?, NULL, CURRENT_TIMESTAMP, NULL)";
    $stmt = $pdo->prepare($sql);

    // Execute the query with the provided values
    $executeQuery = $stmt->execute([$firstName, $lastName, $email, $phoneNumber, $position, $adminId]);

    // Return the last inserted ID or false on failure
    return $executeQuery ? $pdo->lastInsertId() : false; 
}


// Update a staff member's details
function updateStaff($pdo, $staffID, $firstName, $lastName, $email, $phoneNumber, $position, $adminId) {
    $sql = "UPDATE staff SET 
                FirstName = ?, 
                LastName = ?, 
                Email = ?, 
                PhoneNumber = ?, 
                Position = ?, 
                UpdatedBy = ?, 
                UpdatedAt = CURRENT_TIMESTAMP 
            WHERE StaffID = ?";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$firstName, $lastName, $email, $phoneNumber, $position, $adminId, $staffID]);
}


// Delete a staff member
function deleteStaff($pdo, $staff_id) {
    $sql = "DELETE FROM staff WHERE StaffID = ?";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$staff_id]);

    if ($executeQuery) {
        return true;
    }
}

function getAllStaff($pdo) {
    $sql = "
        SELECT 
            s.StaffID, 
            s.FirstName, 
            s.LastName, 
            s.Email, 
            s.PhoneNumber, 
            s.Position, 
            ca.username AS CreatedBy,      -- Fetching username for CreatedBy
            ua.username AS UpdatedBy,       -- Fetching username for UpdatedBy
            s.CreatedAt, 
            s.UpdatedAt
        FROM 
            Staff s
        LEFT JOIN 
            admin_accounts ca ON s.CreatedBy = ca.admin_id  -- Adjust to match the actual column name for admin ID in admin_accounts
        LEFT JOIN 
            admin_accounts ua ON s.UpdatedBy = ua.admin_id  -- Adjust to match the actual column name for admin ID in admin_accounts
    ";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


// Get a staff member by ID
function getStaffByID($pdo, $StaffID) {
    $sql = "SELECT * FROM staff WHERE StaffID = ?";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$StaffID]);

    if ($executeQuery) {
        return $stmt->fetch();
    }
}

// Insert a new project
function insertProject($pdo, $ClientID, $StaffID, $DateFiled, $ProjectSpecification, $PriorityLevel, $Status, $DueDate, $RemainingDays, $Remarks, $adminId) {
    // Prepare the SQL statement. CreatedAt is set automatically, UpdatedAt remains NULL on insert.
    $sql = "INSERT INTO Projects (ClientID, StaffID, DateFiled, ProjectSpecification, PriorityLevel, Status, DueDate, RemainingDays, Remarks, CreatedBy, UpdatedBy, CreatedAt, UpdatedAt) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NULL, CURRENT_TIMESTAMP, NULL)";
    $stmt = $pdo->prepare($sql);

    // Execute the query with the provided values, including admin ID for CreatedBy
    $executeQuery = $stmt->execute([$ClientID, $StaffID, $DateFiled, $ProjectSpecification, $PriorityLevel, $Status, $DueDate, $RemainingDays, $Remarks, $adminId]);

    // Return the last inserted ID or false on failure
    return $executeQuery ? $pdo->lastInsertId() : false; 
}


// Update a project's details
function updateProject($pdo, $project_id, $client_id, $staff_id, $date_filed, $project_specification, $priority_level, $status, $due_date, $remaining_days, $remarks, $adminId) {
    $sql = "UPDATE projects SET 
                ClientID = ?, 
                StaffID = ?, 
                DateFiled = ?, 
                ProjectSpecification = ?, 
                PriorityLevel = ?, 
                Status = ?, 
                DueDate = ?, 
                RemainingDays = ?, 
                Remarks = ?, 
                UpdatedBy = ?, 
                UpdatedAt = CURRENT_TIMESTAMP 
            WHERE ProjectID = ?";
    $stmt = $pdo->prepare($sql);
    
    // Execute the query with the provided values, including admin ID for UpdatedBy
    return $stmt->execute([$client_id, $staff_id, $date_filed, $project_specification, $priority_level, $status, $due_date, $remaining_days, $remarks, $adminId, $project_id]);
}


// Delete a project function
function deleteProject($pdo, $project_id) {
    $sql = "DELETE FROM projects WHERE ProjectID = ?";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$project_id]);

    if ($executeQuery) {
        return true;
    } 
}

// Get all projects
function getAllProjects($pdo) {
    $sql = "
        SELECT 
            p.ProjectID,
            p.ClientID,
            p.StaffID,
            p.DateFiled,
            p.ProjectSpecification,
            p.PriorityLevel,
            p.Status,
            p.DueDate,
            p.RemainingDays,
            p.Remarks,
            ca.username AS CreatedBy,          -- Fetching username for CreatedBy
            ua.username AS UpdatedBy,          -- Fetching username for UpdatedBy
            p.CreatedAt, 
            p.UpdatedAt
        FROM 
            projects p
        LEFT JOIN 
            admin_accounts ca ON p.CreatedBy = ca.admin_id  -- Adjust to match the actual column name for admin ID in admin_accounts
        LEFT JOIN 
            admin_accounts ua ON p.UpdatedBy = ua.admin_id  -- Adjust to match the actual column name for admin ID in admin_accounts
    ";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


// Get a project by ID
function getProjectByID($pdo, $projectID) {
    $stmt = $pdo->prepare("SELECT * FROM projects WHERE ProjectID = :ProjectID");
    $stmt->execute(['ProjectID' => $projectID]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}



?>