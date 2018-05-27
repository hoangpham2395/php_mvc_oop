<?php
if (isset($_SESSION['user_fb'])) {
	header("location:index.php?c=users&a=info");
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Website | Login FB</title>
	<!-- Css -->
	<link rel="stylesheet" type="text/css" href="public/css/login.css">
	<link rel="stylesheet" type="text/css" href="public/css/font-awesome.min.css">
</head>
<body>
<?php 
// Show notification success
if ($this->hasFlash('confirm-loginFB')) {
	?>
	<span style="color:green;"><?php echo $this->getFlash('confirm-loginFB'); ?></span><br>
	<?php
}

// Show notification register
if ($this->hasFlash('registerFB')) {
	?>
	<span style="color:orange;"><?php echo $this->getFlash('registerFB'); ?></span> 
	You want to <a href="index.php?c=login&a=registerFB">register</a>.<br>
	<?php
}

// Show errors
if ($this->hasFlash('errors-loginFB')) {
	?>
	<span style="color:red;"> <i class="fa fa-exclamation-triangle"></i> <?php echo $this->getFlash('errors-loginFB'); ?>. Logout from <a href="<?php echo htmlspecialchars($logoutURL); ?>">Facebook</a> to login other account.</span><br>
	<?php
} else {
?>

	<!-- Login Facebook -->
	<a href="<?php echo htmlspecialchars($loginURL);?>"><img src="public/images/facebook-sign-in-button.png" width="133px" height="50px"></a>

<?php 
}
?>
</body>
</html>
