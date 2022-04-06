<?php include 'Conection.php'; ?>
<?php include 'Page_security.php'; ?>
<?php
	$error=0;
	
	if(isset($_POST['name']))
	{
		$_SESSION['name']=$_POST['name'];
		$name="'".$_POST['name']."'";
	}

	if(isset($_POST['email']))
	{
		$_SESSION['email']=$_POST['email'];
		$email="'".$_POST['email']."'";
	}

	if($_POST['user_type']!="-")
	{
		$_SESSION['user_type']=$_POST['user_type'];
		$type="'".$_POST['user_type']."'";
	}
	else
	{
		$_SESSION['error'][2]=1;
		$error=1;
	}

	if(isset($_POST['password1']) and isset($_POST['password2']))
	{
		if($_POST['password1']==$_POST['password2'])
		{
			$_SESSION['password1']=$_POST['password1'];
			$_SESSION['password2']=$_POST['password2'];
			$password="'".$_POST['password1']."'";
		}
		else
		{
			$_SESSION['error'][5]=1;
			$error=1;
		}
	}

	if($error==0)
	{
		$sql="INSERT INTO user (name,email,password,type) VALUES ($name,$email,$password,$type)";
		$results=mysqli_query($db,$sql);
	}

	$link='location:'.$_SERVER['HTTP_REFERER'];
	header("$link");
?>