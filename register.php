<?php

require "vendor/autoload.php";

session_start();
session_destroy();
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
			<title>
				Registration
			</title>
		<link rel="stylesheet" href="style.css">
	</head>
	
	<body class="reg">
		<form action="save-registration.php" method="POST" class="register">

			<div align="center">
				<img src="images/Logo.png" 
				alt="quizillah" width="300" height="150">
			</div>

			<div align="center">
				<input type="text" name="email" placeholder="Email" optional/>	
			</div>

			<div align="center">
				<input type="text" name="username" placeholder="Username" required/>	
			</div>

			<hr class="divider" align="center">

			<div align="center">
				<input type="password" name="password" placeholder="Password" required/>	
			</div>

			<div align="center">
				<input type="password" name="confirm_password" placeholder="Confirm Password" required/>
			</div>

			<hr class="divider2">

			<div align="center">
				<button type="submit" class="btn">Register</button>
			</div>

			<hr class="divider3" align="center">
			<hr class="divider4" align="center">

			<div class="form-section" align="center">
				<p style="font-size: 15px;">Have an account? <a href="login.php">Log in</a> </p>
			</div>
		</form>
			<div class="vl"></div>
			<div class="vl1"></div>
			
	</body>
		<div class="about">
					<a href="about_us.php" style="color: yellow;font-size: 25px;">About us</a> 
		</div>
</html>

        