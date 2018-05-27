<?php


if (isset($_SESSION['admin_user'])) {
	header("location:index.php?c=users&a=index");
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>System | Login</title>
	<!-- Css -->
	<link rel="stylesheet" type="text/css" href="public/css/login.css">
</head>
<body>
	<div class="login-box">
		<div class="login-box-header">
			Login admin
		</div>

		<?php 
		// Show errors
		require 'views/errors/error.php';
		?>		

		<div class="login-box-body">
			<form method="post" action="index.php?c=login&a=login">
				<input type="email" name="email" placeholder="Email" value="<?php echo $oldEmail;?>">
				<br>
				<input type="password" name="password" placeholder="Password">
				<br>
				<button type="submit" name="submit">Sign in</button>
				<br>
			</form>
		</div>
	</div>
</body>
</html>
