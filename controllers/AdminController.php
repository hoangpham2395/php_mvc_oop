<?php 
class AdminController extends BaseController
{	
	public function index(){
		// Check session admin_user
		if ($this->hasFlash('admin_user')) {
			$idAdmin = $_SESSION['admin_user']['id'];
			$model = new Models_Admin();
			$this->setFlash('admin_user', $model->find($idAdmin));

			if ($this->checkSuperAdmin()) {
				// Search 
				$term = []; $search = [];
				if (!empty($_GET['name'])) {
					$term['name'] = '%'.$_GET['name'].'%';
					$search['name'] = $_GET['name'];
				}
				if (!empty($_GET['email'])) {
					$term['email'] = '%'.$_GET['email'].'%';
					$search['email'] = $_GET['email'];
				}

				// Unset session URL Admin
				if ($this->hasFlash('urlAdmin')) unset($_SESSION['urlAdmin']);

				// Config
				$listLimit = getConfig('limit', [10, 25, 50]); 
				$links = getConfig('links', 5); 
				$page = getConfig('page', 1);

				// Pagination
				$limit = (!empty($_GET['limit'])) ? $_GET['limit'] : $listLimit[0];
				$page = (!empty($_GET['page'])) ? $_GET['page'] : $page;
				$start = ($page - 1) * $limit;

				// Sort
				if (!empty($_GET['row']) && strtolower($_GET['row']) === 'name') {
					$row = 'name';
				} elseif (!empty($_GET['row']) && strtolower($_GET['row']) === 'email') {
					$row = 'email';
				} elseif (!empty($_GET['row']) && strtolower($_GET['row']) === 'role_type') {
					$row = 'role_type';
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
					$admin = $model->searchPaginate($term, $limit, $start, $row, $arrange);
					$total = count($model->search($term));
				} else {
					$admin = $model->paginate($limit, $start, $row, $arrange); 
					$total = count($model->getList());
				}

				// Sort to paginate
				$sort = [];
				if (isset($_GET['row'])) $sort['row'] = $_GET['row'];
				if (isset($_GET['arrange'])) $sort['arrange'] = $_GET['arrange'];
					
				// Info pagination
				$pagination = [
					'table' => 'admin',
					'limit' => $limit,
					'page' => $page,
					'total' => $total,
					'links' => $links,
					'termSearch' => $search,
					'termSort' => $sort
				];

				// Total element and the number of element showing
				$count = ['showing' => count($admin), 'total' => $total];

				return $this->render('admin/index.php', ['admin'=> $admin, 'pagination' => $pagination, 'count' => $count, 'listLimit' => $listLimit]);
			}

			// Role Admin
			return $this->redirect(['c' => 'admin', 'a' => 'role']);
		}
		// Not login
		return $this->redirect(['c' => 'login', 'a' => 'show']);			
	} 

	public function create () {
		// Check session admin_user
		if ($this->hasFlash('admin_user')) {
			$idAdmin = $_SESSION['admin_user']['id'];
			$model = new Models_Admin();
			$this->setFlash('admin_user', $model->find($idAdmin));

			// Check SuperAdmin
			if ($this->checkSuperAdmin()) {
				$admin = ['name' => '', 'email' => ''];
				return $this->render('admin/add.php', ['admin' => $admin]);
			}
			// Role Admin
			return $this->redirect(['c' => 'admin', 'a' => 'role']);
		}

		// Not login
		return $this->redirect(['c' => 'login', 'a' => 'show']);
	}

