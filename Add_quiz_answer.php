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
	    <title>Studlear</title>
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
  		  		if($_SESSION['add']==1)
  		  		{
    				echo '<li class="breadcrumb-item active" aria-current="page"><a href="Add_quiz.php" style="text-decoration: none;">Adaugă quiz</a></li>';
    				echo '<li class="breadcrumb-item active" aria-current="page">Adaugă întrebare quiz</li>';
    			}
    			else
    			{
    				echo '<li class="breadcrumb-item"><a href="Quiz_teacher.php?id='.$_SESSION['quiz'].'" style="text-decoration: none;">Quiz</a></li>';

    				if($_SESSION['add_answer']==1)
    					echo '<li class="breadcrumb-item active" aria-current="page">Adaugă întrebare quiz</li>';
    				else
    					echo '<li class="breadcrumb-item active" aria-current="page">Editeză întrebare quiz</li>';
    			}
    			
    			?>
  			</ol>
		</nav>

    	<div class="row">
    		<!--Courses group-->
		    <div class="col-md-3">
		    	<?php include 'Courses_group.php' ?>
		    </div>
		    <div class="col-md-9">
		    	<div class="me-4">
		    		<?php
		    		$solving_time_min="";
			    	$solving_time_sec="";

			    	$quiz_id=$_SESSION['quiz'];
			    	$sql_quiz="SELECT * FROM question_order WHERE quiz_id LIKE $quiz_id";
			    	$results_quiz=mysqli_query($db,$sql_quiz);
			    	$max_order=mysqli_num_rows($results_quiz)+1;

		    		if($_SESSION['add_answer']==0)
		    		{
		    			echo $_SESSION['element'];
		    			$_SESSION['answer_type']=0;
		    			$answer_id=$_SESSION['answer_id'];
		    			if($_SESSION['element']=="radio_button")
		    			{
		    				$sql="SELECT * FROM radio_button WHERE id LIKE $answer_id";
		    			}
		    			else if($_SESSION['element']=="checkbox")
		    			{
		    				$sql="SELECT * FROM checkbox WHERE id LIKE $answer_id";
		    			}
		    			else if($_SESSION['element']=="true_false")
		    			{
		    				$sql="SELECT * FROM true_false WHERE id LIKE $answer_id";
		    			}
		    			else if($_SESSION['element']=="text")
		    			{
		    				$sql="SELECT * FROM text_question WHERE id LIKE $answer_id";
		    			}
		    			else if($_SESSION['element']=="select")
		    			{
		    				$sql="SELECT * FROM select_question WHERE id LIKE $answer_id";
		    			}

		    			$results=mysqli_query($db,$sql);
			    		$row=mysqli_fetch_array($results);
			    		$id=$row['id'];

			    		$solving_time=$row["solving_time"];
			    		$solving_time_min=intdiv($solving_time,60);
			    		$solving_time_sec=$solving_time%60;

		    		}
		    		else
		    			$_SESSION['element']=0;
		    		
		    		if($_SESSION['add_answer']==1)
		    			echo '<form action="Add_quiz1.php?edit=8" class="needs-validation" method="post" enctype="multipart/form-data" novalidate>';
		    		else
		    		{
		    			$element=$_SESSION['element'];
		    			echo '<form action="Add_quiz1.php?edit=9&answer_id='.$answer_id.'&element='.$element.'" class="needs-validation" method="post" enctype="multipart/form-data" novalidate>';
		    		}
		    		?>
		    			<!--Question-------------->
						<div>
					    	<label for="question" class="form-label"><b>Întrebare:</b></label>
							<textarea class="form-control" rows="2" id="question" name="question" onClick="this.select();" required><?php
								if($_SESSION['add_answer']==0)
								{
									$target_file=$row['question'];
									$file = fopen($target_file, "r");
									while(!feof($file)) {
				  						echo fgets($file);
									}
									fclose($file);
								}
							?></textarea>
							<div class="invalid-feedback">Introduceți o întrebare</div>
						</div>
						<?php
						if($_SESSION['add_answer']==0)
							$value=$row['point'];
						else
							$value="";
						?>
							<div class="mt-3">
								<label for="point" class="form-label"><b>Puncte:</b></label>
								<?php echo '<input type="number" class="form-control point" id="point" name="point" min="0" value="'.$value.'" required>'; ?>
								<div class="invalid-feedback">Introduceți punctele</div>
							</div>
						<?php
						$answer_type_checkbox=0;
						?>

			    		<?php if($_SESSION['answer_type']==1 or $_SESSION['answer_type']==2 or $_SESSION['element']=="radio_button") { //radio button ?>
							<div class="input_fields mt-3">
								<label for="option" class="form-label"><b>Opțiuni:</b></label>
								<?php 
								$answer_type_checkbox=0;
								if($_SESSION['answer_type']==1)
									$max_option=10;
								else if($_SESSION['answer_type']==2)
									$max_option=4;
								else if($row['classic']==1)
									$max_option=10;
								else
									$max_option=4;


								if($_SESSION['add_answer']==1) { 
									$nr_option=2;
									?>
									<div class="input-group">
										<div class="input-group-text">
									    	<input class="form-check-input" type="radio" id="option_check" name="option_check" value="1" required>
									  	</div>
								    	<input type="text" class="form-control" id="option" name="option[]" onClick="this.select();" required>
								    	<span class="input-group-text remove_field"><a href="#" class="link-dark"><i class="bi bi-dash-circle"></i></a></span>
								    	<div class="invalid-feedback">Introduceți opțiunea</div>
							    	</div>
							    	<div class="input-group mt-3">
							    		<div class="input-group-text">
									    	<input class="form-check-input" type="radio" id="option_check" name="option_check" value="2" required>
									  	</div>
								    	<input type="text" class="form-control" id="option" name="option[]" onClick="this.select();" required>
								    	<span class="input-group-text remove_field"><a href="#" class="link-dark"><i class="bi bi-dash-circle"></i></a></span>
								    	<div class="invalid-feedback">Introduceți opțiunea</div>
							    	</div>
						    	<?php } else { 
						    		$sql_option="SELECT * FROM quiz_option WHERE element LIKE 'radio_button' AND question_id LIKE $answer_id";
									$results_option=mysqli_query($db,$sql_option);
									$nr_option=mysqli_num_rows($results_option);
									$i=1;
									while($row_option=mysqli_fetch_array($results_option))
									{ ?>
										<div class="input-group mb-3">
											<div class="input-group-text">
												<?php
												if($row_option['correct']==0)
													echo '<input class="form-check-input" type="radio" id="option_check" name="option_check" value="'.$i.'" required>';
												else
													echo '<input class="form-check-input" type="radio" id="option_check" name="option_check" value="'.$i.'" checked required>';
												$i++;
												?>
											</div>
									    	<?php   	
									    	echo '<input type="text" class="form-control" id="option" name="option[]" value="'.$row_option["option"].'" onClick="this.select();" required>';
									    	?>
									    	<span class="input-group-text remove_field"><a href="#" class="link-dark"><i class="bi bi-dash-circle"></i></a></span>
									    	<div class="invalid-feedback">Introduceți opțiunea</div>
								    	</div>
									<?php }
								}
						    	?>
							</div>
							<div class="d-grid mt-3">							
							    <button class="btn btn-light btn-block add_field_button" id="add_option"><i class="bi bi-plus-circle me-2"></i>Adaugă opțiune</button>
							</div>
						<?php } ?>

						<?php if($_SESSION['answer_type']==3 or $_SESSION['answer_type']==4 or $_SESSION['element']=="checkbox") { //checkbox ?>
							<div class="input_fields mt-3">
								<label for="option" class="form-label"><b>Opțiuni:</b></label>
								<?php 
								$answer_type_checkbox=1;
								if($_SESSION['answer_type']==3)
									$max_option=10;
								else if($_SESSION['answer_type']==4)
									$max_option=4;
								else if($row['classic']==1)
									$max_option=10;
								else
									$max_option=4;

								if($_SESSION['add_answer']==1) { 
									$nr_option=2; ?>
									<div class="input-group">
										<div class="input-group-text">
									    	<input class="form-check-input" type="checkbox" id="option_check" name="option_check1">
									  	</div>
								    	<input type="text" class="form-control" id="option" name="option[]" onClick="this.select();" required>
								    	<span class="input-group-text remove_field"><a href="#" class="link-dark"><i class="bi bi-dash-circle"></i></a></span>
								    	<div class="invalid-feedback">Introduceți opțiunea</div>
							    	</div>
							    	<div class="input-group mt-3">
							    		<div class="input-group-text">
									    	<input class="form-check-input" type="checkbox" id="option_check" name="option_check2">
									  	</div>
								    	<input type="text" class="form-control" id="option" name="option[]" onClick="this.select();" required>
								    	<span class="input-group-text remove_field"><a href="#" class="link-dark"><i class="bi bi-dash-circle"></i></a></span>
								    	<div class="invalid-feedback">Introduceți opțiunea</div>
							    	</div>
							    <?php } else { 
						    		$sql_option="SELECT * FROM quiz_option WHERE element LIKE 'checkbox' AND question_id LIKE $id";
									$results_option=mysqli_query($db,$sql_option);
									$nr_option=mysqli_num_rows($results_option);
									$i=1;
									while($row_option=mysqli_fetch_array($results_option))
									{ ?>
										<div class="input-group mb-3">
											<div class="input-group-text">
												<?php
												if($row_option['correct']==0)
													echo '<input class="form-check-input" type="checkbox" id="option_check" name="option_check'.$i.'">';
												else
													echo '<input class="form-check-input" type="checkbox" id="option_check" name="option_check'.$i.'" checked>';
												$i++; ?>
											</div>
									    	<?php
									    	echo '<input type="text" class="form-control" id="option" name="option[]" value="'.$row_option["option"].'" onClick="this.select();" required>';
									    	?>
									    	<span class="input-group-text remove_field"><a href="#" class="link-dark"><i class="bi bi-dash-circle"></i></a></span>
									    	<div class="invalid-feedback">Introduceți opțiunea</div>
								    	</div>
									<?php }
								}
						    	?>
							</div>

							<div class="d-grid mt-3">							
						    	<button class="btn btn-light btn-block add_field_button" id="add_option"><i class="bi bi-plus-circle me-2"></i>Adaugă opțiune</button>
						    </div>
						<?php } ?>

						<?php if($_SESSION['answer_type']==5 or $_SESSION['answer_type']==6 or $_SESSION['element']=="true_false") { //true/false ?>
							<div class="mt-3">
								<label class="form-label"><b>Răspuns corect:</b></label>
								<div class="form-check">
									<?php 
									if($_SESSION['add_answer']==0 and $row['correct']==1)
							      		echo '<input type="radio" class="form-check-input" id="true" name="true_false" value="1" checked required>';
							      	else
							      		echo '<input type="radio" class="form-check-input" id="true" name="true_false" value="1" required>';
							      	?>
							      	<label class="form-check-label" for="true">Adevărat</label>
							    </div>
							    <div class="form-check">
							    	<?php 
									if($_SESSION['add_answer']==0 and $row['correct']==0)
							      		echo '<input type="radio" class="form-check-input" id="false" name="true_false" value="0" checked required>';
							      	else
							      		echo '<input type="radio" class="form-check-input" id="false" name="true_false" value="0" required>';
							      	?>
							      	<label class="form-check-label" for="false">Fals</label>
							      	<div class="invalid-feedback">Alegeți răspunsul</div>
							    </div>
							</div>
						<?php } ?>

						<?php if($_SESSION['answer_type']==7 or $_SESSION['element']=="text") { //add short text 
							$short=0;
							if(isset($row['short']))
								if($row['short']==1)
									$short=1;
							if($_SESSION['answer_type']==7)
								$short=1;

							if($short==1 or $_SESSION['answer_type']==7){ ?>
								<div class="input_short_text mt-3">
									<label class="form-label"><b>Posibil răspuns corect:</b></label>
									<?php if($_SESSION['add_answer']==1){ ?>
										<div class="input-group mb-3">
											<input type="text" class="form-control" id="answer_short_text" name="answer_short_text[]" onClick="this.select();" required>
											<span class="input-group-text remove_short_text_field"><a href="#" class="link-dark"><i class="bi bi-dash-circle"></i></a></span>
											<div class="invalid-feedback">Introduceți răspunsul corect</div>
										</div>
									<?php } else {
										$text_question_id=$row['id'];
										$sql_answer="SELECT * FROM text_posible_answer WHERE text_question_id LIKE $text_question_id";
										$results_answer=mysqli_query($db,$sql_answer);
										while($row_answer=mysqli_fetch_array($results_answer)) {
											$value=$row_answer['answer']; ?>
											<div class="input-group mb-3">
												<?php echo '<input type="text" class="form-control" id="answer_short_text" name="answer_short_text[]" value="'.$value.'" onClick="this.select();" required>'; ?>
												<span class="input-group-text remove_short_text_field"><a href="#" class="link-dark"><i class="bi bi-dash-circle"></i></a></span>
												<div class="invalid-feedback">Introduceți răspunsul corect</div>
											</div>
									<?php } } ?>
								</div>
								<div class="d-grid mt-3">
									<button class="btn btn-light btn-block add_short_text_button" id="add_answer"><i class="bi bi-plus-circle me-2"></i>Adaugă răspuns</button>
								</div>
						<?php } } ?>

						<?php if($_SESSION['answer_type']==9 or $_SESSION['element']=="select") { //select 
							$nr_option=2;
							$max_option=100;
							?>
							<div class="input_select_fields mt-3">
								<label for="option" class="form-label"><b>Opțiuni:</b></label>
								<?php if($_SESSION['add_answer']==1) { ?>
									<div class="input-group">
										
										<div class="input-group-text">
										   	<input class="form-check-input" type="checkbox" id="option_select_check" name="option_select_check1">
										</div>
									   	<input type="text" class="form-control" id="select_option" name="select_option[]" onClick="this.select();" required>

									   	<div class="input-group-text"><b>Grup:</b></div>

									   	<select class="form-select" aria-label="Default select example" id="select_group" name="select_group[]">
									   		<?php
									   		foreach (range('A','Z') as $i) {
												echo '<option>'.$i.'</option>';
									   		}
									   		?>
										</select>

									   	<span class="input-group-text remove_select_field"><a href="#" class="link-dark"><i class="bi bi-dash-circle"></i></a></span>
									   	<div class="invalid-feedback">Introduceți opțiunea</div>

									</div>
									<div class="input-group mt-3">

										<div class="input-group-text">
										   	<input class="form-check-input" type="checkbox" id="option_select_check" name="option_select_check2">
										</div>

									   	<input type="text" class="form-control" id="select_option" name="select_option[]" onClick="this.select();" required>

									   	<div class="input-group-text"><b>Grup:</b></div>

									   	<select class="form-select" aria-label="Default select example"  id="select_group" name="select_group[]">
									   		<?php
									   		foreach (range('A','Z') as $i) {
												echo '<option>'.$i.'</option>';
									   		}
									   		?>
										</select>

									   	<span class="input-group-text remove_select_field"><a href="#" class="link-dark"><i class="bi bi-dash-circle"></i></a></span>
									   	<div class="invalid-feedback">Introduceți opțiunea</div>

									</div>
								<?php } else { 
									$select_id=$row['id'];
									$sql_select="SELECT * FROM select_option WHERE select_question_id LIKE $select_id";
									$results_select=mysqli_query($db,$sql_select);
									$i=0;
									while($row_select=mysqli_fetch_array($results_select)){ ?>
										<div class="input-group mt-3">

											<div class="input-group-text">
											   	<?php 
											   	if($row_select['correct']==1)
											   		echo '<input class="form-check-input" type="checkbox" id="option_select_check" name="option_select_check'.$i.'" checked>';
											   	else
											   		echo '<input class="form-check-input" type="checkbox" id="option_select_check" name="option_select_check'.$i.'">';
											   	$i++; ?>
											</div>

										   	<?php 
										   	$value=$row_select['option'];
										   	echo '<input type="text" class="form-control" id="select_option" name="select_option[]" value="'.$value.'" onClick="this.select();" required>'; ?>

										   	<div class="input-group-text"><b>Grup:</b></div>

										   	<select class="form-select" aria-label="Default select example"  id="select_group" name="select_group[]">
										   		<?php
										   		foreach (range('A','Z') as $j) {
										   			if($row_select['group']==$j)
														echo '<option selected>'.$j.'</option>';
													else
														echo '<option>'.$j.'</option>';
										   		}
										   		?>
											</select>

										   	<span class="input-group-text remove_select_field"><a href="#" class="link-dark"><i class="bi bi-dash-circle"></i></a></span>
										   	<div class="invalid-feedback">Introduceți opțiunea</div>

										</div>
								<?php }
								$nr_option=$i;
								} ?>
							</div>
							<div class="d-grid mt-3">
							    <button class="btn btn-light btn-block add_select_field_button" id="add_select_option"><i class="bi bi-plus-circle me-2"></i>Adaugă opțiune</button>
							</div>
						<?php } ?>

						<div class="mt-3">
							<?php 
							$quiz_id=$_SESSION['quiz'];
							$sql_time="SELECT * FROM quiz WHERE id LIKE $quiz_id";
							$results_time=mysqli_query($db,$sql_time);
							$row_time=mysqli_fetch_array($results_time);
							if($row_time['solving_time']>0){ 
								$disable=1; ?>
								<input class="form-check-input limit_time" type="checkbox" id="solving_time" data-bs-toggle="tooltip" title="Timp quiz" disabled>
								<label for="solving_time" class="form-check-label"><b>Timp limită:</b></label>
								
							<?php } else { 
								$disable=0; ?>
								<input class="form-check-input limit_time" type="checkbox" id="solving_time" checked>
								<label for="solving_time" class="form-check-label"><b>Timp limită:</b></label>
							<?php } ?>
							
							<div class="row">
								<div class="col">
									<?php 
									if($row_time['solving_time']>0)
										echo '<input type="number" class="form-control solving_time solving_time_min" id="solving_time_min" name="solving_time_min" placeholder="Minute" value="'.$solving_time_min.'" min="0" max="60" disabled required>';
									else
										echo '<input type="number" class="form-control solving_time solving_time_min" id="solving_time_min" name="solving_time_min" placeholder="Minute" value="'.$solving_time_min.'" min="0" max="60" required>';
									?>
									<div class="invalid-feedback">Introduceți minutele</div>
								</div>
								<div class="col">
									<?php
									if($row_time['solving_time']>0)
										echo '<input type="number" class="form-control solving_time solving_time_sec" id="solving_time_sec" name="solving_time_sec" placeholder="Secunde" value="'.$solving_time_sec.'" min="0" max="60" disabled required>';
									else
										echo '<input type="number" class="form-control solving_time solving_time_sec" id="solving_time_sec" name="solving_time_sec" placeholder="Secunde" value="'.$solving_time_sec.'" min="0" max="60" required>';
									?>
									<div class="invalid-feedback">Introduceți secundele</div>
								</div>
							</div>
							<?php if($disable==1)
							{
								echo '<span style="color:#ff0000">*</span>Ati introdus timp limită quiz';
							} ?>

						</div>

						<?php if($max_order>1) { //order number
							if($_SESSION['add_answer']==0)
							{
								$element='"'.$_SESSION['element'].'"';
								$sql_order="SELECT * FROM question_order WHERE answer_id LIKE $answer_id AND element LIKE $element";
			    				$results_order=mysqli_query($db,$sql_order);
			    				$row_order=mysqli_fetch_array($results_order);
							}
							?>
							<div class="mt-3">
								<label for="order_number" class="form-label"><b>Numărul de ordine:</b></label>
								<select class="form-select" id="order_number" name="order_number">
									<?php for($i=1;$i<=$max_order;$i++) {
										if($_SESSION['add_answer']==0)
										{
											if($row_order["order_number"]==$i)
												echo '<option selected>'.$i.'</option>';
											else
												echo '<option>'.$i.'</option>';
										}
										else
										{
											if($max_order==$i)
												echo '<option selected>'.$i.'</option>';
											else
												echo '<option>'.$i.'</option>';
										}
										
									} ?>
  								</select>
							</div>
						<?php } ?>



						<div class="d-grid mt-3 mb-3">
						    <button type="submit" class="btn btn-secondary btn-block">Salvează</button>
						</div>

					</form>

		    	</div>
		    </div>
		</div>

	</body>
