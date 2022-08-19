<?php 
	session_start();
	// if($_SESSION['s_id'] != session_id()) {
	// 	header('location: index.php');
	// }
 ?>
<!DOCTYPE html>

<html>
<head>
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<title>Complete user registration system in php and MySQL using Ajax</title>
	<link rel="stylesheet" href="../css/bootstrap.min.css">
</head>
<body>
	<div class="w3-card-4" style="width:100%">
    <header class="w3-container w3-light-grey">
      
    </header>
    <div class="w3-container">

      <p>Check the API token to get the details</p>
      <hr>
      <img src="https://www.w3schools.com/w3css/img_avatar3.png" alt="Avatar" class="w3-left w3-circle w3-margin-right" style="width:60px">
      <h3>Hello, <?php echo $_SESSION['fname']; ?></h3>
      <p><?php
					$id =$_SESSION['id'];
					$token =$_SESSION['token'];
					echo "<a href='verify.php?id=".$id."&token=".$token."'> Click here to get the api </a>"; ?></p><br>
    </div>
    <button class="w3-button w3-block w3-dark-grey">+ <div class="col-md-2"><a href="logout.php">logout</a></div></button>
  </div>
</div>

</body>
</html>