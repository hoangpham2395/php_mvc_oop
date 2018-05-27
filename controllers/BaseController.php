<?php
class BaseController
{	
	// Get view
	public function render ($viewPath, $data = [])
	{
		ob_start();
		extract($data);
		include_once 'views/'.$viewPath;
		$result = ob_get_contents();
		ob_end_clean();
		return $result;
	}

	// Redirect to other page
	public function redirect ($params = []) {
		$link = http_build_query($params);
		header("location:index.php?".$link);
	}
	
	// Set flash
	public function setFlash ($session, $content) {
		return $_SESSION[$session] = $content;
	}
	// Get flash 
	public function getFlash ($session) {
		$get = $_SESSION[$session];
		unset($_SESSION[$session]);
		return $get;
	}
	// Check flash
	public function hasFlash ($session) {
		return (isset($_SESSION[$session])) ? true : false;
	}
	
	public function getSession ($session) {
		return $_SESSION[$session];
	}

	public function setSession ($session, $content) {
		return $_SESSION[$session] = $content;
	}

	// Check Super Admin
	public function checkSuperAdmin () {
		return ($_SESSION['admin_user']['role_type'] == 1) ? true : false;
	}

	// File not found (404)
	public function fileNotFound () {
		// Check session admin_user
		if ($this->hasFlash('admin_user')) {
			$id = $_SESSION['admin_user']['id'];
			$model = new Models_Admin();
			$this->setFlash('admin_user', $model->find($id));
		}
		return $this->render('errors/404.php', []);
	}

	// Role type
	public function role () {
		// Check session admin_user
		if ($this->hasFlash('admin_user')) {
			$id = $_SESSION['admin_user']['id'];
			$model = new Models_Admin();
			$this->setFlash('admin_user', $model->find($id));

			if ($this->checkSuperAdmin()) {
				return $this->redirect(['c' => 'admin', 'a' => 'index']);
			}
			// Role admin
			return $this->render('others/role.php', []);
		}
		// Not login
		return $this->redirect(['c' => 'login', 'a' => 'show']);
	}
}

?>
