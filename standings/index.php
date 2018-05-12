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
				<h1>Standings</h1>
				<h4><p>
					The standings of all users, registered on the system
				</p></h4>
			</div><br><br>
			<div class="w3-container w3-border w3-border-green w3-card-2 w3-padding-large">
				<table class='w3-table w3-striped w3-border w3-border-green w3-bordered w3-hoverable'>
					<tbody>
					<tr class='w3-green'>
						<th>No.</th>
						<th>Name</th>
						<th>City</th>
						<th>Country</th>
						<th>Points</th>
						<th>Submits</th>
					</tr>
					</tbody>
					<tbody>
					<?php
						
						if(isset($_GET['page'])){$page=intval($_GET['page']); $e=intval($_GET['page'])*20; $b=$e-20+1;}
						else{$e=20; $b=1; $page=1;}
						$db = new DB();
						$n = $db->Max('id','users');
						$res = $db->query("select * from users where id between $b and $e order by points desc, submits asc, name desc");
						
						if($res->num_rows>0)
						{
							$i =$b;
							while($r = $res->fetch_assoc())
							{
								echo "<tr>
								<td>$i</td>
								<td><a href='/acc?user=$r[id]'>$r[name]</a></td>
								<td>$r[stadt]</td>
								<td>$r[staat]</td>
								<td>$r[points]</td>
								<td>$r[submits]</td>
								</tr>"; $i+=1;
							}
						}
						
					?>
					</tbody>
				</table><br><br>
				<div class="w3-center">
				<div class="w3-bar w3-border w3-round">
				  <a href="<?php if($b>1) echo "?page=".strval($page-1); ?>" class="w3-bar-item w3-button" >&laquo;</a>
					<?php
						$i=max(1,$page-2);
						while($i<=min($n/20+($n%20>0),$page+2)){
						echo "<a href='?page=$i' class='w3-bar-item w3-button "; if($i==$page) echo 'w3-green'; echo "'>$i</a>";
						$i+=1;
						}
					?>
				  <a href="<?php if($e<$n) echo "?page=".strval($page+1); ?>" class="w3-bar-item w3-button">&raquo;</a>
				</div>
				</div>
			</div><br>
			
		</div>
		
	</body>
</html>