<?php

require_once(__DIR__ . '/../entities/user.php');
require_once(__DIR__ . '/../entities/task.php');
require_once(__DIR__ . '/../entities/db.php');
session_start();

function rmdir_recursive($dir) {
    foreach(scandir($dir) as $file) {
       if ('.' === $file || '..' === $file) continue;
       if (is_dir("$dir/$file")) rmdir_recursive("$dir/$file");
       else unlink("$dir/$file");
   }

   rmdir($dir);
}

if(!isset($_SESSION['uname'])) header("Location: http://$_SERVER[HTTP_HOST]");
else $user = User::GetByUname($_SESSION['uname']);

if($user->access < 100) header("Location: http://$_SERVER[HTTP_HOST]");

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
				
				<h2>Admin Page - Edit Task</h2>
				
				<?php
				
					if(isset($_POST['taskid']))
					{
						$tid = $_POST['taskid'];
						$task = Task::GetById($tid);
						if($task == null){echo "no such task!"; exit;}
						if(isset($_POST['save']))
						{
							$visible=$_POST['visible'];
							$time=$_POST['time'];
							$memory=$_POST['memory'];
							$name=$_POST['name'];
							$author=$_POST['author'];
							$origin=$_POST['origin'];
							$difficulty=$_POST['difficulty'];
							$year=$_POST['year'];
							$reg_date=$_POST['reg_date'];
							$statement=$_POST['statement'];
							$type=$_POST['type'];
							$checker=$_POST['checker'];
							
							if($checker != ""){file_put_contents(__DIR__ . '/../checkers/' . strval($tid) . '.cpp',$checker); $checker="/checkers/".strval($tid).".cpp";}
							if($statement != ""){file_put_contents(__DIR__ . '/../statements/' . strval($tid) . '.html',$statement); $statement="/statements/".strval($tid).".html";}
							
							if($_FILES['tests']['name'])
							{
								$filename = $_FILES["tests"]["name"];
								$source = $_FILES["tests"]["tmp_name"];
								$type = $_FILES["tests"]["type"];

								$name = explode(".", $filename);
								$accepted_types = array('application/zip', 'application/x-zip-compressed', 'multipart/x-zip', 'application/x-compressed');
								foreach($accepted_types as $mime_type) {
									if($mime_type == $type) {
										$okay = true;
										break;
									} 
								}

								$continue = strtolower($name[1]) == 'zip' ? true : false;
								if(!$continue) {
									echo "The file you are trying to upload is not a .zip file. Please try again.";
								}

							  /* PHP current path */
							  $path = dirname(__FILE__).'/';  // absolute path to the directory where zipper.php is in
							  $filenoext = basename ($filename, '.zip');  // absolute path to the directory where zipper.php is in (lowercase)
							  $filenoext = basename ($filenoext, '.ZIP');  // absolute path to the directory where zipper.php is in (when uppercase)

							  $targetdir = $path . '../tests/'.strval($tid); // target directory
							  $targetzip = $path . '../temp_files/'.strval($tid).'.zip'; // target zip file

							  /* create directory if not exists', otherwise overwrite */
							  /* target directory is same as filename without extension */

							  if (is_dir($targetdir))  rmdir_recursive ( $targetdir);


							  mkdir($targetdir, 0777);


							  /* here it is really happening */

								if(move_uploaded_file($source, $targetzip)) {
									$zip = new ZipArchive();
									$x = $zip->open($targetzip);  // open the zip file to extract
									if ($x === true) {
										$zip->extractTo($targetdir); // place in the directory with same name  
										$zip->close();

										unlink($targetzip);
									}
									echo "Your .zip file was uploaded and unpacked.";
								} else {    
									echo "There was a problem with the upload. Please try again.";
								}
							}
							
							$db = new DB();
							echo "update tasks set visible=$visible, time=$time, memory=$memory, name='$name', author='$author', origin='$origin', difficulty=$difficulty, year=$year, registered='$reg_date', statement='$statement', type=$type, checker='$checker' where id=".strval($tid);
							$db->query("update tasks set visible=$visible, time=$time, memory=$memory, name='$name', author='$author', origin='$origin', difficulty=$difficulty, year=$year, registered='$reg_date', statement='$statement', type=$type, checker='$checker' where id=".strval($tid));
						}
						else
						{
							echo "<form action='edit_task.php' method='post'  enctype='multipart/form-data'>";
							echo 	"Visible: <input type='text' name='visible' value='".$task->visible."'><br>";
							echo 	"Time: <input type='text' name='time' value='".$task->time."'><br>";
							echo 	"Memory: <input type='text' name='memory' value='".$task->memory."'><br>";
							echo 	"Name: <input type='text' name='name' value='".$task->name."'><br>";
							echo 	"Author: <input type='text' name='author' value='".$task->author."'><br>";
							echo 	"Origin: <input type='text' name='origin' value='".$task->origin."'><br>";
							echo 	"Difficulty: <input type='text' name='difficulty' value='".$task->difficulty."'><br>";
							echo 	"year: <input type='text' name='year' value='".$task->year."'><br>";
							echo 	"reg_date: <input type='text' name='reg_date' value='".$task->reg_date."'><br>";
							echo 	"statement: <textarea name='statement' >".html_entity_decode(file_get_contents(__DIR__ . '/..'. $task->statement))."</textarea><br>";
							echo 	"type: <input type='text' name='type' value='".$task->type."'><br>";
							if($task->checker != "") echo 	"checker source: <textarea type='text' name='checker' >".file_get_contents(__DIR__ . '/..' . $task->checker)."</textarea><br>";
							else echo 	"checker source: <textarea type='text' name='checker' ></textarea><br>";
							echo 	"Tests: <input name='tests' type='file' ><br>";
							echo 	"<input name='save' type='text' style='display: none' value='1'>";
							echo 	"<input name='taskid' type='text' style='display: none' value='".strval($tid)."'>";
							echo 	"<input type='submit' class='w3-button w3-green' value='Submit'><br>";
							echo "</form>";
						}
					}
					else
					{
						echo "<form action='edit_task.php' method='post'>";
						echo 	"Task ID: <input type='text' name='taskid' >";
						echo 	"<input type='submit' class='w3-button w3-green' value='Submit'>";
						echo "</form>";
					}
				
				?>
				
			</div>
			
		</div>
		
	</body>
</html>