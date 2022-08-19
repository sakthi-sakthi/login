<?php 
	session_start();
	require 'users.php';
	// require '../mailer/PHPMailerAutoload.php';
	// require '../mailer/credential.php';

	if(isset($_POST['action']) && $_POST['action'] == 'checkCookie') {
		if(isset($_COOKIE['email'], $_COOKIE['pass'])) {
			$data = ['email'=>$_COOKIE['email'], 'pass'=>base64_decode($_COOKIE['pass'])];
			echo json_encode($data);
		}
	}

	if(isset($_POST['action']) && $_POST['action'] == 'updatePass') {
		$users = validateUpdatePassForm();
		$data  = json_decode( base64_decode($users['token']), true );
		$currTime = strtotime(date('d-m-Y h:i:s'));
		$expTime  = strtotime($data['expTime']);
		if($currTime > $expTime) {
			echo json_encode( ["status" => 0, "msg" => "Token expired."] );
			exit;
		}

		$objUser = new Users();
		$objUser->setId($data['id']);
		$userData = $objUser->getUserById();
		if(is_array($userData) && count($userData) > 0) {
			if($data['token'] == $userData['token']) {
				$objUser->setPass(md5($users['pass']));
				if($objUser->updatePass()) {
					echo json_encode( ["status" => 1, "msg" => "Password Updated."] );
					exit;
				} else {
					echo json_encode( ["status" => 0, "msg" => "Failed to update password."] );
					exit;
				}
			} else {
				echo json_encode( ["status" => 0, "msg" => "Token is not valid."] );
				exit;
			}
		} else {
			echo json_encode( ["status" => 0, "msg" => "User not found."] );
			exit;
		}
 		
	}

	if(isset($_POST['action']) && $_POST['action'] == 'resetPass') {
		$email = filter_input(INPUT_POST, 'remail', FILTER_VALIDATE_EMAIL);
		if(false == $email) {
			echo json_encode( ["status" => 0, "msg" => "Enter valid Email"] );
			exit;
		}

		$objUser = new Users();
		$objUser->setEmail($email);
		$userData = $objUser->getUserByEmail();
		if(is_array($userData) && count($userData)>0) {
			$data['id'] = $userData['id'];
			$data['token'] = sha1( $userData['email'] );
			$data['expTime'] = date('d-m-Y h:i:s', time() + (60*60*2));
			$urlToken = base64_encode(json_encode($data));
			$objUser->setId($userData['id']);
			$objUser->setToken($data['token']);
			if($objUser->updateToken()) {
				$url = 'http://' . $_SERVER['SERVER_NAME'] . '/user/reset.php?token=' .$urlToken;
				$html = '<div>You have requested a password reset for your user account at Localhost. You can do this by clicking the link below.:<br>'.$url.'<br><br><strong>Please note this link is valid for 2 hours.</strong></div>';

				
			} else {
				echo json_encode( ["status" => 0, "msg" => "Failed to set token."] );
			}
		} else {
			echo json_encode( ["status" => 0, "msg" => "User is not found."] );
		}

	}

	if(isset($_POST['action']) && $_POST['action'] == 'register') {
		$users = validateRegForm();
		
		$objUser = new Users();
	 	
	 	$objUser->setFirstName($users['fname']);
	 	$objUser->setLastName($users['lname']);
	 	$objUser->setMobile($users['mobile']);
	 	$objUser->setAddress($users['address']);
	 	$objUser->setCity($users['city']);
	 	$objUser->setCountry($users['country']);
	 	$objUser->setEmail($users['uemail']);
	 	$objUser->setPass(md5($users['pass']));
	 	$objUser->setActivated(0);
	 	$objUser->setToken(rand(10,1000000));
	 	$objUser->setCreatedOn(date('Y-m-d'));

	 	$userData = $objUser->getUserByEmail();
		if($userData['email'] == $users['uemail']) {
			echo 'Email is already registered';
			exit;
		}
	 	if($objUser->save()) {
	 		$lastId = $objUser->conn->lastInsertId();
	 		$token = sha1($lastId);
	 		$url = 'http://' . $_SERVER['SERVER_NAME'] . '/user/verify.php?id=' . $lastId . '&token=' .$token;
	 		$html = '<div>Thanks for registering with localhost. Please click this link to complete your registration:<br>'.$url.'</div>';

			
	 	} else {
	 		echo " Failed to save";
	 	}
	}	

	if(isset($_POST['action']) && $_POST['action'] == 'login') {
		$users = validateLoginForm();
		$objUser = new Users();
		$objUser->setEmail($users['email']);
	 	$objUser->setPass(md5($users['pwd']));
	 	$userData = $objUser->getUserByEmail();
	 	$rememberMe = isset($_POST['remember-me']) ? 1 : 0;
	 	if(is_array($userData) && count($userData) > 0) {
	 		if($userData['pass'] == $objUser->getPass()) {
	 			
	 				if($rememberMe == 1) {
	 					setcookie('email', $objUser->getEmail());
	 					setcookie('pass', base64_encode($users['pwd']));
	 				}
	 				$_SESSION['id'] = $userData['id'];
	 				$_SESSION['s_id'] = session_id();
	 				$_SESSION['fname'] = $userData['fname'];
	 				$_SESSION['token'] = $userData['token'];
	 				echo json_encode( ["status" => 1, "msg" => "login successfull."] );
	 			
	 		} else {
	 			echo json_encode( ["status" => 0, "msg" => "Email or Password is wrong."] );
	 		}
	 	} else {
	 		echo json_encode( ["status" => 0, "msg" => "Email or Password is wrong."] );
	 	}
	}
		
	function validateUpdatePassForm() {
		$users['token'] = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRING);
		if(false == $users['token']) {
			echo json_encode( ["status" => 0, "msg" => "Not a valid request."] );
			exit;
		}

		$users['pass'] = filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_STRING);
		if(false == $users['pass']) {
			echo json_encode( ["status" => 0, "msg" => "Enter valid valid pass"] );
			exit;
		}

		$users['cfm_pass'] = filter_input(INPUT_POST, 'cfm_pass', FILTER_SANITIZE_STRING);
		if(false == $users['cfm_pass']) {
			echo json_encode( ["status" => 0, "msg" => "Enter valid confirm pass"] );
			exit;
		}

		if($users['pass'] != $users['cfm_pass']) {
			echo json_encode( ["status" => 0, "msg" => "Password and confirm password not match"] );
			exit;
		}

		return $users;
	}

	function validateLoginForm() {
		$users['email'] = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
		if(false == $users['email']) {
			echo json_encode( ["status" => 0, "msg" => "Enter valid Email"] );
			exit;
		}

		$users['pwd'] = filter_input(INPUT_POST, 'pwd', FILTER_SANITIZE_STRING);
		if(false == $users['pwd']) {
			echo json_encode( ["status" => 0, "msg" => "Enter valid valid pass"] );
			exit;
		}

		return $users;
	}
		
	function validateRegForm() {
		$users['fname'] = filter_input(INPUT_POST, 'fname', FILTER_SANITIZE_STRING);
		if(false == $users['fname']) {
			echo "Enter valid first name";
			exit;
		}

		$users['lname'] = $_POST['lname'];
		if(false == $users['lname']) {
			echo "Enter valid last name";
			exit;
		}

		$users['mobile'] = filter_input(INPUT_POST, 'mobile', FILTER_SANITIZE_NUMBER_INT);
		if(false == $users['mobile']) {
			echo "Enter valid phone number";
			exit;
		}

		$users['address'] = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING);
		if(false == $users['address']) {
			echo "Enter valid address";
			exit;
		}

		$users['city'] = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_STRING);
		if(false == $users['city']) {
			echo "Enter valid city";
			exit;
		}

		$users['country'] = filter_input(INPUT_POST, 'country', FILTER_SANITIZE_STRING);
		if(false == $users['country']) {
			echo "Enter valid country";
			exit;
		}
		$users['uemail'] = filter_input(INPUT_POST, 'uemail', FILTER_VALIDATE_EMAIL);
		if(false == $users['uemail']) {
			echo "Enter valid Email";
			exit;
		}

		$users['pass'] = filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_STRING);
		if(false == $users['pass']) {
			echo "Enter valid valid pass";
			exit;
		}
		$users['cfm_pass'] = filter_input(INPUT_POST, 'cfm_pass', FILTER_SANITIZE_STRING);
		if(false == $users['cfm_pass']) {
			echo "Enter valid valid confirm pass";
			exit;
		}

		if($users['pass'] != $users['cfm_pass']) {
			echo 'Password and confirm password not match';
			exit;
		}

		return $users;
	}
?>