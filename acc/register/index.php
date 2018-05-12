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
			
			<div class="w3-container w3-green w3-card-2"><h2>Registration form</h2></div>
			<form id="form1" class="w3-container w3-card-2" action="reg.php" method="post">
				
				<br>
				<p>
					<label>Name</label>
					<input class="w3-input" name="name" type="text">
				</p><br>
				
				<p>
					<label>E-mail</label>
					<input class="w3-input" name="email" type="email">
				</p><br>
				
				<p>
					<label>Username</label>
					<input class="w3-input" name="uname" type="text">
				</p><br>
				
				<p>
					<label>Password</label>
					<input class="w3-input" name="pass" type="password">
				</p><br>
				
				<p>
					<label>Repeat password</label>
					<input class="w3-input" name="pass1" type="password">
				</p><br>
				
				<p>
					<label>City</label>
					<input class="w3-input" name="stadt" type="text">
				</p><br>
				
				<p>
					<label>Country</label>
					<input class="w3-input" name="staat" type="text">
				</p><br>
				
				<p>
					<label>Gender</label>
					<p>
					  <input class="w3-radio" type="radio" name="sex" value="male">
					  <label>Male</label></p>
					  <p>
					  <input class="w3-radio" type="radio" name="sex" value="female">
					  <label>Female</label></p>
					  <p>
					  <input class="w3-radio" type="radio" name="sex" value="none" checked>
					  <label>Don't know</label></p>
				</p><br>
				
				<p>
					<label>Birthday</label>
					<input class="w3-input" name="geburtstag" type="text">
				</p><br>
				<br>
				<center><a onclick="check()" class="w3-btn w3-green w3-large w3-hover-green">Register!</a></center><br>
				
			</form><br><br>
			
		</div>
		
	</body>
	
	<script>
		
		function check()
		{
			
			var a = document.getElementsByName('uname')[0].value,b = document.getElementsByName('pass')[0].value;
			var c = document.getElementsByName('name')[0].value,b1 = document.getElementsByName('pass1')[0].value;
			var d = document.getElementsByName('email')[0].value;
			
			if(!/[a-zA-Z0-9$#@%~` -]/.test(a)){alert('Username is invalid!');}
			else if(!/[a-zA-Z0-9$#@%~` -]/.test(c)){alert('Name is invalid!');}
			else if(!/[a-zA-Z0-9$#@%~` -]/.test(b)){alert('Password is invalid!');}
			else if(!/[a-zA-Z0-9_.]@[a-z0-9].[a-z]/.test(d)){alert('E-mail is invalid!');}
			else if(b!=b1){alert('The passwords aren\'t same!');}
			else {document.getElementById('form1').submit();}
			
		}
		
	</script>
	
</html>