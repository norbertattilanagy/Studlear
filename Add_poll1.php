<?php include 'Connection.php'; ?>
<?php include 'Page_security.php'; ?>
<?php
//1-add
//0-edit
//2-delete
//3-set add=1
//4-set add=0
//5-answer poll
if ($_GET["edit"]==1)//add
{
	$lesson_id=$_SESSION['lesson_id'];
	$title=$_POST['title'];
	$question=$_POST['question'];
	$options=$_POST['option'];
	$option_type=$_POST['option_type'];

	if(isset($_POST["visibility"]))
	{
		$visibility=1;
	}
	else
	{
		$visibility=0;
	}

	$target_dir="Cours_items/Poll/";
	$user_id=$_SESSION['user_id'];
	$file_name=date("YmdHis").$user_id.'.txt';
	$target_file=$target_dir.$file_name;

	$file=fopen($target_file,"w");
	fwrite($file, $question);
	fclose($file);

	$sql="INSERT INTO poll (title,question,radio_button,lesson_group_id,visibility) VALUES ('$title','$target_file','$option_type','$lesson_id','$visibility')";
	$results=mysqli_query($db,$sql);
	if($results)
		$poll_id = mysqli_insert_id($db);

	$element="poll";
	foreach($options as $i)
	{
		$sql="INSERT INTO quiz_option (option,element,question_id) VALUES ('$i','$element','$poll_id')";
		$results=mysqli_query($db,$sql);
	}
	$link='location: Course_page.php?id='.$_SESSION['course_id'];
	header("$link");
}
else if($_GET["edit"]==0)//edit
{
	$lesson_id=$_POST['lesson_group'];
	$title='"'.$_POST['title'].'"';
	$question=$_POST['question'];
	$options=$_POST['option'];
	$option_type=$_POST['option_type'];

	if(isset($_POST["visibility"]))
	{
		$visibility=1;
	}
	else
	{
		$visibility=0;
	}

	$poll_id=$_SESSION['poll'];
	$sql_question="SELECT * FROM poll WHERE id LIKE $poll_id";
	$results_question=mysqli_query($db,$sql_question);
	$row_question=mysqli_fetch_array($results_question);

	$target_file=$row_question['question'];

	$file=fopen($target_file,"w");
	fwrite($file, $question);
	fclose($file);

	$sql="UPDATE poll SET title=$title, radio_button=$option_type, lesson_group_id=$lesson_id, visibility=$visibility WHERE id LIKE $poll_id";
	$results=mysqli_query($db,$sql);

	$sql_option="SELECT * FROM quiz_option WHERE element LIKE 'poll' AND question_id LIKE $poll_id";
	$results_option=mysqli_query($db,$sql_option);
			
	while($row_option=mysqli_fetch_array($results_option))
	{
		$delete=1;
		foreach($options as $i)
		{
			if($i==$row_option["option"])
				$delete=0;
		}
		if($delete==1)
		{
			$id=$row_option["id"];
			$sql="DELETE FROM quiz_option WHERE id LIKE $id";
			$results=mysqli_query($db,$sql);
		}
	}
	
	$element="poll";
	foreach($options as $i)
	{
		$insert=1;
		$results_option=mysqli_query($db,$sql_option);
		while($row_option=mysqli_fetch_array($results_option))
		{
			if($i==$row_option["option"])
				$insert=0;
		}
		if($insert==1)
		{
			$sql="INSERT INTO quiz_option (option,element,question_id) VALUES ('$i','$element','$poll_id')";
			$results=mysqli_query($db,$sql);
		}
	}

	$link='location: Poll.php?id='.$_SESSION['poll'];
	header("$link");
}
else if($_GET["edit"]==2)//delete
{
	$poll_id=$_SESSION['poll'];

	$sql_option="SELECT * FROM quiz_option WHERE element LIKE 'poll' AND question_id LIKE $poll_id";
	$results_option=mysqli_query($db,$sql_option);
			
	while($row_option=mysqli_fetch_array($results_option))
	{
		$id=$row_option["id"];
		$sql="DELETE FROM quiz_option WHERE id LIKE $id";
		$results=mysqli_query($db,$sql);
	}

	$sql="SELECT * FROM poll WHERE id LIKE $poll_id";
	$results=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($results);

	echo $delete_file=$row["question"];
	unlink($delete_file);

	$sql="DELETE FROM poll WHERE id LIKE $poll_id";
	$results=mysqli_query($db,$sql);

	$link='location: Course_page.php?id='.$_SESSION['course_id'];
	header("$link");
}
else if($_GET["edit"]==3)//set add=1
{
	$_SESSION['lesson_id']=$_GET['lesson_id'];
	$_SESSION['add']=$_GET['add'];

	$link='location: Add_poll.php';
	header("$link");
}
else if($_GET["edit"]==4)//set add=0
{
	$_SESSION['add']=$_GET['add'];

	$link='location: Add_poll.php';
	header("$link");
}
else if($_GET["edit"]==5)//answer poll
{
	$user_id=$_SESSION['user_id'];
	$poll_id=$_SESSION['poll'];

	$sql_option="SELECT * FROM quiz_option WHERE element LIKE 'poll' AND question_id LIKE $poll_id";
	$results_option=mysqli_query($db,$sql_option);
	$i=0;
	while($row_option=mysqli_fetch_array($results_option))
	{
		$option="option".$i;
		if(isset($_POST[$option]))
		{
			$quiz_option_id=$_POST[$option];
			$sql="INSERT INTO answer_quiz_option (user_id,quiz_option_id) VALUES ('$user_id','$quiz_option_id')";
			$results=mysqli_query($db,$sql);
		}
		$i++;
	}

	$link='location: Poll.php?id='.$_SESSION['poll'];
	header("$link");
}
else//security
{
 	if($_SESSION['user_type']=="admin")
		header("location:Search_courses.php");
	else
		header("location:Home_page.php");
}