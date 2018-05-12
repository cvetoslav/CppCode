<?php

require_once('config.php');

class DB
{
	
	private $conn = null;
	
	function __construct()
	{
		$this->conn = new mysqli($GLOBALS['DB_SERVER'],$GLOBALS['DB_USER'],$GLOBALS['DB_PASS'],$GLOBALS['DB_DB'],$GLOBALS['DB_PORT']);
		if($this->conn->connect_error) echo "[Data Base] >> Connection Failed!";
	}
	
	function __destruct()
	{
		$this->conn->close();
	}
	
	public function query($str)
	{
		return $this->conn->query($str);
	}
	
	public function Max($a,$b)
	{
		$res = $this->conn->query("select max($a) from $b");
		if($res->num_rows<=0) return null;
		return ($res->fetch_assoc())["max($a)"];
	}
	
}

?>