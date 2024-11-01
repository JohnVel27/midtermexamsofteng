-- Admin accounts table
CREATE TABLE admin_accounts (
    admin_id INT AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(50),
    lastname VARCHAR(50),
    username VARCHAR(50),
    email VARCHAR(50),
    gender VARCHAR(50),
    password VARCHAR(255), -- This will store the hashed password
    confirm_password VARCHAR(255), -- Optional, not typically needed in the database
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
-- Clients Table
CREATE TABLE Clients (
    ClientID INT AUTO_INCREMENT PRIMARY KEY,               -- Unique ID for each client
    ClientName VARCHAR(255) NOT NULL,                      -- Client's name
    Email VARCHAR(255) NOT NULL,                           -- Client's email
    PhoneNumber VARCHAR(15),                               -- Client's phone number
    Address VARCHAR(255),                                  -- Client's address
    City VARCHAR(100),                                     -- Client's city
    ZipCode VARCHAR(10),                                   -- Client's ZIP code
    CreatedBy INT NULL,                                    -- Allow NULL for CreatedBy
    UpdatedBy INT NULL,                                    -- Allow NULL for UpdatedBy
    CreatedAt TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,    -- Automatically set to current timestamp on insert
    UpdatedAt TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,  -- Allow NULL and auto-update on change
    FOREIGN KEY (CreatedBy) REFERENCES admin_accounts(admin_id),  
    FOREIGN KEY (UpdatedBy) REFERENCES admin_accounts(admin_id)   
);

-- Staff table to store information about the point person (staff member managing the project)
CREATE TABLE Staff (
    StaffID INT AUTO_INCREMENT PRIMARY KEY,               -- Unique ID for each staff member
    FirstName VARCHAR(100) NOT NULL,                      -- First name of the staff member
    LastName VARCHAR(100) NOT NULL,                       -- Last name of the staff member
    Email VARCHAR(255),                                   -- Email address of the staff member
    PhoneNumber VARCHAR(15),                              -- Contact phone number of the staff member
    Position VARCHAR(100),                                -- Position of the staff (e.g., Manager, Supervisor)
    CreatedBy INT NULL,                                   -- Allow NULL for the ID of the admin who created the record
    UpdatedBy INT NULL,                                   -- Allow NULL for the ID of the admin who last updated the record
    CreatedAt TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,                -- Allow NULL for the timestamp when the record was created
    UpdatedAt TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,  -- Allow NULL for the timestamp when the record was last updated
    FOREIGN KEY (CreatedBy) REFERENCES admin_accounts(admin_id),  -- Establishing foreign key to admin_accounts
    FOREIGN KEY (UpdatedBy) REFERENCES admin_accounts(admin_id)   -- Establishing foreign key to admin_accounts
);


-- Projects table to store project details
-- This table has a one-to-many relationship with both Clients and Staff
CREATE TABLE Projects (
    ProjectID INT AUTO_INCREMENT PRIMARY KEY,             -- Unique ID for each project
    ClientID INT,                                         -- Foreign key linking to Clients table (one client can have many projects)
    StaffID INT,                                          -- Foreign key linking to Staff table (one staff can handle many projects)
    DateFiled DATE,                                       -- Date when the project was filed
    ProjectSpecification TEXT,                            -- Detailed description of the project specifications
    PriorityLevel VARCHAR(50),                            -- Priority level of the project (e.g., High, Medium, Low)
    Status VARCHAR(50),                                   -- Current status of the project (e.g., In progress, Completed)
    DueDate DATE,                                         -- Deadline for the project
    RemainingDays INT,                                    -- Number of days remaining until the project is due
    Remarks TEXT,                                         -- Additional comments or remarks about the project
    CreatedBy INT NULL,                                   -- Allow NULL for the ID of the admin who created the record
    UpdatedBy INT NULL,                                   -- Allow NULL for the ID of the admin who last updated the record
    CreatedAt TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,                -- Allow NULL for the timestamp when the record was created
    UpdatedAt TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,  -- Allow NULL for the timestamp when the record was last updated
    FOREIGN KEY (ClientID) REFERENCES Clients(ClientID),  -- Establishes one-to-many relationship with Clients
    FOREIGN KEY (StaffID) REFERENCES Staff(StaffID),      -- Establishes one-to-many relationship with Staff
    FOREIGN KEY (CreatedBy) REFERENCES admin_accounts(admin_id),  -- Establishing foreign key to admin_accounts
    FOREIGN KEY (UpdatedBy) REFERENCES admin_accounts(admin_id)   -- Establishing foreign key to admin_accounts
);


