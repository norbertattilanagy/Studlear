<?php include 'Conection.php'; ?>
<?php include 'Page_security.php'; ?>
<?php
//0-new group modal
//1-edit course
//2-delete
//3-add session group_name and open Edit_course_Modal
if($_GET['edit']==0)
{
	$group_name="'".$_POST['group_name']."'";
	$user_id=$_SESSION['user_id'];
	$sql="SELECT * FROM course_user WHERE user_id LIKE $user_id";
    $results=mysqli_query($db,$sql);
	$num_rows=mysqli_num_rows($results);
	$i=0;
	while ($row=mysqli_fetch_array($results,MYSQLI_ASSOC))
	{
		$check="option".$i;
		$course_id=$row['course_id'];
		if(isset($_POST[$check]))
		{
			$sql_insert="INSERT INTO course_group (group_name, course_id, user_id) VALUES ($group_name, $course_id, $user_id)";
			$results_insert=mysqli_query($db,$sql_insert);
		}
		$i++;
	}
	$link='location:'.$_SERVER['HTTP_REFERER'];
	header("$link");
}
else if($_GET['edit']==1)
{
	$group_name="'".$_SESSION['group_name']."'";
	
	$user_id=$_SESSION['user_id'];
	$sql="SELECT * FROM course_user WHERE user_id LIKE $user_id";
	$results=mysqli_query($db,$sql);
	$i=0;
	while ($row=mysqli_fetch_array($results,MYSQLI_ASSOC))
	{
		$check="option".$i;
		$course_id=$row['course_id'];
		$group_name='"'.$_SESSION['group_name'].'"';
		$sql_verify="SELECT * FROM course_group WHERE user_id LIKE $user_id AND course_id LIKE $course_id AND group_name LIKE $group_name";
		$results_verify=mysqli_query($db,$sql_verify);
		$nr_row_verify=mysqli_num_rows($results_verify);
		if($nr_row_verify==0)
		{
			if(isset($_POST[$check]))
			{
				$sql_insert="INSERT INTO course_group (group_name, course_id, user_id) VALUES ($group_name, $course_id, $user_id)";
				$results_insert=mysqli_query($db,$sql_insert);
			}
		}
		else
		{
			if(!isset($_POST[$check]))
			{
				$sql_delete="DELETE FROM course_group WHERE user_id LIKE $user_id AND course_id LIKE $course_id AND group_name LIKE $group_name";
				$results_delete=mysqli_query($db,$sql_delete);
			}
		}
		$i++;
	}
	//title
	$new_group_name="'".$_POST['group_name']."'";
	if($new_group_name!=$group_name)
	{
		$sql="UPDATE course_group SET group_name=$new_group_name WHERE group_name LIKE $group_name";
		$results=mysqli_query($db,$sql);
	}
	$link='location:'.$_SERVER['HTTP_REFERER'];
	header("$link");
}
else if($_GET['edit']==2)
{
	$group_name="'".$_SESSION['group_name']."'";
	$sql="DELETE FROM course_group WHERE group_name LIKE $group_name";
	$results=mysqli_query($db,$sql);
	$link='location:'.$_SERVER['HTTP_REFERER'];
	header("$link");
}
else if($_GET['edit']==3)
{
	$_SESSION['group_name']=$_GET['group'];
	$link='location:'.$_SERVER['HTTP_REFERER'].'#Edit_course_Modal';
    header("$link");
}
else
{
	if($_SESSION['user_type']=="admin")
		header("location:Search_courses.php");
	else
		header("location:Home_page.php");
}
?>