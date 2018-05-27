<?php 

return array(
	// Connect DB
	'db_host' 			=> 'localhost',
	'db_username' 		=> 'root',
	'db_password' 		=> '',
	'db_name' 			=> 'training',
	// Pagination
	'limit'				=> [10, 25, 50],
	'links'  			=> 5,
	'page'				=> 1,
	// PHPMailer
	'mailFrom'			=> 'hoangpham2395@gmail.com',
	'mailPass'			=> 'hdeqgnczpbnfwtsj',
	'SMTPSecure'		=> 'tls',
	'mailHost'			=> 'smtp.gmail.com',
	'mailPort'			=> 587,
	'mailCharSet'		=> 'utf-8',
	'SMTPDebug'			=> 2,
	'SMTPAuth'			=> true,
	// Facebook
	'appId'        	 	=> '192669024787850',
	'appSecret'     	=> 'e83f6755b66f33a3ca35bc7e873c63da',
	'redirectURL'   	=> 'https://training.com/',
	'imgUserFbUrl'		=> 'http://via.placeholder.com/200x200&text=no-image',
	// Date default timezone
	'date_default_timezone_set' => 'Asia/Ho_Chi_Minh',
	// Select role type (admin rights, key required: 1 and 2)
	// 'select_role_type' 	=> ['' 	=> '---Select role type---', 
	// 						1 	=> 'Super admin', 
	// 						2 	=> 'Admin'],
	'roleSuperAdmin'	=> ['value' => 1, 'text' => 'Super admin'],
	'roleAdmin'			=> ['value' => 2, 'text' => 'Admin'],
	// Info Admin Default
	'defaultImageAdmin'	=> 'public/images/no-image.png',
	'defaultNameAdmin'	=> 'Unknown name',
	// Status User (key required: 1 and 2)
	'active'			=> ['value' => 1, 'text' => 'Active'],
	'blocked'			=> ['value' => 2, 'text' => 'Blocked'],
	// Delete index in DB 
	'del_flag'			=> ['not_delete' => 0, 'deleted' => 1]
);

?>