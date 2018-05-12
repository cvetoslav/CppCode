<?php

require_once(__DIR__ . '/../../entities/user.php');
session_start();

$uname = $_POST['uname'];
$pass = $_POST['pass'];
$ref = $_POST['ref'];

$user = User::GetByUname($uname);

if($user == null)
{
	$_SESSION['status'] = "error";
	$_SESSION['message'] = "The username is not valid!";
}
else
{
	if($user->password == $pass)
	{
		$_SESSION['status'] = "ok";
		$_SESSION['uname'] = $uname;
	}
	else
	{
		$_SESSION['status'] = "error";
		$_SESSION['message'] = "The password is incorrect!";
	}
}

header("Location: $ref");

?>