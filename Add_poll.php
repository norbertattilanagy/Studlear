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
    				echo '<li class="breadcrumb-item active" aria-current="page">Adaugă sondaj</li>';
    			else
    			{
    				echo '<li class="breadcrumb-item"><a href="Poll.php?id='.$_SESSION['poll'].'" style="text-decoration: none;">Sondaj</a></li>';
    				echo '<li class="breadcrumb-item active" aria-current="page">Editare sondaj</li>';
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
			    		$title="";
			    		$_SESSION['poll_nr_option']=2;
			    		if($_SESSION['add']==0)
			    		{
			    			$poll_id=$_SESSION['poll'];
			    			$sql="SELECT * FROM poll WHERE id LIKE $poll_id";
			    			$results=mysqli_query($db,$sql);
			    			$row=mysqli_fetch_array($results);
			    			$title=$row['title'];
			    		}
			    		
			    	?>
			    	<?php echo '<form action="Add_poll1.php?edit='.$_SESSION['add'].'" class="needs-validation" method="post" novalidate>'; ?>
				    	<div>
					    	<label for="title" class="form-label"><b>Titlu:</b></label>
					    	<?php echo '<input type="text" class="form-control" id="title" name="title" value="'.$title.'" onClick="this.select();" required>';?>
					    	<div class="invalid-feedback">Introduceți titlul</div>
					    </div>
					    <div class="mt-3">
				    		<label for="question" class="form-label"><b>Întrebare:</b></label>
							<textarea class="form-control" rows="3" id="question" name="question" onClick="this.select();" required><?php
								if($_SESSION['add']==0)
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
						<div class="mt-3">
							<label for="option_type" class="form-label"><b>Tip răspuns:</b></label>
				    		<select class="form-select" name="option_type" id="option_type">
				    			<?php if($row['radio_button']==1) {
				    				echo '<option value="1" selected>Radio button</option>';
  									echo '<option value="0">Checkbox</option>';
  								}
  								else {
  									echo '<option value="1">Radio button</option>';
  									echo '<option value="0" selected>Checkbox</option>';
  								} ?>
  							</select>
				    	</div>
						<div class="input_fields mt-3">
							<label for="option" class="form-label"><b>Opțiuni:</b></label>
							<?php if($_SESSION['add']==1) { 
								$nr_option=2;
								?>
								<div class="input-group">
							    	<?php
							    	echo '<input type="text" class="form-control" id="option" name="option[]" onClick="this.select();" required>';
							    	?>
							    	<span class="input-group-text remove_field"><a href="#" class="link-dark"><i class="bi bi-dash-circle"></i></a></span>
							    	<div class="invalid-feedback">Introduceți opțiunea</div>
						    	</div>
						    	<div class="input-group mt-3">
							    	<?php
							    	echo '<input type="text" class="form-control" id="option" name="option[]" onClick="this.select();" required>';
							    	?>
							    	<span class="input-group-text remove_field"><a href="#" class="link-dark"><i class="bi bi-dash-circle"></i></a></span>
							    	<div class="invalid-feedback">Introduceți opțiunea</div>
						    	</div>
						    	
					    	<?php } else { 
					    		$sql_option="SELECT * FROM quiz_option WHERE element LIKE 'poll' AND question_id LIKE $poll_id";
								$results_option=mysqli_query($db,$sql_option);
								$nr_option=mysqli_num_rows($results_option);
								while($row_option=mysqli_fetch_array($results_option))
								{ ?>
									<div class="input-group mb-3">
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
					    	<button class="btn btn-light btn-block add_field_button"><i class="bi bi-plus-circle me-2"></i>Adaugă opțiune</button>
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
						    <button type="submit" class="btn btn-secondary btn-block">Salvează</button>
						</div>
					</form>
				</div>
		    </div>
		</div>

	</body>
</html>
<script type="text/javascript">
$(document).ready(function() {
	var max_fields=10;
	var min_fields=2;
	var wrapper=$(".input_fields");
	var add_button=$(".add_field_button");

	var x=<?php echo $nr_option; ?>;
	$(add_button).click(function(e){
		e.preventDefault();
		if(x < max_fields){
			x++;
			$(wrapper).append('<div class="input-group mt-3"><input type="text" class="form-control" id="option" name="option[]" value="" onClick="this.select();" required/><span class="input-group-text remove_field"><a href="#" class="link-dark"><i class="bi bi-dash-circle"></i></a></span><div class="invalid-feedback">Introduceți opțiunea</div></div>');
		}
	});
	
	$(wrapper).on("click",".remove_field", function(e){ //user click on remove text
		e.preventDefault();
		if(x > min_fields){
			$(this).parent('div').remove();
			x--;
		}
	})
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