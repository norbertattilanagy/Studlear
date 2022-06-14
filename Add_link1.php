<?php include 'Connection.php'; ?>
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
	$description=$_POST['description'];

	if(isset($_POST["visibility"]))
	{
		$visibility=1;
	}
	else
	{
		$visibility=0;
	}

	$target_dir="Cours_items/Link/";
	$user_id=$_SESSION['user_id'];
	$file_name=date("YmdHis").$user_id.'.txt';
	$target_file=$target_dir.$file_name;

	$file=fopen($target_file,"w");
	fwrite($file, $description);
	fclose($file);

	$sql="INSERT INTO link (title, link, description, lesson_group_id, visibility) VALUES ('$title','$link','$target_file','$lesson_id','$visibility')";
	$results=mysqli_query($db,$sql);

	$link='location: Course_page.php?id='.$_SESSION['course_id'];
	header("$link");
}
else if($_GET["edit"]==0)//edit
{
	$lesson_group_id=$_POST['lesson_group'];
	$lesson_id=$_SESSION['lesson_id'];
	$title='"'.$_POST['title'].'"';
	$link='"'.$_POST['link'].'"';;
	$description=$_POST['description'];

	if(isset($_POST["visibility"]))
	{
		$visibility=1;
	}
	else
	{
		$visibility=0;
	}

	$link_id=$_SESSION['link'];
	$sql_description="SELECT * FROM link WHERE id LIKE $link_id";
	$results_description=mysqli_query($db,$sql_description);
	$row_description=mysqli_fetch_array($results_description);

	$target_file=$row_description['description'];

	$file=fopen($target_file,"w");
	fwrite($file, $description);
	fclose($file);

	$sql="UPDATE link SET title=$title, link=$link, lesson_group_id=$lesson_group_id, visibility=$visibility WHERE id LIKE $link_id";
	$results=mysqli_query($db,$sql);

	$link='location: Link.php?id='.$_SESSION['link'];
	header("$link");
}
else if($_GET["edit"]==2)//delete
{
	$link_id=$_SESSION['link'];

	$sql_description="SELECT * FROM link WHERE id LIKE $link_id";
	$results_description=mysqli_query($db,$sql_description);
	$row_description=mysqli_fetch_array($results_description);

	$delete_file=$row_description["description"];
	unlink($delete_file);

	$sql="DELETE FROM link WHERE id LIKE $link_id";
	$results=mysqli_query($db,$sql);

	$link='location: Course_page.php?id='.$_SESSION['course_id'];
	header("$link");
}
else if($_GET["edit"]==3)//set add=1
{
	$_SESSION['lesson_id']=$_GET['lesson_id'];
	$_SESSION['add']=$_GET['add'];

	$link='location: Add_link.php';
	header("$link");
}
else if($_GET["edit"]==4)//set add=0
{
	$_SESSION['add']=$_GET['add'];

	$link='location: Add_link.php';
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