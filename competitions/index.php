<?php

require_once(__DIR__ . '/../entities/user.php');
require_once(__DIR__ . '/../entities/db.php');
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
			
			<div class="w3-container w3-border w3-border-green w3-card-2 w3-padding-large">
				<h1>Competitions</h1>
				<h4><p>
					The list of all available competitions on the system
				</p></h4>
			</div><br><br>
			<div class="w3-container w3-border w3-border-green w3-card-2 w3-padding-large">
				<h2>Upcoming competitions</h2>
				
				<ul class="w3-ul w3-card-2 w3-border w3-hoverable">
					<?php
						
						$curr = 
						$db = new DB();
						$res = $db->query("select * from competitions order by start asc");
						if($res->num_rows<1) echo "<center><h4>There are no competitions!</h4></center>";
                        else
						while($r=$res->fetch_assoc())
						{
							$d=$r['start'];
							
							echo "<li class=\"";
							if($user != null)
							{
								if(in_array($problem,$user->solved))
								{
									echo "w3-green";
								}
								else if(in_array($problem,$user->tried))
								{
									echo "w3-yellow";
								}
							}
							echo "\"><h3>" . $r['name'] . "</h3><br/>" . $r['origin'] . "</li>";
						}
							
					?>
				</ul>
				
			</div><br>
			
		</div>
		
	</body>
</html>