</html>
<!--Limit-time------------>
<script type="text/javascript">
	$('.limit_time').click(function () {
    	if(!this.checked) {
       		$('.solving_time').attr('disabled' , true);
    	} else {
        	$('.solving_time').attr('disabled' , false);
    	}
	});
</script>
<!--Add-field-checkbox-radio-button------------->
<script type="text/javascript">
$(document).ready(function() {
	var answer_type=<?php echo $answer_type_checkbox; ?>;
	var max_fields=<?php echo $max_option; ?>;
	var min_fields=2;
	var wrapper=$(".input_fields");
	var add_button=$(".add_field_button");
	var add=0;
	var x=<?php echo $nr_option; ?>;

	if(x==max_fields)
	{
		add=1;
		$(add_button).hide();
	}

	$(add_button).click(function(e){
		e.preventDefault();
		if(x < max_fields){
			x++;
			if(answer_type==0)
			{
				$(wrapper).append(`<div class="input-group mt-3"><div class="input-group-text"><input class="form-check-input" type="radio" id="option_check" name="option_check" value="${x}"></div><input type="text" class="form-control" id="option" name="option[]" value="" onClick="this.select();" required/><span class="input-group-text remove_field"><a href="#" class="link-dark"><i class="bi bi-dash-circle"></i></a></span><div class="invalid-feedback">Introduceți opțiunea</div></div>`);
			}
			else
			{
				$(wrapper).append(`<div class="input-group mt-3"><div class="input-group-text"><input class="form-check-input" type="checkbox" id="option_check" name="option_check${x}"></div><input type="text" class="form-control" id="option" name="option[]" value="" onClick="this.select();"/><span class="input-group-text remove_field"><a href="#" class="link-dark"><i class="bi bi-dash-circle"></i></a></span><div class="invalid-feedback">Introduceți opțiunea</div></div>`);
			}
		}
		if(x==max_fields)
		{
			$(add_button).hide();
        	add=1;
		}
	});
	
	$(wrapper).on("click",".remove_field", function(e){ //user click on remove text
		e.preventDefault();
		if(x > min_fields){
			$(this).parent('div').remove();
			x--;
		}
		else
		{
			alert("Ați atins numărul minim de câmpuri.");
		}
		if(add==1)
		{
			$(add_button).show();
			add=0;
		}
	});
});
</script>
<!--Add-field-short-text----------------------->
<script type="text/javascript">
$(document).ready(function() {
	var wrapper_short_text=$(".input_short_text");
	var add_short_text_button=$(".add_short_text_button");

	$(add_short_text_button).click(function(e){
		e.preventDefault();
		$(wrapper_short_text).append(`<div class="input-group mb-3"><input type="text" class="form-control" id="answer_short_text" name="answer_short_text[]" onClick="this.select();" required><span class="input-group-text remove_short_text_field"><a href="#" class="link-dark"><i class="bi bi-dash-circle"></i></a></span><div class="invalid-feedback">Introduceți răspunsul corect</div></div>`);
	});
	
	$(wrapper_short_text).on("click", ".remove_short_text_field", function(e) {
        e.preventDefault();
        $(this).parent('div').remove();
    });
});
</script>
<!--Add-field-select---------------------->
<script type="text/javascript">
$(document).ready(function() {

	var max_fields=<?php echo $max_option ?>;
	var min_fields=2;
	var wrapper=$(".input_select_fields");
	var add_button=$(".add_select_field_button");
	var add=0;
	var x=<?php echo $nr_option; ?>;

	if(x==max_fields)
	{
		add=1;
		$(add_button).hide();
	}

	$(add_button).click(function(e){
		e.preventDefault();
		if(x < max_fields){
			x++;
			$(wrapper).append(`<div class="input-group mt-3"><div class="input-group-text"><input class="form-check-input" type="checkbox" id="option_select_check" name="option_select_check${x}"></div><input type="text" class="form-control" id="select_option" name="select_option[]" onClick="this.select();" required><div class="input-group-text"><b>Grup:</b></div><select class="form-select" aria-label="Default select example"  id="select_group" name="select_group[]"><option>A</option><option>B</option><option>C</option><option>D</option><option>E</option><option>F</option><option>G</option><option>H</option><option>I</option><option>J</option><option>K</option><option>L</option><option>M</option><option>N</option><option>O</option><option>P</option><option>Q</option><option>R</option><option>S</option><option>T</option><option>U</option><option>V</option><option>W</option><option>X</option><option>Y</option><option>Z</option></select><span class="input-group-text remove_select_field"><a href="#" class="link-dark"><i class="bi bi-dash-circle"></i></a></span><div class="invalid-feedback">Introduceți opțiunea</div></div></div>`);
		}
		if(x==max_fields)
		{
			$(add_button).hide();
        	add=1;
		}
	});
	
	$(wrapper).on("click",".remove_select_field", function(e){ //user click on remove text
		e.preventDefault();
		if(x > min_fields){
			$(this).parent('div').remove();
			x--;
		}
		else
		{
			alert("Ați atins numărul minim de câmpuri.");
		}

		if(add==1)
		{
			$(add_button).show();
			add=0;
		}
	});
});
</script>
<!--Max min input number-->
<script type="text/javascript">
    document.getElementsByClassName('solving_time_min')[0].oninput = function () {
	    var max = parseInt(this.max);
	    var min = parseInt(this.min);

		if (parseInt(this.value) > max) {
		    this.value = max; 
		}
		else if (parseInt(this.value) < min) {
		    this.value = min; 
		}
    }
    document.getElementsByClassName('solving_time_sec')[0].oninput = function () {
	    var max = parseInt(this.max);
	    var min = parseInt(this.min);

		if (parseInt(this.value) > max) {
		    this.value = max; 
		}
		else if (parseInt(this.value) < min) {
		    this.value = min; 
		}
    }
    document.getElementsByClassName('point')[0].oninput = function () {
	    var min = parseInt(this.min);

		if (parseInt(this.value) < min) {
		    this.value = min; 
		}
    }
</script>
<script>
	var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
	var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
	  return new bootstrap.Tooltip(tooltipTriggerEl)
	})
</script>
<script type="text/javascript">
(function () {
	
  	var forms = document.querySelectorAll('.needs-validation') 
  	Array.prototype.slice.call(forms).forEach(function (form) {
			
      	form.addEventListener('submit', function (event)
      	{			
        	if (!form.checkValidity())
        	{	
          		event.preventDefault()
          		event.stopPropagation()
        	}
        	form.classList.add('was-validated')
      	}, false)
    })
})()
</script>