<?php

require_once(__DIR__ . '/../entities/user.php');
require_once(__DIR__ . '/../entities/db.php');
require_once(__DIR__ . '/../entities/task.php');
require_once(__DIR__ . '/../entities/group.php');
session_start();

if(isset($_SESSION['uname'])) $user = User::GetByUname($_SESSION['uname']);
else $user = null;

function check($task,$u)
{
	if($u->access > 20) return true;
	$ga = Group::GetByUserId($u->id);
	foreach($ga as $g)
	{
		if(in_array($task->id,$g->GetProblems())) return true;
	}return false;
}

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
			
			<div class="w3-container w3-display-container w3-card-2 w3-border w3-border-green ">
				
				<?php
					$f=false;
					if(!isset($_GET['taskid'])) echo "<h2>This task is unavailable.</h2>";
					else
					{
						$task = Task::GetById($_GET['taskid']);
						if($task == null || ($task->visible == 0 && $user == null) || ($task->visible == 0 && !check($task,$user))) echo "<h2>This task is unavailable.</h2>";
						else{
							echo "<br><h1>$task->name</h1><br><small>Origin: $task->origin, $task->year</small><br><small>Author: ".User::GetById($task->author)->name."</small><small class='w3-display-topright w3-padding-large'>TL: $task->time<br>ML: $task->memory</small>";
							echo "<br><br>";
							echo "<p>".html_entity_decode(file_get_contents(__DIR__ . '/..'. $task->statement))."</p><br>"; if($user != null) $f=true;
						}
					}
				?>
				
			</div><br><br>
			
			<div class="w3-container w3-display-container w3-card-2 w3-border w3-border-green" style='<?php if($f==false) echo "display: none"; ?>'>
				<h2>Submit a solution</h2>
				<form onsubmit="return check()" action="send.php" method="post">
					<input name="task_id" type="text" value="<?php echo $_GET['taskid']; ?>" style="display: none">
					<textarea cols=97 rows=15 name="source"></textarea><br><br>
					<input type="submit" class="w3-button w3-green" value="Submit!">
				</form><br>
				
			</div><br><br>
			
			<div class="w3-container w3-display-container w3-card-2 w3-border w3-border-green" style='<?php if($f==false) echo "display: none"; ?>'>
				
				<h2>Your Submissions</h2>
				
				<ul class="w3-ul w3-card-2 w3-border w3-hoverable">
					<li>
						<div class="w3-row">
							<div class="w3-col" style="width: 10%"><p>ID</p></div>
							<div class="w3-col" style="width: 70%"><p>Verdict</p></div>
							<div class="w3-col" style="width: 20%"><p>Points</p></div>
						</div>
					</li>
					<?php
						
						$db = new DB();
						$res = $db->query("select * from submits where user=".$user->id." and task=".$task->id);
						
						if($res->num_rows<1) echo "<center><h4>There are no submissions you sent!</h4></center>";
						else
							while($r = $res->fetch_assoc())
							{
								echo "<a style=\"text-decoration: none\" href=\"/../submits/view.php?id=" . $r['id'] . "\"><li>
									<div class=\"w3-row\">
										<div class=\"w3-col\" style=\"width: 10%\"><p>".$r['id']."</p></div>
										<div class=\"w3-col\" style=\"width: 70%\"><p>".$r['verdict']."</p></div>
										<div class=\"w3-col\" style=\"width: 20%\"><p>".$r['points']."</p></div>
									</div>
								</li></a>";
							}
						
					?>
					
				</ul><br>
				
			</div><br><br>
			
		</div>
		
		<script>
			function check()
			{
				if(document.getElementsByName('source')[0].value!="") return true;
				alert("Please insert your code.");
				return false;
			}
		</script>
		
	</body>
</html>