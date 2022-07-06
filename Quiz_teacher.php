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
    			<li class="breadcrumb-item active" aria-current="page">Quiz view</li>
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
			    	$_SESSION['question_order']=1;
				    $_SESSION['quiz']=$quiz_id;
					$sql="SELECT * FROM quiz WHERE id LIKE $quiz_id";
					$results=mysqli_query($db,$sql);
					$row=mysqli_fetch_array($results);

					if($_SESSION['user_type']!="student" and $row['visibility']==0){?>
						<h3><b><?php echo $row['title']; ?></b><i class="bi bi-eye-slash ms-4"></i></h3>
					<?php } else { ?>
						<h3><b><?php echo $row['title']; ?></b></h3>
					<?php } ?>


					<a href="Quiz.php" class="btn btn-success btn-sm me-2 mb-3"><i class="bi bi-play-fill"></i> Start quiz</a>
					<a href="Quiz_solve_table.php" class="btn btn-primary btn-sm me-2 mb-3"><i class="bi bi-check-circle"></i> Rezolvări</a>
					<a href="Add_quiz1.php?edit=4&add=0" class="btn btn-primary btn-sm me-2 mb-3"><i class="bi bi-pencil-square"></i> Editează</a>
					<button class="btn btn-danger btn-sm mb-3" data-bs-toggle="modal" data-bs-target="#Delete_quiz"><i class="bi bi-trash"></i> Șterge</button>

					<div>
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
					<div class="mt-3">
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

			    		echo 'Început: <b>'.$start_event.'</b><br>';
						echo 'Final: <b>'.$end_event.'</b>';
						?>
					</div>
					<div class="mt-3">
						<hr>
						<?php
						$sql_order="SELECT * FROM question_order WHERE quiz_id LIKE $quiz_id ORDER BY order_number";
						$results_order=mysqli_query($db,$sql_order);
						while($row_order=mysqli_fetch_array($results_order))
						{
							$answer_id=$row_order['answer_id'];
							$element=$row_order['element'];
							if($element=="radio_button")
							{
								$sql_answer="SELECT * FROM radio_button WHERE id LIKE $answer_id";
							}
							else if($element=="checkbox")
							{
								$sql_answer="SELECT * FROM checkbox WHERE id LIKE $answer_id";
							}
							else if($element=="true_false")
							{
								$sql_answer="SELECT * FROM true_false WHERE id LIKE $answer_id";
							}
							else if($element=="text")
							{
								$sql_answer="SELECT * FROM text_question WHERE id LIKE $answer_id";
							}
							else if($element=="select")
							{
								$sql_answer="SELECT * FROM select_question WHERE id LIKE $answer_id";
							}

							$results_answer=mysqli_query($db,$sql_answer);
							$row_answer=mysqli_fetch_array($results_answer); ?>

							<div class="mt-3">
								<div class="d-flex justify-content-between">
									<div>
									<?php //question
									echo '<b>'.$row_order['order_number'].'. </b>';
									$target_file=$row_answer['question'];
									$file = fopen($target_file, "r");
									echo fgets($file)."<br>";
									echo '<div class="ms-3">';
									while(!feof($file)) {
						  				echo fgets($file)."<br>";
									}
									echo '</div>';
									fclose($file);
								    ?>
							    	</div>
								    <div>
								    	<?php echo '<a href="Add_quiz1.php?edit=6&answer_id='.$answer_id.'&element='.$element.'" class="btn btn-primary btn-sm me-2"><i class="bi bi-pencil-square"></i></a>';
										echo '<a href="Add_quiz1.php?edit=10&answer_id='.$answer_id.'&element='.$element.'" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></a>'; ?>
								    </div>
							    </div>
							</div>

							<div class="mt-3 mx-4">
								<?php
								if($element=="radio_button" or $element=="checkbox")
								{
									$question_id=$row_order['id'];
									$element1='"'.$element.'"';
									$sql_option="SELECT * FROM quiz_option WHERE element LIKE $element1 AND question_id LIKE $answer_id";
									$results_option=mysqli_query($db,$sql_option);
									$nr_option=0;
									$max_option=mysqli_num_rows($results_option)-1;
									while($row_option=mysqli_fetch_array($results_option))
									{
										if($element=="radio_button")//radio button
										{
											if($row_answer['classic']==1)
											{ ?>
												<div class="form-check">

													<?php if($row_option['correct']==0){ ?>
				  										<input class="form-check-input" type="radio" value="" id="option" disabled>
				  									<?php } else { ?>
														<input class="form-check-input" type="radio" value="" id="option" checked disabled>
				  									<?php } ?>

													<label class="form-check-label" for="option"><?php echo $row_option['option']; ?></label>
												</div>
											<?php } else { ?>
												<?php 
												$color=array("btn-outline-primary","btn-outline-success","btn-outline-warning","btn-outline-danger");
												if($nr_option==0)
												{
													echo '<div class="d-flex justify-content-between">';
												} ?>

												<div class="form-check">
													<?php
													if($row_option['correct']==0){ ?>
					  									<input class="btn-check" type="radio" value="" id="option" disabled>
					  								<?php } else { ?>
														<input class="btn-check" type="radio" value="" id="option" checked disabled>
					  								<?php } ?>

													<?php echo '<label class="btn '.$color[$nr_option].' btn-lg" for="option" style="width: 30vw;border-width:4px">'.$row_option['option'].'</label>'; ?>
												</div>

												<?php
												if($nr_option==1 and $nr_option<$max_option)
												{
													echo '</div>';
													echo '<div class="d-flex justify-content-between mt-3">';
												}
												else if($nr_option==$max_option)
												{
													echo '</div>';
												}
												$nr_option++;
											}
										}
								//checkbox		
										else if($element=="checkbox")
										{

											if($row_answer['classic']==1)
											{ ?>
												<div class="form-check">
													
													<?php if($row_option['correct']==0){ ?>
				  										<input class="form-check-input" type="checkbox" value="" id="flexCheckDisabled" disabled>
				  									<?php } else { ?>
														<input class="form-check-input" type="checkbox" value="" id="flexCheckDisabled" checked disabled>
				  									<?php } ?>

													<label class="form-check-label" for="flexCheckDisabled"><?php echo $row_option['option']; ?></label>
												</div>
											<?php } else { ?>
												<?php 
												$color=array("btn-outline-primary","btn-outline-success","btn-outline-warning","btn-outline-danger");
												if($nr_option==0)
												{
													echo '<div class="d-flex justify-content-between">';
												} ?>

												<div class="form-check">
													<?php
													if($row_option['correct']==0){ ?>
					  									<input class="btn-check" type="checkbox" value="" id="option" disabled>
					  								<?php } else { ?>
														<input class="btn-check" type="checkbox" value="" id="option" checked disabled>
					  								<?php } ?>

													<?php echo '<label class="btn '.$color[$nr_option].' btn-lg" for="option" style="width: 30vw;border-width:4px">'.$row_option['option'].'</label>'; ?>
												</div>

												<?php
												if($nr_option==1 and $nr_option<$max_option)
												{
													echo '</div>';
													echo '<div class="d-flex justify-content-between mt-3">';
												}
												else if($nr_option==$max_option)
												{
													echo '</div>';
												}
												$nr_option++;
											}

										}	
									}
									
								} 
								else if($element=="true_false")// true/false
								{
									if($row_answer['classic']==1)
									{ 
										if($row_answer['correct']==1){ ?>
											<div class="form-check">
				  								<input class="form-check-input" type="radio" value="1" id="true" disabled checked>
												<label class="form-check-label" for="true">Adevărat</label>
											</div>
											<div class="form-check">
				  								<input class="form-check-input" type="radio" value="0" id="false" disabled>
												<label class="form-check-label" for="false">Fals</label>
											</div>
				  						<?php } else { ?>
											<div class="form-check">
				  								<input class="form-check-input" type="radio" value="1" id="true" disabled>
												<label class="form-check-label" for="true">Adevărat</label>
											</div>
											<div class="form-check">
				  								<input class="form-check-input" type="radio" value="0" id="false" disabled checked>
												<label class="form-check-label" for="false">Fals</label>
											</div>
				  						<?php }
				  					} 
				  					else
				  					{ ?>
				  						<div class="d-flex justify-content-between">
					  						<?php if($row_answer['correct']==1){ ?>
												<div class="form-check">
													<input class="btn-check" type="radio" value="1" id="true" disabled checked>
													<label class="btn btn-outline-success btn-lg" for="option" style="width: 30vw;border-width:4px">Adevărat</label>
												</div>
												<div class="form-check">
					  								<input class="btn-check" type="radio" value="1" id="true" disabled>
													<label class="btn btn-outline-danger btn-lg" for="option" style="width: 30vw;border-width:4px">Fals</label>
												</div>
					  						<?php } else { ?>
												<div class="form-check">
					  								<input class="btn-check" type="radio" value="1" id="true" disabled>
													<label class="btn btn-outline-success btn-lg" for="option" style="width: 30vw;border-width:4px">Adevărat</label>
												</div>
												<div class="form-check">
					  								<input class="btn-check" type="radio" value="1" id="true" disabled checked>
													<label class="btn btn-outline-danger btn-lg" for="option" style="width: 30vw;border-width:4px">Fals</label>
												</div>
					  						<?php } ?>
					  					</div>
				  					<?php }
								}
								else if($element=="text")//short text
								{ 
									if($row_answer['short']==1){ ?>
										<b>Posibile răspunsuri:</b><br>
										<ul>
											<?php
											$sql_answer_option="SELECT * FROM text_posible_answer WHERE text_question_id LIKE $answer_id";
											$results_answer_option=mysqli_query($db,$sql_answer_option);
											while($row_answer_option=mysqli_fetch_array($results_answer_option))
											{
												echo '<li>'.$row_answer_option['answer']."</li>";
											} ?>
										</ul>
									<?php } 
								} 
								else if($element=="select")//select
								{
									$sql_select="SELECT * FROM select_option WHERE select_question_id LIKE $answer_id ORDER BY `group`";
									$results_select=mysqli_query($db,$sql_select);
									$i=0;

									while($row_select=mysqli_fetch_array($results_select))
									{
										if($i==0)
										{
											$group[$i]=$row_select['group'];
											$i++;
										}
										else if($group[$i-1]!=$row_select['group'])
										{
											$group[$i]=$row_select['group'];
											$i++;
										}
									}
									foreach($group as $i)
									{
										$i='"'.$i.'"';
										$sql_select="SELECT * FROM select_option WHERE select_question_id LIKE $answer_id AND `group` LIKE $i ORDER BY RAND()";
										$results_select=mysqli_query($db,$sql_select); ?>

										<select class="form-select mt-3" aria-label="Default select example" id="select" name="select[]">
											<?php while($row_select=mysqli_fetch_array($results_select))
											{ 
												echo '<option>'.$row_select["option"].'</option>';
											} ?>
										</select>
										<?php 
										$first=1;
										echo '<b>Răspuns corect:</b> ';
										$results_select=mysqli_query($db,$sql_select);
										while($row_select=mysqli_fetch_array($results_select))
										{
											if($row_select["correct"]==1)
											{
												if($first==1)
													echo $row_select['option'];
												else
													echo ' ,'.$row_select['option'];
											}
										}
									}
								}
								?>
								
							</div>
							
							<div class="mt-2">
								<?php
								if($row['solving_time']==0){ 
									if($row_answer['solving_time']>0)
									{
										$solving_time=$row_answer["solving_time"];
								    	$solving_time_min=intdiv($solving_time,60);
								    	$solving_time_sec=$solving_time%60;
								    	if($solving_time_min<10)
								    		$solving_time_min="0".$solving_time_min;
								    	else if($solving_time_min==0)
								    		$solving_time_min="00";
								    	if($solving_time_sec<10)
								    		$solving_time_sec="0".$solving_time_sec;
								    	else if($solving_time_sec==0)
								    		$solving_time_sec="00";
									}
								}?>
								<div class="d-flex justify-content-between">
									<?php
									if($row['solving_time']==0)
										echo "<i>Timp: <b>".$solving_time_min.':'.$solving_time_sec."</b></i>";
									else
										echo "<i></i>";
									echo "<i>Puncte: <b>".$row_answer['point']."</b></i>";
									?>
								</div>
							</div>
							<hr>

						<?php }//while ?>

						<div class="d-grid mb-3">
							<button class="btn btn-secondary btn-block" data-bs-toggle="modal" data-bs-target="#Answer_type"><i class="bi bi-plus-circle me-2"></i>Adaugă întrebare</button>
						</div>
					</div>

				</div>
			</div>
		</div>

		<!--Modal--Delete-quiz--->
		<div class="modal fade" id="Delete_quiz">
		  	<div class="modal-dialog">
		    	<div class="modal-content">

		      		<!-- Modal Header -->
		      		<div class="modal-header">
		        		<h4 class="modal-title">Șterge quiz</h4>
		        		<button type="button" class="btn-close" data-bs-dismiss="modal" data-bs-target="#Delete_quiz"></button>
		      		</div>

		      		<!-- Modal body -->
		      		<div class="modal-body">
		      			<div class="d-flex justify-content-center">
		      				<p><b>Doriti să ștergeți quizul?</b></p>
		      			</div>
		      			<div class="d-flex justify-content-around">
		      				<div class="d-grid gap-1 col-4">
		      					<a href="Add_quiz1.php?edit=2" class="btn btn-danger">Da</a>
		      				</div>
		      				<div class="d-grid gap-1 col-4">
		      					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" data-bs-target="#Delete_lesson_group">Nu</button>
		      				</div>
		      			</div>
		      		</div>

		    	</div>
		  	</div>
		</div>
		<!--Modal--Delete-question--->
		<div class="modal fade" id="Delete_question">
		  	<div class="modal-dialog">
		    	<div class="modal-content">

		      		<!-- Modal Header -->
		      		<div class="modal-header">
		        		<h4 class="modal-title">Șterge întrebare</h4>
		        		<button type="button" class="btn-close" data-bs-dismiss="modal" data-bs-target="#Delete_question"></button>
		      		</div>

		      		<!-- Modal body -->
		      		<div class="modal-body">
		      			<div class="d-flex justify-content-center">
		      				<p><b>Doriti să ștergeți întrebarea?</b></p>
		      			</div>
		      			<div class="d-flex justify-content-around">
		      				<div class="d-grid gap-1 col-4">
		      					<a href="Add_quiz1.php?edit=11" class="btn btn-danger">Da</a>
		      				</div>
		      				<div class="d-grid gap-1 col-4">
		      					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" data-bs-target="#Delete_lesson_group">Nu</button>
		      				</div>
		      			</div>
		      		</div>

		    	</div>
		  	</div>
		</div>
		<!--Modal-Answer-type--->
		<div class="modal fade" id="Answer_type" role="dialog">
		  	<div class="modal-dialog">
		    	<div class="modal-content">

		      		<!-- Modal Header -->
		      		<div class="modal-header">
		        		<h4 class="modal-title">Tip întrebare</h4>
		        		<button type="button" class="btn-close" data-bs-dismiss="modal" data-bs-target="#Answer_type"></button>
		      		</div>

		      		<!-- Modal body -->
		      		<div class="modal-body">
		      			<?php $_SESSION['add']=0 ?>
		      			<form action="Add_quiz1.php?edit=5" method="post">
			      			<div class="mt-3">
								<label for="answer_type" class="form-label"><b>Tip de răspuns:</b></label>
								<select class="form-select" id="answer_type" name="answer_type">
								  	<option value="1">Radiobutton clasic</option>
								  	<option value="2">Radiobutton modern</option>
								  	<option value="3">Checkbox clasic</option>
								  	<option value="4">Checkbox modern</option>
								  	<option value="5">True/False clasic</option>
								  	<option value="6">True/False modern</option>
								  	<option value="7">Text scurt</option>
								  	<option value="8">Text lung</option>
								  	<option value="9">Select</option>
								</select>
							</div>
							<div class="d-grid mt-3">
							    <button type="submit" class="btn btn-secondary btn-block">Adaugă întrebare</button>
							</div>
						</form>
		      		</div>

		    	</div>
		  	</div>
		</div>

	</body>
</html>
<?php $url="'".$_SERVER['REQUEST_URI']."'"; ?>
<!--Modal-->
<script type="text/javascript">
	$(document).ready(function() {
		var url=<?php echo $url; ?>;
	    if(window.location.href.indexOf('#Delete_question') != -1) {
	        $('#Delete_question').modal('show');
	        window.history.pushState('', 'Quiz_teacher', url);
	    }
	});
</script>