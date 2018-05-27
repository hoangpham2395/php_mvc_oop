<?php 
ob_start();
session_start();

include_once __DIR__.'/Helper/Helper.php';

date_default_timezone_set(getConfig('date_default_timezone_set', 'Asia/Ho_Chi_Minh'));

// Autoload
function __autoload($className)
{
	if(strpos($className, 'Controller') !== false){
		$className = 'controllers/'. $className;
	} else {
		$className = str_replace('_','/', $className);
	}
	$className .= '.php';

	//Check file
    if(file_exists($className))
    {
        include_once $className;
    } else {
    	redirect('base', 'fileNotFound'); 
    }
}
try{
	$getController = isset($_GET['c']) ? $_GET['c'] : 'login';
	$controllerName = ucfirst($getController).'Controller';
	$actionName =  isset($_GET['a']) ? $_GET['a'] : 'loginFB';
	$controller = new $controllerName();
	if(!method_exists($controller, $actionName)){	
		redirect($getController, 'fileNotFound'); 
	} else {
		// Show view from controller 
		echo $controller->$actionName();
	}

}catch(\Exception $e){
	echo $e->getMessage();
}
