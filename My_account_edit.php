<?php include 'Connection.php'; ?>
<?php include 'Page_security.php'; ?>
<?php
//0-edit profile image
//1-delete profile image
//2-edit data
//3-edit password
//4-delete profile
//5-update user type
if ($_GET["edit"]==0)//edit profile image
{
	$user_id=$_SESSION['user_id'];
	if(!empty($_FILES['photo']['name']))
	{
		$name = $_FILES['photo']['name'];
		$target_dir = "Images/Profile/";
		$target_file = $target_dir . basename($_FILES["photo"]["name"]);
		$new_name=date("YmdHis").$user_id.$name;
		$name=$new_name;
		$new_name='"'.$new_name.'"';
		// Select file type
		$FileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		// Valid file extensions
		$extensions= array("jpg","jpeg","png");
		if(in_array($FileType,$extensions))
		{
			//delete old image
			$sql="SELECT * FROM user WHERE id LIKE $user_id";
			$results=mysqli_query($db,$sql);
			$row=mysqli_fetch_array($results);
			$delete_file=$target_dir.$row["profile_image"];
			unlink($delete_file);
			//upload image
			$sql="UPDATE user SET profile_image=$new_name WHERE id LIKE $user_id";
			$results=mysqli_query($db,$sql);
			move_uploaded_file($_FILES['photo']['tmp_name'],$target_dir.$name);
		}
	}	
	$link='location:'.$_SERVER['HTTP_REFERER'];
	header("$link");
}
else if ($_GET["edit"]==1)//delete profile image
{
	$user_id=$_SESSION['user_id'];
	$target_dir = "Images/Profile/";

	//delete old image
	$sql="SELECT * FROM user WHERE id LIKE $user_id";
	$results=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($results);
	$delete_file=$target_dir.$row["profile_image"];
	unlink($delete_file);

	//delete image db
	$sql="UPDATE user SET profile_image=NULL WHERE id LIKE $user_id";
	$results=mysqli_query($db,$sql);

	$link='location:'.$_SERVER['HTTP_REFERER'];
	header("$link");
}
else if ($_GET["edit"]==2)//edit data
{
	$name='"'.$_POST['name'].'"';
	$email='"'.$_POST['email'].'"';
	$user_id=$_SESSION['user_id'];

	$sql="UPDATE user SET name=$name, email=$email WHERE id LIKE $user_id";
	//$results=mysqli_query($db,$sql);

	$link='location:'.$_SERVER['HTTP_REFERER'];
	header("$link");
}
else  if ($_GET["edit"]==3)//edit password
{
	$old_password=$_POST['old_password'];
	$new_password1=$_POST['new_password1'];
	$new_password2=$_POST['new_password2'];
	$user_id=$_SESSION['user_id'];

	$sql="SELECT * FROM user WHERE id LIKE $user_id";
	$results=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($results,MYSQLI_ASSOC);

	if($old_password==$row["password"])
	{
		if($new_password1==$new_password2)
		{
			$sql="UPDATE user SET password=$new_password1 WHERE id LIKE $user_id";
			//$results=mysqli_query($db,$sql);
		}
		else
		{
			$eror_message="Nu coincide parola noua";
		}
	}
	else
		$eror_message="Parola veche gresita";

	$link='location:'.$_SERVER['HTTP_REFERER'];
	header("$link");
}
else  if ($_GET["edit"]==4)//delete profile
{
	$user_id=$_SESSION['user_id'];

	$sql="DELETE FROM calendar WHERE user_id LIKE $user_id";
	$results=mysqli_query($db,$sql);

	$sql="DELETE FROM course_group WHERE user_id LIKE $user_id";
	$results=mysqli_query($db,$sql);

	$sql="DELETE FROM course_user WHERE user_id LIKE $user_id";
	$results=mysqli_query($db,$sql);

	$sql="SELECT * FROM answer_homework WHERE user_id LIKE $user_id";
	$results=mysqli_query($db,$sql);
	while ($row=mysqli_fetch_array($results))
	{
		rmdir($row['folder_name']);
	}
	$sql="DELETE FROM answer_homework WHERE user_id LIKE $user_id";
	$results=mysqli_query($db,$sql);

	$sql="DELETE FROM answer_quiz_option WHERE user_id LIKE $user_id";
	$results=mysqli_query($db,$sql);

	$sql="DELETE FROM answer_text_question WHERE user_id LIKE $user_id";
	$results=mysqli_query($db,$sql);

	$sql="DELETE FROM answer_true_false WHERE user_id LIKE $user_id";
	$results=mysqli_query($db,$sql);

	$sql="DELETE FROM answer_select_question WHERE user_id LIKE $user_id";
	$results=mysqli_query($db,$sql);

	$sql="DELETE FROM user WHERE id LIKE $user_id";
	$results=mysqli_query($db,$sql);
	
	$_SESSION['user_type']="not_logged";

	$link='location:Sign_in.php';
	header("$link");
}
else  if ($_GET["edit"]==5)//update user type
{
	$search_user_id=$_GET['search_user_id'];
	$user_type='"'.$_POST['user_type'].'"';
	echo $sql="UPDATE user SET type=$user_type WHERE id LIKE $search_user_id";
	$results=mysqli_query($db,$sql);

	$link='location:'.$_SERVER['HTTP_REFERER'];
	header("$link");
}
?>