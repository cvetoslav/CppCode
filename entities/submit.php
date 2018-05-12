<?php

require_once('db.php');
require_once('task.php');

class Submit
{
	
	public $id = -1;
	public $user = -1;
	public $sub_date = 'any';
	public $graded_date = 'any';
	public $time = 0;
	public $mem = 0;
	public $verdict = '';
	public $points = 0;
	public $status = 'Pending';
	public $message = 'Please wait until your solution is being submitted.';
	public $task = -1;
	public $source = 'any';
	public $lang = 'any';
	public $data = 'any';
	
	public function Add($source, $task, $user)
	{
		$sub = new Submit();
		$db = new DB();
		$sub->user = $user;
		$sub->task = $task;
		$sub->lang = 'cpp';
		$sub->id = $id = $db->Max('id','submits')+1;
		
		$fp = fopen(__DIR__ . "/../sources/".$sub->id.".cpp","w");
		fwrite($fp,$source);
		fclose($fp);
		
		$sub->source = '/sources/'.$sub->id.'.cpp';
		
		$db->query("insert into submits (id,user,task,lang,source,status,message) values ($id, $user, $task, 'cpp', '".$sub->source."', '".$sub->status."', '".$sub->message."')");
		return $sub;
	}
	
	public function Update($time,$mem,$verdict,$points,$status,$message)
	{
		$this->time=$time;
		$this->mem=$mem;
		$this->points=$points;
		$this->verdict=$verdict;
		$this->status=$status;
		$this->message=$message;
		$this->graded_date=strval(date("d.m.Y h:m:s"));
		$db = new DB();
		$db->query("update submits set graded='".$this->graded_date."', time=$time, mem=$mem, status='$status', message='$message', verdict='".$this->verdict."', points=".strval($this->points)." where id=".strval($this->id));
	}
	
	public function GetById($sid)
	{
		$db = new DB();
		$res = $db->query("select * from submits where id=".strval($sid));
		if($res->num_rows<1) return null;
		$r = $res->fetch_assoc();
		$sub = new Submit();
		$sub->id = $sid;
		$sub->user = $r['user'];
		$sub->data = $r['data'];
		$sub->sub_date = $r['submitted'];
		$sub->graded_date = $r['graded'];
		$sub->time = $r['time'];
		$sub->mem = $r['mem'];
		$sub->verdict = $r['verdict'];
		$sub->points = $r['points'];
		$sub->status = $r['status'];
		$sub->message = $r['message'];
		$sub->task = $r['task'];
		$sub->source = $r['source'];
		$sub->lang = $r['lang'];
		return $sub;
	}
	
	public function IsFreeToSend()
	{
		$db = new DB();
		$res = $db->query("select * from submits where status='Testing'");
		if($res->num_rows < 1) return true;
		return false;
	}
	
	public function GetLastInQueue()
	{
		$db = new DB();
		$res = $db->query("select * from submits where status='Pending'");
		if($res->num_rows < 1) return null;
		$res = $res->fetch_assoc();
		return Submit::GetById($res['id']);
	}
	
	public function CheckQueue()
	{
		if(Submit::IsFreeToSend())
		{
			
			$sub = Submit::GetLastInQueue();
			if($sub == null) return ;
			
			$task = Task::GetById($sub->task);
			if($task == null) return ;
			
			$db = new DB();
			$db->query("update submits set status='Testing', submitted='".strval(date("d.m.Y h:m:s"))."' where id=".$sub->id);
			
			$checker="";
			if($task->checker != "") $checker = file_get_contents(__DIR__ . '/..' . $task->checker);
			
			$source="";
			if($sub->source != "") $source = file_get_contents(__DIR__ . '/..' . $sub->source);
			
			$tl = $task->time;
			$ml = $task->memory;
			
			$tests = array();
			foreach (scandir(__DIR__ . "/../tests/" . strval($task->id)) as $f)
			{
				if($f != "." && $f != ".." && end(explode(".", $f)) == 'in')
				{
					//$tests[] = array('url'=>'http://cppcode.ddns.net:1234/tests/'.strval($task->id), 'inp_name'=>$f, 'out_name'=>basename($f,".in").".sol");
					$tests[] = array('url'=>strval($task->id)."\\", 'inp_name'=>$f, 'out_name'=>basename($f,".in").".sol");
				}
			}
							
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "http://cppcode.ddns.net/evaluate"); 
				$data = array(
				'id'=>$sub->id,
				'tl'=>$tl,
				'ml'=>$ml,
				'source' => $source,
				'checker_source'=> $checker,
				'update_url' => 'http://localhost:1234/upd.php',
				't_info' => $tests
			);
				//return the transfer as a string 
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
			curl_setopt($ch, CURLOPT_POST, 1); 
			curl_setopt($ch, CURLOPT_PORT, 5000); 
			curl_setopt($ch, CURLOPT_POSTFIELDS, array('data' => json_encode($data)));
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
			curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
			curl_setopt($ch, CURLOPT_USERPWD,"admin:dm6123456");
			// $output contains the output string 
			$output = curl_exec($ch); 
			// close curl resource to free up system resources 
			curl_close($ch);
		}
	}
	
	public function Delete($id)
	{
		$db = new DB();
		$db->query("delete from submits where id=$id");
	}
	
}

?>