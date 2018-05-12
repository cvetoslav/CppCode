<?php

require_once(__DIR__ . '/../../entities/user.php');
session_start();

if(!isset($_SESSION['uname'])){$_SESSION['status'] = 'error'; $_SESSION['message'] = 'You have to log in.'; header("Location: http://$_SERVER[HTTP_HOST]");}
else $user = User::GetByUname($_SESSION['uname']);

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
			
			<div class="w3-container w3-green w3-card-2"><h2>Account edit form</h2></div>
			<form id="form1" onsubmit="return Validate(this)" class="w3-container w3-card-2" action="edit.php" method="post" enctype="multipart/form-data">
				
				<br>
				<p>
					<label>Image</label>
					<input class="w3-input" name="image" type="file">
				</p><br>
				
				<p>
					<label>Name</label>
					<input class="w3-input" name="name" type="text" value="<?php echo $user->name;?>">
				</p><br>
				
				<p>
					<label>E-mail</label>
					<input class="w3-input" name="email" type="email" value="<?php echo $user->email;?>">
				</p><br>
				
				<p>
					<label>Password</label>
					<input class="w3-input" name="pass" type="password" value="<?php echo $user->password;?>">
				</p><br>
				
				<p>
					<label>Repeat password</label>
					<input class="w3-input" name="pass1" type="password" value="<?php echo $user->password;?>">
				</p><br>
				
				<p>
					<label>City</label>
					<input class="w3-input" name="stadt" type="text" value="<?php echo $user->stadt;?>">
				</p><br>
				
				<p>
					<label>Country</label>
					<input class="w3-input" name="staat" type="text" value="<?php echo $user->staat;?>">
				</p><br>
				
				<p>
					<label>Gender</label>
					<p>
					  <input class="w3-radio" type="radio" name="sex" value="male" <?php if($user->sex=="male") echo "checked"; ?>>
					  <label>Male</label></p>
					  <p>
					  <input class="w3-radio" type="radio" name="sex" value="female" <?php if($user->sex=="female") echo "checked"; ?>>
					  <label>Female</label></p>
					  <p>
					  <input class="w3-radio" type="radio" name="sex" value="none" <?php if($user->sex=="none") echo "checked"; ?>>
					  <label>Don't know</label></p>
				</p><br>
				
				<p>
					<label>Birthday</label>
					<input class="w3-input" name="geburtstag" type="text" value="<?php echo $user->geburtstag;?>">
				</p><br>
				<br>
				<center><input type="submit" class="w3-btn w3-green w3-large w3-hover-green" value="Edit!"></center><br>
				
			</form><br><br>
			
		</div>
		
		<script>
			var _validFileExtensions = [".jpg", ".jpeg", ".bmp", ".gif", ".png"];    
			function Validate(oForm) {
				var arrInputs = oForm.getElementsByTagName("input");
				for (var i = 0; i < arrInputs.length; i++) {
					var oInput = arrInputs[i];
					if (oInput.type == "file") {
						var sFileName = oInput.value;
						if (sFileName.length > 0) {
							var blnValid = false;
							for (var j = 0; j < _validFileExtensions.length; j++) {
								var sCurExtension = _validFileExtensions[j];
								if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
									blnValid = true;
									break;
								}
							}
							
							if (!blnValid) {
								alert("Sorry, " + sFileName + " is invalid, allowed extensions are: " + _validFileExtensions.join(", "));
								return false;
							}
						}
					}
				}
			  
				return true;
			}
		</script>
		
	</body>
	
</html>