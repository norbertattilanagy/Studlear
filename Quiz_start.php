<?php include 'Connection.php'; ?>
<?php include 'Page_security.php'; ?>
<!doctype html>
<html lang="en">
  	<head>
	    <!-- Required meta tags -->
	    <meta charset="utf-8">
	    <meta http-equiv="x-ua-compatible" content="ie=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1"/>
	    <!-- Bootstrap CSS -->
	    <link href="assets\css\bootstrap.min.css" rel="stylesheet"/>
	    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
	    <script src="assets\js\bootstrap.bundle.min.js"></script>
	    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
	    <title>Studlearn</title>
	</head>
	<body>
		<!--Top bar-->
    	<?php include 'Top_bar.php' ?>

    	<?php 
    	$quiz_id=$_GET['id'];
    	if(empty($_SESSION['course_id']))
    	{
    		$sql="SELECT * FROM quiz AS q JOIN lesson_group AS lg ON q.lesson_group_id=lg.id WHERE q.id LIKE $quiz_id";
    		$results=mysqli_query($db,$sql);
			$row=mysqli_fetch_array($results);
			$_SESSION['course_id']=$row['course_id'];
    	}
    	?>

    	<nav class="mx-3" aria-label="breadcrumb">
  			<ol class="breadcrumb">
  		  		<?php
  		  		if($_SESSION['user_type']=="admin")
  					echo '<li class="breadcrumb-item"><a href="Search_courses.php" style="text-decoration: none;">Căutare curs</a></li>';
  				else
  		  			echo '<li class="breadcrumb-item"><a href="Home_page.php" style="text-decoration: none;">Acasă</a></li>';
  		  		echo '<li class="breadcrumb-item"><a href="Course_page.php?id='.$_SESSION['course_id'].'" style="text-decoration: none;">Curs</a></li>'; ?>
    			<li class="breadcrumb-item active" aria-current="page">Start quiz</li>
  			</ol>
		</nav>
		<div class="row">

    		<!--Courses group-->
		    <div class="col-md-3">
		    	<?php include 'Courses_group.php' ?>
		    </div>
		    <div class="col-md-9">
		    	<div class="mx-3 mb-3">
			    	<?php
				    $_SESSION['quiz']=$quiz_id;
				    $_SESSION['question_order']=1;
			    	$sql="SELECT * FROM quiz WHERE id LIKE $quiz_id";
					$results=mysqli_query($db,$sql);
					$row=mysqli_fetch_array($results);
			    	?>
			    	<h3><b><?php echo $row['title']; ?></b></h3>

			    	<hr>

			    	<div class="text-center mt-3">
						<p>
							<?php
							$target_file=$row['description'];
							$file = fopen($target_file, "r");
							while(!feof($file)) {
			  					echo fgets($file)."<br>";
							}
							fclose($file);
					    	?>
						</p>
					</div>
					<div class="text-center mt-3">
						<?php 
						if($row['solving_time']>0)
						{
							$solving_time=$row["solving_time"];
				    		$solving_time_hour=intdiv($solving_time,3600);
				    		$solving_time=$solving_time%3600;
				    		$solving_time_min=intdiv($solving_time,60);
				    		$solving_time_sec=$solving_time%60;

				    		if($solving_time_hour<10)
				    			$solving_time_hour="0".$solving_time_hour;
				    		else if($solving_time_hour==0)
				    			$solving_time_hour="00";

				    		if($solving_time_min<10)
				    			$solving_time_min="0".$solving_time_min;
				    		else if($solving_time_min==0)
				    			$solving_time_min="00";

				    		if($solving_time_sec<10)
				    			$solving_time_sec="0".$solving_time_sec;
				    		else if($solving_time_sec==0)
				    			$solving_time_sec="00";

							echo 'Timp de rezolvare: <b>'.$solving_time_hour.':'.$solving_time_min.':'.$solving_time_sec.'</b><br>';
						}

						$start_event=date_create($row['start_event']);
			    		$start_event=date_format($start_event,"Y.m.d. H:i");
			    		$end_event=date_create($row['end_event']);
			    		$end_event=date_format($end_event,"Y.m.d. H:i");
			    		$today=date("Y.m.d. H:i");

			    		echo 'Început: <b>'.$start_event.'</b><br>';
						echo 'Final: <b>'.$end_event.'</b>';

						//point,resolved verification
						$resolved=0;
					    $sql_verify="SELECT * FROM question_order WHERE quiz_id LIKE $quiz_id ORDER BY order_number";
						$results_verify=mysqli_query($db,$sql_verify);
				    	$user_id=$_SESSION['user_id'];
				  		$point=0;
				  		$max_point=0;
				    	while($row_verify=mysqli_fetch_array($results_verify))
				    	{
					    	$answer_id=$row_verify['answer_id'];
					    	if($row_verify['element']=="radio_button")
							{
								$sql_answer="SELECT * FROM answer_quiz_option WHERE quiz_option_id IN (SELECT id FROM quiz_option WHERE question_id LIKE $answer_id AND element LIKE 'radio_button') AND user_id LIKE $user_id";
								$results_answer=mysqli_query($db,$sql_answer);
								$row_answer=mysqli_fetch_array($results_answer);
								if(isset($row_answer['point']))
								{
									$resolved=1;
									$point+=$row_answer['point'];
								}
								$sql_max_point="SELECT `point` FROM radio_button WHERE id LIKE $answer_id LIMIT 1";
								$results_max_point=mysqli_query($db,$sql_max_point);
								$row_max_point=mysqli_fetch_array($results_max_point);
								$max_point+=$row_max_point['point'];
							}
							else if($row_verify['element']=="checkbox")
							{
								$sql_answer="SELECT * FROM answer_quiz_option WHERE quiz_option_id IN (SELECT id FROM quiz_option WHERE question_id LIKE $answer_id AND element LIKE 'checkbox') AND user_id LIKE $user_id LIMIT 1";
								$results_answer=mysqli_query($db,$sql_answer);
								$row_answer=mysqli_fetch_array($results_answer);
								if(isset($row_answer['point']))
								{
									$resolved=1;
									$point+=$row_answer['point'];
								}
								$sql_max_point="SELECT `point` FROM checkbox WHERE id LIKE $answer_id LIMIT 1";
								$results_max_point=mysqli_query($db,$sql_max_point);
								$row_max_point=mysqli_fetch_array($results_max_point);
								$max_point+=$row_max_point['point'];
							}
							else if($row_verify['element']=="true_false")
							{
								$sql_answer="SELECT * FROM answer_true_false WHERE true_false_id IN (SELECT id FROM true_false WHERE id LIKE $answer_id) AND user_id LIKE $user_id";
								$results_answer=mysqli_query($db,$sql_answer);
								$row_answer=mysqli_fetch_array($results_answer);
								if(isset($row_answer['point']))
								{
									$resolved=1;
									$point+=$row_answer['point'];
								}
								$sql_max_point="SELECT `point` FROM true_false WHERE id LIKE $answer_id LIMIT 1";
								$results_max_point=mysqli_query($db,$sql_max_point);
								$row_max_point=mysqli_fetch_array($results_max_point);
								$max_point+=$row_max_point['point'];
							}
							else if($row_verify['element']=="text")
							{
								$sql_answer="SELECT * FROM answer_text_question WHERE text_question_id IN (SELECT id FROM text_question WHERE id LIKE $answer_id) AND user_id LIKE $user_id";
								$results_answer=mysqli_query($db,$sql_answer);
								$row_answer=mysqli_fetch_array($results_answer);
								if(isset($row_answer['point']))
								{
									$resolved=1;
									$point+=$row_answer['point'];
								}
								$sql_max_point="SELECT `point` FROM text_question WHERE id LIKE $answer_id LIMIT 1";
								$results_max_point=mysqli_query($db,$sql_max_point);
								$row_max_point=mysqli_fetch_array($results_max_point);
								$max_point+=$row_max_point['point'];
							}
							else if($row_verify['element']=="select")
							{
								$sql_answer="SELECT * FROM answer_select_question WHERE select_option_id IN (SELECT id FROM select_option WHERE select_question_id LIKE $answer_id) AND user_id LIKE $user_id";
								$results_answer=mysqli_query($db,$sql_answer);
								$row_answer=mysqli_fetch_array($results_answer);
								if(isset($row_answer['point']))
								{
									$resolved=1;
									$point+=$row_answer['point'];
								}
								$sql_max_point="SELECT `point` FROM select_question WHERE id LIKE $answer_id LIMIT 1";
								$results_max_point=mysqli_query($db,$sql_max_point);
								$row_max_point=mysqli_fetch_array($results_max_point);
								$max_point+=$row_max_point['point'];
							}
						}
						if($resolved==0){ ?>
							</div>
							<?php 
							//if($start_event<$today and $today<$end_event){ ?>
								<div class="d-grid mt-3">
									<a class="btn btn-secondary" href="Quiz.php">Start quiz</a>
								</div>
							<?php //}
						} 
						else 
						{
							echo '<br>Puncte: <b>'.$point.' / '.$max_point.'</b>';
							echo '</div>';
							echo '<div class="d-grid mt-3">';
								echo '<a class="btn btn-secondary" href="Quiz_solve.php?id='.$_SESSION['user_id'].'">Vizualizare quiz</a>';
							echo '</div>';
						}
						?>
						
					
				</div>
		    </div>
		</div>

	</body>
</html>