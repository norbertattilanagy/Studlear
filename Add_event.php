
<?php 
echo "string=".$_POST['title'];
$error=0;
if(empty($_POST['title']))
	$error=1;
if(empty($_POST['event_date_start']))
	$error=2;
if(empty($_POST['event_time_start']))
	$error=3;
if(empty($_POST['event_date_end']))
	$error=4;
if(empty($_POST['event_time_end']))
	$error=5;
echo $error;
if($error==0)
{
	$title=$_POST['title'];
	$start_event=$_POST['event_date_start'].' '.$_POST['event_time_start'];
	$end_event=$_POST['event_date_end'].' '.$_POST['event_time_end'];
	$color=$_POST['event_color'];
	$description=$_POST['description'];
	$sql="INSERT INTO calendar (title,start_event,end_event,color,description) VALUES ('$title','$start_event','$end_event','$color','$description')";
	$results=mysqli_query($db,$sql);
	if (!$results)
		die('Invalid querry:' .mysqli_error($db));
	else
		echo "Succes";
}
?>