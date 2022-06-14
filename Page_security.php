<?php include 'Connection.php'; ?>
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
	elseif($_SESSION['user_type']=="admin")
		header("location:Search_courses.php");
	else
		header("location:Home_page.php");
}
if($_SESSION['user_type']!="not_logged")
	$user_id=$_SESSION['user_id'];

if(basename($_SERVER['PHP_SELF'])=="Add_announcement1.php" or basename($_SERVER['PHP_SELF'])=="Add_course_file1.php" or basename($_SERVER['PHP_SELF'])=="Add_course_group.php" or basename($_SERVER['PHP_SELF'])=="Add_folder1.php" or basename($_SERVER['PHP_SELF'])=="Add_homework1.php" or basename($_SERVER['PHP_SELF'])=="Add_lesson.php" or basename($_SERVER['PHP_SELF'])=="Add_link1.php" or basename($_SERVER['PHP_SELF'])=="Add_poll1.php" or basename($_SERVER['PHP_SELF'])=="Add_quiz1.php" or basename($_SERVER['PHP_SELF'])=="Add_video_conference1.php" or basename($_SERVER['PHP_SELF'])=="My_account_edit.php")
{
	if(!isset($_GET['edit']))
	{
		if($_SESSION['user_type']=="admin")
			header("location:Search_courses.php");
		else
		{
			header("location:Home_page.php");
			exit();
		}
	}
}

if(basename($_SERVER['PHP_SELF'])=="Add_announcement.php" or basename($_SERVER['PHP_SELF'])=="Add_course_file.php" or basename($_SERVER['PHP_SELF'])=="Add_folder.php" or basename($_SERVER['PHP_SELF'])=="Add_homework.php" or basename($_SERVER['PHP_SELF'])=="Add_link.php" or basename($_SERVER['PHP_SELF'])=="Add_poll.php" or basename($_SERVER['PHP_SELF'])=="Add_quiz.php" or basename($_SERVER['PHP_SELF'])=="Add_quiz_answer.php" or basename($_SERVER['PHP_SELF'])=="Add_video_conference.php")
{
	if(!isset($_SESSION['add']))
  	{
  		if($_SESSION['user_type']=="admin")
			header("location:Search_courses.php");
		else
		{
			header("location:Home_page.php");
			exit();
		}

  	}
}

if(basename($_SERVER['PHP_SELF'])=="Announcement.php" or basename($_SERVER['PHP_SELF'])=="Course_file.php" or basename($_SERVER['PHP_SELF'])=="Course_participants.php" or basename($_SERVER['PHP_SELF'])=="Folder.php" or basename($_SERVER['PHP_SELF'])=="Homework.php" or basename($_SERVER['PHP_SELF'])=="Homework_answer_table.php" or basename($_SERVER['PHP_SELF'])=="Link.php" or basename($_SERVER['PHP_SELF'])=="Poll.php" or basename($_SERVER['PHP_SELF'])=="Quiz.php" or basename($_SERVER['PHP_SELF'])=="Quiz_solve.php" or basename($_SERVER['PHP_SELF'])=="Quiz_solve_table.php" or basename($_SERVER['PHP_SELF'])=="Quiz_teacher.php" or basename($_SERVER['PHP_SELF'])=="Search_users.php" or basename($_SERVER['PHP_SELF'])=="Video_conference.php")
{
	if(!isset($_SESSION['course_id']))
	{
		if($_SESSION['user_type']=="admin")
			header("location:Search_courses.php");
		else
		{
			header("location:Home_page.php");
			exit();
		}
	}
	
}

if(basename($_SERVER['PHP_SELF'])=="Course_page.php" or basename($_SERVER['PHP_SELF'])=="My_account.php" or basename($_SERVER['PHP_SELF'])=="Announcement.php" or basename($_SERVER['PHP_SELF'])=="Course_file.php" or basename($_SERVER['PHP_SELF'])=="Folder.php" or basename($_SERVER['PHP_SELF'])=="Homework.php" or basename($_SERVER['PHP_SELF'])=="Link.php" or basename($_SERVER['PHP_SELF'])=="Poll.php" or basename($_SERVER['PHP_SELF'])=="Quiz_teacher.php" or basename($_SERVER['PHP_SELF'])=="Video_conference.php" or basename($_SERVER['PHP_SELF'])=="Quiz_solve.php")
{
	if(!isset($_GET['id']))
	{
		if($_SESSION['user_type']=="admin")
			header("location:Search_courses.php");
		else
		{
			header("location:Home_page.php");
			exit();
		}
	}
}

