<!DOCTYPE html>
<html>
<head>
	<title>Website | Info</title>
	<style>
		p {
			width: 100%;
			margin-bottom: 10px;
		}
		img {
			width: 60px;
			height: 60px;
		}
		span {
			font-weight: bold;
		}
		a {
			text-decoration: none;
		}
	</style>
</head>
<body>
	<p><img src="<?php echo $info['picture']; ?>"></p>
	<p>Name: <span><?php echo $info['name']; ?></span></p>
	<p>Email: <span><?php echo $info['email']; ?></span>
	<p>Facebook ID: <span><?php echo $info['facebook_id']; ?></span></p>
	<p>Logout from <a href="<?php echo $info['logoutURL'];?>">Facebook</a>.</p>
</body>
</html>