<?php include 'Conection.php'; ?>
<?php
$page='"'.basename($_SERVER['PHP_SELF']).'"';

if(empty($_SESSION['user_type']))
	$_SESSION['user_type']="not_logged";

$user_type='"'.$_SESSION['user_type'].'"';
$sql="SELECT * FROM security WHERE page=$page and user_type=$user_type";
$results= mysqli_query($db,$sql);
$row=mysqli_fetch_array($results,MYSQLI_ASSOC);
if(empty($row["id"]))
{
	if($_SESSION['user_type']=="not_logged")
		header("location:Sign_in.php");
	else
		header("location:Home_page.php");
}
?>