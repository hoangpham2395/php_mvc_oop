<?php 
$configs = require __DIR__.'/../Config/Config.php';

// Get data from Config
function getConfig($key, $default) 
{	
	global $configs;
	$result = (!empty($configs[$key])) ? $configs[$key] : $default;
	return $result;
}

// Redirect to other page
function redirect($controller, $action) 
{
	header('location:index.php?c='.$controller.'&a='.$action);
}

// Get info admin signing in
function getNameAdmin() 
{
	$defaultNameAdmin = getConfig('defaultNameAdmin', 'Unknown name');
	$result = (!empty($_SESSION['admin_user']['name'])) ? $_SESSION['admin_user']['name'] : $defaultNameAdmin;
	return $result;
}

function getImageAdmin() 
{
	if (!empty($_SESSION['admin_user']['avatar']) && file_exists('uploads/images/'.$_SESSION['admin_user']['avatar'])) {
		$urlImage = 'uploads/images/'.$_SESSION['admin_user']['avatar'];
	} else {
		$urlImage = getConfig('defaultImageAdmin', "public/images/no-image.png");
	}
	return $urlImage;
}	
?>