	public function add () {
		// Check session admin_user
		if ($this->hasFlash('admin_user')) {
			$idAdmin = $_SESSION['admin_user']['id'];
			$model = new Models_Admin();
			$this->setFlash('admin_user', $model->find($idAdmin));

			// Check validate
			$isValid = new Validators_Admin();

			$data = [
				'name' => trim($_POST['name']),
				'password' => trim($_POST['password']),
				'password_confirmation' => trim($_POST['password_confirmation']),
				'email' => trim($_POST['email']),
				'role_type' => $_POST['role_type']
			];

			// Check image to save value file
			$img = new Uploader_Image();
			$avatar = []; 
			if ($img->checkImage($_FILES['avatar'])) {
				$avatar = $_FILES['avatar'];
				$tmp_path = 'uploads/tmp/'.$avatar['name'];
				$avatar['type'] = strtolower(pathinfo($tmp_path,PATHINFO_EXTENSION));
				$avatar['name'] = date('YmdHis').'.'.$avatar['type'];
				$img->saveImageToTempFolder($avatar);
			} elseif ($this->hasFlash('avatar')) {
				$avatar = $this->getFlash('avatar');
			}

			// Check validate
			if ($isValid->requiredAdmin($data) === false 
				|| $isValid->checkLengthName($_POST['name']) === false 
				|| $isValid->checkPasswordSize($_POST['password']) === false 
				|| $isValid->checkPasswordConfirmation($_POST['password'], $_POST['password_confirmation']) === false) 
			{
				$this->setFlash('old-admin', $_POST);
				$this->setFlash('errors', $isValid->errors());
				if (!empty($avatar)) {
					$_SESSION['old-admin']['file'] = $avatar;
				}			
				return $this->redirect(['c' => 'admin', 'a' => 'create']);
			}

			// Check unique email 
			if ($model->uniqueEmail($_POST['email']) === false) {
				$this->setFlash('old-admin', $_POST);
				if (!empty($avatar)) {
					$_SESSION['old-admin']['file'] = $avatar;
				}
				$this->setFlash('errors', ['email' => 'Email is unique.']);
				return $this->redirect(['c' => 'admin', 'a' => 'create']);
			}

			// Validate success
			$data['password'] = md5($data['password']);
			unset($data['password_confirmation']);
			$data['avatar'] = null;

			// Upload image
			$errorsImg = [];
			if (!empty($avatar)) {
				// Check validate
				if ((!empty($avatar['type']) && $isValid->checkImage($avatar['type']) === false) || $isValid->checkFileSize($avatar['size']) === false) {
					$errorsImg = $isValid->errors();
				}

				// Upload image
				if (empty($errorsImg)) {		
					if ($img->uploadImage('avatar', $avatar)) {
						$data['avatar'] = 'avatar_'.$avatar['name'];
					} else {
						$errorsImg['upload'] = "Sorry, there was an error uploading your avatar.";
					}
				}
			}

			if (!empty($errorsImg)) {
				$this->setFlash('errors', $errorsImg);
				$this->setFlash('old-admin', $_POST);
				if (!empty($avatar)) {
					$_SESSION['old-admin']['file'] = $avatar;
				}
				return $this->redirect(['c' => 'admin', 'a' => 'create']);
			} 

			$admin = $model->create($data); 

			if ($admin) {
				$this->setFlash('notification', 'Add new admin success!');
				return $this->redirect(['c' => 'admin', 'a' => 'index']);
			} else {
				$this->setSession('create-user', $admin);
				return $this->redirect(['c' => 'admin', 'a' => 'create']);
			}
		}
		// Not login
		return $this->redirect(['c' => 'login', 'a' => 'show']);
	}

	public function show() {
		// Check session admin_user
		if ($this->hasFlash('admin_user')) {
			$idAdmin = $_SESSION['admin_user']['id'];
			$model = new Models_Admin();
			$this->setFlash('admin_user', $model->find($idAdmin));

			// Check id
			if (isset($_GET['id'])) {
				$id = trim($_GET['id']);
				$admin = $model->find($id);

				// Check role 
				if ($this->checkSuperAdmin() || $idAdmin == $id) {
					if (!empty($admin['avatar']) && file_exists('uploads/images/'.$admin['avatar'])) {
						$urlImage = 'uploads/images/'.$admin['avatar'];
					} else {
						$urlImage = getConfig('defaultImageAdmin', 'public/images/no-image.png');
					}
					return $this->render('admin/show.php', ['admin' => $admin, 'urlImage' => $urlImage]);
				}
				// None  role
				return $this->redirect(['c' => 'admin', 'a' => 'role']);			
			} 
			// File not found
			return $this->redirect(['c' => 'admin', 'a' => 'fileNotFound']); 
		}
		// Not login
		return $this->redirect(['c' => 'login', 'a' => 'show']);
	}

