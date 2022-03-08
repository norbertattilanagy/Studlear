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
	$description=$_POST['description'];

	$solving_time=0;
	if(!empty($_POST['solving_time_hour']))
		$solving_time=$solving_time+$_POST['solving_time_hour']*3600;
	else if(!empty($_POST['solving_time_min']))
		$solving_time=$solving_time+$_POST['solving_time_min']*60;
	else if(!empty($_POST['solving_time_sec']))
		$solving_time=$solving_time+$_POST['solving_time_sec'];

	$start_event=$_POST['start_event'];
	$end_event=$_POST['end_event'];

	if(isset($_POST["visibility"]))
	{
		$visibility=1;
	}
	else
	{
		$visibility=0;
	}

	$target_dir="Cours_items/Quiz/Description/";
	$user_id=$_SESSION['user_id'];
	$file_name=date("YmdHis").$user_id.'.txt';
	$target_file=$target_dir.$file_name;

	$file=fopen($target_file,"w");
	fwrite($file, $description);
	fclose($file);

	$sql="INSERT INTO quiz (title,description,solving_time,start_event,end_event,lesson_group_id,visibility) VALUES ('$title','$target_file','$solving_time','$start_event','$end_event','$lesson_id','$visibility')";
	$results=mysqli_query($db,$sql);

	if($results)
		$quiz_id = mysqli_insert_id($db);

	$_SESSION['add']=0;
	$_SESSION['quiz']=$quiz_id;

	$link='location: Add_quiz.php#Answer_type';
	header("$link");
}
else if($_GET["edit"]==0)//edit
{
	$lesson_id=$_POST['lesson_group'];
	$title='"'.$_POST['title'].'"';
	$description=$_POST['description'];

	$solving_time=0;
	if(!empty($_POST['solving_time_hour']))
		$solving_time=$solving_time+$_POST['solving_time_hour']*3600;
	else if(!empty($_POST['solving_time_min']))
		$solving_time=$solving_time+$_POST['solving_time_min']*60;
	else if(!empty($_POST['solving_time_sec']))
		$solving_time=$solving_time+$_POST['solving_time_sec'];

	$start_event='"'.$_POST['start_event'].'"';
	$end_event='"'.$_POST['end_event'].'"';

	if(isset($_POST["visibility"]))
	{
		$visibility=1;
	}
	else
	{
		$visibility=0;
	}

	$quiz_id=$_SESSION['quiz'];
	$sql_quiz="SELECT * FROM quiz WHERE id LIKE $quiz_id";
	$results_quiz=mysqli_query($db,$sql_quiz);
	$row_quiz=mysqli_fetch_array($results_quiz);

	$target_file=$row_quiz['description'];

	$file=fopen($target_file,"w");
	fwrite($file, $description);
	fclose($file);

	$sql="UPDATE quiz SET title=$title, solving_time=$solving_time, start_event=$start_event, end_event=$end_event, lesson_group_id=$lesson_id, visibility=$visibility WHERE id LIKE $quiz_id";
	$results=mysqli_query($db,$sql);

	if($_SESSION['user_type']=="teacher")
		$link='location: Quiz_teacher.php?id='.$_SESSION['quiz'];
	else
		$link='location: Quiz.php?id='.$_SESSION['quiz'];
	header("$link");

}
else if($_GET["edit"]==2)//delete
{
	$quiz_id=$_SESSION['quiz'];
	$sql_select="SELECT * FROM question_order WHERE quiz_id LIKE $quiz_id";
	$results_select=mysqli_query($db,$sql_select);
	while($row_select=mysqli_fetch_array($results_select))
	{
		$answer_id=$row_select['answer_id'];
		$element=$row_select['element'];
		$element1='"'.$element.'"';

		if($element=="radio_button")
		{
			$sql="SELECT * FROM radio_button WHERE id LIKE $answer_id";
		}
		else if($element=="checkbox")
		{
			$sql="SELECT * FROM checkbox WHERE id LIKE $answer_id";
		}
		else if($element=="true_false")
		{
			$sql="SELECT * FROM true_false WHERE id LIKE $answer_id";
		}
		else if($element=="text")
		{
			$sql="SELECT * FROM text_question WHERE id LIKE $answer_id";
		}
		else if($element=="select")
		{
			$sql="SELECT * FROM select_question WHERE id LIKE $answer_id";
		}
		$results=mysqli_query($db,$sql);
		$row=mysqli_fetch_array($results);
		$file=$row['question'];
		unlink($file);

		$sql="DELETE FROM question_order WHERE element LIKE $element1 AND answer_id LIKE $answer_id";
		$results=mysqli_query($db,$sql);

		if($element=="radio_button" or $element=="checkbox")
			$sql="DELETE FROM quiz_option WHERE element LIKE $element1 AND question_id LIKE $answer_id";
		else if($element=="text")
			$sql="DELETE FROM text_answer WHERE text_question_id LIKE $answer_id";
		else if($element=="select")
			$sql="DELETE FROM select_option WHERE select_question_id LIKE $answer_id";
		$results=mysqli_query($db,$sql);

		if($element=="radio_button")
			$sql="DELETE FROM radio_button WHERE id LIKE $answer_id";
		else if($element=="checkbox")
			$sql="DELETE FROM checkbox WHERE id LIKE $answer_id";
		else if($element=="true_false")
			$sql="DELETE FROM true_false WHERE id LIKE $answer_id";
		else if($element=="text")
			$sql="DELETE FROM text_question WHERE id LIKE $answer_id";
		else if($element=="select")
			$sql="DELETE FROM select_question WHERE id LIKE $answer_id";
		$results=mysqli_query($db,$sql);
	}
	
	$sql="DELETE FROM quiz WHERE id LIKE $quiz_id";
	$results=mysqli_query($db,$sql);

	$link='location: Course_page.php?id='.$_SESSION['course_id'];
	header("$link");

}
else if($_GET["edit"]==3)//set add=1
{
	$_SESSION['lesson_id']=$_GET['lesson_id'];
	$_SESSION['add']=$_GET['add'];

	$link='location: Add_quiz.php';
	header("$link");
}
else if($_GET["edit"]==4)//set add=0
{
	$_SESSION['add']=$_GET['add'];

	$link='location: Add_quiz.php';
	header("$link");
}
else if($_GET["edit"]==5)//answer_type, add_answer
{
	$_SESSION['answer_type']=$_POST['answer_type'];
	$_SESSION['add_answer']=1;

	$link='location: Add_quiz_answer.php';
	header("$link");
}
else if($_GET["edit"]==6)//edit_answer
{
	$_SESSION['add_answer']=0;
	$_SESSION['answer_id']=$_GET['answer_id'];
	$_SESSION['element']=$_GET['element'];

	$link='location: Add_quiz_answer.php';
	header("$link");
}
else if($_GET["edit"]==7)//next/previous question
{
	if($_GET['next']==1)
		$_SESSION['question_order']++;
	else if($_GET['next']==0 and $_SESSION['question_order']>1)
		$_SESSION['question_order']--;
	else if($_GET['next']==2)
		$_SESSION['question_order']=$_GET['nr_question'];

	$link='location: Quiz.php';
	header("$link");
}
else if($_GET["edit"]==8)//add answer
{
	$quiz_id=$_SESSION['quiz'];
	$question=$_POST['question'];
	$point=$_POST['point'];

	if($_SESSION['answer_type']<5 and $_SESSION['answer_type']!=0)//radio button, checkbox
		$options=$_POST['option'];
	else if($_SESSION['answer_type']==7)//short text
		$answer=$_POST['answer_short_text'];
	else if($_SESSION['answer_type']==9)//select
	{
		$select_options=$_POST['select_option'];
		$group=$_POST['select_group'];
	}
	

	$solving_time=0;
	if(!empty($_POST['solving_time_min']))
		$solving_time=$solving_time+$_POST['solving_time_min']*60;
	else if(!empty($_POST['solving_time_sec']))
		$solving_time=$solving_time+$_POST['solving_time_sec'];

	$sql_quiz="SELECT * FROM question_order WHERE quiz_id LIKE $quiz_id";
	$results_quiz=mysqli_query($db,$sql_quiz);
	$max_order=mysqli_num_rows($results_quiz)+1;
	if($max_order>1)
		$order_number=$_POST['order_number'];
	else
		$order_number=1;


	$target_dir="Cours_items/Quiz/Question/";
	$user_id=$_SESSION['user_id'];
	$file_name=date("YmdHis").$user_id.'.txt';
	$target_file=$target_dir.$file_name;

	$file=fopen($target_file,"w");
	fwrite($file, $question);
	fclose($file);	

	if($_SESSION['answer_type']==1)//radio button classic
	{
		$element="radio_button";
		$sql="INSERT INTO radio_button (question,`point`,classic,quiz_id,solving_time) VALUES ('$target_file','$point','1','$quiz_id','$solving_time')";
	}
	else if($_SESSION['answer_type']==2)//radio button modern
	{
		$element="radio_button";
		$sql="INSERT INTO radio_button (question,`point`,classic,quiz_id,solving_time) VALUES ('$target_file','$point','0','$quiz_id','$solving_time')";
	}
	else if($_SESSION['answer_type']==3)//checkbox classic
	{
		$element="checkbox";
		$sql="INSERT INTO checkbox (question,`point`,classic,quiz_id,solving_time) VALUES ('$target_file','$point','1','$quiz_id','$solving_time')";
	}
	else if($_SESSION['answer_type']==4)//checkbox modern
	{
		$element="checkbox";
		$sql="INSERT INTO checkbox (question,`point`,classic,quiz_id,solving_time) VALUES ('$target_file','$point','0','$quiz_id','$solving_time')";
	}
	else if($_SESSION['answer_type']==5)// true/false classic
	{
		$element="true_false";
		$correct=$_POST['true_false'];
		$sql="INSERT INTO true_false (question,`point`,correct,quiz_id,classic,solving_time) VALUES ('$target_file','$point','$correct','$quiz_id','1','$solving_time')";

	}
	else if($_SESSION['answer_type']==6)//true/false modern
	{
		$element="false";
		$correct=$_POST['true_false'];
		$sql="INSERT INTO true_false (question,`point`,correct,quiz_id,classic,solving_time) VALUES ('$target_file','$point','$correct','$quiz_id','0','$solving_time')";
	}
	else if($_SESSION['answer_type']==7)//short text
	{
		$element="short_text";
		$sql="INSERT INTO text_question (question,`point`,short,quiz_id,solving_time) VALUES ('$target_file','$point','1','$quiz_id','$solving_time')";
	}
	else if($_SESSION['answer_type']==8)//long text
	{
		$element="text";
		$sql="INSERT INTO text_question (question,`point`,short,quiz_id,solving_time) VALUES ('$target_file','$point','0','$quiz_id','$solving_time')";
	}
	else if($_SESSION['answer_type']==9)//select
	{
		$element="select";
		$sql="INSERT INTO select_question (question,`point`,quiz_id,solving_time) VALUES ('$target_file','$point','$quiz_id','$solving_time')";
	}

	$results=mysqli_query($db,$sql);
	if($results)
		$answer_id = mysqli_insert_id($db);

	if($_SESSION['answer_type']<5 and $_SESSION['answer_type']!=0)//radio button, checkbox
	{
		for($i=0;$i<count($options);$i++)
		{
			$correct=0;
			$j=$i+1;
			if($_SESSION['answer_type']==1 or $_SESSION['answer_type']==2)
			{
				$_POST['option_check']."=".$j;
				if($_POST['option_check']==$j)
					$correct=1;
			}
			else if($_SESSION['answer_type']==3 or $_SESSION['answer_type']==4)
			{
				if(isset($_POST['option_check'.$j]))
					$correct=1;
			}

			$sql="INSERT INTO quiz_option (option,element,correct,question_id) VALUES ('$options[$i]','$element','$correct','$answer_id')";
			$results=mysqli_query($db,$sql);
		}
	}
	else if($_SESSION['answer_type']==7)//short text
	{
		foreach($answer as $i)
		{
			$sql="INSERT INTO text_answer (text_question_id,answer) VALUES ('$answer_id','$i')";
			$results=mysqli_query($db,$sql);
		}
	}
	else if($_SESSION['answer_type']==9)//select
	{
		
		for($i=0;$i<count($select_options);$i++)
		{
			$correct=0;
			if(isset($_POST['option_select_check'.$i]))
				$correct=1;

			$sql="INSERT INTO select_option (select_question_id,`option`,`group`,correct) VALUES ('$answer_id','$select_options[$i]','$group[$i]','$correct')";
			$results=mysqli_query($db,$sql);
		}
		
	}
	
	$sql_quiz="SELECT * FROM question_order WHERE quiz_id LIKE $quiz_id";
	$results_quiz=mysqli_query($db,$sql_quiz);
	$max_order=mysqli_num_rows($results_quiz)+1;

	if($max_order>$order_number)
	{
		$sql_update="UPDATE question_order SET order_number = order_number+1 WHERE order_number >= $order_number AND quiz_id LIKE $quiz_id";
		$results_update=mysqli_query($db,$sql_update);
	}
	$sql="INSERT INTO question_order (quiz_id,answer_id,element,order_number) VALUES ('$quiz_id','$answer_id','$element','$order_number')";
	$results=mysqli_query($db,$sql);
	

	$link='location: Quiz_teacher.php?id='.$_SESSION['quiz'];
	header("$link");
}
else if($_GET["edit"]==9)//edit answer
{
	$quiz_id=$_SESSION['quiz'];
	$answer_id=$_GET['answer_id'];
	$element=$_GET['element'];

	$question=$_POST['question'];
	$point=$_POST['point'];

	if($element=="radio_button" or $element=="checkbox")//radio button, checkbox
	{
		$options=$_POST['option'];
	}
	else if($element=="text")//short text
	{
		$answer=$_POST['answer_short_text'];
	}
	else if($element=="select")//select
	{
		$select_options=$_POST['select_option'];
		$group=$_POST['select_group'];
	}
	
	$solving_time=0;
	if(!empty($_POST['solving_time_min']))
		$solving_time=$solving_time+$_POST['solving_time_min']*60;
	else if(!empty($_POST['solving_time_sec']))
		$solving_time=$solving_time+$_POST['solving_time_sec'];

	$order_number=$_POST['order_number'];

	if($element=="radio_button")
	{
		$sql="SELECT * FROM radio_button WHERE id LIKE $answer_id";
	}
	else if($element=="checkbox")
	{
		$sql="SELECT * FROM checkbox WHERE id LIKE $answer_id";
	}
	else if($element=="true_false")
	{
		$sql="SELECT * FROM true_false WHERE id LIKE $answer_id";
	}
	else if($element=="text")
	{
		$sql="SELECT * FROM text_question WHERE id LIKE $answer_id";
	}
	else if($element=="select")
	{
		$sql="SELECT * FROM select_question WHERE id LIKE $answer_id";
	}
	$results=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($results);

	$target_file=$row['question'];
	$file=fopen($target_file,"w");
	fwrite($file, $question);
	fclose($file);

	if($element=="radio_button")
	{
		$sql_update="UPDATE radio_button SET `point`=$point, solving_time=$solving_time WHERE id LIKE $answer_id";
	}
	else if($element=="checkbox")
	{
		$sql_update="UPDATE checkbox SET `point`=$point, solving_time=$solving_time WHERE id LIKE $answer_id";
	}
	else if($element=="true_false")
	{
		$correct=$_POST['true_false'];
		$sql_update="UPDATE true_false SET `point`=$point, correct=$correct ,solving_time=$solving_time WHERE id LIKE $answer_id";
	}
	else if($element=="text")
	{
		$sql_update="UPDATE text_question SET `point`=$point, solving_time=$solving_time WHERE id LIKE $answer_id";
	}
	else if($element=="select")
	{
		$sql_update="UPDATE select_question SET `point`=$point, solving_time=$solving_time WHERE id LIKE $answer_id";
	}
	$results_update=mysqli_query($db,$sql_update);

	//option
	$element1='"'.$element.'"';
	if($element=="radio_button" or $element=="checkbox")//radio button, checkbox
	{
		$sql_option="SELECT * FROM quiz_option WHERE element LIKE $element1 AND question_id LIKE $answer_id";
		$results_option=mysqli_query($db,$sql_option);
		
		while($row_option=mysqli_fetch_array($results_option))//delete, update correct
		{
			$delete=1;
			for($i=0;$i<count($options);$i++)
			{
				if($row_option['option']==$options[$i])
				{
					$delete=0;

					$correct=0;
					$j=$i+1;
					if($element=="radio_button")
					{
						$_POST['option_check']."=".$j;
						if($_POST['option_check']==$j)
							$correct=1;
					}
					else if($element=="checkbox")
					{
						if(isset($_POST['option_check'.$j]))
							$correct=1;
					}
					if($row_option['correct']!=$correct)
					{
						$quiz_option_id=$row_option['id'];
						$sql_update="UPDATE quiz_option SET correct=$correct WHERE id LIKE $quiz_option_id";
						$results_update=mysqli_query($db,$sql_update);
					}
				}
			}
			if($delete==1)
			{
				$quiz_option_id=$row_option['id'];
				$sql_delete="DELETE FROM quiz_option WHERE id LIKE $quiz_option_id";
				$results_delete=mysqli_query($db,$sql_delete);
			}
		}

		for($i=0;$i<count($options);$i++)//insert
		{
			$insert=1;
			$results_option=mysqli_query($db,$sql_option);
			while($row_option=mysqli_fetch_array($results_option))
			{
				if($options[$i]==$row_option["option"])
					$insert=0;
			}
			if($insert==1)
			{
				$correct=0;
				$j=$i+1;
				if($element=="radio_button")
				{
					$_POST['option_check']."=".$j;
					if($_POST['option_check']==$j)
						$correct=1;
				}
				else if($element=="checkbox")
				{
					if(isset($_POST['option_check'.$j]))
						$correct=1;
				}

				$sql_insert="INSERT INTO quiz_option (option,element,correct,question_id) VALUES ('$options[$i]','$element','$correct','$answer_id')";
				$results_insert=mysqli_query($db,$sql_insert);
			}	
		}
	}
	else if($element=="text")
	{
		$sql_answer="SELECT * FROM text_answer WHERE text_question_id LIKE $answer_id";
		$results_answer=mysqli_query($db,$sql_answer);
		
		while($row_answer=mysqli_fetch_array($results_answer))//delete
		{
			$delete=1;
			foreach($answer as $i)
			{
				if($i==$row_answer["answer"])
					$delete=0;
			}
			if($delete==1)
			{
				$text_answer_id=$row_answer['id'];
				$sql_delete="DELETE FROM quiz_option WHERE id LIKE $text_answer_id";
				$results_delete=mysqli_query($db,$sql_delete);
			}
		}

		foreach($answer as $i)//insert
		{
			$insert=1;
			$results_answer=mysqli_query($db,$sql_answer);
			while($row_answer=mysqli_fetch_array($results_answer))
			{
				if($i==$row_answer["answer"])
					$insert=0;
			}
			if($insert==1)
			{
				$sql_insert="INSERT INTO text_answer (text_question_id,answer) VALUES ('$answer_id','$i')";
				$results_insert=mysqli_query($db,$sql_insert);
			}		
		}
	}
	else if($element=="select")
	{
		$sql_option="SELECT * FROM select_option WHERE select_question_id LIKE $answer_id";
		$results_option=mysqli_query($db,$sql_option);
		while($row_option=mysqli_fetch_array($results_option))
		{
			$delete=1;
			for($i=0;$i<count($select_options);$i++)
			{
				if($select_options[$i]==$row_option["option"] and $group[$i]==$row_option['group'])
				{
					$delete=0;

					$correct=0;
					if(isset($_POST['option_select_check'.$i]))
					{
						$correct=1;
					}
					if($row_option['correct']!=$correct)
					{
						$select_question_id=$row_option['id'];
						$group1='"'.$group[$i].'"';
						$sql_update="UPDATE select_option SET correct=$correct WHERE id LIKE $select_question_id";
						$results_update=mysqli_query($db,$sql_update);
					}
				}
			}
			if($delete==1)
			{
				$select_question_id=$row_option['id'];
				$sql_delete="DELETE FROM select_option WHERE id LIKE $select_question_id";
				$results_delete=mysqli_query($db,$sql_delete);
			}
		}


		for($i=0;$i<count($select_options);$i++)
		{
			$insert=1;
			$results_option=mysqli_query($db,$sql_option);
			while($row_option=mysqli_fetch_array($results_option))
			{
				if($select_options[$i]==$row_option["option"] and $group[$i]==$row_option['group'])
					$insert=0;
			}
			if($insert==1)
			{
				$correct=0;
				$j=$i+1;
				if(isset($_POST['option_select_check'.$j]))
					$correct=1;

				$sql_insert="INSERT INTO select_option (select_question_id,`option`,`group`,correct) VALUES ('$answer_id','$select_options[$i]','$group[$i]','$correct')";
				$results_insert=mysqli_query($db,$sql_insert);
			}
		}
	}

	//order
	$sql_select="SELECT * FROM question_order WHERE quiz_id LIKE $quiz_id";
	$results_select=mysqli_query($db,$sql_select);
	$row_select=mysqli_fetch_array($results_select);
	$old_order_number=$row_select["order_number"];

	if($old_order_number>$order_number)//move
	{
		$sql_update="UPDATE question_order SET order_number = order_number+1 WHERE order_number >= $order_number AND order_number < $old_order_number AND quiz_id LIKE $quiz_id";
		$results_update=mysqli_query($db,$sql_update);
	}
	else
	{
		$sql_update="UPDATE question_order SET order_number = order_number-1 WHERE order_number <= $order_number AND order_number > $old_order_number AND quiz_id LIKE $quiz_id";
		$results_update=mysqli_query($db,$sql_update);
	}

	$sql_update="UPDATE question_order SET order_number=$order_number WHERE answer_id LIKE $answer_id AND element LIKE $element1";
	$results_update=mysqli_query($db,$sql_update);

	$link='location: Quiz_teacher.php?id='.$_SESSION['quiz'];
	header("$link");
}
else if($_GET["edit"]==10)//delete answer
{
	$_SESSION['answer_id']=$_GET['answer_id'];
	$_SESSION['element']=$_GET['element'];

	$link='location: Quiz_teacher.php?id='.$_SESSION['quiz'].'#Delete_question';
	header("$link");
}
else if($_GET["edit"]==11)//delete answer
{
	$answer_id=$_SESSION['answer_id'];
	$element=$_SESSION['element'];
	$element1='"'.$element.'"';

	if($element=="radio_button")
	{
		$sql="SELECT * FROM radio_button WHERE id LIKE $answer_id";
	}
	else if($element=="checkbox")
	{
		$sql="SELECT * FROM checkbox WHERE id LIKE $answer_id";
	}
	else if($element=="true_false")
	{
		$sql="SELECT * FROM true_false WHERE id LIKE $answer_id";
	}
	else if($element=="text")
	{
		$sql="SELECT * FROM text_question WHERE id LIKE $answer_id";
	}
	else if($element=="select")
	{
		$sql="SELECT * FROM select_question WHERE id LIKE $answer_id";
	}
	$results=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($results);
	$file=$row['question'];
	unlink($file);

	$sql="DELETE FROM question_order WHERE element LIKE $element1 AND answer_id LIKE $answer_id";
	$results=mysqli_query($db,$sql);

	if($element=="radio_button" or $element=="checkbox")
		$sql="DELETE FROM quiz_option WHERE element LIKE $element1 AND question_id LIKE $answer_id";
	else if($element=="text")
		$sql="DELETE FROM text_answer WHERE text_question_id LIKE $answer_id";
	else if($element=="select")
		$sql="DELETE FROM select_option WHERE select_question_id LIKE $answer_id";
	$results=mysqli_query($db,$sql);

	if($element=="radio_button")
		$sql="DELETE FROM radio_button WHERE id LIKE $answer_id";
	else if($element=="checkbox")
		$sql="DELETE FROM checkbox WHERE id LIKE $answer_id";
	else if($element=="true_false")
		$sql="DELETE FROM true_false WHERE id LIKE $answer_id";
	else if($element=="text")
		$sql="DELETE FROM text_question WHERE id LIKE $answer_id";
	else if($element=="select")
		$sql="DELETE FROM select_question WHERE id LIKE $answer_id";
	$results=mysqli_query($db,$sql);

	$link='location: Quiz_teacher.php?id='.$_SESSION['quiz'];
	header("$link");
}