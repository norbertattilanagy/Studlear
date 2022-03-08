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
	<body>
		<!--Top bar-->
    	<?php include 'Top_bar.php' ?>

    	<nav class="ms-4" aria-label="breadcrumb">
  			<ol class="breadcrumb">
  		  		<li class="breadcrumb-item"><a href="Home_page.php" style="text-decoration: none;">Acasa</a></li>
  		  		<?php echo '<li class="breadcrumb-item"><a href="Course_page.php?id='.$_SESSION['course_id'].'" style="text-decoration: none;">Curs</a></li>'; ?>
    			<li class="breadcrumb-item active" aria-current="page">Participanți curs</li>
  			</ol>
		</nav>

    	<div class="row">
		    <!--Courses group-->
		    <div class="col-md-3">
		    	<?php include 'Courses_group.php' ?>
		    </div>

		    <div class="col-md-9">
		    	<?php if($_SESSION['user_type']=='teacher') { ?>
			      	<a href="Search_users.php?s=0" class="btn btn-primary btn-sm mb-3">Adaugă participanți<i class="bi bi-person-plus ms-2"></i></a>
			    <?php }	?>
		    	<?php
		    	$course_id=$_SESSION["course_id"];

		    	$sql="SELECT * FROM user AS u JOIN course_user AS c ON u.id=c.user_id WHERE c.course_id LIKE $course_id AND u.type LIKE 'student' ORDER BY name";
		    	$results=mysqli_query($db,$sql);
		    	?>
		    	<div class="me-3">
		    		<div class="me-3">
			    	<table class="table">
	  					<thead>
	  						<tr>
						      	<th>#</th>
						      	<th>Nume</th>
						      	<th>Email</th>
						    </tr>
						</thead>
						<tbody>
							<?php
					    	$i=1;
							while($row=mysqli_fetch_array($results))
							{
								echo '<tr>';
	        						echo '<td>'.$i.'</td>';
	        						echo '<td>'.$row["name"].'</td>';
	        						echo '<td>'.$row["email"].'</td>';
	        						echo '<td><a href="Enroll_in_course.php?enroll=4&course_user='.$row["user_id"].'" class="link-dark"><i class="bi bi-trash"></i></a></td>';
	        					echo '</tr>';
	        					$i++;
							}
							?>
							
						</tbody>
					</table>
		    	</div>
		    </div>
		</div>
		<!--Footers-->
    	<?php include 'Footers.php' ?>

    	<!--Modal--Delete-user-from-course--->
		<div class="modal fade" id="Delete_user_from_course">
		  	<div class="modal-dialog">
		    	<div class="modal-content">

		      		<!-- Modal Header -->
		      		<div class="modal-header">
		        		<h4 class="modal-title">Șterge utilizatorul din curs</h4>
		        		<button type="button" class="btn-close" data-bs-dismiss="modal" data-bs-target="#Delete_user_from_course"></button>
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
		      				<?php echo '<p>Doriti să îl ștergeți pe <b>'.$row_modal["name"].'</b>, <b>'.$row_modal["email"].'</b>?</p>'; ?>
		      			</div>
		      			<div class="d-flex justify-content-around">
		      				<div class="d-grid gap-1 col-4">
		      					<a href="Enroll_in_course.php?enroll=5" class="btn btn-danger">Da</a>
		      				</div>
		      				<div class="d-grid gap-1 col-4">
		      					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" data-bs-target="#Delete_user_from_course">Nu</button>
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
	    if(window.location.href.indexOf('#Delete_user_from_course') != -1) {
	        $('#Delete_user_from_course').modal('show');
	    }
	});
</script>