	public function edit () {
		// Check session admin_user
		if ($this->hasFlash('admin_user')) {
			$idAdmin = $_SESSION['admin_user']['id'];
			$model = new Models_Admin();
			$this->setFlash('admin_user', $model->find($idAdmin));

			// Check id
			if (isset($_GET['id'])) {
				$id = trim($_GET['id']);
				$admin = $model->find($id);

				// Check role 
				if ($this->checkSuperAdmin() || $idAdmin == $id) {
					return $this->render('admin/edit.php', ['admin' => $admin]);
				}
				// None  role
				return $this->redirect(['c' => 'admin', 'a' => 'role']);			
			} 
			// File not found
			return $this->redirect(['c' => 'admin', 'a' => 'fileNotFound']); 
		}
		// Not login
		return $this->redirect(['c' => 'login', 'a' => 'show']);
	}

	public function update () {		
		// Check session admin_user
		if ($this->hasFlash('admin_user')) {
			$idAdmin = $_SESSION['admin_user']['id'];
			$model = new Models_Admin();
			$this->setFlash('admin_user', $model->find($idAdmin));

			// Check id
			if (isset($_GET['id'])) {
				$id = trim($_GET['id']);

				// Validate
				$isValid = new Validators_Admin();
				$data = [];

				// Get data
				$data['name'] = trim($_POST['name']);
				$data['email'] = trim($_POST['email']);
				$data['role_type'] = $_POST['role_type'] ;

				// Check image to save value file
				$img = new Uploader_Image();
				$avatar = []; 
				if ($img->checkImage($_FILES['avatar'])) {
					$avatar = $_FILES['avatar'];
					$tmp_path = 'uploads/tmp/'.$avatar['name'];
					$avatar['type'] = strtolower(pathinfo($tmp_path,PATHINFO_EXTENSION));
					$avatar['name'] = date('YmdHis').'.'.$avatar['type'];
					$img->saveImageToTempFolder($avatar);
				} elseif ($this->hasFlash('avatar')) {
					$avatar = $this->getFlash('avatar');
				}
				
				// Check validate
				if ($isValid->requiredAdmin($data) === false || $isValid->checkLengthName($_POST['name']) === false) {
					$this->setFlash('old-admin', $_POST);
					if (!empty($avatar)) {
						$_SESSION['old-admin']['file'] = $avatar;
					}
					$this->setFlash('errors', $isValid->errors());
					return $this->redirect(['c' => 'admin', 'a' => 'edit', 'id' => $id]);
				}

				// Check unique email 
				if ($model->uniqueEditEmail($id, $data['email']) === false) {
					$this->setFlash('old-admin', $_POST);
					if (!empty($avatar)) {
						$_SESSION['old-admin']['file'] = $avatar;
					}
					$this->setFlash('errors', ['email' => 'Email is unique.']);
					return $this->redirect(['c' => 'admin', 'a' => 'edit', 'id' => $id]);
				}

				// Validate success
				$admin = $model->find($id);
				$data['avatar'] = $admin['avatar']; 

				// Upload image
				$errorsImg = [];
				if (!empty($avatar)) {
					// Check validate
					if ((!empty($avatar['type']) && $isValid->checkImage($avatar['type']) === false) || $isValid->checkFileSize($avatar['size']) === false) {
						$errorsImg = $isValid->errors();
					} 

					// Upload image
					if (empty($errorsImg)) {		
						if ($img->uploadImage('avatar', $avatar)) {
							$data['avatar'] = 'avatar_'.$avatar['name'];
							// Delete old avatar
							$img->deleteImage($admin['avatar']);
						} else {
							$errorsImg['upload'] = "Sorry, there was an error uploading your avatar.";
						}
					}
				} 

				if (!empty($errorsImg)) {
					$this->setFlash('old-admin', $_POST);
					if (!empty($avatar)) {
						$_SESSION['old-admin']['file'] = $avatar;
					}
					$this->setFlash('errors', $errorsImg);
					return $this->redirect(['c' => 'admin', 'a' => 'edit', 'id' => $id]);
				} 

				// Check new password
				if (!empty($_POST['new_password'])) {
					if (strcmp($_POST['new_password'], trim($_POST['new_password'])) != 0) {
						$this->setFlash('errors', ['password' => "Password don't contain blank characters."]);
					} elseif ($isValid->required(trim($_POST['password_confirmation']))) {
						$this->setFlash('errors', ['password_confirmation' => "Password confirmation can't be blank."]);
					} elseif ($isValid->checkPasswordSize(trim($_POST['new_password'])) === false) {
						$this->setFlash('errors', $isValid->errors());
					} elseif ($isValid->checkPasswordConfirmation(trim($_POST['new_password']), trim($_POST['password_confirmation'])) === false) {
						$this->setFlash('errors', $isValid->errors());
					} else {
						$data['password'] = trim($_POST['new_password']);
					}
				}

				// Password is not valid
				if (!empty($_SESSION['errors'])) {
					$this->setFlash('old-admin', $_POST);
					if (!empty($avatar)) {
						$_SESSION['old-admin']['file'] = $avatar;
					}
					return $this->redirect(['c' => 'admin', 'a' => 'edit', 'id' => $id]);
				}

				// Update admin
				$admin = $model->update($id, $data); 
				if ($admin) {
					$this->setFlash('notification', 'Update success!');
					$url = ['c' => 'admin', 'a' => 'index'];
					if ($this->hasFlash('urlAdmin')) {
						$getUrl = $_SESSION['urlAdmin'];
						foreach ($getUrl as $key => $value) {
							$url[$key] = $value;
						}
					}
					return $this->redirect($url);
				} 

				// Update failed
				$this->setFlash('errors', ['update' => 'Update failed.']);
				return $this->redirect(['c' => 'admin', 'a' => 'edit', 'id' => $id]);
			}
			// File not found (404)
			return $this->redirect(['c' => 'admin', 'a' => 'fileNotFound']);
		}
		// Not login
		return $this->redirect(['c' => 'login', 'a' => 'show']);
	}

