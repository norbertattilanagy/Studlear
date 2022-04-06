<?php include 'Conection.php'; ?>
<?php include 'Page_security.php'; ?>
<?php 
	$name=$_POST['Cours_name'];
	$password=$_POST['Cours_password'];
	$sql="INSERT INTO course (title,password) VALUES ('$name','$password')";
	$results= mysqli_query($db,$sql);
	if (!$results)
	  	die('Invalid querry:' .mysqli_error($db));

	$course_id = mysqli_insert_id($db);
	$user_id=$_SESSION['user_id'];
	$sql="INSERT INTO course_user (course_id,user_id,admin) VALUES ('$course_id','$user_id','1')";
	$results= mysqli_query($db,$sql);
	if (!$results)
	  	die('Invalid querry:' .mysqli_error($db));

	header('Location:Home_page.php');
	      
?>