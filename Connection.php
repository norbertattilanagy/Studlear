<?php
if(basename($_SERVER['PHP_SELF'])=="Conection.php")//security
{
	if(empty($_SESSION['user_id']))
		header("location: Sign_in.php");
	else
	{
		if($_SESSION['user_type']=="admin")
			header("location:Search_courses.php");
		else
		{
			header("location:Home_page.php");
			exit();
		}
	}
}
error_reporting( E_ALL & ~E_DEPRECATED & ~E_NOTICE );
$db=mysqli_connect("127.0.0.1","root","");
mysqli_select_db($db,"studlearn");
session_start();
?>