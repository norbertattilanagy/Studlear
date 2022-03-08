<?php include 'Conection.php'; ?>
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
	    <title>Course</title>
	</head>
	<body onload="timer()">
		<!--Top bar-->
    	<?php include 'Top_bar.php' ?>

    	<nav class="ms-4" aria-label="breadcrumb">
  			<ol class="breadcrumb">
  		  		<li class="breadcrumb-item"><a href="Home_page.php" style="text-decoration: none;">Acasă</a></li>
  		  		<?php echo '<li class="breadcrumb-item"><a href="Course_page.php?id='.$_SESSION['course_id'].'" style="text-decoration: none;">Curs</a></li>'; ?>
  		  		<?php echo '<li class="breadcrumb-item"><a href="Quiz_student.php?id='.$_SESSION['quiz'].'" style="text-decoration: none;">Start quiz</a></li>'; ?>
    			<li class="breadcrumb-item active" aria-current="page">Quiz</li>
  			</ol>
		</nav>
		<div class="row">
			<div class="col-9">
				<div class="ms-4">
					<?php
						$question_order=$_SESSION['question_order'];
						$quiz_id=$_SESSION['quiz'];
						$sql="SELECT * FROM question_order WHERE quiz_id LIKE $quiz_id AND order_number LIKE $question_order";
						$results=mysqli_query($db,$sql);
						$row=mysqli_fetch_array($results);
						$answer_id=$row['answer_id'];

						if($row['element']=="radio_button")
						{
							$sql_answer="SELECT * FROM radio_button WHERE id LIKE $answer_id";
						}
						else if($row['element']=="checkbox")
						{
							$sql_answer="SELECT * FROM checkbox WHERE id LIKE $answer_id";
						}
						else if($row['element']=="true_false")
						{
							$sql_answer="SELECT * FROM true_false WHERE id LIKE $answer_id";
						}
						else if($row['element']=="text")
						{
							$sql_answer="SELECT * FROM text_question WHERE id LIKE $answer_id";
						}
						else if($row['element']=="select")
						{
							$sql_answer="SELECT * FROM select_question WHERE id LIKE $answer_id";
						}
						$results_answer=mysqli_query($db,$sql_answer);
						$row_answer=mysqli_fetch_array($results_answer);

						if($row_answer['solving_time']>0)
						{
							$solving_time=$row_answer["solving_time"];
							$solving_time_min=intdiv($solving_time,60);
			    			$solving_time_sec=$solving_time%60;
						}
					?>
					<div class="card" style="height: 50vh;">
					  	<div class="card-header">
					  		<div style="font-size: 18px;">
					  			<?php echo '<b>Întrebarea '.$question_order.'</b>'; ?>
					  		</div>
					  	</div>
					  	<div class="card-body text-center" ><b>
							<?php //question
							$target_file=$row_answer['question'];
							$file = fopen($target_file, "r");
							echo fgets($file)."<br>";
							while(!feof($file)) {
				  				echo fgets($file)."<br>";
							}
							fclose($file);
						    ?>
						</b></div>
						<br>

						<div class="mx-4 mb-5">
							<?php
							if($row['element']=="radio_button" or $row['element']=="checkbox")
							{
								$question_id=$row['id'];
								$element='"'.$row['element'].'"';
								$sql_option="SELECT * FROM quiz_option WHERE element LIKE $element AND question_id LIKE $answer_id ORDER BY RAND()";
								$results_option=mysqli_query($db,$sql_option);
								$nr_option=0;
								$max_option=mysqli_num_rows($results_option)-1;
								while($row_option=mysqli_fetch_array($results_option))
								{
									if($row['element']=="radio_button")//radio button
									{
										if($row_answer['classic']==1)
										{ ?>
											<div class="form-check mx-5">
			  									<input class="form-check-input" type="radio" value="" id="option">
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
				  								<input class="btn-check" type="radio" value="" id="option">
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
									else if($row['element']=="checkbox")
									{

										if($row_answer['classic']==1)
										{ ?>
											<div class="form-check mx-5">
			  									<input class="form-check-input" type="checkbox" value="" id="checkbox">
												<label class="form-check-label" for="checkbox"><?php echo $row_option['option']; ?></label>
											</div>
										<?php } else { ?>
											<?php 
											$color=array("btn-outline-primary","btn-outline-success","btn-outline-warning","btn-outline-danger");
											if($nr_option==0)
											{
												echo '<div class="d-flex justify-content-between">';
											} ?>

											<div class="form-check">
				  								<input class="btn-check" type="checkbox" value="" id="option">
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
							else if($row['element']=="true_false")// true/false
							{
								if($row_answer['classic']==1)
								{ ?>
									<div class="form-check mx-5 ">
			  							<input class="form-check-input" type="radio" value="1" id="true">
										<label class="form-check-label" for="true">Adevărat</label>
									</div>
									<div class="form-check mx-5 mb-5">
			  							<input class="form-check-input" type="radio" value="0" id="false">
										<label class="form-check-label" for="false">Fals</label>
									</div>
			  					<?php } 
			  					else
			  					{ ?>
			  						<div class="d-flex justify-content-between">
										<div class="form-check">
			  								<input class="btn-check" type="radio" value="1" id="true">
											<label class="btn btn-outline-success btn-lg" for="option" style="width: 30vw;border-width:4px">Adevărat</label>
										</div>
										<div class="form-check">
			  								<input class="btn-check" type="radio" value="1" id="true">
											<label class="btn btn-outline-danger btn-lg" for="option" style="width: 30vw;border-width:4px">Fals</label>
										</div>
				  					</div>
			  					<?php }
							}
							else if($row['element']=="text")//short text
							{ 
								if($row_answer['short']==1){ ?>
									<div class="mx-5 mb-5">
										<input type="text" class="form-control" id="short_text" name="short_text">
									</div>
								<?php } else { ?>
									<div class="mx-5">
										<textarea class="form-control" id="short_text" name="short_text" rows="3"></textarea>
									</div>
								<?php } 
							}
							else if($row['element']=="select")//select
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
									<div class="mx-5">
										<select class="form-select mt-3 " aria-label="Default select example" id="select" name="select[]">
											<?php while($row_select=mysqli_fetch_array($results_select))
											{ 
												echo '<option>'.$row_select["option"].'</option>';
											} ?>
										</select>
									</div>
								<?php }
							}
							?>
							
						</div>

					</div>
				</div>


			</div>
			<div class="col-3">

				<h3 class="mb-3" id="showtime" style="text-align: center;"></h3>
				<?php
				/*
					$sql_quiz="SELECT * FROM quiz WHERE id LIKE $quiz_id";
					$results_quiz=mysqli_query($db,$sql_quiz);
					$row_quiz=mysqli_fetch_array($results_quiz);
					if($row_quiz['solving_time']>0)
					{
						$solving_time=$row_quiz["solving_time"];
			    		$solving_time_hour=intdiv($solving_time,3600);
			    		$solving_time=$solving_time%3600;
			    		$solving_time_min=intdiv($solving_time,60);
			    		$solving_time_sec=$solving_time%60;
					}
				*/
					$sql_question="SELECT * FROM question_order WHERE quiz_id LIKE $quiz_id";
					$results_question=mysqli_query($db,$sql_question);
					$nr_row=mysqli_num_rows($results_question);
					while($row_question=mysqli_fetch_array($results_question))
					{
						if($row_question['order_number']!=$_SESSION['question_order'])
							echo '<a href="Add_quiz1.php?edit=7&next=2&nr_question='.$row_question['order_number'].'" class="btn btn-outline-dark me-2 mb-2" style="width: 50px;">'.$row_question['order_number'].'</a>';
						else
							echo '<button type="button" class="btn btn-dark disabled me-2 mb-2" style="width: 50px;">'.$row_question['order_number'].'</button>';
					}	
				?>
			</div>

			<div class="row mt-3">
				<div class="col-6">
					<div class="d-grid ms-4">
						<?php if($_SESSION['question_order']==1){ ?>
							<a href="Add_quiz1.php?edit=7&next=0" class="btn btn-secondary disabled"><i class="bi bi-arrow-left me-4"></i>Anteriorul</a>
						<?php } else { ?>
							<a href="Add_quiz1.php?edit=7&next=0" class="btn btn-secondary"><i class="bi bi-arrow-left me-4"></i>Anteriorul</a>
						<?php } ?>
					</div>
				</div>
				<div class="col-6">
					<div class="d-grid me-4">
						<?php if($_SESSION['question_order']==$nr_row) ?>
						<a href="Add_quiz1.php?edit=7&next=1" class="btn btn-secondary">Următorul<i class="bi bi-arrow-right ms-4"></i></a>
					</div>
				</div>
			</div>
		</div>

		<!--Footers-->
    	<?php //include 'Footers.php' ?>

	</body>
</html>
<script language ="javascript" >
    
    var max=<?php echo $nr_row; ?>;
    var question_order=<?php echo $_SESSION['question_order']; ?>;
    var min=<?php echo $solving_time_min; ?>;
    var sec=<?php echo $solving_time_sec+1; ?>;
    var min1;
    var sec1;

    function timer() 
    {
        if (parseInt(sec)>0) 
        {
            sec=parseInt(sec)-1;
            min1=min;
            sec1=sec;
            if(sec<10)
               	sec1="0"+sec1;
            if(min<10)
               	min1="0"+min1;

            document.getElementById("showtime").innerHTML = min1+":"+sec1;
            tim = setTimeout("timer()", 1000);
        }
        else if(parseInt(sec)==0) 
        {
            
            if(parseInt(min)==0) 
            {
                clearTimeout(tim);
                
                //if(question_order<max)
                	//location.href="Add_quiz1.php?edit=7&next=1";
                //else
                	location.href="#";
            }
            else 
            {
            	min=parseInt(min) - 1;
                sec=60;
                min1=min;
	            sec1=sec;
	            if(sec<10)
	               	sec1="0"+se1;
	            if(min<10)
	               	min1="0"+min1;
                document.getElementById("showtime").innerHTML = min1+":"+sec1;
                tim = setTimeout("timer()", 1000);
            }
        }
    }
</script>