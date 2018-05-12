<?php

require_once(__DIR__ . '/../../entities/user.php');
require_once(__DIR__ . '/../../entities/db.php');
session_start();

if(isset($_SESSION['uname'])) header("Location: http://$_SERVER[HTTP_HOST]");

$db = new DB();

$name = $_POST['name'];
$uname = $_POST['uname'];
$pass = $_POST['pass'];
$email = $_POST['email'];
$staat = $_POST['staat'];
$stadt = $_POST['stadt'];
$sex = $_POST['sex'];
$geburtstag = $_POST['geburtstag'];

$user = User::Add(10,$uname,$pass,$name,$email,$stadt,$staat,$sex,$geburtstag);

if($user != null)
{
	
	$_SESSION['status'] = 'ok';
	$_SESSION['message'] = 'You have successfully registered.';
	
	header("Location: http://$_SERVER[HTTP_HOST]");
}
else
{
	
	$_SESSION['status'] = 'error';
	$_SESSION['message'] = 'Something went wrong.';
	
	header("Location: http://$_SERVER[HTTP_HOST]/acc/register");
}

?>