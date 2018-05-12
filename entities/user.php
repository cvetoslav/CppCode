<?php

require_once('db.php');
session_start();

class User
{
	
	public $id=-1;
	public $image="none";
	public $access=0;
	public $reg_date='1970-1-1';
	public $username='any';
	public $password='any';
	public $name='any';
	public $email='any';
	public $stadt='any';
	public $staat='any';
	public $sex='any';
	public $solved='any';
	public $tried='any';
	public $points=0;
	public $submits=0;
	public $geburtstag='any';
	public $letztsehen='any';
	
	public function Add($access,$uname,$pass,$name,$email,$stadt,$staat,$sex,$geburtstag)
	{
		$user = new User();
		$db = new DB();
		$res = $db->query("select * from users where uname='$uname'");
		if($res->num_rows > 0)
		{
			$_SESSION['status'] = 'error';
			$_SESSION['message'] = 'This username is already used!';
			return null;
		}
		$user->id = $db->Max('id','users')+1;
		$user->access = $access;
		$user->username = $uname;
		$user->password = $pass;
		$user->name = $name;
		$user->email = $email;
		$user->stadt = $stadt;
		$user->staat = $staat;
		$user->sex = $sex;
		$user->geburtstag = $geburtstag;
		$user->reg_date = strval(date("Y.m.d"));
		$db->query("insert into users (id,access,uname,pass,name,email,stadt,staat,sex,geburtstag,points,submits,registered) values (".$user->id.",$access,'$uname','$pass','$name','$email','$stadt','$staat','$sex','$geburtstag',0,0,'".strval(date("d.m.Y"))."')");
		return $user;
	}
	
	public function update($access,$pass,$name,$stadt,$staat,$sex,$geburtstag,$points,$submits)
	{
		
		$this->access = $access;
		$this->password = $pass;
		$this->name = $name;
		$this->stadt = $stadt;
		$this->sex = $sex;
		$this->geburtstag = $geburtstag;
		$this->points = $points;
		$this->submits = $submits;
		
	}
	
	public function GetById($id)
	{
		$db = new DB();
		$res = $db->query("select * from users where id=$id");
		if($res->num_rows>0)
		{
			$res = $res->fetch_assoc();
			$user = new User();
			$user->id=$id;
			$user->image=$res['image'];
			$user->reg_date=$res['registered'];
			$user->access=$res["access"];
			$user->uname=$res["uname"];
			$user->email=$res["email"];
			$user->password=$res["pass"];
			$user->name=$res["name"];
			$user->stadt=$res["stadt"];
			$user->staat=$res["staat"];
			$user->sex=$res["sex"];
			$user->solved=$res["solved"];
			$user->tried=$res["tried"];
			$user->geburtstag=$res["geburtstag"];
			$user->points=$res["points"];
			$user->submits=$res["submits"];
			return $user;
		}
		return null;
	}
	
	public function GetByUname($uname)
	{
		$db = new DB();
		$res = $db->query("select * from users where uname='$uname'");
		if($res->num_rows>0)
		{
			$res = $res->fetch_assoc();
			$user = new User();
			$user->id=$res["id"];
			$user->reg_date=$res['registered'];
			$user->image=$res['image'];
			$user->access=$res["access"];
			$user->email=$res["email"];
			$user->uname=$uname;
			$user->password=$res["pass"];
			$user->name=$res["name"];
			$user->stadt=$res["stadt"];
			$user->staat=$res["staat"];
			$user->sex=$res["sex"];
			$user->solved=$res["solved"];
			$user->tried=$res["tried"];
			$user->geburtstag=$res["geburtstag"];
			$user->points=$res["points"];
			$user->submits=$res["submits"];
			return $user;
		}
		return null;
	}
	
	public function Delete($id)
	{
		$db = new DB();
		$db->query("delete from users where id=$id");
	}
	
}

?>