<?php include 'Conection.php'; ?>
<?php include 'Page_security.php'; ?>
<?php
if($_GET['edit']==1)#search
{
	$_SESSION['s']=0;

	$link='location:Search_users_admin.php';
	header("$link");
}
else if($_GET['edit']==2)#search
{
	$_SESSION['s']=1;
	$_SESSION['search']=$_POST['search'];

	$link='location:'.$_SERVER['HTTP_REFERER'];
	header("$link");
}
else if($_GET['edit']==3)#delete user
{
	$_SESSION['delete_user_id']=$_GET['delete_user_id'];

	$link='location:Search_users_admin.php#Delete_user';
	header("$link");
}
else if($_GET['edit']==4)#delete user
{
	$delete_user_id=$_SESSION['delete_user_id'];
	$sql="DELETE FROM calendar WHERE user_id LIKE $delete_user_id";
	$results=mysqli_query($db,$sql);

	$sql="DELETE FROM course_group WHERE user_id LIKE $delete_user_id";
	$results=mysqli_query($db,$sql);

	$sql="DELETE FROM course_user WHERE user_id LIKE $delete_user_id";
	$results=mysqli_query($db,$sql);

	$sql="SELECT * FROM answer_homework WHERE user_id LIKE $delete_user_id";
	$results=mysqli_query($db,$sql);
	while ($row=mysqli_fetch_array($results))
	{
		rmdir($row['folder_name']);
	}
	$sql="DELETE FROM answer_homework WHERE user_id LIKE $delete_user_id";
	$results=mysqli_query($db,$sql);

	$sql="DELETE FROM answer_quiz_option WHERE user_id LIKE $delete_user_id";
	$results=mysqli_query($db,$sql);

	$sql="DELETE FROM answer_text_question WHERE user_id LIKE $delete_user_id";
	$results=mysqli_query($db,$sql);

	$sql="DELETE FROM answer_true_false WHERE user_id LIKE $delete_user_id";
	$results=mysqli_query($db,$sql);

	$sql="DELETE FROM answer_select_question WHERE user_id LIKE $delete_user_id";
	$results=mysqli_query($db,$sql);

	$sql="DELETE FROM user WHERE id LIKE $delete_user_id";
	$results=mysqli_query($db,$sql);

	$link='location:Search_users_admin.php';
	header("$link");
}

?>