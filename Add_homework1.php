<?php include 'Conection.php'; ?>
<?php include 'Page_security.php'; ?>
<?php
//1-add
//0-edit
//2-delete
//3-set add=1
//4-set add=0
//5-upload student file
//6-edit student file
//7-view file answer teacher
//8-point answer teacher
//9-update point answer teacher
if ($_GET["edit"]==1)//add
{
	$lesson_id=$_SESSION['lesson_id'];
	$title=$_POST['title'];
	$requirement=$_POST['requirement'];
	$end_event=$_POST['date_limit'];

	if(isset($_POST["visibility"]))
	{
		$visibility=1;
	}
	else
	{
		$visibility=0;
	}
	$user_id=$_SESSION['user_id'];

	$target_dir_requirement="Cours_items/Homework/Requirement/";
	$files_name_requirement=date("YmdHis").$user_id.'.txt';
	$target_files_requirement=$target_dir_requirement.$files_name_requirement;

	$file=fopen($target_files_requirement,"w");
	fwrite($file, $requirement);
	fclose($file);

	$target_dir_files="Cours_items/Homework/Teacher/";
	$folder_name_files=date("YmdHis").$user_id.'/';
	$target_folder_files=$target_dir_files.$folder_name_files;

	mkdir($target_folder_files);
	$nr_files = count($_FILES['files']['name']);

	for($i=0; $i<$nr_files; $i++)
	{
		$filename_files = $_FILES['files']['name'][$i];
		$target_folder_files1=$target_folder_files.$filename_files;

		move_uploaded_file($_FILES['files']['tmp_name'][$i],$target_folder_files1);
	}


	$sql="INSERT INTO homework (title,requirement,folder_name,end_event,lesson_group_id,visibility) VALUES ('$title','$target_files_requirement','$target_folder_files','$end_event','$lesson_id','$visibility')";
	$results=mysqli_query($db,$sql);

	$link='location: Course_page.php?id='.$_SESSION['course_id'];
	header("$link");
}
else if($_GET["edit"]==0)//edit
{
	$title='"'.$_POST['title'].'"';
	$requirement=$_POST['requirement'];
	$end_event='"'.$_POST['date_limit'].'"';
	$lesson_group_id=$_POST['lesson_group'];

	if(isset($_POST["visibility"]))
	{
		$visibility=1;
	}
	else
	{
		$visibility=0;
	}

	$homework_id=$_SESSION['homework'];

	$sql_select="SELECT * FROM homework WHERE id LIKE $homework_id";
	$results_select=mysqli_query($db,$sql_select);
	$row_select=mysqli_fetch_array($results_select);

	$target_file=$row_select['requirement'];

	$file=fopen($target_file,"w");
	fwrite($file, $requirement);
	fclose($file);

	$edit_folder=$row_select["folder_name"];
	$files = scandir($edit_folder);
	$nr_files = count($files);

	for($i=0; $i<$nr_files; $i++)
	{
		$post='file'.$i;
		if($files[$i]!="." and $files[$i]!=".." and isset($_POST[$post]))
		{
			$target_file=$edit_folder.$files[$i];
			unlink($target_file);
		}
	}

	$num_files = count($_FILES['files']['name']);
	$target_folder=$row_select["folder_name"];
	for($i=0; $i<$num_files; $i++)
	{
		$filename = $_FILES['files']['name'][$i];
		$target_folder1=$target_folder.$filename;
		move_uploaded_file($_FILES['files']['tmp_name'][$i],$target_folder1);
	}

	$sql="UPDATE homework SET title=$title, end_event=$end_event, lesson_group_id=$lesson_group_id, visibility=$visibility WHERE id LIKE $homework_id";
	$results=mysqli_query($db,$sql);

	$link='location: Homework.php?id='.$_SESSION['homework'];
	header("$link");
}
else if($_GET["edit"]==2)//delete
{
	$homework_id=$_SESSION['homework'];

	$sql_select="SELECT * FROM homework WHERE id LIKE $homework_id";
	$results_select=mysqli_query($db,$sql_select);
	$row_select=mysqli_fetch_array($results_select);

	$delete_file=$row_select['requirement'];
	unlink($delete_file);

	$delete_folder=$row_select["folder_name"];
	$files = scandir($delete_folder);
	$nr_files = count($files);
	for($i=0; $i<$nr_files; $i++)
	{
		if($files[$i]!="." and $files[$i]!="..")
		{
			$target_file=$delete_folder.$files[$i];
			unlink($target_file);
		}
	}
	$delete_folder=substr($delete_folder, 0, -1);
	rmdir($delete_folder);

	$sql="DELETE FROM homework WHERE id LIKE $homework_id";
	$results=mysqli_query($db,$sql);

	$link='location: Course_page.php?id='.$_SESSION['course_id'];
	header("$link");
}
else if($_GET["edit"]==3)//set add=1
{
	$_SESSION['lesson_id']=$_GET['lesson_id'];
	$_SESSION['add']=$_GET['add'];

	$link='location: Add_homework.php';
	header("$link");
}
else if($_GET["edit"]==4)//set add=0
{
	$_SESSION['add']=$_GET['add'];

	$link='location: Add_homework.php';
	header("$link");
}
else if($_GET["edit"]==5)//upload student file
{
	$homework_id=$_SESSION['homework'];
	$user_id=$_SESSION['user_id'];

	$target_dir_files="Cours_items/Homework/Student/";
	$folder_name_files=date("YmdHis").$user_id.'/';
	$target_folder_files=$target_dir_files.$folder_name_files;

	mkdir($target_folder_files);
	$nr_files = count($_FILES['files']['name']);

	for($i=0; $i<$nr_files; $i++)
	{
		$filename_files = $_FILES['files']['name'][$i];
		$target_folder_files1=$target_folder_files.$filename_files;

		move_uploaded_file($_FILES['files']['tmp_name'][$i],$target_folder_files1);
	}

	$sql="INSERT INTO answer_homework (folder_name,user_id,homework_id) VALUES ('$target_folder_files','$user_id','$homework_id')";
	$results=mysqli_query($db,$sql);

	$link='location: Homework.php?id='.$_SESSION['homework'];
	header("$link");
}
else if($_GET["edit"]==6)//edit student file
{
	$homework_id=$_SESSION['homework'];
	$user_id=$_SESSION['user_id'];

	$sql_select="SELECT * FROM answer_homework WHERE homework_id LIKE $homework_id AND user_id LIKE $user_id";
	$results_select=mysqli_query($db,$sql_select);
	$row_select=mysqli_fetch_array($results_select);

	$edit_folder=$row_select["folder_name"];
	$files = scandir($edit_folder);
	$nr_files = count($files);

	for($i=0; $i<$nr_files; $i++)
	{
		$post='file'.$i;
		if($files[$i]!="." and $files[$i]!=".." and isset($_POST[$post]))
		{
			$target_file=$edit_folder.$files[$i];
			unlink($target_file);
		}
	}

	$num_files = count($_FILES['files']['name']);
	$target_folder=$row_select["folder_name"];
	for($i=0; $i<$num_files; $i++)
	{
		$filename = $_FILES['files']['name'][$i];
		$target_folder1=$target_folder.$filename;
		move_uploaded_file($_FILES['files']['tmp_name'][$i],$target_folder1);
	}
}
else if($_GET["edit"]==7)//view file answer teacher
{
	$_SESSION['homework_user_id']=$_GET['user_id'];

	$link='location:'.$_SERVER['HTTP_REFERER'].'#Answer_homework';
	header("$link");
}
else if($_GET["edit"]==8)//point answer teacher
{
	$_SESSION['homework_user_id']=$_GET['user_id'];

	$link='location:'.$_SERVER['HTTP_REFERER'].'#Point_homework';
	header("$link");
}
else if($_GET["edit"]==9)//update point answer teacher
{
	$point=$_POST['point'];
	$homework_id=$_SESSION['homework'];
	$homework_user_id=$_SESSION['homework_user_id'];

	$sql="UPDATE answer_homework SET `point`=$point WHERE homework_id LIKE $homework_id AND user_id LIKE $homework_user_id";
	$results=mysqli_query($db,$sql);

	$link='location:'.$_SERVER['HTTP_REFERER'];
	header("$link");
}
?>