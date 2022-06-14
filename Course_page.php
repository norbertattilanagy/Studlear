<?php include 'Connection.php'; ?>
<?php include 'Page_security.php'; ?>
<?php
$_SESSION["course_id"]=$_GET['id'];
?>
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
  		  			echo '<li class="breadcrumb-item"><a href="Home_page.php" style="text-decoration: none;">Acasă</a></li>'; ?>
    			<li class="breadcrumb-item active" aria-current="page">Curs</li>
  			</ol>
		</nav>

    	<div class="row">
		    <!--Courses group-->
		    <div class="col-md-3">
		    	<?php include 'Courses_group.php' ?>
		    </div>

		    <div class="col-md-9">
			    <div class="container">
			    	<?php
				    	$course_id=$_SESSION['course_id'];
				    	$sql="SELECT * FROM course WHERE id LIKE $course_id";
				    	$results=mysqli_query($db,$sql);
				    	$row=mysqli_fetch_array($results,MYSQLI_ASSOC);
				    	$course_name=$row["title"];
				    	$password=$row['password'];
				    	$course_id=$row['id'];
				    ?>	
			    	<?php echo '<h3><u>'.$course_name.'</u></h3>'; ?>
			    	<?php echo 'id: '.$course_id; ?>
			    	<br>
			    	<div class="mt-3">
			    		<a href="Course_participants.php" class="btn btn-primary btn-sm me-2">Participanți<i class="bi bi-people ms-2"></i></a>
			    		<?php if($_SESSION['user_type']!='student') { ?>
			    			<button type="button" class="btn btn-primary btn-sm me-2" data-bs-toggle="modal" data-bs-target="#Edit_course">Editează<i class="bi bi-pencil-square ms-2"></i></button>
			      			<button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#New_lesson_group">Lecție nouă +</button>
			      		<?php }	?>
			    	</div>
			    	

			      	
			    	<?php
			      		$course_id=$_SESSION["course_id"];
			      		$sql="SELECT * FROM lesson_group WHERE course_id LIKE $course_id ORDER BY order_number";
						$results=mysqli_query($db,$sql);
						while($row=mysqli_fetch_array($results,MYSQLI_ASSOC)) {
			      	?>
			      	<?php 
			      	//lesson_group
					if($row["visibility"]==1 OR $_SESSION['user_type']!='student') {	
					?>
		      		<div class="card mt-3">
					 	<div class="card-header">
					 		<div class="d-flex justify-content-between">
						 		<b><?php echo $row["group_title"]; ?></b>
						 		<?php 
						 		if($_SESSION['user_type']!='student') {
						 			if($row["visibility"]==0)
						 				echo '<i class="bi bi-eye-slash"></i>';
						 		?>
							 		<div>
							 			<div class="btn-group drop-down">
	  										<a href="#" class="link-dark" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
	    										<i class="bi bi-plus-circle-fill"></i>
	  										</a>
	  										<ul class="dropdown-menu dropdown-menu-end">
	    										<li>
	    											<?php echo '<a class="dropdown-item" href="Add_announcement1.php?edit=3&add=1&lesson_id='.$row["id"].'"><i class="bi bi-megaphone"></i> Adaugă anunț</a>'; ?>
	    										</li>
	    										<li>
	    											<?php echo '<a class="dropdown-item" href="Add_poll1.php?edit=3&add=1&lesson_id='.$row["id"].'"><i class="bi bi-bar-chart-line"></i> Adaugă sondaj</a>'; ?>
	    										</li>
	    										<li>
	    											<?php echo '<a class="dropdown-item" href="Add_video_conference1.php?edit=3&add=1&lesson_id='.$row["id"].'"><i class="bi bi-camera-video"></i> Adaugă videoconferință</a>'; ?>
	    										</li>
	    										<li>
	    											<?php echo '<a class="dropdown-item" href="Add_course_file1.php?edit=3&add=1&lesson_id='.$row["id"].'"><i class="bi bi-book"></i> Adaugă fișier curs</a>'; ?>
	    										</li>
	    										<li>
	    											<?php echo '<a class="dropdown-item" href="Add_homework1.php?edit=3&add=1&lesson_id='.$row["id"].'"><i class="bi bi-house-door"></i> Adaugă temă</a>'; ?>
	    										</li>
	    										<li>
	    											<?php echo '<a class="dropdown-item" href="Add_folder1.php?edit=3&add=1&lesson_id='.$row["id"].'"><i class="bi bi-folder"></i> Adaugă dosar</a>'; ?>
	    										</li>
	    										<li>
	    											<?php echo '<a class="dropdown-item" href="Add_link1.php?edit=3&add=1&lesson_id='.$row["id"].'"><i class="bi bi-link-45deg"></i> Adaugă link</a>'; ?>
	    										</li>
	    										<li>
	    											<?php echo '<a class="dropdown-item" href="Add_quiz1.php?edit=3&add=1&lesson_id='.$row["id"].'"><i class="bi bi-question-diamond"></i> Adaugă test</a>'; ?>
	    										</li>
	  										</ul>
										</div>
							 			
							 			<?php echo '<a href="Add_lesson.php?edit=3&lesson_id='.$row["id"].'" class="link-dark"><i class="bi bi-pencil-square"></i></a>';?>
							 			<?php echo '<a href="Add_lesson.php?edit=4&lesson_id='.$row["id"].'" class="link-dark"><i class="bi bi-trash"></i></a>';?>
							 		</div>
						 		<?php } ?>
						 	</div>
					 	</div>
					  	<div class="card-body">
					  		<!--Announcment-------->
					  		<?php 
					  		$lesson_id=$row['id'];
					  		$sql_notification="SELECT * FROM notification WHERE lesson_group_id LIKE $lesson_id";
					  		$results_notification=mysqli_query($db,$sql_notification);

					  		while($row_notification=mysqli_fetch_array($results_notification)){
					  			$title=$row_notification["title"];
					  			echo '<div class="mt-3">';
						  			if($_SESSION['user_type']!='student') {
							 			if($row_notification["visibility"]==0)
						  					echo '<a class="link-dark " style="text-decoration: none;" href="Announcement.php?id='.$row_notification["id"].'"><i class="bi bi-megaphone me-3"></i>'.$title.'<i class="bi bi-eye-slash ms-3"></i></a>';
						  				else
						  					echo '<a class="link-dark " style="text-decoration: none;" href="Announcement.php?id='.$row_notification["id"].'"><i class="bi bi-megaphone me-3"></i>'.$title.'</a>';
						  			}
						  			else if($row_notification["visibility"]==1)
						  			{
						  				echo '<a class="link-dark " style="text-decoration: none;" href="Announcement.php?id='.$row_notification["id"].'"><i class="bi bi-megaphone me-3"></i>'.$title.'</a>';
						  			}
					  			echo '</div>';
					  		}
					  		?>
					  		<!--Poll-------->
					  		<?php 
					  		$lesson_id=$row['id'];
					  		$sql_poll="SELECT * FROM poll WHERE lesson_group_id LIKE $lesson_id";
					  		$results_poll=mysqli_query($db,$sql_poll);

					  		while($row_poll=mysqli_fetch_array($results_poll)){
					  			$title=$row_poll["title"];
					  			echo '<div class="mt-3">';
						  			if($_SESSION['user_type']!='student') {
							 			if($row_poll["visibility"]==0)
						  					echo '<a class="link-dark " style="text-decoration: none;" href="Poll.php?id='.$row_poll["id"].'"><i class="bi bi-bar-chart-line me-3"></i>'.$title.'<i class="bi bi-eye-slash ms-3"></i></a>';
						  				else
						  					echo '<a class="link-dark " style="text-decoration: none;" href="Poll.php?id='.$row_poll["id"].'"><i class="bi bi-bar-chart-line me-3"></i>'.$title.'</a>';
						  			}
						  			else if($row_poll["visibility"]==1)
						  			{
						  				echo '<a class="link-dark " style="text-decoration: none;" href="Poll.php?id='.$row_poll["id"].'"><i class="bi bi-bar-chart-line me-3"></i>'.$title.'</a>';
						  			}
					  			echo '</div>';
					  		}
					  		?>
					  		<!--Video-conference------>
					  		<?php 
					  		$lesson_id=$row['id'];
					  		$sql_video_conference="SELECT * FROM video_conference WHERE lesson_group_id LIKE $lesson_id";
					  		$results_video_conference=mysqli_query($db,$sql_video_conference);

					  		while($row_video_conference=mysqli_fetch_array($results_video_conference)){
					  			$title=$row_video_conference["title"];
					  			echo '<div class="mt-3">';
						  			if($_SESSION['user_type']!='student') {
							 			if($row_video_conference["visibility"]==0)
						  					echo '<a class="link-dark " style="text-decoration: none;" href="Video_conference.php?id='.$row_video_conference["id"].'"><i class="bi bi-camera-video me-3"></i>'.$title.'<i class="bi bi-eye-slash ms-3"></i></a>';
						  				else
						  					echo '<a class="link-dark " style="text-decoration: none;" href="Video_conference.php?id='.$row_video_conference["id"].'"><i class="bi bi-camera-video me-3"></i>'.$title.'</a>';
						  			}
						  			else if($row_video_conference["visibility"]==1)
						  			{
						  				echo '<a class="link-dark " style="text-decoration: none;" href="Video_conference.php?id='.$row_video_conference["id"].'"><i class="bi bi-camera-video me-3"></i>'.$title.'</a>';
						  			}
					  			echo '</div>';
					  		}
					  		?>
					  		<!--Course-file------>
					  		<?php 
					  		$lesson_id=$row['id'];
					  		$sql_course_file="SELECT * FROM course_file WHERE lesson_group_id LIKE $lesson_id";
					  		$results_course_file=mysqli_query($db,$sql_course_file);

					  		while($row_course_file=mysqli_fetch_array($results_course_file)){
					  			$title=$row_course_file["title"];
					  			echo '<div class="mt-3">';
						  			if($_SESSION['user_type']!='student') {
							 			if($row_course_file["visibility"]==0)
						  					echo '<a class="link-dark " style="text-decoration: none;" href="Course_file.php?id='.$row_course_file["id"].'"><i class="bi bi-book me-3"></i>'.$title.'<i class="bi bi-eye-slash ms-3"></i></a>';
						  				else
						  					echo '<a class="link-dark " style="text-decoration: none;" href="Course_file.php?id='.$row_course_file["id"].'"><i class="bi bi-book me-3"></i>'.$title.'</a>';
						  			}
						  			else if($row_course_file["visibility"]==1)
						  			{
						  				echo '<a class="link-dark " style="text-decoration: none;" href="Course_file.php?id='.$row_course_file["id"].'"><i class="bi bi-book me-3"></i>'.$title.'</a>';
						  			}
					  			echo '</div>';
					  		}
					  		?>
					  		<!--Homework------>
					  		<?php 
					  		$lesson_id=$row['id'];
					  		$sql_homework="SELECT * FROM homework WHERE lesson_group_id LIKE $lesson_id";
					  		$results_homework=mysqli_query($db,$sql_homework);

					  		while($row_homework=mysqli_fetch_array($results_homework)){
					  			$title=$row_homework["title"];
					  			echo '<div class="mt-3">';
						  			if($_SESSION['user_type']!='student') {
							 			if($row_homework["visibility"]==0)
						  					echo '<a class="link-dark " style="text-decoration: none;" href="Homework.php?id='.$row_homework["id"].'"><i class="bi bi-book me-3"></i>'.$title.'<i class="bi bi-eye-slash ms-3"></i></a>';
						  				else
						  					echo '<a class="link-dark " style="text-decoration: none;" href="Homework.php?id='.$row_homework["id"].'"><i class="bi bi-house-door me-3"></i>'.$title.'</a>';
						  			}
						  			else if($row_homework["visibility"]==1)
						  			{
						  				echo '<a class="link-dark " style="text-decoration: none;" href="Homework.php?id='.$row_homework["id"].'"><i class="bi bi-house-door me-3"></i>'.$title.'</a>';
						  			}
					  			echo '</div>';
					  		}
					  		?>
					  		<!--Folder----------->
					  		<?php 
					  		$lesson_id=$row['id'];
					  		$sql_folder="SELECT * FROM folder WHERE lesson_group_id LIKE $lesson_id";
					  		$results_folder=mysqli_query($db,$sql_folder);

					  		while($row_folder=mysqli_fetch_array($results_folder)){
					  			$title=$row_folder["title"];
					  			echo '<div class="mt-3">';
						  			if($_SESSION['user_type']!='student') {
							 			if($row_folder["visibility"]==0)
						  					echo '<a class="link-dark " style="text-decoration: none;" href="Folder.php?id='.$row_folder["id"].'"><i class="bi bi-folder me-3"></i>'.$title.'<i class="bi bi-eye-slash ms-3"></i></a>';
						  				else
						  					echo '<a class="link-dark " style="text-decoration: none;" href="Folder.php?id='.$row_folder["id"].'"><i class="bi bi-folder me-3"></i>'.$title.'</a>';
						  			}
						  			else if($row_folder["visibility"]==1)
						  			{
						  				echo '<a class="link-dark " style="text-decoration: none;" href="Folder.php?id='.$row_folder["id"].'"><i class="bi bi-folder me-3"></i>'.$title.'</a>';
						  			}
					  			echo '</div>';
					  		}
					  		?>
					  		<!--Link----------->
					  		<?php 
					  		$lesson_id=$row['id'];
					  		$sql_link="SELECT * FROM link WHERE lesson_group_id LIKE $lesson_id";
					  		$results_link=mysqli_query($db,$sql_link);

					  		while($row_link=mysqli_fetch_array($results_link)){
					  			$title=$row_link["title"];
					  			echo '<div class="mt-3">';
						  			if($_SESSION['user_type']!='student') {
							 			if($row_link["visibility"]==0)
						  					echo '<a class="link-dark " style="text-decoration: none;" href="Link.php?id='.$row_link["id"].'"><i class="bi bi-link-45deg me-3"></i>'.$title.'<i class="bi bi-eye-slash ms-3"></i></a>';
						  				else
						  					echo '<a class="link-dark " style="text-decoration: none;" href="Link.php?id='.$row_link["id"].'"><i class="bi bi-link-45deg me-3"></i>'.$title.'</a>';
						  			}
						  			else if($row_link["visibility"]==1)
						  			{
						  				echo '<a class="link-dark " style="text-decoration: none;" href="Link.php?id='.$row_link["id"].'"><i class="bi bi-link-45deg me-3"></i>'.$title.'</a>';
						  			}
					  			echo '</div>';
					  		}
					  		?>
					  		<!--Quiz----------->
					  		<?php 
					  		$lesson_id=$row['id'];
					  		$sql_quiz="SELECT * FROM quiz WHERE lesson_group_id LIKE $lesson_id";
					  		$results_quiz=mysqli_query($db,$sql_quiz);

					  		while($row_quiz=mysqli_fetch_array($results_quiz)){
					  			$title=$row_quiz["title"];
					  			echo '<div class="mt-3">';
						  			if($_SESSION['user_type']!='student') {
							 			if($row_quiz["visibility"]==0)
						  					echo '<a class="link-dark " style="text-decoration: none;" href="Quiz_teacher.php?id='.$row_quiz["id"].'"><i class="bi bi-question-diamond me-3"></i>'.$title.'<i class="bi bi-eye-slash ms-3"></i></a>';
						  				else
						  					echo '<a class="link-dark " style="text-decoration: none;" href="Quiz_teacher.php?id='.$row_quiz["id"].'"><i class="bi bi-question-diamond me-3"></i>'.$title.'</a>';
						  			}
						  			else if($row_quiz["visibility"]==1)
						  			{
						  				echo '<a class="link-dark " style="text-decoration: none;" href="Quiz_start.php?id='.$row_quiz["id"].'"><i class="bi bi-question-diamond me-3"></i>'.$title.'</a>';
						  			}
					  			echo '</div>';
					  		}
					  		?>
					  	</div>
					</div>
				<?php } }?>
		      	</div>
		    </div>
	  	</div>
	  	<!--Edit course modal-->
	    <div class="modal fade" id="Edit_course">
	      <div class="modal-dialog">
	        <div class="modal-content">

	          <!-- Modal Header -->
	          <div class="modal-header">
	            <h4 class="modal-title">Editează curs</h4>
	            <button type="button" class="btn-close" data-bs-dismiss="modal" data-bs-target="#Edit_course"></button>
	          </div>

	          <!-- Modal body -->
	          <div class="modal-body">
	            <?php echo '<form action="Add_lesson.php?edit=5&id='.$course_id.'" class="needs-validation" method="post" novalidate>
	              <div class="mb-3">'; ?>
	                <label for="Cours_name" class="form-label">Nume curs:</label>
	                <?php echo '<input type="text" class="form-control" id="Cours_name" placeholder="Nume curs" name="Cours_name" value="'.$course_name.'" required>'; ?>
	                <div class="invalid-feedback">Introduceți numele cursului</div>
	              </div>
	              <div class="mb-3">
	                <label for="Cours_password" class="form-label">Parolă curs:</label>
	                <?php echo '<input type="text" class="form-control" id="Cours_password" placeholder="Parolă curs" name="Cours_password" value="'.$password.'">'; ?>
	              </div>
	              <div class="d-grid">
	                <button type="submit" class="btn btn-secondary btn-block mt-3">Salvează</button>
	              </div>
	            </form>
	          </div>
	        </div>
	      </div>
	    </div>
	  	
	  	<!--Modal--New-lesson-group--->
		<div class="modal fade" id="New_lesson_group">
		  	<div class="modal-dialog">
		    	<div class="modal-content">

		      		<!-- Modal Header -->
		      		<div class="modal-header">
		        		<h4 class="modal-title">Lecție nouă</h4>
		        		<button type="button" class="btn-close" data-bs-dismiss="modal" data-bs-target="#New_lesson_group"></button>
		      		</div>

		      		<!-- Modal body -->
		      		<div class="modal-body">
		      			<form action="Add_lesson.php?edit=0" class="needs-validation" method="post" novalidate>
		      				<div class="mb-3">
							    <label for="lesson_title" class="form-label">Titlu lecție:</label>
							    <input type="text" class="form-control" id="lesson_title" name="lesson_title" required>
							    <div class="invalid-feedback">Introduceți titlul lecției</div>
							</div>
							<?php
								$course_id=$_SESSION["course_id"];
								$sql="SELECT * FROM lesson_group WHERE course_id LIKE $course_id";
								$results=mysqli_query($db,$sql);
								$max=mysqli_num_rows($results)+1;
							?>
							<div class="mb-3">
								<label for="order_number">Numărul de ordine:</label>
								<?php echo '<input type="number" class="input_number" id="order_number" name="order_number" value="'.$max.'" min="1" max="'.$max.'">'; ?>
							</div>
							<div class="form-check">
      							<input class="form-check-input" type="checkbox" id="visibility" name="visibility" checked> 
    							<label class="form-check-label" for="visibility">Vizibilitate</label>
							</div>
							<div class="d-grid">
						    	<button type="submit" class="btn btn-secondary btn-block mt-3">Crează</button>
						    </div>
						</form>
		      		</div>

		    	</div>
		  	</div>
		</div>

		<!--Modal--Edit-lesson-group--->
		<div class="modal fade" id="Edit_lesson_group">
		  	<div class="modal-dialog">
		    	<div class="modal-content">

		      		<!-- Modal Header -->
		      		<div class="modal-header">
		        		<h4 class="modal-title">Editare lecție</h4>
		        		<button type="button" class="btn-close" data-bs-dismiss="modal" data-bs-target="#Edit_lesson_group"></button>
		      		</div>

		      		<!-- Modal body -->
		      		<div class="modal-body">
		      			<form action="Add_lesson.php?edit=1" class="needs-validation" method="post" novalidate>
		      				<?php
								$course_id=$_SESSION["course_id"];
								$sql="SELECT * FROM lesson_group WHERE course_id LIKE $course_id";
								$results=mysqli_query($db,$sql);
								$max=mysqli_num_rows($results);

								$lesson_id=$_SESSION['lesson_id'];
								$sql="SELECT * FROM lesson_group WHERE id LIKE $lesson_id";
								$results=mysqli_query($db,$sql);
								$row=mysqli_fetch_array($results,MYSQLI_ASSOC);
							?>
		      				<div class="mb-3">
							    <label for="lesson_title" class="form-label" placeholder="">Titlu lecție:</label>
							    <?php echo '<input type="text" class="form-control" id="lesson_title" name="lesson_title" value="'.$row["group_title"].'" onClick="this.select();" required>'; ?>
							    <div class="invalid-feedback">Introduceți titlul lecției</div>
							</div>
							<div class="mb-3">
								<label for="order_number">Numărul de ordine:</label>
								<?php echo '<input type="number" class="input_number" id="order_number" name="order_number" value="'.$row["order_number"].'" min="1" max="'.$max.'">'; ?>
							</div>
							<div class="form-check">
								
								<?php 
								if($row["visibility"]==1){
									echo '<input class="form-check-input" type="checkbox" id="visibility" name="visibility" checked>';
								}
								else
								{
									echo '<input class="form-check-input" type="checkbox" id="visibility" name="visibility">';
								}
								?> 
      							<label class="form-check-label" for="visibility">Vizibilitate</label>
							</div>
							<div class="d-grid">
						    	<button type="submit" class="btn btn-secondary btn-block mt-3">Editează</button>
						    </div>
						</form>
		      		</div>

		    	</div>
		  	</div>
		</div>

		<!--Modal--Delete-lesson-group--->
		<div class="modal fade" id="Delete_lesson_group">
		  	<div class="modal-dialog">
		    	<div class="modal-content">

		      		<!-- Modal Header -->
		      		<div class="modal-header">
		        		<h4 class="modal-title">Șterge lecție</h4>
		        		<button type="button" class="btn-close" data-bs-dismiss="modal" data-bs-target="#Delete_lesson_group"></button>
		      		</div>

		      		<!-- Modal body -->
		      		<div class="modal-body">
		      			<div class="d-flex justify-content-center">
		      				<p>Doriti să ștergeți lecția?</p>
		      			</div>
		      			<div class="d-flex justify-content-around">
		      				<div class="d-grid gap-1 col-4">
		      					<a href="Add_lesson.php?edit=2" class="btn btn-danger">Da</a>
		      				</div>
		      				<div class="d-grid gap-1 col-4">
		      					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" data-bs-target="#Delete_lesson_group">Nu</button>
		      				</div>
		      			</div>
		      		</div>
		    	</div>
		  	</div>
		</div>
	
	</body>
</html>
<!--Max min input number-->
<script type="text/javascript">
	document.getElementsByClassName('input_number')[0].oninput = function () {
	    var max = parseInt(this.max);
	    var min = parseInt(this.min);

		if (parseInt(this.value) > max) {
		    this.value = max; 
		}
		else if (parseInt(this.value) < min) {
		    this.value = min; 
		}
    }
</script>
<!--Modal-->
<script type="text/javascript">
	$(document).ready(function() {
		var id=<?php echo $_GET['id']; ?>;
		var url='Course_page.php?id='+id;
	    if(window.location.href.indexOf('#Edit_lesson_group') != -1) {
	        $('#Edit_lesson_group').modal('show');
	        window.history.pushState('', 'Course_page', url);
	    }
	    else if(window.location.href.indexOf('#Delete_lesson_group') != -1) {
	        $('#Delete_lesson_group').modal('show');
	        window.history.pushState('', 'Course_page', url);
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