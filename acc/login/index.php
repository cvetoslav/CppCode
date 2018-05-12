<?php

require_once(__DIR__ . '/../../entities/user.php');
session_start();

if(isset($_SESSION['uname'])){$_SESSION['status'] = 'error'; $_SESSION['message'] = 'You have already logged in.'; header("Location: http://$_SERVER[HTTP_HOST]");}
else $user = null;

?>

<!DOCTYPE html>
<html>
	<head>
		<title>CppCode.ml</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	</head>
	
	<body>
		
		<?php require_once(__DIR__ . '/../../templates/header.php'); ?>
		
		<div style="width: 100%; padding-left: 25%; padding-right: 25%; margin-top: 100px">
			
			<div class="w3-container w3-green w3-card-2"><h2>Login form</h2></div>
			<form id="form1" class="w3-container w3-card-2" action="login.php" method="post">
				<input style="display: none" type="text" name="ref" value="<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>">
			
				<br>
				<p>
					<label>Username</label>
					<input class="w3-input" name="uname" type="text">
				</p><br>
				
				<p>
					<label>Password</label>
					<input class="w3-input" name="pass" type="password">
				</p><br><br>
				
				<center><a onclick="check()" class="w3-btn w3-green w3-large w3-hover-green">Log in!</a></center><br>
				
			</form>
			
		</div>
		
	</body>
	
	<script>
		
		function check()
		{
			
			var a = document.getElementsByName('uname')[0].value,b = document.getElementsByName('pass')[0].value;
			
			if(!/[a-zA-Z0-9$#@%~` -]/.test(a)){alert('Username is invalid!');}
			else if(!/[a-zA-Z0-9$#@%~` -]/.test(b)){alert('Password is invalid!');}
			else {document.getElementById('form1').submit();}
			
		}
		
	</script>
	
</html>