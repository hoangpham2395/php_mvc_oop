<?php 
// Facebook
use Facebook\Facebook;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;

// PHPMailer
require('PHPMailer\src\PHPMailer.php');
require('PHPMailer\src\SMTP.php');
require('PHPMailer\src\POP3.php');
require('PHPMailer\src\OAuth.php');
require('PHPMailer\src\Exception.php');
// If require error, run the following command:
// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\Exception;

class LoginController extends BaseController {
	// Login Admin
	public function show () {
		// Old email
		$oldEmail = (isset($_SESSION['email'])) ? $this->getFlash('email') : '';
		return $this->render('login/login.php', ['oldEmail' => $oldEmail]);
	}

	public function login() {
		// Check validate
		$isValid = new Validators_Login(); 
		if ($isValid->validate($_POST) == false) {
			$this->setSession('email', $_POST['email']);
			$this->setSession('errors', $isValid->errors());
			return $this->redirect(['c' => 'login', 'a' => 'show']);
		} 

		$admin = new Models_Admin();

		$email = $_POST['email'];
		$password = md5($_POST['password']); 

		// Check Login
		$user = $admin->checkLogin($email, $password);
		
		if (!empty($user)) {
			$this->setSession('admin_user', $user);
			
			if (isset($_SESSION['email'])) {
				unset($_SESSION['email']);
			}
			
			return $this->redirect(['c' => 'users', 'a' => 'index']);
		}
		// Login failed
		$this->setSession('errors', ['login' => 'Email or password is wrong.']);
		$this->setSession('email', $email);
		return $this->redirect(['c' => 'login', 'a' => 'show']);
	
	}

	public function logout() {
		unset($_SESSION['admin_user']);
		return $this->redirect(['c' => 'login', 'a' => 'show']);
	}

	// Login Facebook
	public function loginFB() {
		$appId         = getConfig('appId', '192669024787850'); //Facebook App ID
		$appSecret     = getConfig('appSecret', 'e83f6755b66f33a3ca35bc7e873c63da'); //Facebook App Secret
		$redirectURL   = getConfig('redirectURL', 'https://training.com/'); //Callback URL
		$fbPermissions = array('email');  //Optional permissions
		

		$fb = new Facebook([
		    'app_id' => $appId,
		    'app_secret' => $appSecret,
		    'default_graph_version' => 'v2.10',
		]);

		// Get redirect login helper
		$helper = $fb->getRedirectLoginHelper();
		// Get login url
    	$loginURL = $helper->getLoginUrl($redirectURL, $fbPermissions);
    	// Define logout FB
    	$logoutURL = '';

    	// Try to get access token
    	try {
		    if (isset($_SESSION['facebook_access_token'])) {
		        $accessToken = $_SESSION['facebook_access_token'];
		    } else {
		        $accessToken = $helper->getAccessToken();
		    }
		} catch(FacebookResponseException $e) {
     		echo 'Graph returned an error: ' . $e->getMessage();
      		exit;
		} catch(FacebookSDKException $e) {
		    echo 'Facebook SDK returned an error: ' . $e->getMessage();
      		exit;
		}

		$model = new Models_User();

		// Check fb token
		if (isset($accessToken)) {
			if (isset($_SESSION['facebook_access_token'])) {
				$fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
			} else {
				// Put short-lived accsess token in session (Đặt session cho token ngắn hạn)
				$this->setSession('facebook_access_token', (string) $accessToken);
				// OAuth 2.0 client handler helps to manage access tokens
				$oAuth2Client = $fb->getOAuth2Client();

				// Exchanges a short-lived access token for a long-lived one (Thay đổi token ngắn hạn sang dài hạn)
				$longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($_SESSION['facebook_access_token']);
				$this->setSession('facebook_access_token', (string) $longLivedAccessToken);
			}

			 // Redirect the user back to the same page if url has "code" parameter in query string
		    if(isset($_GET['code'])){
		        header("location:index.php?c=login&a=loginFB");
		    }

		    // Get info user
		    try {
		    	$profileRequest = $fb->get('/me?fields=name, email, first_name, last_name, picture');
		    	$fbUserProfile = $profileRequest->getGraphNode()->asArray();
		    } catch (FacebookResponseException $e) {
		    	echo 'Graph returned an error: ' . $e->getMessage();
		        session_destroy();
		        exit;
		    } catch(FacebookSDKException $e) {
		        echo 'Facebook SDK returned an error: ' . $e->getMessage();
		        exit;
		    }

		    // Get url logout FB
		    $logoutURL = $helper->getLogoutUrl($accessToken, $redirectURL.'index.php?c=login&a=logoutFB');
		    $_SESSION['logoutURL'] = $logoutURL;

		    // Get user data
		    $fbUserData = [
		    	'name' => $fbUserProfile['first_name'].' '.$fbUserProfile['last_name'],
		    	'facebook_id' => $fbUserProfile['id'],
		    	'email' => $fbUserProfile['email'],
		    	'picture' => $fbUserProfile['picture']['url']
		    ];

		    // Check account
		    $checkAccount = $model->checkAccountFB($fbUserData['facebook_id']);

		    $this->setFlash('user_fb', $fbUserData);

		    if ($checkAccount === true) {
		    	// Check status
		    	$checkStatus = $model->checkStatus($fbUserData['facebook_id']);

		    	if ($checkStatus === true) {
		    		return $this->redirect(['c' => 'users', 'a' => 'info']);
		    	}
				unset($_SESSION['user_fb']);
				$this->setFlash('errors-loginFB', 'Account is block.');	    	
		    } else {
		    	return $this->redirect(['c' => 'login', 'a' => 'registerFB']);
		    }
		}

		return $this->render('login/loginFB.php', ['loginURL' => $loginURL, 'logoutURL' => $logoutURL]);
	}	
	
