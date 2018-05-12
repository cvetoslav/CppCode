<?php

require_once(__DIR__ . '/../entities/user.php');
session_start();

if(isset($_SESSION['uname'])) $user = User::GetByUname($_SESSION['uname']);
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
		
		<?php require_once(__DIR__ . '/../templates/header.php'); ?>
		
		<div style="width: 100%; padding-left: 20%; padding-right: 20%; margin-top: 100px">
			
			<div class="w3-container w3-display-container w3-card-2 w3-border w3-border-green">
				
				<?php 
					
					if(isset($_GET['user']))
					{
						$u = User::GetById($_GET['user']);
					}
					else $u=$user;
					
					if($u!=null)
					{
						echo "<img src='".$u->image."'>";
						echo "<h2>".$u->name."</h2>";
						echo "<div class='w3-display-topright' style='padding-right: 30%; padding-top:10px'><h5>City: ".$u->stadt."<br>Country: ".$u->staat."<br>Points: ".$u->points."<br>Submits: ".$u->submits."<br>Registered on: ".$u->reg_date."</h5></div>";
						if($u==$user)
                                                {
                                                    echo "<a href='/acc/edit' class='w3-display-topright w3-button'>Edit!</a>";
                                                    if($user->access == 20) echo "<a href='/admin/teacher.php' class='w3-button w3-green w3-display-bottommiddle' style='margin-bottom: 10px' >Enter Teacher Page!</a>";
                                                    else if($user->access == 100) echo "<a href='/admin/admin.php' class='w3-button w3-green w3-display-bottommiddle' style='margin-bottom: 10px' >Enter Admin Page!</a>";
                                                }
					}
					else echo "<b>No such user!</b>";
					
				?>
				
			</div>
			
		</div>
		
	</body>
</html>