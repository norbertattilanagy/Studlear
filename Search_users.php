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
	    <style type="text/css">
	    	.text-underline-hover {
			    text-decoration: none;
			}

			.text-underline-hover:hover {
			    text-decoration: underline;
			}
	    </style>
	</head>
	<body>
		<!--Top bar-->
    	<?php include 'Top_bar.php' ?>

    	<nav class="ms-4" aria-label="breadcrumb">
  			<ol class="breadcrumb">
  		  		<li class="breadcrumb-item"><a href="Home_page.php" style="text-decoration: none;">Acasa</a></li>
  		  		<?php echo '<li class="breadcrumb-item"><a href="Course_page.php?id='.$_SESSION['course_id'].'" style="text-decoration: none;">Curs</a></li>'; ?>
  		  		<?php echo '<li class="breadcrumb-item"><a href="Course_participants.php" style="text-decoration: none;">Participanți curs</a></li>'; ?>
    			<li class="breadcrumb-item active" aria-current="page">Căutare utilizatori</li>
  			</ol>
		</nav>

    	<?php 
    		if($_GET["s"]==0)
    			$_SESSION['search']="";
    	?>
    	<div class="row">
		    <!--Courses group-->
		    <div class="col-md-3">
		    	<?php include 'Courses_group.php' ?>
		    </div>

		    <div class="col-md-9">
		    	<br>
		    	<div class="container">
		    		<form action="Search_users.php?s=1" method="post">
					    <div class="input-group">
					        <input type="text" class="form-control" id="search" name="search" placeholder="Search">
					        <button type="submit" class="input-group-text btn-primary"><i class="bi bi-search me-2"></i> Search</button>
					    </div>
					</form>
					<?php
					if(!empty($_POST['search']) || !empty($_SESSION['search']))
					{
						if(!empty($_POST['search']))
						{
							$search=$_POST['search'];
							$_SESSION['search']=$_POST['search'];
						}
						else
							$search=$_SESSION['search'];
						
						$search_email="'".$search."'";
						$search_name="'%".$search."%'";
						$sql="SELECT * FROM user WHERE email LIKE $search_email OR name LIKE $search_name";
					}
					else
					{
						$sql="SELECT * FROM user";
					}
					$results=mysqli_query($db,$sql);
					$i=1;
					while ($row=mysqli_fetch_array($results,MYSQLI_ASSOC))
					{
						$user_id=$row["id"];
						$course_id=$_SESSION["course_id"];

						$sql_verify="SELECT * FROM course_user WHERE user_id LIKE $user_id and course_id LIKE $course_id";
						$results_verify=mysqli_query($db,$sql_verify);
						$nr_row_verify=mysqli_num_rows($results_verify);

						if($nr_row_verify==0){
							echo '<div class="mt-3">';
								echo '<a class="link-dark text-underline-hover" href="Enroll_in_course.php?enroll=2&course_user='.$row["id"].'">';
										echo '<div class="d-flex justify-content-start">';
											echo '<div class="d-grid col-1">'.$i.'.</div>
											<div class="d-grid col-4">'.$row["name"].'</div>
											<div class="d-grid col-4">'.$row["email"].'</div>';
										echo '</div>';
								echo '</a>';
							echo '</div>';
							$i++;
						}
					}
					?>
		    	</div>

		    </div>
	  	</div>

	  	<!--Footers-->
    	<?php include 'Footers.php' ?>

    	<!--Modal--Add-user-in-course--->
		<div class="modal fade" id="Add_user_in_course">
		  	<div class="modal-dialog">
		    	<div class="modal-content">

		      		<!-- Modal Header -->
		      		<div class="modal-header">
		        		<h4 class="modal-title">Adaugă utilizator</h4>
		        		<button type="button" class="btn-close" data-bs-dismiss="modal" data-bs-target="#Add_user_in_course"></button>
		      		</div>

		      		<!-- Modal body -->
		      		<div class="modal-body">
		      			<?php
		      			$course_user=$_SESSION['course_user'];
		      			$sql_modal="SELECT * FROM user WHERE id LIKE $course_user";
		      			$results_modal=mysqli_query($db,$sql_modal);
		      			$row_modal=mysqli_fetch_array($results_modal,MYSQLI_ASSOC);
		      			?>
		      			<div class="text-center">
		      				<?php echo '<p>Doriti să îl adăugați pe <b>'.$row_modal["name"].'</b>, <b>'.$row_modal["email"].'</b>?</p>'; ?>
		      			</div>
		      			<div class="d-flex justify-content-around">
		      				<div class="d-grid gap-1 col-4">
		      					<a href="Enroll_in_course.php?enroll=3" class="btn btn-danger">Da</a>
		      				</div>
		      				<div class="d-grid gap-1 col-4">
		      					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" data-bs-target="#Add_user_in_course">Nu</button>
		      				</div>
		      			</div>
		      		</div>
		    	</div>
		  	</div>
		</div>

	</body>
</html>

<!--Modal-->
<script type="text/javascript">
	$(document).ready(function() {
	    if(window.location.href.indexOf('#Add_user_in_course') != -1) {
	        $('#Add_user_in_course').modal('show');
	    }
	});
</script>