	// Don't have account
	public function registerFB () {
		$info = ($this->hasFlash('user_fb')) ? $_SESSION['user_fb'] : [];
		return $this->render('login/registerFB.php', ['info' => $info]);
	}

	public function addFB () {
		if ($this->hasFlash('user_fb')) unset($_SESSION['user_fb']);

		$data = [
			'name' => $_POST['name'],
			'email' => $_POST['email'],
			'facebook_id' => $_POST['facebook_id'],
			'status' => '1',
			'ins_id' => '1',
			'upd_id' => '1',
			'ins_datetime' => date('Y-m-d H:i:s'),
			'upd_datetime' => date('Y-m-d H:i:s'),
			'del_flag' => 0
		];

		$model = new Models_User();

		// Content mail
		$body = '<h3>Thông tin người đăng ký:</h3><br>';
		$img = (!empty($_POST['img'])) ? $_POST['img'] : getConfig('imgUserFbUrl', 'http://via.placeholder.com/200x200&text=no-image'); 
		$body .= '<img src="'.$img.'" alt="Avatar"><br>';
		$body .= '<b>Tên: </b>'.$data['name'].'<br>';
		$body .= '<b>Email: </b>'.$data['email'].'<br>';
		$body .= '<b>Facebook ID: </b>'.$data['facebook_id'].'<br>';

		$admin_model = new Models_Admin();
		// First super admin
		$superadmin = $admin_model->findSuperAdmin();

		$admin = $admin_model->getList();
		$i = 0; $ccmail = [];
		// Get list admin to CC mail
		foreach ($admin as $ad) {
			$ccmail[$i] = $ad['email'];
			$i ++;
		}

		// SEND MAIL
		
		$mail = new PHPMailer\PHPMailer\PHPMailer(true);
		// If use "use PHPMailer/PHPMailer/PHPMailer", run "$mail = new PHPMailer(true);"
		try {
			// Config SMTP
			$mail->isSMTP();
			$mail->CharSet = getConfig('mailCharSet', "utf-8");
			$mail->SMTPDebug = getConfig('SMTPDebug', 2);
			$mail->SMTPAuth = getConfig('SMTPAuth', true);

			// SMTPSecure: ssl | tls (If use local)
			$mail->SMTPSecure = getConfig('SMTPSecure', 'tls');
			$mail->SMTPOptions = array(
			    'ssl' => array(
			        'verify_peer' => false,
			        'verify_peer_name' => false,
			        'allow_self_signed' => true
			    )
			);

			// Gmail's SMTP 
			$mail->Host = getConfig('mailHost', "smtp.gmail.com");
			$mail->Port = getConfig('mailPort', 587); // Gmail Port: 465 | 587 (If use local)

			// Email From
			$mail->Username = getConfig('mailFrom', 'hoangpham2395@gmail.com');
			$mail->Password = getConfig('mailPass', 'hdeqgnczpbnfwtsj');
			$mail->setFrom($data['email'], $data['name']);
		
			// Email To	
		 	$mail->AddAddress($superadmin['email'], $superadmin['name']);
		 	// Address CC:
			if (!empty($ccmail)) {
				foreach ($ccmail as $key => $value) {
					$mail->addCC($value);
				} 
			}

			// Content mail
			$mail->isHTML(true);
			$mail->Subject = 'Đăng ký tài khoản bằng facebook để truy cập vào TrainingPHP'; 		
			$mail->Body = $body;

			$mail->send();

		    // Insert DB
			$user_fb = $model->create($data); 
			if (!$user_fb) {
				$this->setFlash('confirm-loginFB', 'Register failed.');
			}

			return $this->redirect(['c' => 'login', 'a' => 'loginFB']);
		} catch (Exception $e) {
		    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
		}
	}

	public function logoutFB() {
		unset($_SESSION['facebook_access_token']);
		unset($_SESSION['user_fb']);
		return $this->redirect(['c' => 'login', 'a' => 'loginFB']);
	}
}
?>
