<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Register Form</title>
	<!-- custom css file link --> 
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<div class="form-container">
		<form action="/register" method="POST">
            @csrf
			<h3>Register Now</h3>
			@if (session('error'))
            <span class="error-msg">
            @endif
			<select name="type" required>
				<option value="Student">Student</option>
				<option value="Cashier">Cashier</option>
				<option value="Registrar">Registrar</option>
			</select>

			<input type="text" name="firstname" required placeholder="First Name *">
			<input type="text" name="middlename" required placeholder="Middle Name *">
			<input type="text" name="lastname" required placeholder="Last Name *">
			<input type="email" name="email" required placeholder="Enter your Email *">
			<input type="password" name="password" required placeholder="Enter your Password *">
			<input type="password" name="cpassword" required placeholder="Confirm your Password *">
			<input type="submit" name="submit" value="Register Now" class="form-btn">
			<p>Already have an Account? <a href="login_form.php">Login Now</a> </p>
		</form>
	</div>
</body>
</html>