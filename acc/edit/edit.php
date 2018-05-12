<?php

require_once(__DIR__ . '/../../entities/user.php');
require_once(__DIR__ . '/../../entities/db.php');
session_start();

if(!isset($_SESSION['uname'])) header("Location: http://$_SERVER[HTTP_HOST]");
else $user=User::GetByUname($_SESSION['uname']);

$db = new DB();

if(isset($_FILES['image']))
{
    $file_name = $_FILES['image']['name'];
    $file_size =$_FILES['image']['size'];
    $file_tmp =$_FILES['image']['tmp_name'];
    $file_type=$_FILES['image']['type'];
    $file_ext=strtolower(end(explode('.',$_FILES['image']['name'])));
	
	if($file_size < 2097152 && file_exists($file_tmp))
	{
		if($user->image!="/images/none.jpg"&&file_exists(__DIR__ . "/../..".$user->image)) unlink(__DIR__ . "/../..".$user->image);
		move_uploaded_file($file_tmp,__DIR__ . "/../../images/".$user->id.".".$file_ext);
		$user->image="/images/".$user->id.".".$file_ext;
	}
}

$id = $user->id;
$name = $_POST['name'];
$pass = $_POST['pass'];
$email = $_POST['email'];
$city = $_POST['stadt'];
$country = $_POST['staat'];
$sex = $_POST['sex'];
$bd = $_POST['geburtstag'];

$db->query("update users set image='".$user->image."', name='$name', email='$email', pass='$pass', stadt='$city', staat='$country', sex='$sex', geburtstag='$bd' where id=$id");

if($user != null)
{
	
	$_SESSION['status'] = 'ok';
	$_SESSION['message'] = 'Your account is successfully edited.';
	
	header("Location: http://$_SERVER[HTTP_HOST]/acc/");
}
else
{
	
	$_SESSION['status'] = 'error';
	$_SESSION['message'] = 'Something went wrong.';
	
	header("Location: http://$_SERVER[HTTP_HOST]/acc/");
}

?>