if(basename($_SERVER['PHP_SELF'])=="Quiz.php" or basename($_SERVER['PHP_SELF'])=="Quiz_solve.php" or basename($_SERVER['PHP_SELF'])=="Quiz_solve_table.php")
{
	if(!isset($_SESSION['quiz']))
	{
		if($_SESSION['user_type']=="admin")
		    header("location:Search_courses.php");
		else
		    header("location:Home_page.php");
	}
}

if(basename($_SERVER['PHP_SELF'])=="My_account.php")
{
	$id=$_GET['id'];
	$sql="SELECT * FROM user WHERE id LIKE $id";
	$results=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($results);
	if(empty($row['id']))
	{
		$_SESSION['error_message']="Id-ul utilizatorului este invalid.";
		header("location:Error_page.php");
	}
}

if(basename($_SERVER['PHP_SELF'])=="Course_page.php")
{
	$id=$_GET['id'];
	if($_SESSION['user_type']!='admin')
		$sql="SELECT * FROM course_user WHERE course_id LIKE $id AND user_id LIKE $user_id";
	else
		$sql="SELECT * FROM course WHERE id LIKE $id";
	$results=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($results);
	if(empty($row['id']))
	{
		$_SESSION['error_message']="Id-ul cursului este invalid.";
		header("location:Error_page.php");
	}
}

if(basename($_SERVER['PHP_SELF'])=="Announcement.php")
{
	$id=$_GET['id'];
	
	$sql="SELECT * FROM notification WHERE id LIKE $id";
	$results=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($results);
	if(!empty($row['lesson_group_id']))
	{
		$lesson_group_id=$row['lesson_group_id'];
		$sql="SELECT course_id FROM lesson_group WHERE id LIKE $lesson_group_id";
		$results=mysqli_query($db,$sql);
		$row=mysqli_fetch_array($results);
		if(!empty($row['course_id']))
		{
			if($_SESSION['user_type']!='admin')
			{
				$course_id=$row['course_id'];
				$sql="SELECT * FROM course_user WHERE course_id LIKE $course_id AND user_id LIKE $user_id";
				$results=mysqli_query($db,$sql);
				$row=mysqli_fetch_array($results);
				if(empty($row['id']))
				{
					$_SESSION['error_message']="Id-ul anunțului este invalid.";
					header("location:Error_page.php");
				}
			}
		}
		else
		{
			$_SESSION['error_message']="Id-ul anunțului este invalid.";
			header("location:Error_page.php");
		}
	}
	else
	{
		$_SESSION['error_message']="Id-ul anunțului este invalid.";
		header("location:Error_page.php");
	}
}

if(basename($_SERVER['PHP_SELF'])=="Video_conference.php")
{
	$id=$_GET['id'];
	$sql="SELECT lesson_group_id FROM video_conference WHERE id LIKE $id";
	$results=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($results);
	if(!empty($row['lesson_group_id']))
	{
		$lesson_group_id=$row['lesson_group_id'];
		$sql="SELECT course_id FROM lesson_group WHERE id LIKE $lesson_group_id";
		$results=mysqli_query($db,$sql);
		$row=mysqli_fetch_array($results);
		if(!empty($row['course_id']))
		{
			if($_SESSION['user_type']!='admin')
			{
				$course_id=$row['course_id'];
				$sql="SELECT * FROM course_user WHERE course_id LIKE $course_id AND user_id LIKE $user_id";
				$results=mysqli_query($db,$sql);
				$row=mysqli_fetch_array($results);
				if(empty($row['id']))
				{
					$_SESSION['error_message']="Id-ul videoconferinței este invalid.";
					header("location:Error_page.php");
				}
			}
		}
		else
		{
			$_SESSION['error_message']="Id-ul videoconferinței este invalid.";
			header("location:Error_page.php");
		}
	}
	else
	{
		$_SESSION['error_message']="Id-ul videoconferinței este invalid.";
		header("location:Error_page.php");
	}
}

