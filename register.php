<?php  
require_once 'core/models.php'; 
require_once 'core/handleForms.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Register - UCOSnaps</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
	<style>
		body {
			margin: 0;
			font-family: Arial, sans-serif;
			background: linear-gradient(to bottom right, #001F3F, #EAD8B1);
			height: 100vh;
			display: flex;
			justify-content: center;
			align-items: center;
			color: #FFFFFF;
		}

		.registration-container {
			background-color: #FFFFFF;
			color: #001F3F;
			padding: 30px;
			border-radius: 10px;
			box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
			width: 100%;
			max-width: 400px;
			text-align: center;
		}

		.registration-container h1 {
			font-size: 1.8rem;
			margin-bottom: 20px;
		}

		.registration-container p {
			margin: 15px 0;
		}

		.registration-container label {
			display: block;
			margin-bottom: 5px;
			font-weight: bold;
		}

		.registration-container input[type="text"],
		.registration-container input[type="password"] {
			width: 100%;
			padding: 10px;
			margin-bottom: 15px;
			border: 1px solid #3A6D8C;
			border-radius: 5px;
			font-size: 1rem;
		}

		.registration-container input[type="submit"] {
			background-color: #001F3F;
			color: #FFFFFF;
			border: none;
			padding: 10px 20px;
			font-size: 1rem;
			border-radius: 5px;
			cursor: pointer;
			transition: background-color 0.3s ease;
		}

		.registration-container input[type="submit"]:hover {
			background-color: #3A6D8C;
		}

		.registration-container a {
			color: #001F3F;
			text-decoration: none;
			font-weight: bold;
			transition: color 0.3s ease;
		}

		.registration-container a:hover {
			color: #3A6D8C;
		}

		.message {
			padding: 10px;
			border-radius: 5px;
			text-align: center;
			margin-bottom: 20px;
			font-size: 1rem;
			font-weight: bold;
		}

		.message.green {
			background-color: #3A6D8C;
			color: #FFFFFF;
		}

		.message.red {
			background-color: #FF6347;
			color: #FFFFFF;
		}
	</style>
</head>
<body>
	<div class="registration-container">
		<h1>Register Here!</h1>
		<?php  
		if (isset($_SESSION['message']) && isset($_SESSION['status'])) {
			if ($_SESSION['status'] == "200") {
				echo "<h1 class='message green'>{$_SESSION['message']}</h1>";
			} else {
				echo "<h1 class='message red'>{$_SESSION['message']}</h1>";	
			}
			unset($_SESSION['message']);
			unset($_SESSION['status']);
		}
		?>
		<form action="core/handleForms.php" method="POST">
			<p>
				<label for="username">Username</label>
				<input type="text" name="username" placeholder="Enter your username">
			</p>
			<p>
				<label for="first_name">First Name</label>
				<input type="text" name="first_name" placeholder="Enter your first name">
			</p>
			<p>
				<label for="last_name">Last Name</label>
				<input type="text" name="last_name" placeholder="Enter your last name">
			</p>
			<p>
				<label for="password">Password</label>
				<input type="password" name="password" placeholder="Enter your password">
			</p>
			<p>
				<label for="confirm_password">Confirm Password</label>
				<input type="password" name="confirm_password" placeholder="Confirm your password">
			</p>
			<p>
				<input type="submit" name="insertNewUserBtn" value="Register">
			</p>
		</form>
		<p>Already have an account? You may login <a href="login.php">here</a></p>
	</div>
</body>
</html>
