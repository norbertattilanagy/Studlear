<?php include 'Connection.php'; ?>
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
		$_SESSION['email_c']=$_POST['email'];
		$email="'".$_POST['email']."'";
		$sql="SELECT * FROM user WHERE email LIKE $email";
		$results=mysqli_query($db,$sql);
		$nr=mysqli_num_rows($results);
		if($nr>0)
		{
			echo $_SESSION['incorrect_email']="Există deja un cont înregistrat cu această adresă de email.";
			$error=1;
		}
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
			$error=1;
		}
	}

	if($error==0)
	{
        $type='"'."student".'"';
		echo $sql="INSERT INTO user (name,email,password,type) VALUES ($name,$email,$password,$type)";
		$results=mysqli_query($db,$sql);
		$link='location:Sign_in.php';
		$_SESSION['incorrect_email']="";
	}
	else
	{
		$link='location:Create_account.php';
	}
	
	header("$link");
?>