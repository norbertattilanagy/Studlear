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
  		  		echo '<li class="breadcrumb-item"><a href="Course_page.php?id='.$_SESSION['course_id'].'" style="text-decoration: none;">Curs</a></li>'; ?>
  		  		<?php echo '<li class="breadcrumb-item"><a href="Course_participants.php" style="text-decoration: none;">Participanți curs</a></li>'; ?>
    			<li class="breadcrumb-item active" aria-current="page">Căutare utilizatori</li>
  			</ol>
		</nav>
		<?php 
    		if(empty($_SESSION["s"]))
    			$_SESSION['search']="";
    		else if(isset($_SESSION["s"]))
    		{
    			if($_SESSION['s']!=1)
    				$_SESSION['search']="";
    		}
    	?>

    	<div class="row">
		    <!--Courses group-->
		    <div class="col-md-3">
		    	<?php include 'Courses_group.php' ?>
		    </div>

		    <div class="col-md-9">
		    	<br>
		    	<div class="container">
		    		<form action="Enroll_in_course.php?enroll=7" method="post">
					    <div class="input-group">
					        <?php 
					        echo '<input type="search" class="form-control" id="search" name="search" placeholder="Search" value="'.$_SESSION['search'].'" onClick="this.select();">'; ?>
					        <button type="submit" class="input-group-text btn-primary"><i class="bi bi-search me-2"></i> Search</button>
					    </div>
					</form>
					<table class="table">
	  					<thead>
	    					<tr>
						      	<th scope="col">Id</th>
						      	<th scope="col">Nume</th>
						      	<th scope="col">Email</th>
	    					</tr>
	  					</thead>
	  					<tbody>
							<?php
							if(isset($_GET['page']))
						    	$page=$_GET['page'];
						    else
						    	$page=1;

						    $limit=20;
					    	$start=$limit*($page-1);

							if(!empty($_POST['search']) || !empty($_SESSION['search']))
							{
								if(!empty($_POST['search']))
								{
									$search=$_POST['search'];
								}
								else
									$search=$_SESSION['search'];
								
								$search_email="'".$search."'";
								$search_name="'%".$search."%'";
								$user_id=$_SESSION['user_id'];
								$sql="SELECT * FROM user WHERE (email LIKE $search_email OR name LIKE $search_name) AND type NOT LIKE 'admin' AND id NOT LIKE $user_id";
								$results=mysqli_query($db,$sql);
								$nr_row=mysqli_num_rows($results);
								$sql="SELECT * FROM user WHERE (email LIKE $search_email OR name LIKE $search_name) AND type NOT LIKE 'admin' AND id NOT LIKE $user_id LIMIT $start, $limit";
								$results=mysqli_query($db,$sql);
							}
							else
							{
								$sql="SELECT * FROM user WHERE type NOT LIKE 'admin' AND id NOT LIKE $user_id";
								$results=mysqli_query($db,$sql);
								$nr_row=mysqli_num_rows($results);
								$user_id=$_SESSION['user_id'];
								$sql="SELECT * FROM user WHERE type NOT LIKE 'admin' AND id NOT LIKE $user_id LIMIT $start, $limit";
								$results=mysqli_query($db,$sql);
							}
							$nr=($page-1)*$limit+1;
							while ($row=mysqli_fetch_array($results,MYSQLI_ASSOC))
							{
								$user_id=$row["id"];
								$course_id=$_SESSION["course_id"];

								$sql_verify="SELECT * FROM course_user WHERE user_id LIKE $user_id and course_id LIKE $course_id";
								$results_verify=mysqli_query($db,$sql_verify);
								$nr_row_verify=mysqli_num_rows($results_verify);

								if($nr_row_verify==0){
									echo '<tr>';
										echo '<td><a href="Enroll_in_course.php?enroll=2&course_user='.$row["id"].'" class="link-dark" style="text-decoration: none;">'.$nr.'.</a></td>';
										echo '<td><a href="Enroll_in_course.php?enroll=2&course_user='.$row["id"].'" class="link-dark" style="text-decoration: none;">'.$row["name"].'</a></td>';
										echo '<td><a href="Enroll_in_course.php?enroll=2&course_user='.$row["id"].'" class="link-dark" style="text-decoration: none;">'.$row["email"].'</a></td>';
									echo '</tr>';
									$nr++;
								}
								
							}
							?>
						</tbody>
					</table>
					<?php if($nr_row>$limit){ //pagination?>
						<ul class="pagination justify-content-center">
						    <?php
						    if($nr_row%$limit==0)
						    	$max_page=intdiv($nr_row,$limit);
						    else
						    	$max_page=intdiv($nr_row,$limit)+1;

						    if($page>1)
						    	echo '<li class="page-item"><a class="page-link" href="?page='.($page-1).'">Previous</a></li>'; 
						    else
						    	echo '<li class="page-item disabled"><a class="page-link" href="?page='.($page-1).'">Previous</a></li>';

						    if($page==$max_page and $page>4)
						    	echo '<li class="page-item"><a class="page-link" href="?page='.($page-4).'">'.($page-4).'</a></li>';
						    if(($page==$max_page or $page==$max_page-1) and $page>3)
						    	echo '<li class="page-item"><a class="page-link" href="?page='.($page-3).'">'.($page-3).'</a></li>';
						    if($page>2)
						    	echo '<li class="page-item"><a class="page-link" href="?page='.($page-2).'">'.($page-2).'</a></li>';
							if($page>1)
						    	echo '<li class="page-item"><a class="page-link" href="?page='.($page-1).'">'.($page-1).'</a></li>';

						    echo '<li class="page-item active"><a class="page-link" href="?page='.$page.'">'.$page.'</a></li>';
						    if(($page+1)<=$max_page)
						    	echo '<li class="page-item"><a class="page-link" href="?page='.($page+1).'">'.($page+1).'</a></li>';
							if(($page+2)<=$max_page)
						    	echo '<li class="page-item"><a class="page-link" href="?page='.($page+2).'">'.($page+2).'</a></li>';

						    if($page<=2 and ($page+3)<=$max_page)
						    	echo '<li class="page-item"><a class="page-link" href="?page='.($page+3).'">'.($page+3).'</a></li>';
							if($page==1 and ($page+4)<=$max_page)
						    	echo '<li class="page-item"><a class="page-link" href="?page='.($page+4).'">'.($page+4).'</a></li>';
						    if($page<$max_page)
						    	echo '<li class="page-item"><a class="page-link" href="?page='.($page+1).'">Next</a></li>';
						    else
						    	echo '<li class="page-item disabled"><a class="page-link" href="?page='.($page+1).'">Next</a></li>';
						    ?>
						</ul>
					<?php } ?>
		    	</div>

		    </div>
	  	</div>

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
	        window.history.pushState('', 'Search_users', 'Search_users.php');
	    }
	});
</script>