	public function destroy () {
		// Check session admin_user
		if ($this->hasFlash('admin_user')) {
			$idAdmin = $_SESSION['admin_user']['id'];
			$model = new Models_Admin();
			$this->setFlash('admin_user', $model->find($idAdmin));

			if (isset($_GET['id'])) {
				$id = trim($_GET['id']);
				$admin = $model->find($id);

				// Check admin 
				if (empty($admin)) {
					$this->setFlash('errors', ['deleteAdmin' => 'Delete failed.']);
				} elseif ($model->delete($id)) {
					$this->setFlash('notification', 'Delete success!');
					// Delete avatar
					$img = new Uploader_Image();
					$img->deleteImage($admin['avatar']);
				} else {
					$this->setFlash('errors', ['deleteAdmin' => 'Delete failed.']);
				}

				$url = ['c' => 'admin', 'a' => 'index'];
				if ($this->hasFlash('urlAdmin')) {
					$getUrl = $_SESSION['urlAdmin'];
					foreach ($getUrl as $key => $value) {
						$url[$key] = $value;
					}
				}
				return $this->redirect($url);
			} 
			// File not found (404)
			return $this->redirect(['c' => 'admin', 'a' => 'fileNotFound']);
		}
		// Not login
		return $this->redirect(['c' => 'login', 'a' => 'show']);
	}
}
