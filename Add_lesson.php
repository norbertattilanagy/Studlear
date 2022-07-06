<?php include 'Connection.php'; ?>
<?php include 'Page_security.php'; ?>
<?php
//0-add
//1-edit
//2-delete
//3-set lesson group id edit
//4-set lesson group id delete
if ($_GET["edit"]==0)//add
{
	$lesson_group_title=$_POST["lesson_title"];
	$course_id=$_SESSION['course_id'];
	$order_number=$_POST['order_number'];
	if(isset($_POST["visibility"]))
	{
		$visibility=1;
	}
	else
	{
		$visibility=0;
	}

	$sql_update="UPDATE lesson_group SET order_number = order_number+1 WHERE order_number >= $order_number AND course_id like $course_id";
	$results_update=mysqli_query($db,$sql_update);

	$sql="INSERT INTO lesson_group (group_title,course_id,order_number,visibility) VALUES ('$lesson_group_title','$course_id','$order_number','$visibility')";
	$results=mysqli_query($db,$sql);

	$link='location:'.$_SERVER['HTTP_REFERER'];
	header("$link");
}
else if($_GET["edit"]==1)//edit
{
	$lesson_group_title='"'.$_POST["lesson_title"].'"';
	$order_number=$_POST['order_number'];
	$course_id=$_SESSION['course_id'];
	$lesson_id=$_SESSION['lesson_id'];

	$sql_select="SELECT * FROM lesson_group WHERE course_id LIKE $course_id AND id LIKE $lesson_id";
	$results_select=mysqli_query($db,$sql_select);
	$row_select=mysqli_fetch_array($results_select);
	$old_order_number=$row_select["order_number"];

	if($old_order_number>$order_number)//move
	{
		$sql_update="UPDATE lesson_group SET order_number = order_number+1 WHERE order_number >= $order_number AND order_number < $old_order_number AND course_id LIKE $course_id";
		$results_update=mysqli_query($db,$sql_update);
	}
	else
	{
		$sql_update="UPDATE lesson_group SET order_number = order_number-1 WHERE order_number <= $order_number AND order_number > $old_order_number AND course_id LIKE $course_id";
		$results_update=mysqli_query($db,$sql_update);
	}
	
	if(isset($_POST["visibility"]))
	{
		$visibility='TRUE';
	}
	else
	{
		$visibility='FALSE';
	}
	$sql="UPDATE lesson_group SET group_title=$lesson_group_title, order_number = $order_number, visibility = $visibility WHERE id like $lesson_id";
	$results=mysqli_query($db,$sql);

	$link='location:'.$_SERVER['HTTP_REFERER'];
	header("$link");
}
else if($_GET["edit"]==2)//delete
{
	$course_id=$_SESSION['course_id'];
	$lesson_id=$_SESSION['lesson_id'];

	$sql_order="SELECT * FROM lesson_group WHERE id LIKE $lesson_id";
	$results_order=mysqli_query($db,$sql_order);
	$row_order=mysqli_fetch_array($results_order,MYSQLI_ASSOC);
	$order_number=$row_order["order_number"];

	$sql_update="UPDATE lesson_group SET order_number = order_number-1 WHERE order_number > $order_number AND course_id like $course_id";
	$results_update=mysqli_query($db,$sql_update);

	$sql="DELETE FROM lesson_group WHERE id LIKE $lesson_id";
	$results=mysqli_query($db,$sql);

	$link='location:'.$_SERVER['HTTP_REFERER'];
	header("$link");
}
else if($_GET["edit"]==3)//set lesson group id edit
{
	$_SESSION['lesson_id']=$_GET['lesson_id'];

	$link='location:'.$_SERVER['HTTP_REFERER'].'#Edit_lesson_group';
		header("$link");
}
else if($_GET["edit"]==4)//set lesson group id delete
{
	$_SESSION['lesson_id']=$_GET['lesson_id'];

	$link='location:'.$_SERVER['HTTP_REFERER'].'#Delete_lesson_group';
	header("$link");
}
else if($_GET["edit"]==5)//set lesson group id delete
{
	$title='"'.$_POST['Cours_name'].'"';
	$password='"'.$_POST['Cours_password'].'"';
	$course_id=$_GET['id'];
	$sql="UPDATE course SET title=$title, password=$password WHERE id LIKE $course_id";
	$results=mysqli_query($db,$sql);
	$link='location:'.$_SERVER['HTTP_REFERER'];
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