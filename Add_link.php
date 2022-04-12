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
  		  		
  		  		if($_SESSION['add']==1)
    				echo '<li class="breadcrumb-item active" aria-current="page">Adaugă link</li>';
    			else
    			{
    				echo '<li class="breadcrumb-item"><a href="Link.php?id='.$_SESSION['link'].'" style="text-decoration: none;">Link</a></li>';
    				echo '<li class="breadcrumb-item active" aria-current="page">Editează link</li>';
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
		    		$link="";
		    		if($_SESSION['add']==0)
		    		{
		    			$link_id=$_SESSION['link'];
		    			$sql="SELECT * FROM link WHERE id LIKE $link_id";
		    			$results=mysqli_query($db,$sql);
		    			$row=mysqli_fetch_array($results);
		    			$title=$row['title'];
		    			$link=$row['link'];
		    		}
			    	?>
			    	<?php echo '<form action="Add_link1.php?edit='.$_SESSION['add'].'" class="needs-validation" method="post" novalidate>'; ?>
				    	<div class="mt-3">
				    		<label for="title" class="form-label"><b>Titlu:</b></label>
				    		<?php echo '<input type="text" class="form-control" id="title" name="title" value="'.$title.'" onClick="this.select();" required>';?>
				    		<div class="invalid-feedback">Introduceți titlul</div>
				    	</div>
				    	<div class="mt-3">
				    		<label for="link" class="form-label"><b>Link:</b></label>
							<?php echo '<input type="url" class="form-control" id="link" name="link" value="'.$link.'" onClick="this.select();" required>';?>
							<div class="invalid-feedback">Introduceți un link</div>
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
						<div class="d-grid mt-3">
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