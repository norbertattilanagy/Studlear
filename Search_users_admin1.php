<?php include 'Conection.php'; ?>
<?php include 'Page_security.php'; ?>
<?php
if($_GET['edit']==1)
{
	$_SESSION['s']=0;

	$link='location:Search_users_admin.php';
	header("$link");
}
else if($_GET['edit']==2)
{
	$_SESSION['s']=1;
	$_SESSION['search']=$_POST['search'];

	$link='location:'.$_SERVER['HTTP_REFERER'];
	header("$link");
}
else if($_GET['edit']==3)
{
	$_SESSION['delete_user_id']=$_GET['delete_user_id'];

	$link='location:Search_users_admin.php#Delete_user';
	header("$link");
}
else if($_GET['edit']==4)
{
	$delete_user_id=$_SESSION['delete_user_id'];
	$sql="DELETE FROM calendar WHERE user_id LIKE $delete_user_id";
	$results=mysqli_query($db,$sql);

	$sql="DELETE FROM course_group WHERE user_id LIKE $delete_user_id";
	$results=mysqli_query($db,$sql);

	$sql="DELETE FROM course_user WHERE user_id LIKE $delete_user_id";
	$results=mysqli_query($db,$sql);

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