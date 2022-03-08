<?php include 'Conection.php'; ?>
<?php
	$eror=0;
	$name="'".$_POST['name']."'";
	$email="'".$_POST['email']."'";
	if($_POST['user_type']!="-")
		$type="'".$_POST['user_type']."'";
	else
		$eror=1;

	if($_POST['password1']==$_POST['password2'])
		$password="'".$_POST['password1']."'";
	else
		$eror=1;

	if($eror==0)
	{
		$sql="INSERT INTO user (name,email,password,type) VALUES ($name,$email,$password,$type)";
		$results=mysqli_query($db,$sql);
		if (!$results)
	  		die('Invalid querry:' .mysqli_error($db));
	  	$link='location:Sign_in.php';
	    header("$link");
	}
	else
		echo $eror;
?>