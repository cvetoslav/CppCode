<?php

require_once('db.php');

class Task
{
	
	public $id=-1;
	public $visible=0;
	public $time=0;
	public $memory=0;
	public $name='any';
	public $author=-1;
	public $origin='any';
	public $difficulty=-1;
	public $year=-1;
	public $reg_date='any';
	public $statement='any';
	public $type=-1;
	public $checker='any';
	
	public function Add($name,$author,$origin,$statement,$time,$mem,$type,$year,$difficulty,$checker,$visible)
	{
		$db = new DB();
		
		$task = new Task();
		$task->name = $name;
		$task->author = $author;
		$task->origin = $origin;
		$task->statement = $statement;
		$task->time = $time;
		$task->memory = $mem;
		$task->type = $type;
		$task->year = $year;
		$task->difficulty = $difficulty;
		$task->checker = $checker;
		$task->visible = $visible;
		$task->id = $db->Max('id','tasks')+1;
		$task->reg_date = strval(date('d.m.Y'));
		
		$db->query("insert into tasks (id,name,author,origin,statement,time,memory,type,year,difficulty,checker,registered,visible) values (".strval($task->id).",'$name',$author,'$origin','$statement',$time,$mem,$type,$year,$difficulty,'$checker','".$task->reg_date."',$visible)");
		
		return $task;
	}
	
	public function update($name,$author,$origin,$statement,$type,$checker,$visible,$f=1)
	{
		$this->name = $name;
		$this->author = $author;
		$this->origin = $origin;
		$this->statement = $statement;
		$this->type = $type;
		$this->checker = $checker;
		$this->visible = $visible;
		
		if($f==1){
		$db = new DB();
		$db->query("update tasks set name='$name', visible=$visible, author=$author, origin='$origin', statement='$statement', type=$type, checker='$checker' where id=".strval($this->id));
		}
		
	}
	
	public function GetById($id)
	{
		
		$db = new DB();
		$res = $db->query("select * from tasks where id=$id");
		if($res->num_rows>0)
		{
			$res = $res->fetch_assoc();
			$task = new Task();
			$task->id=$id;
			$task->time=$res['time'];
			$task->memory=$res['memory'];
			$task->year=$res['year'];
			$task->difficulty=$res['difficulty'];
			$task->reg_date=$res['registered'];
			$task->update($res['name'], $res['author'], $res['origin'], $res['statement'], $res['type'], $res['checker'], $res['visible'], 0);
			return $task;
		}
		return null;
		
	}
	
	public function Delete($id)
	{
		$db = new DB();
		$db->query("delete from tasks where id=$id");
	}
	
}

?>