if(basename($_SERVER['PHP_SELF'])=="Course_file.php")
{
	$id=$_GET['id'];
	$sql="SELECT lesson_group_id FROM course_file WHERE id LIKE $id";
	$results=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($results);
	if(!empty($row['lesson_group_id']))
	{
		$lesson_group_id=$row['lesson_group_id'];
		$sql="SELECT course_id FROM lesson_group WHERE id LIKE $lesson_group_id";
		$results=mysqli_query($db,$sql);
		$row=mysqli_fetch_array($results);
		if(!empty($row['course_id']))
		{
			if($_SESSION['user_type']!='admin')
			{
				$course_id=$row['course_id'];
				$sql="SELECT * FROM course_user WHERE course_id LIKE $course_id AND user_id LIKE $user_id";
				$results=mysqli_query($db,$sql);
				$row=mysqli_fetch_array($results);
				if(empty($row['id']))
				{
					$_SESSION['error_message']="Id-ul fișier cursului este invalid.";
					header("location:Error_page.php");
				}
			}
		}
		else
		{
			$_SESSION['error_message']="Id-ul fișier cursului este invalid.";
			header("location:Error_page.php");
		}
	}
	else
	{
		$_SESSION['error_message']="Id-ul fișier cursului este invalid.";
		header("location:Error_page.php");
	}
}

if(basename($_SERVER['PHP_SELF'])=="Homework.php")
{
	$id=$_GET['id'];
	$sql="SELECT lesson_group_id FROM homework WHERE id LIKE $id";
	$results=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($results);
	if(!empty($row['lesson_group_id']))
	{
		$lesson_group_id=$row['lesson_group_id'];
		$sql="SELECT course_id FROM lesson_group WHERE id LIKE $lesson_group_id";
		$results=mysqli_query($db,$sql);
		$row=mysqli_fetch_array($results);
		if(!empty($row['course_id']))
		{
			if($_SESSION['user_type']!='admin')
			{
				$course_id=$row['course_id'];
				$sql="SELECT * FROM course_user WHERE course_id LIKE $course_id AND user_id LIKE $user_id";
				$results=mysqli_query($db,$sql);
				$row=mysqli_fetch_array($results);
				if(empty($row['id']))
				{
					$_SESSION['error_message']="Id-ul temei este invalid.";
					header("location:Error_page.php");
				}
			}
		}
		else
		{
			$_SESSION['error_message']="Id-ul temei este invalid.";
			header("location:Error_page.php");
		}
	}
	else
	{
		$_SESSION['error_message']="Id-ul temei este invalid.";
		header("location:Error_page.php");
	}
}

if(basename($_SERVER['PHP_SELF'])=="Folder.php")
{
	$id=$_GET['id'];
	$sql="SELECT lesson_group_id FROM folder WHERE id LIKE $id";
	$results=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($results);
	if(!empty($row['lesson_group_id']))
	{
		$lesson_group_id=$row['lesson_group_id'];
		$sql="SELECT course_id FROM lesson_group WHERE id LIKE $lesson_group_id";
		$results=mysqli_query($db,$sql);
		$row=mysqli_fetch_array($results);
		if(!empty($row['course_id']))
		{
			if($_SESSION['user_type']!='admin')
			{
				$course_id=$row['course_id'];
				$sql="SELECT * FROM course_user WHERE course_id LIKE $course_id AND user_id LIKE $user_id";
				$results=mysqli_query($db,$sql);
				$row=mysqli_fetch_array($results);
				if(empty($row['id']))
				{
					$_SESSION['error_message']="Id-ul folderului este invalid.";
					header("location:Error_page.php");
				}
			}
		}
		else
		{
			$_SESSION['error_message']="Id-ul folderului este invalid.";
			header("location:Error_page.php");
		}
	}
	else
	{
		$_SESSION['error_message']="Id-ul folderului este invalid.";
		header("location:Error_page.php");
	}
}

if(basename($_SERVER['PHP_SELF'])=="Quiz_teacher.php")
{
	$id=$_GET['id'];
	$sql="SELECT lesson_group_id FROM quiz WHERE id LIKE $id";
	$results=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($results);
	if(!empty($row['lesson_group_id']))
	{
		$lesson_group_id=$row['lesson_group_id'];
		$sql="SELECT course_id FROM lesson_group WHERE id LIKE $lesson_group_id";
		$results=mysqli_query($db,$sql);
		$row=mysqli_fetch_array($results);
		if(!empty($row['course_id']))
		{
			if($_SESSION['user_type']!='admin')
			{
				$course_id=$row['course_id'];
				$sql="SELECT * FROM course_user WHERE course_id LIKE $course_id AND user_id LIKE $user_id";
				$results=mysqli_query($db,$sql);
				$row=mysqli_fetch_array($results);
				if(empty($row['id']))
				{
					$_SESSION['error_message']="Id-ul quizului este invalid.";
					header("location:Error_page.php");
				}
			}
		}
		else
		{
			$_SESSION['error_message']="Id-ul quizului este invalid.";
			header("location:Error_page.php");
		}
	}
	else
	{
		$_SESSION['error_message']="Id-ul quizului este invalid.";
		header("location:Error_page.php");
	}
}
?>