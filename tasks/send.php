<?php

require_once(__DIR__ . '/../entities/user.php');
require_once(__DIR__ . '/../entities/db.php');
require_once(__DIR__ . '/../entities/task.php');
require_once(__DIR__ . '/../entities/submit.php');
session_start();

if(isset($_SESSION['uname'])) $user = User::GetByUname($_SESSION['uname']);
else header("Location: http://$_SERVER[HTTP_HOST]");

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
					
					if(isset($_POST['source'])&&isset($_POST['task_id']))
					{
						$source = $_POST['source'];
						$task = Task::GetById($_POST['task_id']);
						if($task == null) exit;
						
						$sub = Submit::Add($source, $task->id, $user->id);
						Submit::CheckQueue();
						
						header("Location: http://$_SERVER[HTTP_HOST]/submits/view.php?id=".$sub->id);
						
					}
					else echo "<h2>Your submission was not be sent</h2>";
					
				?>
				
			</div><br><br>
			
		</div>
		
	</body>
</html>