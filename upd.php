<?php

require_once(__DIR__ . '/entities/submit.php');
require_once(__DIR__ . '/entities/db.php');

	if (!isset($_SERVER['PHP_AUTH_USER']))
	{
		header('WWW-Authenticate: Basic realm="My Realm"');
		header('HTTP/1.0 401 Unauthorized');
		echo 'Text, der gesendet wird, falls der Benutzer auf Abbrechen drückt';
		exit;
	}
	else
	{
		if($_SERVER['PHP_AUTH_USER'] == "USER" && $_SERVER['PHP_AUTH_PW'] == "PASS")
		{
			if(isset($_POST['data']))
			{
				
				file_put_contents(__DIR__ . '/asd.txt', $_POST['data']);
				
				$data = json_decode($_POST['data'], true);
				$sub_id = $_POST['sub_id'];
				$points = $_POST['overal_points'];
				
				$db = new DB();
				
				$verdict = ''; $i = 0; $mt = 0.0; $mm = 0;
				$status = 'Testing'; $f = true; $op = 0.0;
				foreach($data as $test)
				{
					if($test['Tested'] == true)
					{
						$verdict .= $test['Result']." ";
						$op += $test['Points'];
						if($test['Time']>$mt) $mt = $test['Time'];
						if($test['Memory']>$mm) $mm = $test['Memory'];
					}
					else{$verdict .= "? "; $f = false;}
					$i++;
				}
				$op = $op*100/$i;
				if($f) $status = 'Graded';
				$db->query("update submits set verdict='$verdict', data='".$_POST['data']."', status='$status', time=$mt, mem=$mm, points=$op where id=".$sub_id);
				
				if($f) Submit::CheckQueue();
				
			}
			else echo "no data received!";
		}
		else echo "wrong user/pass!";
	}

?>
