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

	if(isset($_POST["visibility"]))
	{
		$visibility=1;
	}
	else
	{
		$visibility=0;
	}

	$user_id=$_SESSION['user_id'];
	if(!empty($_FILES['input_file']['name']))
	{
		$target_dir="Cours_items/Cours_file/";
		$user_id=$_SESSION['user_id'];
		$folder_name=date("YmdHis").$user_id.'/';
		$target_folder=$target_dir.$folder_name;

		$file_name = $_FILES['input_file']['name'];

		// Select file type
		$FileType = strtolower(pathinfo($file_name,PATHINFO_EXTENSION));
		// Valid file extensions
		$extensions= array("pdf");
		if(in_array($FileType,$extensions))
		{
			mkdir($target_folder);
			$target_folder1=$target_folder.$file_name;

			$sql="INSERT INTO course_file (title,file_name,lesson_group_id,visibility) VALUES ('$title','$target_folder','$lesson_id','$visibility')";
			$results=mysqli_query($db,$sql);
			move_uploaded_file($_FILES['input_file']['tmp_name'],$target_folder1);
		}
	}
	$link='location: Course_page.php?id='.$_SESSION['course_id'];
	header("$link");
}
else if($_GET["edit"]==0)//edit
{
	$title='"'.$_POST['title'].'"';
	$lesson_group_id=$_POST['lesson_group'];

	if(isset($_POST["visibility"]))
	{
		$visibility=1;
	}
	else
	{
		$visibility=0;
	}

	$course_file_id=$_SESSION['course_file'];
	$sql_course_file="SELECT * FROM course_file WHERE id LIKE $course_file_id";
	$results_course_file=mysqli_query($db,$sql_course_file);
	$row_course_file=mysqli_fetch_array($results_course_file);

	$user_id=$_SESSION['user_id'];
	if(!empty($_FILES['input_file']['name']))
	{
		$target_folder=$row_course_file["file_name"];
		$files = scandir($target_folder);



		$file_name = $_FILES['input_file']['name'];

		
		// Select file type
		$FileType = strtolower(pathinfo($file_name,PATHINFO_EXTENSION));
		// Valid file extensions
		$extensions= array("pdf");
		if(in_array($FileType,$extensions))
		{
			//delete old file
			for($i=0; $i<3; $i++)
			{
				if($files[$i]!="." and $files[$i]!="..")
				{
					$target_file=$target_folder.$files[$i];
					unlink($target_file);
				}
			}

			//upload file
			$target_folder1=$target_folder.$file_name;
			move_uploaded_file($_FILES['input_file']['tmp_name'],$target_folder1);
		}
	}
	$sql="UPDATE course_file SET title=$title, lesson_group_id=$lesson_group_id, visibility=$visibility WHERE id LIKE $course_file_id";
	$results=mysqli_query($db,$sql);

	$link='location: Course_page.php?id='.$_SESSION['course_id'];
	header("$link");
}
else if($_GET["edit"]==2)//delete
{
	$course_file_id=$_SESSION['course_file'];

	$sql_course_file="SELECT * FROM course_file WHERE id LIKE $course_file_id";
	$results_course_file=mysqli_query($db,$sql_course_file);
	$row_course_file=mysqli_fetch_array($results_course_file);

	//delete file
	$delete_folder=$row_course_file["file_name"];
	$files = scandir($delete_folder);

	for($i=0; $i<3; $i++)
	{
		if($files[$i]!="." and $files[$i]!="..")
		{
			$target_file=$delete_folder.$files[$i];
			unlink($target_file);
		}
	}

	$delete_folder=substr($delete_folder, 0, -1);
	rmdir($delete_folder);

	$sql="DELETE FROM course_file WHERE id LIKE $course_file_id";
	$results=mysqli_query($db,$sql);

	$link='location: Course_page.php?id='.$_SESSION['course_id'];
	header("$link");
}
else if($_GET["edit"]==3)//set add=1
{
	$_SESSION['lesson_id']=$_GET['lesson_id'];
	$_SESSION['add']=$_GET['add'];

	$link='location: Add_course_file.php';
	header("$link");
}
else if($_GET["edit"]==4)//set add=0
{
	$_SESSION['add']=$_GET['add'];

	$link='location: Add_course_file.php';
	header("$link");
}
?>