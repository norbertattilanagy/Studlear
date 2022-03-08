<?php include 'Conection.php'; ?>
<?php
//0-enroll search course
//1-enroll search course
//2-enroll course
//3-enroll course
//4-delete course
//5-delete course
if($_GET["enroll"]==0)
{
	$_SESSION['course_title']=$_GET['course_title'];
	$link='location:'.$_SERVER['HTTP_REFERER'].'#Enroll_in_course';
	header("$link");
}
else if($_GET["enroll"]==1)
{
	$password="'".$_POST['password']."'";
	$course_title="'".$_SESSION["course_title"]."'";
	$sql="SELECT * FROM course WHERE title LIKE $course_title AND password LIKE $password";
	$results=mysqli_query($db,$sql);

	if(!empty($row=mysqli_fetch_array($results,MYSQLI_ASSOC)))
	{
		if(!empty($row))
		{
			$id=$row["id"];
			$user_id=$_SESSION["user_id"];
			echo $id." ".$user_id;
			$sql_insert="INSERT INTO course_user (course_id, user_id, admin) VALUES ($id, $user_id, 0)";
			$results_insert=mysqli_query($db,$sql_insert);
		}
	}
	$link='location:'.$_SERVER['HTTP_REFERER'];
    header("$link");
}
else if($_GET["enroll"]==2)
{
	$_SESSION['course_user']=$_GET['course_user'];

	$link='location:'.$_SERVER['HTTP_REFERER'].'#Add_user_in_course';
    header("$link");
}
else if($_GET["enroll"]==3)
{
	$course_user=$_SESSION['course_user'];
	$course_id=$_SESSION['course_id'];
	$sql="INSERT INTO course_user (course_id,user_id,admin) VALUES ($course_id,$course_user,0)";
	$results=mysqli_query($db,$sql);

	$link='location:'.$_SERVER['HTTP_REFERER'];
    header("$link");
}
else if($_GET["enroll"]==4)
{
	$_SESSION['course_user']=$_GET['course_user'];

	$link='location:'.$_SERVER['HTTP_REFERER'].'#Delete_user_from_course';
    header("$link");
}
else if($_GET["enroll"]==5)
{
	$course_user=$_SESSION['course_user'];
	$course_id=$_SESSION['course_id'];
	$sql="DELETE FROM course_user WHERE course_id LIKE $course_id AND user_id LIKE $course_user";
	$results=mysqli_query($db,$sql);

	$link='location:'.$_SERVER['HTTP_REFERER'];
    header("$link");
}	
?>