<?php

require_once(__DIR__ . '/../entities/user.php');
session_start();

if(!isset($_SESSION['uname'])) header("Location: http://$_SERVER[HTTP_HOST]");
else $user = User::GetByUname($_SESSION['uname']);

if($user->access < 20) header("Location: http://$_SERVER[HTTP_HOST]");
else if($user->access == 100) header("Location: http://$_SERVER[HTTP_HOST]/admin/admin.php");

?>

<!DOCTYPE html>
<html>
	<head>
		<title>CppCode.ml</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	</head>
	
	<body>
		
		<?php require_once(__DIR__ . '/../templates/header.php'); ?>
		
		<div style="width: 100%; padding-left: 20%; padding-right: 20%; margin-top: 100px">
			
			<div class="w3-container w3-display-container w3-card-2 w3-border w3-border-green">
				
				<h2>Teacher's Page</h2>
				
				
				
			</div>
			
		</div>
		
	</body>
</html>