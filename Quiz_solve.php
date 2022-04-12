<?php include 'Conection.php'; ?>
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
	    <title>Course</title>
	</head>
	<body>
		<!--Top bar-->
    	<?php include 'Top_bar.php' ?>

    	<nav class="ms-4" aria-label="breadcrumb">
  			<ol class="breadcrumb">
  		  		<?php
  		  		if($_SESSION['user_type']=="admin")
  					echo '<li class="breadcrumb-item"><a href="Search_courses.php" style="text-decoration: none;">Căutare curs</a></li>';
  				else
  		  			echo '<li class="breadcrumb-item"><a href="Home_page.php" style="text-decoration: none;">Acasă</a></li>'; 
  		  		echo '<li class="breadcrumb-item"><a href="Course_page.php?id='.$_SESSION['course_id'].'" style="text-decoration: none;">Curs</a></li>'; 
  		  		echo '<li class="breadcrumb-item"><a href="Quiz_teacher.php?id='.$_SESSION['quiz'].'" style="text-decoration: none;">Quiz</a></li>';
  		  		echo '<li class="breadcrumb-item"><a href="Quiz_solve_table.php" style="text-decoration: none;">Tabel rezolvări</a></li>';
  		  		?>
    			<li class="breadcrumb-item active" aria-current="page">Rezolvări</li>
  			</ol>
		</nav>
		<div class="row">

    		<!--Courses group-->
		    <div class="col-md-3">
		    	<?php include 'Courses_group.php' ?>
		    </div>
		    <div class="col-md-9">
		    	<div class="me-4">
		    		<form action="Add_quiz1.php?edit=12" method="post">
			    		<?php
			    		$max_point=0;
			    		$quiz_id=$_SESSION['quiz'];
			    		$answer_user_id=$_GET['id'];
			    		$_SESSION['answer_user_id']=$answer_user_id;
			    		$sql_order="SELECT * FROM question_order WHERE quiz_id LIKE $quiz_id ORDER BY order_number";
						$results_order=mysqli_query($db,$sql_order);
						$max_order=mysqli_num_rows($results_order);
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
										$correct_answer="";
										$quiz_option_id=$row_option['id'];
										$sql_answer_option="SELECT * FROM answer_quiz_option WHERE user_id LIKE $answer_user_id AND quiz_option_id LIKE $quiz_option_id";
										$results_answer_option=mysqli_query($db,$sql_answer_option);
										$row_answer_option=mysqli_fetch_array($results_answer_option);

										if($element=="radio_button")//radio button
										{
											if($row_answer['classic']==1)
											{ ?>
												<div class="form-check">

													<?php if(isset($row_answer_option['id'])){ 
														$point_value=$row_answer_option['point'];
														$correct_answer=$row_option['option']; ?>
				  										<input class="form-check-input" type="radio" value="" id="option" checked disabled>
				  									<?php } else { ?>
														<input class="form-check-input" type="radio" value="" id="option"  disabled>
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
													if(isset($row_answer_option['id'])){ 
														$point_value=$row_answer_option['point']; 
														$correct_answer=$row_option['option']; ?>
					  									<input class="btn-check" type="radio" value="" id="option" checked disabled>
					  								<?php } else { ?>
														<input class="btn-check" type="radio" value="" id="option" disabled>
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
													<?php if(isset($row_answer_option['id'])){
														$point_value=$row_answer_option['point']; 
														if($correct_answer=="")
															$correct_answer=$correct_answer.$row_option['option'];
														else
															$correct_answer=$correct_answer.'; '.$row_option['option']; ?>
				  										<input class="form-check-input" type="checkbox" value="" id="flexCheckDisabled" checked disabled>
				  									<?php } else { ?>
														<input class="form-check-input" type="checkbox" value="" id="flexCheckDisabled" disabled>
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
													if(isset($row_answer_option['id'])){
														$point_value=$row_answer_option['point']; 
														if($correct_answer=="")
															$correct_answer=$correct_answer.$row_option['option'];
														else
															$correct_answer=$correct_answer.'; '.$row_option['option']; ?>
					  									<input class="btn-check" type="checkbox" value="" id="option" checked disabled>
					  								<?php } else { ?>
														<input class="btn-check" type="checkbox" value="" id="option" disabled>
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
									$sql_answer_true_false="SELECT * FROM answer_true_false WHERE user_id LIKE $answer_user_id AND true_false_id LIKE $answer_id";
									$results_answer_true_false=mysqli_query($db,$sql_answer_true_false);
									$row_answer_true_false=mysqli_fetch_array($results_answer_true_false);
									$point_value=$row_answer_true_false['point'];

									if($row_answer['classic']==1)
									{ 

										if($row_answer_true_false['answer_true']==1){ ?>
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
					  						<?php if($row_answer_true_false['answer_true']==1){ ?>
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
								else if($element=="text")//text
								{ 
									$sql_answer_text="SELECT * FROM answer_text_question WHERE user_id LIKE $answer_user_id AND text_question_id LIKE $answer_id";
									$results_answer_text=mysqli_query($db,$sql_answer_text);
									$row_answer_text=mysqli_fetch_array($results_answer_text);
									$point_value=$row_answer_text['point'];

									if($row_answer['short']==1)//short text
									{
										echo '<input type="text" class="form-control" id="short_text" name="short_text" value="'.$row_answer_text['answer'].'" disabled>';
									}
									else //long text
									{
										$i=0;
										$target_file=$row_answer_text['answer'];
										echo '<textarea class="form-control" id="exampleFormControlTextarea1" rows="3" disabled>';
											
											$file = fopen($target_file, "r");
											while(!feof($file)) {
								  				echo fgets($file);
											}
										echo '</textarea>';
									}
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
										$sql_select="SELECT * FROM select_option WHERE select_question_id LIKE $answer_id AND `group` LIKE $i";
										$results_select=mysqli_query($db,$sql_select); ?>

										<?php while($row_select=mysqli_fetch_array($results_select))
										{
											$select_option_id=$row_select['id'];
											$sql_answer_select="SELECT * FROM answer_select_question WHERE user_id LIKE $answer_user_id AND select_option_id LIKE $select_option_id";
											$results_answer_select=mysqli_query($db,$sql_answer_select);
											$row_answer_select=mysqli_fetch_array($results_answer_select);
											if(!empty($row_answer_select['id']))
											{
												echo '<select class="form-select mt-3" aria-label="Default select example" id="select" name="select[]" disabled>';
													echo '<option>'.$row_select['option'].'</option>';
												echo '</select>';
												$point_value=$row_answer_select['point'];
											}

										} 
									}
								}
								?>
							</div>
							<?php 
							$i=$row_order['order_number'];
							$total_point[$i]=$point_value; ?>
							<div class="mt-2">
								<div class="d-flex justify-content-end">
									<label for="point" class="form-label me-2"><i>Puncte:</i></label>
			  						<?php 
			  						$id="point".$row_order['order_number'];
			  						if($_SESSION['user_type']!="student")
			  							echo '<input type="number" class="form-control me-2 '.$id.'" style="width: 70px; height: 25px;" id="'.$id.'" name="'.$id.'" value="'.$point_value.'" min=0 max='.$row_answer['point'].' onchange="calculateTotal(\''.$id.'\','.$row_order['order_number'].');">'; 
			  						else
			  							echo '<b class="me-2">'.$point_value."</b>";
			  						?>
			  						<b class="me-2">/</b>
			  						<?php echo '<b>'.$row_answer['point'].'</b>';?>
								</div>
							</div>
							<hr>
							<?php $max_point=$max_point+$row_answer['point']; ?>

						<?php } ?>
						<div class="d-flex justify-content-end">
							<?php echo '<h3><i class="me-2">Total puncte:</i><b id="total_point"></b> / '.$max_point.'</h3>'; ?>
						</div>
						<?php if($_SESSION['user_type']!="student"){ ?>
							<div class="d-grid mt-3">
								<button type="submit" class="btn btn-secondary">Slavează</button>
							</div>
						<?php } ?>
					</form>
		    	</div>
		    </div>
		</div>

	</body>
</html>
<script type="text/javascript">//limit min max
	var n=<?php echo $max_order; ?>;
	for(var i = 1; i <= n; i++)
	{
		var id="point"+i;
		document.getElementsByClassName(id)[0].oninput = function () {
		    var max = parseInt(this.max);
		    var min = parseInt(this.min);
			if (parseInt(this.value) > max) {
			    this.value = max; 
			}
			else if (parseInt(this.value) < min) {
			    this.value = min; 
			}
	    }
	}
</script>

<script type="text/javascript">//total point
var n=<?php echo $max_order; ?>;
var total_point = <?php echo json_encode($total_point); ?>;
func();
function func() {
	var total=0;
	for (var i = 1; i <= n; i++) {
		total_point[i]=parseFloat(total_point[i]);
		total+=total_point[i];
	}
	document.getElementById("total_point").innerHTML=total;
}
function calculateTotal(id,i) {
	var value_point=document.getElementById(id).value;
	var total=0;
	total_point[i]=value_point;
	for (var i = 1; i <= n; i++) {
		total_point[i]=parseFloat(total_point[i]);
		total+=total_point[i];
	}
	document.getElementById("total_point").innerHTML=total;
}
</script>