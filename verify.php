<!DOCTYPE html>
<html>
<head>
	<title>Verify user account</title>
</head>
<body>
	<?php 
		$id 	= $_GET['id'];
		$token 	= $_GET['token'];

		require 'users.php';
	 	$objUser = new Users();
	 	$objUser->setId($id);

	 	$user = $objUser->getUserById();
	 	if(is_array($user) && count($user)>0) {
	 		if($user['token'] == $token) {
	 			
	 				echo json_encode(["status" => 1, "msg" => "login successfull.", "data" => $user]);
	 				exit;
	 			}
	 		} 

	 ?>
</body>
</html>