<?php include 'Conection.php'; ?>
<?php include 'Page_security.php'; ?>
<?php
//1-add
//0-edit
//2-delete
//3-set add=1
//4-set add=0
if ($_GET["edit"]==1)//add
{
	$lesson_id=$_SESSION['lesson_id'];
	$title=$_POST['title'];
	$link=$_POST['link'];
	$password=$_POST['password'];
	$start_event=$_POST['start_event'];
	$end_event=$_POST['end_event'];

	if(isset($_POST["visibility"]))
	{
		$visibility=1;
	}
	else
	{
		$visibility=0;
	}

	$sql="INSERT INTO video_conference (title, link, password, start_event, end_event, lesson_group_id, visibility) VALUES ('$title','$link','$password','$start_event','$end_event','$lesson_id','$visibility')";
	$results=mysqli_query($db,$sql);

	$link='location: Course_page.php?id='.$_SESSION['course_id'];
	header("$link");
}
else if($_GET["edit"]==0)//edit
{
	$title='"'.$_POST['title'].'"';
	$link='"'.$_POST['link'].'"';
	$password='"'.$_POST['password'].'"';
	$start_event='"'.$_POST['start_event'].'"';
	$end_event='"'.$_POST['end_event'].'"';
	$lesson_group_id=$_POST['lesson_group'];

	if(isset($_POST["visibility"]))
	{
		$visibility=1;
	}
	else
	{
		$visibility=0;
	}

	$video_conference_id=$_SESSION['video_conference'];
	$sql="UPDATE video_conference SET title=$title, link=$link, password=$password, start_event=$start_event, end_event=$end_event, lesson_group_id=$lesson_group_id, visibility=$visibility WHERE id LIKE $video_conference_id";
	$results=mysqli_query($db,$sql);

	$link='location: Video_conference.php?id='.$_SESSION['video_conference'];
	header("$link");
}
else if($_GET["edit"]==2)//delete
{
	$video_conference_id=$_SESSION['video_conference'];

	$sql_message="SELECT * FROM video_conference WHERE id LIKE $video_conference_id";
	$results_message=mysqli_query($db,$sql_message);
	$row_message=mysqli_fetch_array($results_message);

	$delete_file=$row_message["file_name"];
	unlink($delete_file);

	$sql="DELETE FROM video_conference WHERE id LIKE $video_conference_id";
	$results=mysqli_query($db,$sql);

	$link='location: Course_page.php?id='.$_SESSION['course_id'];
	header("$link");
}
else if($_GET["edit"]==3)//set add=1
{
	$_SESSION['lesson_id']=$_GET['lesson_id'];
	$_SESSION['add']=$_GET['add'];

	$link='location: Add_video_conference.php';
	header("$link");
}
else if($_GET["edit"]==4)//set add=0
{
	$_SESSION['add']=$_GET['add'];

	$link='location: Add_video_conference.php';
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