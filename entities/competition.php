<?php

require_once('db.php');

class Competition
{
	
	public $id = -1;
	public $name = 'any';
	public $author = -1;
	public $problems = '';
	public $public = 0;
	public $users = 'any';
	public $reg_date = 'any';
	public $start = 'any';
	public $end = 'any';
	public $groups = 'any';
	public $standings = 'any';
	
	public function Add($name, $author, $groups, $public, $users, $reg_date, $start, $end, $problems)
	{
		$db = new DB();
		$id = $db->Max('id','competitions')+1;
		$res = $db->query("insert into competitions (id, name, author, public, users, problems, start, reg_date, end, groups, standings) values (".strval($id).", '$name', $author, $public, '$users', '$problems', '$start', '$reg_date', '$end', '$groups', '/competitions/standings/".strval($id)."')");
		return $res;
	}
	
	public function GetById($cid)
	{
		$db = new DB();
		$res = $db->query("select * from competitions where id=$cid");
		if($res->num_rows<1) return null;
		$r = $res->fetch_assoc();
		$comp = new Competition();
		$comp->id = $cid;
		$comp->name = $r['name'];
		$comp->author = $r['author'];
		$comp->problems = $r['problems'];
		$comp->public = $r['public'];
		$comp->users = $r['user'];
		$comp->start = $r['start'];
		$comp->reg_date = $r['reg_date'];
		$comp->end = $r['end'];
		$comp->groups = $r['groups'];
		$comp->standings = $r['standings'];
	}
	
	public function AddProblem($problemid)
	{
		$db = new DB();
		
		if($this->problems == "") $this->problems = strval($problemid);
		else $this->problems .= ",".strval($problemid);
		
		$res = $db->query("update competitions set problems='".$this->problems."' where id=".strval($this->id));
	}
	
	public function Delete($cid)
	{
		$db = new DB();
		$db->query("delete from competitions where id=$cid");
	}
	
}

?>