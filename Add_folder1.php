<?php include 'Conection.php'; ?>
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

	$target_dir="Cours_items/Folder/";
	$user_id=$_SESSION['user_id'];
	$folder_name=date("YmdHis").$user_id.'/';
	$target_folder=$target_dir.$folder_name;

	mkdir($target_folder);

	$nr_files = count($_FILES['folder']['name']);

	for($i=0; $i<$nr_files; $i++)
	{
		$filename = $_FILES['folder']['name'][$i];
		$target_folder1=$target_folder.$filename;
		move_uploaded_file($_FILES['folder']['tmp_name'][$i],$target_folder1);
	}
	$sql="INSERT INTO folder (title,folder_name,lesson_group_id,visibility) VALUES ('$title','$target_folder','$lesson_id','$visibility')";
	$results=mysqli_query($db,$sql);

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

	$folder_id=$_SESSION['folder'];
	$sql_folder_name="SELECT * FROM folder WHERE id LIKE $folder_id";
	$results_folder_name=mysqli_query($db,$sql_folder_name);
	$row_folder_name=mysqli_fetch_array($results_folder_name);

	$edit_folder=$row_folder_name["folder_name"];
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

	$num_files = count($_FILES['folder']['name']);
	$target_folder=$row_folder_name["folder_name"];
	for($i=0; $i<$num_files; $i++)
	{
		$filename = $_FILES['folder']['name'][$i];
		$target_folder1=$target_folder.$filename;
		move_uploaded_file($_FILES['folder']['tmp_name'][$i],$target_folder1);
	}

	$sql="UPDATE folder SET title=$title, lesson_group_id=$lesson_group_id, visibility=$visibility WHERE id LIKE $folder_id";
	$results=mysqli_query($db,$sql);

	$link='location: Folder.php?id='.$_SESSION['folder'];
	header("$link");
}
else if($_GET["edit"]==2)//delete
{
	$folder_id=$_SESSION['folder'];

	$sql_folder_name="SELECT * FROM folder WHERE id LIKE $folder_id";
	$results_folder_name=mysqli_query($db,$sql_folder_name);
	$row_folder_name=mysqli_fetch_array($results_folder_name);

	$delete_folder=$row_folder_name["folder_name"];

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

	$sql="DELETE FROM folder WHERE id LIKE $folder_id";
	$results=mysqli_query($db,$sql);

	$link='location: Course_page.php?id='.$_SESSION['course_id'];
	header("$link");
}
else if($_GET["edit"]==3)//set add=1
{
	$_SESSION['lesson_id']=$_GET['lesson_id'];
	$_SESSION['add']=$_GET['add'];

	$link='location: Add_folder.php';
	header("$link");
}
else if($_GET["edit"]==4)//set add=0
{
	$_SESSION['add']=$_GET['add'];

	$link='location: Add_folder.php';
	header("$link");
}
?>