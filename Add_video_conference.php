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
  		  		<li class="breadcrumb-item"><a href="Home_page.php">Acasă</a></li>
  		  		<?php echo '<li class="breadcrumb-item"><a href="Course_page.php?id='.$_SESSION['course_id'].'">Curs</a></li>';
  		  		
  		  		if($_SESSION['add']==1)
    				echo '<li class="breadcrumb-item active" aria-current="page">Adaugă videoconferință</li>';
    			else
    			{
    				echo '<li class="breadcrumb-item"><a href="Video_conference.php?id='.$_SESSION['video_conference'].'">Videoconferință</a></li>';
    				echo '<li class="breadcrumb-item active" aria-current="page">Editează videoconferință</li>';
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
		    		$password="";
		    		$start_event="";
		    		$end_event="";
		    		if($_SESSION['add']==0)
		    		{
		    			$video_conference_id=$_SESSION['video_conference'];
		    			$sql="SELECT * FROM video_conference WHERE id LIKE $video_conference_id";
		    			$results=mysqli_query($db,$sql);
		    			$row=mysqli_fetch_array($results);
		    			$title=$row['title'];
		    			$link=$row['link'];
		    			$password=$row['password'];
		    			$start_event1=date_create($row['start_event']);
		    			$start_event=date_format($start_event1,"Y-m-d")."T".date_format($start_event1,"h:i");
		    			$end_event=date_create($row['end_event']);
		    			$end_event=date_format($end_event,"Y-m-d")."T".date_format($end_event,"h:i");

		    			$date=date('Y-m-d h:i');
		    			if($start_event1<$date)
		    				$min=date("Y-m-d")."T".date("H:i");
		    			else
		    				$min=$start_event;

		    		}
		    		else
		    		{
		    			$min=date("Y-m-d")."T".date("H:i");
		    		}
			    	?>
			    	<?php echo '<form action="Add_video_conference1.php?edit='.$_SESSION['add'].'" class="needs-validation" method="post" novalidate>'; ?>
			    		
			    		<div class="mt-3">
			    			<label for="title" class="form-label"><b>Titlu:</b></label>
			    			<?php echo '<input type="text" class="form-control" id="title" name="title" value="'.$title.'" onClick="this.select();" required>';?>
			    			<div class="invalid-feedback">Introduceți un titlu</div>
			    		</div>
			    		<div class="mt-3">
			    			<label for="link" class="form-label"><b>Link:</b></label>
							<?php echo '<input type="url" class="form-control" id="link" name="link" value="'.$link.'" onClick="this.select();" required>';?>
							<div class="invalid-feedback">Introduceți un link</div>
						</div>
						<div class="mt-3">
							<label for="password" class="form-label"><b>Parolă:</b></label>
							<?php echo '<input type="text" class="form-control" id="password" name="password" value="'.$password.'" onClick="this.select();">';?>
							<p class="text-muted">*Nu este obligatoriu</p>
						</div>
						<div class="mt-3">
							<label for="start_event" class="form-label"><b>Început:</b></label>
							<?php echo '<input type="datetime-local" class="form-control" id="start_event" name="start_event" value="'.$start_event.'" min="'.$min.'" required>'; ?>
							<div class="invalid-feedback">Introduceți începutul</div>
						</div>
						<div class="mt-3">
							<label for="end_event" class="form-label"><b>Final:</b></label>
							<?php echo '<input type="datetime-local" class="form-control" id="end_event" name="end_event" value="'.$end_event.'" min="'.$min.'" required>';?>
							<div class="invalid-feedback">Introduceți finalul</div>
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

    	<!--Footers-->
    	<?php include 'Footers.php' ?>

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