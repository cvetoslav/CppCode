<?php

require_once('db.php');
require_once('competition.php');

class Group
{
	
	public $id = -1;
	public $name = 'any';
	public $teacher = -1;
	public $students = 'any';
	public $comps = 'any';
	public $news = 'any';
	
	public function Add($name, $teacher, $students)
	{
		$g = new Group();
		$db = new DB();
		$g->id = $id = $db->Max('id','groups')+1;
		$g->name = $name;
		$g->teacher = $teacher;
		$g->students = $students;
		$g->comps = $g->news = '';
		
		$db->query("insert into groups (id,name,teacher,students,comps,news) values ($id, '$name', $teacher, '$students', '','')");
		return $g;
	}
	
	public function AddNews($newsid)
	{
		if($this->news=='') $this->news = strval($newsid);
		else $this->news += ",$newsid";
		$db = new DB();
		$db->query("update groups set news='".$this->news."' where id=".strval($this->id));
	}
	
	public function AddComp($compid)
	{
		if($this->comps=='') $this->comps = strval($compid);
		else $this->comps += ",$compid";
		$db = new DB();
		$db->query("update groups set comps='".$this->comps."' where id=".strval($this->id));
	}
	
	public function AddStudent($sid)
	{
		if($this->students=='') $this->students = strval($sid);
		else $this->students += ",$sid";
		$db = new DB();
		$db->query("update groups set students='".$this->students."' where id=".strval($this->id));
	}
	
	public function GetById($gid)
	{
		$db = new DB();
		$res = $db->query("select * from groups where id=$gid");
		if($res->num_rows<1) return null;
		$r = $res->fetch_assoc();
		$g = new Group();
		$g->id = $gid;
		$g->name = $r['name'];
		$g->teacher = $r['teacher'];
		$g->students = $r['students'];
		$g->comps = $r['comps'];
		$g->news = $r['news'];
		return $g;
	}
	
	public function GetByUserId($uid)
	{
		$db = new DB();
		$res = $db->query("select * from groups");
		if($res->num_rows<1) return null;
		$ga = array();
		while($r = $res->fetch_assoc())
		{
			if(!in_array(strval($uid), $r['students']) || $uid != $r['teacher']) continue;
			$g = new Group();
			$g->id = $r['id'];
			$g->name = $r['name'];
			$g->teacher = $r['teacher'];
			$g->students = $r['students'];
			$g->comps = $r['comps'];
			$g->news = $r['news'];
			$ga[] = $g;
		}
		return $ga;
	}
	
	public function GetProblems()
	{
		$ca = explode(',',$this->comps);
		$pa = array();
		foreach($ca as $cid)
		{
			$comp = Competition::GetById($cid);
			array_merge($pa, explode(',',$comp->problems));
		}
		return $pa;
	}
	
	public function Delete($id)
	{
		$db = new DB();
		$db->query("delete from groups where id=$id");
	}
	
}

?>