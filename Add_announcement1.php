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
	$message=$_POST['message'];

	if(isset($_POST["visibility"]))
	{
		$visibility=1;
	}
	else
	{
		$visibility=0;
	}
	
	$target_dir="Cours_items/Notification/";
	$user_id=$_SESSION['user_id'];
	$file_name=date("YmdHis").$user_id.'.txt';
	$target_file=$target_dir.$file_name;

	$file=fopen($target_file,"w");
	fwrite($file, $message);
	fclose($file);
	

	$sql="INSERT INTO notification (title,message,lesson_group_id,visibility) VALUES ('$title','$target_file','$lesson_id','$visibility')";
	$results=mysqli_query($db,$sql);
	
	$link='location: Course_page.php?id='.$_SESSION['course_id'];
	header("$link");
}
else if($_GET["edit"]==0)//edit
{
	$title='"'.$_POST['title'].'"';
	$message=$_POST['message'];
	$lesson_group_id=$_POST['lesson_group'];

	if(isset($_POST["visibility"]))
	{
		$visibility=1;
	}
	else
	{
		$visibility=0;
	}

	$notification_id=$_SESSION['notification'];
	$sql_message="SELECT * FROM notification WHERE id LIKE $notification_id";
	$results_message=mysqli_query($db,$sql_message);
	$row_message=mysqli_fetch_array($results_message);

	$target_file=$row_message['message'];

	$file=fopen($target_file,"w");
	fwrite($file, $message);
	fclose($file);

	$sql="UPDATE notification SET title=$title, lesson_group_id=$lesson_group_id, visibility=$visibility WHERE id LIKE $notification_id";
	$results=mysqli_query($db,$sql);

	$link='location: Announcement.php?id='.$_SESSION['notification'];
	header("$link");
}
else if($_GET["edit"]==2)//delete
{
	$notification_id=$_SESSION['notification'];

	$sql_message="SELECT * FROM notification WHERE id LIKE $notification_id";
	$results_message=mysqli_query($db,$sql_message);
	$row_message=mysqli_fetch_array($results_message);

	$delete_file=$row_message["message"];
	unlink($delete_file);

	$sql="DELETE FROM notification WHERE id LIKE $notification_id";
	$results=mysqli_query($db,$sql);

	$link='location: Course_page.php?id='.$_SESSION['course_id'];
	header("$link");
}
else if($_GET["edit"]==3)//set add=1
{
	$_SESSION['lesson_id']=$_GET['lesson_id'];
	$_SESSION['add']=$_GET['add'];

	$link='location: Add_announcement.php';
	header("$link");
}
else if($_GET["edit"]==4)//set add=0
{
	$_SESSION['add']=$_GET['add'];

	$link='location: Add_announcement.php';
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