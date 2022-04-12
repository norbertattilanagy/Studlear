<?php include 'Conection.php'; ?>
<?php include 'Page_security.php'; ?>
<?php
	$email="'".$_POST['email']."'";
	$password="'".$_POST['password']."'";
	$sql="SELECT * FROM user WHERE email LIKE $email AND password LIKE $password";
	$results=mysqli_query($db,$sql);
	if(!empty($row=mysqli_fetch_array($results,MYSQLI_ASSOC)))
	{
		$_SESSION['user_id']=$row['id'];
		$_SESSION['user_type']=$row['type'];
		if($_SESSION['user_type']=="admin")
			$link='location:Search_courses.php';
		else
			$link='location:Home_page.php';

	    header("$link");
	}
	else
	{
		$sql="SELECT * FROM user WHERE email LIKE $email";
		$results=mysqli_query($db,$sql);
		if(empty($row=mysqli_fetch_array($results,MYSQLI_ASSOC)))
			$_SESSION['incorect']="Email și parolă inorectă.";
		else
		{
			$_SESSION['email']=$_POST['email'];
			$_SESSION['incorect']="Parolă inorectă";
		}
		$link='location:'.$_SERVER['HTTP_REFERER'];
	    header("$link");
	}
?>