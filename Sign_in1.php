<?php include 'Conection.php'; ?>
<?php
	$email="'".$_POST['email']."'";
	$password="'".$_POST['password']."'";
	$sql="SELECT * FROM user WHERE email LIKE $email AND password LIKE $password";
	echo $sql;
	$results=mysqli_query($db,$sql);
	if(!empty($row=mysqli_fetch_array($results,MYSQLI_ASSOC)))
	{
		$_SESSION['user_id']=$row['id'];
		$_SESSION['user_type']=$row['type'];
		$link='location:Home_page.php';
	    header("$link");
	}
	else
	{
		$link='location:'.$_SERVER['HTTP_REFERER'];
	    header("$link");
	}
?>