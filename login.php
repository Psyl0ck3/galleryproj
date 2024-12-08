<?php  
require_once 'core/models.php'; 
require_once 'core/handleForms.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login - UCOSnaps</title>
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

		.login-container {
			background-color: #FFFFFF;
			color: #001F3F;
			padding: 30px;
			border-radius: 10px;
			box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
			width: 100%;
			max-width: 400px;
			text-align: center;
		}

		.login-container h1 {
			font-size: 1.8rem;
			margin-bottom: 20px;
		}

		.login-container p {
			margin: 15px 0;
		}

		.login-container label {
			display: block;
			margin-bottom: 5px;
			font-weight: bold;
		}

		.login-container input[type="text"],
		.login-container input[type="password"] {
			width: 100%;
			padding: 10px;
			margin-bottom: 15px;
			border: 1px solid #3A6D8C;
			border-radius: 5px;
			font-size: 1rem;
		}

		.login-container input[type="submit"] {
			background-color: #001F3F;
			color: #FFFFFF;
			border: none;
			padding: 10px 20px;
			font-size: 1rem;
			border-radius: 5px;
			cursor: pointer;
			transition: background-color 0.3s ease;
		}

		.login-container input[type="submit"]:hover {
			background-color: #3A6D8C;
		}

		.login-container a {
			color: #001F3F;
			text-decoration: none;
			font-weight: bold;
			transition: color 0.3s ease;
		}

		.login-container a:hover {
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

	<div class="login-container">
		<h1>Login Now to UCOSnaps!</h1> 
		<form action="core/handleForms.php" method="POST">
			<p>
				<label for="username">Username</label>
				<input type="text" name="username" placeholder="Enter your username">
			</p>
			<p>
				<label for="password">Password</label>
				<input type="password" name="password" placeholder="Enter your password">
			</p>
			<p>
				<input type="submit" name="loginUserBtn" value="Login">
			</p>
		</form>
		<p>Don't have an account? You may register <a href="register.php">here</a></p>
	</div>
</body>
</html>
