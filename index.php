<?php

require_once(__DIR__ . '/entities/user.php');
require_once(__DIR__ . '/entities/db.php');
require_once(__DIR__ . '/entities/submit.php');
//session_start();

if(isset($_SESSION['uname'])) $user = User::GetByUname($_SESSION['uname']);
else $user = null;

Submit::CheckQueue();

?>

<!DOCTYPE html>
<html>
	<head>
		<title>CppCode.ml</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	</head>
	
	<body>
		
		<?php require_once(__DIR__ . '/templates/header.php'); ?>
		
		<div style="width: 100%; padding-left: 20%; padding-right: 20%; margin-top: 100px">
			
			<div class='w3-container w3-card-2 w3-border w3-border-green w3-padding-large'>
				<h1>Welcome to the CppCode.ml testing system!</h1>
				<h4><p>Solve tasks, submit solutions, compete with other people and participate in groups on our new online testing system.</p></h4>
			</div>
			<br><br><br>
			<div class='w3-container w3-card-2 w3-border w3-border-green w3-padding-large'>
				<h1>News</h1>
			</div><br>
			<?php
				
				$db = new DB();
				$res = $db->query("select * from news order by id desc");
				if($res->num_rows>0)
				{
					while($r=$res->fetch_assoc())
					{
						if($r['visible']==1)
						{
							echo "<div class='w3-container w3-border w3-border-green w3-card-2 w3-padding-large'>
							<i class='w3-right w3-xxxlarge fa fa-$r[icon]'></i>
							<h2>$r[title]</h2><br>
							<p>$r[content]</p><br>
							<small>  by $r[author]</small><br><br>
							</div><br>";
						}
					}
				}
				
			?>
			
		</div>
		
	</body>
</html>