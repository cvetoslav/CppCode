<?php

require_once(__DIR__ . '/../entities/user.php');
require_once(__DIR__ . '/../entities/db.php');
require_once(__DIR__ . '/../entities/task.php');
require_once(__DIR__ . '/../entities/submit.php');
session_start();

if(isset($_SESSION['uname'])) $user = User::GetByUname($_SESSION['uname']);
else $user = null;

$sub = null;
if(!isset($_GET['id'])) header("Location: http://$_SERVER[HTTP_HOST]");
else $sub = Submit::GetById($_GET['id']);

if(!($user->access>20 || (Task::GetById($sub->task)->author == $user->id) || $sub->user == $user->id )) header("Location: http://$_SERVER[HTTP_HOST]");

?>

<!DOCTYPE html>
<html>
	<head>
		<title>CppCode.ml</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
		
		<style>
			.accordion {
				background-color: #eee;
				color: #444;
				cursor: pointer;
				padding: 18px;
				width: 100%;
				border: none;
				text-align: left;
				outline: none;
				font-size: 15px;
				transition: 0.4s;
			}

			.active, .accordion:hover {
				background-color: #ccc;
			}

			.accordion:after {
				content: '\002B';
				color: #777;
				font-weight: bold;
				float: right;
				margin-left: 5px;
			}

			.active:after {
				content: "\2212";
			}

			.panel {
				padding: 0 18px;
				background-color: white;
				max-height: 0;
				overflow: hidden;
				transition: max-height 0.2s ease-out;
			}
		</style>
		
	</head>
	
	<body>
		
		<?php require_once(__DIR__ . '/../templates/header.php'); ?>
		
		<div style="width: 100%; padding-left: 20%; padding-right: 20%; margin-top: 100px">
			
			<div class="w3-container w3-display-container w3-card-2 w3-border w3-border-green w3-padding-large ">
				
				<h2>Submission No.<?php echo $sub->id; ?> - Details</h2>
				<?php
					
					$data = json_decode($sub->data, true);
					if(!$data) echo "Please wait until your solution is being tested.";
					else
					{
						echo "<div class='w3-display-topright' style='margin-top: 20px; margin-right: 20px'>Max Time: ".$sub->time."<br>Max Memory: ".$sub->mem."</div>";
						
						$i=0;
						foreach($data as $test)
						{$i++;
							if(!$test['Tested']) echo "
								<button class='accordion w3-border w3-border-gray'>Test Case $i</button>
								<div class='panel'>
									Not ready.<br>Status: $test[Status].
								</div>";
							else
							{
								if($test['Result'] == 'ok' && $test['Points']>0) echo "<button class='accordion w3-green w3-hover w3-hover-teal'>Test Case $i</button>";
								else echo "<button class='accordion w3-red w3-hover w3-hover-purple'>Test Case $i</button>";
								
								echo "<div class='panel'>";
								echo "Tested.<br>Status: $test[Status]<br>Evaluator Result: $test[Result]<br>Checker Output: ";
								if(Task::GetById($sub->task)->checker == '' || $test['Result'] == 'ce') echo "-";
								else echo "'".$test['Points']."'";
								echo "<br>Overal Points: $test[Points]<br>Total Time: $test[Time]<br>Total Memory: $test[Memory]";
								echo "</div>";
								
							}
							
						}
					}
					
					
				?>

				<script>
				var acc = document.getElementsByClassName("accordion");
				var i;

				for (i = 0; i < acc.length; i++) {
				  acc[i].addEventListener("click", function() {
					this.classList.toggle("active");
					var panel = this.nextElementSibling;
					if (panel.style.maxHeight){
					  panel.style.maxHeight = null;
					} else {
					  panel.style.maxHeight = panel.scrollHeight + "px";
					} 
				  });
				}
				</script>
			</div><br><br>
			
			<div class="w3-container w3-display-container w3-card-2 w3-border w3-border-green w3-padding-large ">
				
				<h2>Submission No.<?php echo $sub->id; ?> - Source Code</h2>
				<textarea cols=97 rows=20><?php echo file_get_contents(__DIR__ . '/..' . $sub->source); ?></textarea>
			</div><br><br>
			
		</div>
		
	</body>
</html>