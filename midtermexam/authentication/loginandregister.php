<?php  
require_once '../core/datamodel.php'; 
require_once '../core/handleform.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login and Register</title>
    <link rel="stylesheet" type="text/css" href="slide navbar style.css">
    <link href="../styles/registerandlogin.css" rel="stylesheet">
    <style>
        .success-message {
			color: green; /* Green text for success */
			background-color: #e0ffe0; /* Light green background */
			padding: 10px;
			border: 1px solid green;
			border-radius: 5px;
			margin: 10px 0;
			text-align: center; /* Center the text */
		}

		.error-message {
			color: red; /* Red text for error */
			background-color: #ffe0e0; /* Light red background */
			padding: 10px;
			border: 1px solid red;
			border-radius: 5px;
			margin: 10px 0;
			text-align: center; /* Center the text */
		}

    </style>
</head>
<body>
    <div class="main"> 

	<input type="checkbox" id="chk" aria-hidden="true">

        <!-- Signup Form -->
        <div class="signup">
            <form action="../core/handleform.php" method="POST">
                <label for="chk" aria-hidden="true">Sign up</label>
                <input type="text" name="firstname" placeholder="Firstname" required>
                <input type="text" name="lastname" placeholder="Lastname" required>
                <input type="text" name="username" placeholder="Username" required>
                <input type="email" name="email" placeholder="Email" required>
                <select name="gender" required>
                    <option value="" disabled selected>Select Gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
                <input type="password" name="password" placeholder="Password" required>
                <input type="password" name="confirm_password" placeholder="Confirm Password" required>
                <button type="submit" name="registerUserBtn">Sign up</button>

				<!-- Display Session Message if Available -->
				<?php

				if (isset($_SESSION['register_message'])) {
					// Determine the CSS class based on message type
					$messageClass = $_SESSION['message_type'] === 'success' ? 'success-message' : 'error-message';
					
					// Display the message
					echo "<div class='{$messageClass}'>" . htmlspecialchars($_SESSION['register_message']) . "</div>";
					
					// Clear the message and type after displaying
					unset($_SESSION['register_message']);
					unset($_SESSION['message_type']);
				}
				?>



            </form>
        </div>

        <!-- Login Form -->
        <div class="login">
            <form action="../core/handleform.php" method="POST">
                <label for="chk" aria-hidden="true">Login</label>
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" name="loginUserBtn">Login</button>

				<?php
					if (isset($_SESSION['login_message'])) {
						// Determine the CSS class based on message type
						$messageClass = $_SESSION['message_type'] === 'success' ? 'success-message' : 'error-message';

						// Display the message
						echo "<div class='{$messageClass}'>" . htmlspecialchars($_SESSION['login_message']) . "</div>";

						// Clear the message after displaying
						unset($_SESSION['login_message']);
					}
				?>

            </form>
        </div>
    </div>
</body>
</html>




