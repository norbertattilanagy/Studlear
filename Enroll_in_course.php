<?php include 'Connection.php'; ?>
<?php include 'Page_security.php'; ?>
<?php
//0-open modal Enroll_in_course
//1-enroll search course
//2-open modal Add_user_in_course
//3-enroll course by the teacher
//4-remove user modal
//5-remove user
//6-set default search user
//7-search
//8-set default search courses

if(!isset($_GET['enroll']))//security
{
	if($_SESSION['user_type']=="admin")
		header("location:Search_courses.php");
	else
	{
		header("location:Home_page.php");
		exit();
	}
}
if($_GET["enroll"]==0)
{
	$_SESSION['incorect_password']=0;
	$_SESSION['course_id']=$_GET['course_id'];
	$link='location:'.$_SERVER['HTTP_REFERER'].'#Enroll_in_course';
	header("$link");
}
else if($_GET["enroll"]==1)//enroll search course
{
	$password="'".$_POST['password']."'";
	$course_id=$_SESSION["course_id"];
	$sql="SELECT * FROM course WHERE id LIKE $course_id AND password LIKE $password";
	$results=mysqli_query($db,$sql);

	if(!empty($row=mysqli_fetch_array($results,MYSQLI_ASSOC)))
	{
		$_SESSION['incorect_password']=0;
		$id=$row["id"];
		$user_id=$_SESSION["user_id"];
		$sql_insert="INSERT INTO course_user (course_id, user_id, admin) VALUES ($id, $user_id, 0)";
		$results_insert=mysqli_query($db,$sql_insert);
		$link='location:Course_page.php?id='.$id;
	}
	else
	{
		$_SESSION['incorect_password']=1;
		$link='location:'.$_SERVER['HTTP_REFERER'].'#Enroll_in_course';
	}
	
    header("$link");
}
else if($_GET["enroll"]==2)//open modal course
{
	$_SESSION['course_user']=$_GET['course_user'];

	$link='location:'.$_SERVER['HTTP_REFERER'].'#Add_user_in_course';
    header("$link");
}
else if($_GET["enroll"]==3)//enroll course by the teacher
{
	$course_user=$_SESSION['course_user'];
	$course_id=$_SESSION['course_id'];
	$sql="INSERT INTO course_user (course_id,user_id,admin) VALUES ($course_id,$course_user,0)";
	$results=mysqli_query($db,$sql);

	$link='location:'.$_SERVER['HTTP_REFERER'];
    header("$link");
}
else if($_GET["enroll"]==4)//remove user modal
{
	$_SESSION['course_user']=$_GET['course_user'];

	$link='location:'.$_SERVER['HTTP_REFERER'].'#Delete_user_from_course';
    header("$link");
}
else if($_GET["enroll"]==5)//remove user
{
	$course_user=$_SESSION['course_user'];
	$course_id=$_SESSION['course_id'];
	$sql="DELETE FROM course_user WHERE course_id LIKE $course_id AND user_id LIKE $course_user";
	$results=mysqli_query($db,$sql);

	$link='location:'.$_SERVER['HTTP_REFERER'];
    header("$link");
}
else if($_GET["enroll"]==6)//set default search_users
{
	$_SESSION['s']=0;

	$link='location:Search_users.php';
    header("$link");
}
else if($_GET["enroll"]==7)//search
{
	$_SESSION['s']=1;
	$_SESSION['search']=$_POST['search'];

	$link='location:'.$_SERVER['HTTP_REFERER'];
	header("$link");
}
else if($_GET["enroll"]==8)//set default search courses
{
	$_SESSION['s']=0;

	$link='location:Search_courses.php';
    header("$link");
}
else//security
{
    if($_SESSION['user_type']=="admin")
        header("location:Search_courses.php");
    else
        header("location:Home_page.php");
} 
?>