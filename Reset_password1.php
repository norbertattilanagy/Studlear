<?php include 'Conection.php'; ?>
<?php include 'Page_security.php'; ?>
<?php
if($_GET['edit']==1)
{
	$email="'".$_POST['email']."'";
	$sql="SELECT * FROM user WHERE email LIKE $email";
	$results=mysqli_query($db,$sql);

	if(empty($row=mysqli_fetch_array($results,MYSQLI_ASSOC)))
	{
		$_SESSION['incorect']="Adresa de email nu există.";
	}
	else
	{
		//$email=$_POST['email'];
		$email="norbertattilanagy@gmail.com";
		$subject = "STUDLEAR Resetare parolă";
		$message = '
		<html>
			<head>
			</head>
			<body>
				<p>Am înregistrat cererea dumneavoastră de resetare a parolei.</p>
				<p>Pentru resetarea parolei apăsați pe linkul următor:</p>
				<a href="localhost/Studlear/Reset_password1.php?edit=2&id='.$row['id'].'">Resetare_parolă</a>
				<p>În cazul în care nu ați solicitat resetarea parolei, vă rugăm să ignorați acest email.</p>
			</body>
		</html>';
		$headers = "MIME-Version: 1.0" . "\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\n";
		$headers .= "From: norbertattilanagy@gmail.com";

		if(mail($email,$subject,$message,$headers))
		{
			echo "Email sent successfully to $email";
			$_SESSION['correct']="A fost trimis un email de resetare a parolei pe adresa".$email;
		} 
		else 
		{
		    echo "Sorry, failed while sending mail!";
		}
		

		
	}
	$link='location:Sign_in.php';
	header("$link");
}
elseif($_GET['edit']==2)
{
	$_SESSION['correct']="";
	$_SESSION['reset_user_id']=$_GET['id'];
	$link='location:Reset_password.php';
	header("$link");
}
elseif($_GET['edit']==3)
{
	$reset_user_id=$_SESSION['reset_user_id'];
	$password=$_POST['password1'];
	$sql="UPDATE user SET password=$password WHERE id LIKE $reset_user_id";
	$results=mysqli_query($db,$sql);

	$_SESSION['correct']="Parola a fost resetat cu succes.";
	echo $link='location:Sign_in.php';
	header("$link");
}
?>