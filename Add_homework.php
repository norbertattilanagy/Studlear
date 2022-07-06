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
    				echo '<li class="breadcrumb-item active" aria-current="page">Adaugă temă</li>';
    			else
    			{
    				echo '<li class="breadcrumb-item"><a href="Homework.php?id='.$_SESSION['homework'].'" style="text-decoration: none;">Temă</a></li>';
    				echo '<li class="breadcrumb-item active" aria-current="page">Editează temă</li>';
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
		    	<div class="mx-4 mb-3">
		    		<?php
		    		$title="";
		    		$date_limit="";
		    		if($_SESSION['add']==0)//edit
		    		{
		    			$homework_id=$_SESSION['homework'];
		    			$sql="SELECT * FROM homework WHERE id LIKE $homework_id";
		    			$results=mysqli_query($db,$sql);
		    			$row=mysqli_fetch_array($results);
		    			$title=$row['title'];

		    			$date_limit1=date_create($row['end_event']);
		    			$date_limit=date_format($date_limit1,"Y-m-d")."T".date_format($date_limit1,"h:i");

		    			$date=date('Y-m-d h:i');
		    			if($date_limit1<$date)
		    				$min=date("Y-m-d")."T".date("H:i");
		    			else
		    				$min=$date_limit;
		    		}
		    		else
		    		{
		    			$min=date("Y-m-d")."T".date("H:i");
		    		}
			    	?>
			    	<?php echo '<form action="Add_homework1.php?edit='.$_SESSION['add'].'" class="needs-validation" method="post" enctype="multipart/form-data" novalidate>'; ?>
			    		<div>
				    		<label for="title" class="form-label"><b>Titlu:</b></label>
				    		<?php echo '<input type="text" class="form-control" id="title" name="title" value="'.$title.'" onClick="this.select();" required>';?>
				    		<div class="invalid-feedback">Introduceți titlul</div>
				    	</div>
				    	<div class="mt-3">
			    			<label for="requirement" class="form-label"><b>Cerință:</b></label>
							<textarea class="form-control" rows="5" id="requirement" name="requirement" onClick="this.select();" required><?php
								if($_SESSION['add']==0)
								{
									$target_file=$row['requirement'];
									$file = fopen($target_file, "r");
									while(!feof($file)) {
		  								echo fgets($file);
									}
									fclose($file);
								}
							?></textarea>
							<div class="invalid-feedback">Introduceți cerința</div>
						</div>

				    	<?php if($_SESSION['add']==0){ ?>
				    		<div class="mt-3">
				    			<div class="mb-2">
				    				<b>Șterge fișiere:</b><br>
				    			</div>

							    <?php
					    		$target_folder=$row["folder_name"];
								$files = scandir($target_folder);
								$nr_files = count($files);
								for($i=0; $i<$nr_files; $i++)
								{
									if($files[$i]!="." and $files[$i]!="..")
									{
										$target_file=$target_folder.$files[$i];
										echo '<div class="form-check">';
											echo '<label class="form-check-label" for="file'.$i.'"><a href="'.$target_file.'" class="link-dark" style="text-decoration: none;">'.$files[$i].'</a></label>';
											echo '<input class="form-check-input" type="checkbox" id="file'.$i.'" name="file'.$i.'">';
										echo '</div>';
									}	
								} ?>
							</div>
					    <?php } ?>
				    	<div class="mt-3">
				    		<label for="files" class="form-label"><b>Adaugă fișiere:</b></label>
  							<input class="form-control" type="file" id="files" name="files[]" multiple>
  							<p class="text-muted">*Nu este obligatoriu</p>
				    	</div>
				    	<div class="mt-3">
							<label for="date_limit" class="form-label"><b>Limită:</b></label>
							<?php echo '<input type="datetime-local" class="form-control" id="date_limit" name="date_limit" value="'.$date_limit.'" min="'.$min.'" required>';?>
							<div class="invalid-feedback">Introduceți o limită</div>
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