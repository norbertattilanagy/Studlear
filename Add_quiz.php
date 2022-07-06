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

    	<nav class="mx-3" aria-label="breadcrumb">
  			<ol class="breadcrumb">
  		  		<?php
  		  		if($_SESSION['user_type']=="admin")
  					echo '<li class="breadcrumb-item"><a href="Search_courses.php" style="text-decoration: none;">Căutare curs</a></li>';
  				else
  		  			echo '<li class="breadcrumb-item"><a href="Home_page.php" style="text-decoration: none;">Acasă</a></li>';
  		  		echo '<li class="breadcrumb-item"><a href="Course_page.php?id='.$_SESSION['course_id'].'" style="text-decoration: none;">Curs</a></li>';
  		  		
  		  		if($_SESSION['add']==1)
    				echo '<li class="breadcrumb-item active" aria-current="page">Adaugă quiz</li>';
    			else
    			{
    				echo '<li class="breadcrumb-item"><a href="Quiz_teacher.php?id='.$_SESSION['quiz'].'" style="text-decoration: none;">Quiz</a></li>';
    				echo '<li class="breadcrumb-item active" aria-current="page">Editare quiz</li>';
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
		    	<div class="mx-3 mb-3">
		    		<?php
			    	$title="";
			    	$solving_time_hour="";
			    	$solving_time_min="";
			    	$solving_time_sec="";
			    	$start_event="";
		    		$end_event="";
			    	if($_SESSION['add']==0)
			    	{
			    		$quiz_id=$_SESSION['quiz'];
			    		$sql="SELECT * FROM quiz WHERE id LIKE $quiz_id";
			    		$results=mysqli_query($db,$sql);
			    		$row=mysqli_fetch_array($results);
			    		$title=$row['title'];

			    		$solving_time=$row["solving_time"];
			    		$solving_time_hour=intdiv($solving_time,3600);
			    		$solving_time=$solving_time%3600;
			    		$solving_time_min=intdiv($solving_time,60);
			    		$solving_time_sec=$solving_time%60;
			    		
			    		$start_event1=date_create($row['start_event']);

			    		$start_event=date_format($start_event1,"Y-m-d")."T".date_format($start_event1,"h:i");

			    		$end_event=date_create($row['end_event']);
			    		$end_event=date_format($end_event,"Y-m-d")."T".date_format($end_event,"h:i");

			    		$date=date('Y-m-d h:i');
			    		$min=date("Y-m-d")."T".date("H:i");
			    		echo $start_event."<".$min;
			    		if($start_event<$min)
			    			$min=$start_event;
			    	}
			    	else
			    	{
			    		$min=date("Y-m-d")."T".date("H:i");
			    	}	
			    	
			    	?>
			    	<?php echo '<form action="Add_quiz1.php?edit='.$_SESSION['add'].'" class="needs-validation" method="post" novalidate>'; ?>

				    	<div>
					    	<label for="title" class="form-label"><b>Titlu:</b></label>
					    	<?php echo '<input type="text" class="form-control" id="title" name="title" value="'.$title.'" onClick="this.select();" required>';?>
					    	<div class="invalid-feedback">Introduceți titlul</div>
					    </div>

					    <div class="mt-3">
				    		<label for="description" class="form-label"><b>Descriere:</b></label>
							<textarea class="form-control" rows="5" id="description" name="description" onClick="this.select();"><?php
								if($_SESSION['add']==0)
								{
									$target_file=$row['description'];
									$file = fopen($target_file, "r");
									while(!feof($file)) {
			  							echo fgets($file);
									}
									fclose($file);
								}
							?></textarea>
							<p class="text-muted">*Nu este obligatoriu</p>
						</div>

						<div class="mt-3">
							<input class="form-check-input limit_time" type="checkbox" id="solving_time" checked>
							<label for="solving_time" class="form-label"><b>Timp limită:</b></label>
							<div class="row">
								<div class="col">
									<?php echo '<input type="number" class="form-control solving_time solving_time_hour" id="solving_time_hour" name="solving_time_hour" placeholder="Oră" value="'.$solving_time_hour.'" min="0" max="24" required>'; ?>
									<div class="invalid-feedback">Introduceți ora</div>
								</div>
								<div class="col">
									<?php echo '<input type="number" class="form-control solving_time solving_time_min" id="solving_time_min" name="solving_time_min" placeholder="Minute" value="'.$solving_time_min.'" min="0" max="60" required>'; ?>
									<div class="invalid-feedback">Introduceți minutele</div>
								</div>
								<div class="col">
									<?php echo '<input type="number" class="form-control solving_time solving_time_sec" id="solving_time_sec" name="solving_time_sec" placeholder="Secunde" value="'.$solving_time_sec.'" min="0" max="60" required>'; ?>
									<div class="invalid-feedback">Introduceți secundele</div>
								</div>

							</div>
						</div>

						<div class="mt-3">
							<label for="start_event" class="form-label"><b>Început:</b></label>
							<?php echo '<input type="datetime-local" class="form-control" id="start_event" name="start_event" value="'.$start_event.'" min="'.$min.'" required>'; ?>
							<div class="invalid-feedback">Introduceți începutul</div>
						</div>
						<div class="mt-3">
							<label for="end_event" class="form-label"><b>Final:</b></label>
							<?php echo '<input type="datetime-local" class="form-control" id="end_event" name="end_event" value="'.$end_event.'" min="'.$min.'" required>'; ?>
							<div class="invalid-feedback">Introduceți sfârșitul</div>
						</div>

						<?php if($_SESSION['add']==0){ ?>
						<div class="mt-3">
							<label for="lesson" class="form-label"><b>Grup de lecție:</b></label>
							<select class="form-select" id="lesson" name="lesson_group">
								<?php 
								$course_id=$_SESSION['course_id'];
								$current_lesson_group_id=$row['lesson_group_id'];
								$sql_lesson_group="SELECT * FROM lesson_group WHERE course_id LIKE $course_id";
								$results_lesson_group=mysqli_query($db,$sql_lesson_group);
								while($row_lesson_group=mysqli_fetch_array($results_lesson_group))
								{
									if($current_lesson_group_id==$row_lesson_group["id"])
										echo '<option value="'.$row_lesson_group["id"].'" selected>'.$row_lesson_group["order_number"].'. '.$row_lesson_group["group_title"].'</option>';
									else
										echo '<option value="'.$row_lesson_group["id"].'" >'.$row_lesson_group["order_number"].'. '.$row_lesson_group["group_title"].'</option>';
								}
								?>
							</select>
						</div>
						<?php } ?>

					    <div class="form-check mt-3">
			    			<?php
			    			if($_SESSION['add']==0)
			    			{
			    				if($row['visibility']==0)
			    					echo '<input class="form-check-input" type="checkbox" id="visibility" name="visibility">';
			    				else
			    					echo '<input class="form-check-input" type="checkbox" id="visibility" name="visibility" checked>';
			    			}
			    			else {
			    				echo '<input class="form-check-input" type="checkbox" id="visibility" name="visibility" checked>';
			    			}
			    			?>
	      					
	    					<label class="form-check-label" for="visibility">Vizibilitate</label>
						</div>

					    <div class="d-grid mt-3 mb-3">
					    	<?php
					    	if($_SESSION['add']==1)
								echo '<button type="submit" class="btn btn-secondary btn-block">Adaugă întrebare</button>';
							else
								echo '<button type="submit" class="btn btn-secondary btn-block">Salvează</button>';
					    	?>
						    
						</div>
					</form>
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
		      			<form action="Add_quiz1.php?edit=5" method="post">
			      			<div class="mt-3">
								<label for="answer_type" class="form-label"><b>Tip de răspuns:</b></label>
								<select class="form-select" id="answer_type" name="answer_type">
								  	<option value="1"><i class="bi bi-ui-radios"></i>Radiobutton clasic</option>
								  	<option value="2"><i class="bi bi-ui-radios-grid"></i>Radiobutton modern</option>
								  	<option value="3"><i class="bi bi-ui-checks"></i>Checkbox clasic</option>
								  	<option value="4"><i class="bi bi-ui-checks-grid"></i>Checkbox modern</option>
								  	<option value="5"><i class="bi bi-input-cursor"></i>Text scurt</option>
								  	<option value="6"><i class="bi bi-card-text"></i>Text lung</option>
								  	<option value="7">Select</option>
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
<!--Limit-time------------>
<script type="text/javascript">
	$('.limit_time').click(function () { //disable or enable limit time
    	if(!this.checked) {
       		$('.solving_time').attr('disabled' , true);
    	} else {
        	$('.solving_time').attr('disabled' , false);
    	}
	});
</script>
<!--Max min input number-->
<script type="text/javascript">
	document.getElementsByClassName('solving_time_hour')[0].oninput = function () {
	    var max = parseInt(this.max);
	    var min = parseInt(this.min);

		if (parseInt(this.value) > max) {
		    this.value = max; 
		}
		else if (parseInt(this.value) < min) {
		    this.value = min; 
		}
    }
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
<!--Modal-->
<script type="text/javascript">
	$(document).ready(function() {
	    if(window.location.href.indexOf('#Answer_type') != -1) {
	        $('#Answer_type').modal('show');
	        window.history.pushState('', 'Add_quiz', 'Add_quiz.php');
	    }
	});
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