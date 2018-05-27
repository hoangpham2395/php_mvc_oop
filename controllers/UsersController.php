<?php class UsersController extends BaseController{
	public function index()	{
		// Check session admin_user
		if ($this->hasFlash('admin_user')) {
			$idAdmin = $_SESSION['admin_user']['id'];
			$modelAdmin = new Models_Admin();
			$this->setFlash('admin_user', $modelAdmin->find($idAdmin));

			$model = new Models_User();

			// Get term
			$term = []; $search = [];
			if (!empty($_GET['name'])) {
				$term['name'] = '%'.$_GET['name'].'%';
				$search['name'] = $_GET['name'];
			}

			if (!empty($_GET['email'])) {
				$term['email'] = '%'.$_GET['email'].'%';
				$search['email'] = $_GET['email'];
			}

			// Delete session url (info search, limit)
			if ($this->hasFlash('urlUser')) unset($_SESSION['urlUser']);

			// CONFIG
			$listLimit = getConfig('limit', [10, 25, 50]);
			$links = getConfig('links', 5);
			$page = getConfig('page', 1);

			// Pagination and display
			$limit = (!empty($_GET['limit'])) ? $_GET['limit'] : $listLimit[0];
			$page = (!empty($_GET['page'])) ? $_GET['page'] : $page;
			$start = ($page - 1) * $limit;

			// Sort
			if (!empty($_GET['row']) && strtolower($_GET['row']) === 'name') {
				$row = 'name';
			} elseif (!empty($_GET['row']) && strtolower($_GET['row']) === 'email') {
				$row = 'email';
			} elseif (!empty($_GET['row']) && strtolower($_GET['row']) === 'status') {
				$row = 'status';
			} else {
				$row = 'id';
			}

			if (isset($_GET['arrange']) && strtoupper($_GET['arrange']) === 'ASC') {
				$arrange = 'ASC';
			} else {
				$arrange = 'DESC';
			}

			// Get data 
			if (!empty($term)) {
				$users = $model->searchPaginate($term, $limit, $start, $row, $arrange);
				$total = count($model->search($term));
			} else {
				$users = $model->paginate($limit, $start, $row, $arrange);
				$total = count($model->getList());
			}

			$sort = [];
				if (isset($_GET['row'])) $sort['row'] = $_GET['row'];
				if (isset($_GET['arrange'])) $sort['arrange'] = $_GET['arrange'];

			// Info pagination
			$pagination = [
				'table' => 'users',
				'limit' => $limit,
				'page' => $page,
				'total' => $total,
				'links' => $links,
				'termSearch' => $search,
				'termSort' => $sort
			];

			$count = ['showing' => count($users), 'total' => $total];

			return $this->render('users/index.php', ['users'=> $users, 'pagination' => $pagination, 'count' => $count, 'listLimit' => $listLimit]);
		}
		// Not login
		return $this->redirect(['c' => 'login', 'a' => 'show']);
	} 

	public function edit () {
		// Check session admin_user
		if ($this->hasFlash('admin_user')) {
			$idAdmin = $_SESSION['admin_user']['id'];
			$modelAdmin = new Models_Admin();
			$this->setFlash('admin_user', $modelAdmin->find($idAdmin));

			// Check id
			if (isset($_GET['id'])) {
				$model = new Models_User();
				$id = trim($_GET['id']);
				$user = $model->find($id);

				if (empty($user)) {
					$this->setFlash('errors', ["updateID" => "Update failed."]);
				} else {
					$data['status'] = ($user['status'] == 1) ? 2 : 1;

					if ($model->update($id, $data)) {
						$this->setFlash('notification', 'Update success!');
					} else {
						$this->setFlash('errors', ['update' => 'Update failed.']);
					}
					
				}
				
				$url = ['c' => 'users', 'a' => 'index'];
				if ($this->hasFlash('urlUser')) {
					$getUrls = $_SESSION['urlUser'];
					foreach ($getUrls as $key => $value) {
						$url[$key] = $value;
					}
				}
				return $this->redirect($url);
			}
			// File not found (404)
			return $this->redirect(['c' => 'users', 'a' => 'fileNotFound']);
		}
		// Not login
		return $this->redirect(['c' => 'login', 'a' => 'show']);
	}

	public function destroy() {
		// Check session admin_user
		if ($this->hasFlash('admin_user')) {
			$idAdmin = $_SESSION['admin_user']['id'];
			$modelAdmin = new Models_Admin();
			$this->setFlash('admin_user', $modelAdmin->find($idAdmin));

			if (isset($_GET['id'])) {
				$id = trim($_GET['id']);
				$model = new Models_User();

				// Link redirect index (save info)
				$url = ['c' => 'users', 'a' => 'index'];
				if ($this->hasFlash('urlUser')) {
					$getUrls = $_SESSION['urlUser'];
					foreach ($getUrls as $k => $v) {
						$url[$k] = $v;
					}
				}

				// Check id
				if (empty($model->find($id))) {
					$this->setFlash('errors', ['deleteID' => "Delete failed."]);
				} else {
					if ($model->delete($id)) {
						$this->setFlash('notification', "Delete success!");
					} else {
						$this->setFlash('errors', ['delete' => 'Delete failed.']);
					}
				}
				return $this->redirect($url);	
			} 
			return $this->redirect('errors/404.php');
		}
		// Not login
		return $this->redirect(['c' => 'login', 'a' => 'show']);
	}

	public function info () {
		if ($this->hasFlash('user_fb')) {
			$info = $_SESSION['user_fb'];
			$info['logoutURL'] = (isset($_SESSION['logoutURL'])) ? $_SESSION['logoutURL'] : 'index.php?c=login&a=logoutFB'; 
			return $this->render('users/info.php', ['info' => $info]);
		}
		// Not login FB
		return $this->redirect(['c' => 'login', 'a' => 'loginFB']);
	}
}
