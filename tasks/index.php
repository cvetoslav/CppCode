<?php

require_once(__DIR__ . '/../entities/user.php');
require_once(__DIR__ . '/../entities/db.php');
require_once(__DIR__ . '/../entities/task.php');
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
				<h1>Problems</h1>
				<h4><p>
					There are all problems in the arena. You can filter them from the search menu below.
				</p></h4>
			</div><br><br>
			
			<div class="w3-container w3-border w3-border-green w3-card-2 w3-padding-large">
				<h1>Search</h1>
				<h4><form action="index.php" method="post">
					<select class="w3-round w3-border w3-border-green w3-card-2" name="origin">
						<option value="" disabled selected>Choose origin</option>
						<option value="BGcode training">BGcode training</option>
						<option value="Nacionalen Esenen Turnir">Национален Есенен Турнир</option>
						<option value="Nacionalna Olimpiada - I round">Национална Олимпиада - 1 кръг</option>
						<option value="Nacionalna Olimpiada - II round">Национална Олимпиада - 2 кръг</option>
						<option value="Nacionalna Olimpiada - III round">Национална Олимпиада - 3 кръг</option>
						<option value="Zimni Sastezaniq">Зимни Състезания</option>
						<option value="Proleten Turnir">Пролетен Турнир</option>
						<option value="Other">Друго</option>
					</select>&nbsp;
					<select class="w3-round w3-border w3-border-green w3-card-2" name="year">
						<option value="" disabled selected>Choose year</option>
						<option value="2001">2001</option>
						<option value="2002">2002</option>
						<option value="2003">2003</option>
						<option value="2004">2004</option>
						<option value="2005">2005</option>
						<option value="2006">2006</option>
						<option value="2007">2007</option>
						<option value="2008">2008</option>
						<option value="2009">2009</option>
						<option value="2010">2010</option>
						<option value="2011">2011</option>
						<option value="2012">2012</option>
						<option value="2013">2013</option>
						<option value="2014">2014</option>
						<option value="2015">2015</option>
						<option value="2016">2016</option>
						<option value="2017">2017</option>
						<option value="2018">2018</option>
					</select>&nbsp;
					<select class="w3-round w3-border w3-border-green w3-card-2" name="difficulty">
						<option value="" disabled selected>Choose difficulty</option>
						<option value="1">Very easy</option>
						<option value="2">Easy</option>
						<option value="3">Medium</option>
						<option value="4">Hard</option>
						<option value="5">Very hard</option>
						<option value="6">Insane</option>
					</select>&nbsp;
					<input class="w3-btn w3-large w3-teal w3-padding-large w3-hover-green" type="submit" value="Search!" />
				</form>
				</h4>
			</div><br>
			
			<div class="w3-container w3-border w3-border-green w3-card-2 w3-padding-large">
				<h1>Problems list</h1>
					
				<ul class="w3-ul w3-card-2 w3-border w3-hoverable">
						<?php
							
							$q = '';
							if(isset($_POST["origin"])) $q="origin='$_POST[origin]'";
							if(isset($_POST["year"]))
							{
								if($q!='') $q.=" and ";
								$q.="year=$_POST[year]";
							}
							if(isset($_POST["difficulty"]))
							{
								if($q!='') $q.=" and ";
								$q.="difficulty='$_POST[difficulty]'";
							}
							if($q!='') $q=" and ".$q;
							$db = new DB();
							if($user!=null && $user->access>=100) $res = $db->query("select * from tasks where 1 $q");
							else $res = $db->query("select * from tasks where visible=1 $q");

							if($res->num_rows<1) echo "<center><h4>There are no problems with theese requirements!</h4></center>";
                            else
							while($r=$res->fetch_assoc())
							{
								echo "<a style=\"text-decoration: none\" href=\"display.php?taskid=" . $r['id'] . "\"><li class=\"";
								if($user != null)
								{
									if(in_array(strval($r['id']),$user->solved))
									{
										echo "w3-green";
									}
									else if(in_array(strval($r['id']),$user->tried))
									{
										echo "w3-yellow";
									}
								}
								echo "\"><h3>" . $r['name'] . "</h3><br/>" . $r['origin'] . "</li></a>";
							}
							
						?>
				</ul>
			</div><br>
			
		</div>
		
	</body>
</html>