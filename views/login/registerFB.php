<?php 
if (empty($info)) {
	header('location:index.php?c=login&a=loginFB');
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Website | Register FB</title>
	<!-- Css -->
	<link rel="stylesheet" type="text/css" href="public/css/login.css">
</head>
<body>
	<div class="login-box">
		<div class="login-box-header">
			Register
		</div>		

		<div class="login-box-body">
			<form method="post" action="index.php?c=login&a=addFB">
				<img src="<?php echo $info['picture']; ?>" height="60px" width="60px" style="text-align: center; border-radius: 50%; margin-bottom: 15px;">
				<br>
				<input type="text" name="email" disabled value="<?php echo $info['email']; ?>">
				<br>			
				<input type="hidden" name="name" value="<?php echo $info['name']; ?>">
				<input type="hidden" name="email" value="<?php echo $info['email'];?>">
				<input type="hidden" name="facebook_id" value="<?php echo $info['facebook_id'];?>">
				<input type="hidden" name="img" value="<?php echo $info['picture'];?>">
				<br>
				<button type="submit" name="submit" value="signup">Sign up</button>
				<br>
			</form>
		</div>
	</div>
</body>
</html>