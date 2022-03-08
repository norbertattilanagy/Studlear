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
    			<li class="breadcrumb-item active" aria-current="page">Căutare curs</li>
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
		    		<form action="Search_courses.php?s=1" method="post">
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
						
						$search_id="'".$search."'";
						$search_title="'%".$search."%'";
						$sql="SELECT * FROM course WHERE id LIKE $search_id OR title LIKE $search_title";
					}
					else
					{
						$sql="SELECT * FROM course";
					}
					$results=mysqli_query($db,$sql);
					while ($row=mysqli_fetch_array($results,MYSQLI_ASSOC))
					{
						$user_id=$_SESSION["user_id"];
						$course_id=$row["id"];
						$sql_verify="SELECT * FROM course_user WHERE user_id LIKE $user_id and course_id LIKE $course_id";
						$results_verify=mysqli_query($db,$sql_verify);
						$nr_row_verify=mysqli_num_rows($results_verify);
						if($nr_row_verify==0){
							echo '<a class="link-dark text-underline-hover" href="Enroll_in_course.php?enroll=0&course_title='.$row["title"].'">';
								echo '<div class="container-sm p-2 my-3 border border-2 rounded">';
									echo '<h4>'.$row["title"].'</h4>';
								echo '</div>';
							echo '</a>';
						}
					}
					?>
		    	</div>

		    </div>
	  	</div>
	  	
	  	<!--Enroll in course modal-->
	  	<div class="modal fade" id="Enroll_in_course">
      		<div class="modal-dialog">
        		<div class="modal-content">

        			<!-- Modal Header -->
			        <div class="modal-header">
			            <h4 class="modal-title">Înscriere la curs</h4>
			            <button type="button" class="btn-close" data-bs-dismiss="modal" data-bs-target="#Enroll_in_course"></button>
			        </div>

			        <!-- Modal body -->
			        <div class="modal-body">
			        	<form action="Enroll_in_course.php?enroll=1" method="post">
			        		<div class="mb-3">
			        			<input type="password" class="form-control" placeholder="Introduceți parola" id="password" name="password">
			        		</div>
			        		<div class="mb-3">
			        			<label class="form-check-label">
					              	<input class="form-check-input" type="checkbox"  name="show_password" onclick="myFunction()"> Arată parola
					            </label>
			        		</div>
			        		<div class="d-grid">
			        			<button type="submit" class="btn btn-dark btn-block">Înscriere</button>
			        		</div>
				            
			        	</form>
			        </div>

        		</div>
        	</div>
        </div>
        <!--Show password-->
	     <script>
	        function myFunction() {
	        	var x = document.getElementById("password");
	          	if (x.type === "password") {
	            	x.type = "text";
	          	} else {
	            	x.type = "password";
	          	}
	        }
	     </script>
	    
	  	<!--Footers-->
    	<?php include 'Footers.php' ?>
	</body>
</html>
<script type="text/javascript">
    $(document).ready(function() {
        if(window.location.href.indexOf('#Enroll_in_course') != -1) {
            $('#Enroll_in_course').modal('show');
        }
    });
</script>