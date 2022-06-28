<?php include 'Connection.php'; ?>
<?php include 'Page_security.php'; ?>
<?php 
if(empty($_SESSION['homework']))
{
	if($_SESSION['user_type']=="admin")
	    header("location:Search_courses.php");
	else
	    header("location:Home_page.php");
}
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

    	<nav class="mx-3" aria-label="breadcrumb">
  			<ol class="breadcrumb">
  		  		<?php
  		  		if($_SESSION['user_type']=="admin")
  					echo '<li class="breadcrumb-item"><a href="Search_courses.php" style="text-decoration: none;">Căutare curs</a></li>';
  				else
  		  			echo '<li class="breadcrumb-item"><a href="Home_page.php" style="text-decoration: none;">Acasă</a></li>';
  		  		echo '<li class="breadcrumb-item"><a href="Course_page.php?id='.$_SESSION['course_id'].'" style="text-decoration: none;">Curs</a></li>'; ?>
  		  		<?php echo '<li class="breadcrumb-item"><a href="Homework.php?id='.$_SESSION['homework'].'" style="text-decoration: none;">Temă</a></li>'; ?>
    			<li class="breadcrumb-item active" aria-current="page">Teme încărcate</li>
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
			    	if(isset($_GET['page']))
					    $page=$_GET['page'];
					else
					   	$page=1;			
					$limit=20;
				    $start=$limit*($page-1);

			    	$homework_id=$_SESSION['homework'];
			    	$course_id=$_SESSION['course_id'];

			    	$sql="SELECT * FROM user AS u JOIN course_user AS c ON u.id=c.user_id WHERE c.course_id LIKE $course_id AND u.type LIKE 'student'";
				    $results=mysqli_query($db,$sql);
					$nr_row=mysqli_num_rows($results);

					$sql="SELECT * FROM user AS u JOIN course_user AS c ON u.id=c.user_id WHERE c.course_id LIKE $course_id AND u.type LIKE 'student' ORDER BY name LIMIT $start, $limit";
				    $results=mysqli_query($db,$sql);
			    	?>
			    	<table class="table">
	  					<thead>
	  						<tr>
						      	<th>#</th>
						      	<th>Nume</th>
						      	<th>Email</th>
						      	<th>Temă</th>
						      	<th>Puncte</th>
						    </tr>
						</thead>
						<tbody>
					    	<?php
					    	$i=1;
					    	$pagination=0;
							while($row=mysqli_fetch_array($results))
							{
								$tema="";
								$point=0;
								$pagination=1;

								$user_id=$row["user_id"];
								$sql_homework="SELECT * FROM answer_homework WHERE homework_id LIKE $homework_id AND user_id LIKE $user_id";
								$results_homework=mysqli_query($db,$sql_homework);
								$row_homework=mysqli_fetch_array($results_homework);

								if(!empty($row_homework["id"]))
								{
									$tema="temă";

									if(empty($row_homework["point"]))
										$point=0;
									else
										$point=$row_homework["point"];
								}
								
								echo '<tr>';
	        						echo '<td>'.$i.'</td>';
	        						echo '<td><a href="My_account.php?id='.$row['user_id'].'" class="link-dark" style="text-decoration:none;">'.$row['name'].'</a></td>';
	        						echo '<td><a href="My_account.php?id='.$row['user_id'].'" class="link-dark" style="text-decoration:none;">'.$row['email'].'</a></td>';
	        						echo '<td><a href="Add_homework1.php?edit=7&user_id='.$user_id.'" class="link-dark">'.$tema.'</a></td>';
	        						if($point>0)
	        							echo '<td><a href="Add_homework1.php?edit=8&user_id='.$user_id.'" class="link-dark" style="text-decoration: none;">'.$point.'</a></td>';
	        						else
	        							echo '<td>'.$point.'</td>';
	        					echo '</tr>';
	        					$i++;
							}
					    	?>

					    </tbody>
					</table>

					<?php if($pagination==1){ //pagination?>
						<ul class="pagination justify-content-center">
						    <?php
						    if($nr_row%$limit==0)
						    	$max_page=intdiv($nr_row,$limit);
						    else
						    	$max_page=intdiv($nr_row,$limit)+1;

						    if($page>1)
						    	echo '<li class="page-item"><a class="page-link" href="?page='.($page-1).'">Anterior</a></li>'; 
						    else
						    	echo '<li class="page-item disabled"><a class="page-link" href="?page='.($page-1).'">Anterior</a></li>';

						    if($page==$max_page and $page>4)
						    	echo '<li class="page-item"><a class="page-link" href="?page='.($page-4).'">'.($page-4).'</a></li>';
						    if(($page==$max_page or $page==$max_page-1) and $page>3)
						    	echo '<li class="page-item"><a class="page-link" href="?page='.($page-3).'">'.($page-3).'</a></li>';
						    if($page>2)
						    	echo '<li class="page-item"><a class="page-link" href="?page='.($page-2).'">'.($page-2).'</a></li>';
							if($page>1)
						    	echo '<li class="page-item"><a class="page-link" href="?page='.($page-1).'">'.($page-1).'</a></li>';

						    echo '<li class="page-item active" aria-current="page"><span class="page-link">'.$page.'</span></li>';
						    if(($page+1)<=$max_page)
						    	echo '<li class="page-item"><a class="page-link" href="?page='.($page+1).'">'.($page+1).'</a></li>';
							if(($page+2)<=$max_page)
						    	echo '<li class="page-item"><a class="page-link" href="?page='.($page+2).'">'.($page+2).'</a></li>';

						    if($page<=2 and ($page+3)<=$max_page)
						    	echo '<li class="page-item"><a class="page-link" href="?page='.($page+3).'">'.($page+3).'</a></li>';
							if($page==1 and ($page+4)<=$max_page)
						    	echo '<li class="page-item"><a class="page-link" href="?page='.($page+4).'">'.($page+4).'</a></li>';
						    if($page<$max_page)
						    	echo '<li class="page-item"><a class="page-link" href="?page='.($page+1).'">Următorul</a></li>';
						    else
						    	echo '<li class="page-item disabled"><a class="page-link" href="?page='.($page+1).'">Următorul</a></li>';
						    ?>
						</ul>
					<?php } ?>

				</div>
		    </div>
		</div>

		<!--Modal-Answer-homework--->
		<div class="modal fade" id="Answer_homework">
		  	<div class="modal-dialog">
		    	<div class="modal-content">

		      		<!-- Modal Header -->
		      		<div class="modal-header">
		        		<h4 class="modal-title">Temă</h4>
		        		<button type="button" class="btn-close" data-bs-dismiss="modal" data-bs-target="#Answer_homework"></button>
		      		</div>

		      		<!-- Modal body -->
		      		<div class="modal-body">
		      			<?php
		      			$homework_id=$_SESSION['homework'];
						$homework_user_id=$_SESSION['homework_user_id'];
					    $sql_modal="SELECT * FROM answer_homework WHERE homework_id LIKE $homework_id AND user_id LIKE $homework_user_id";
					    $results_modal=mysqli_query($db,$sql_modal);
					    $row_modal=mysqli_fetch_array($results_modal); 
					    ?>
						<div class="mt-3">
							<?php
					    	$target_folder_modal = $row_modal["folder_name"];
							$files_modal = scandir($target_folder_modal);
							$nr_files_modal = count($files_modal);
							for($i=0; $i<$nr_files_modal; $i++)
							{
								if($files_modal[$i]!="." and $files_modal[$i]!="..")
								{
									$target_file_modal=$target_folder_modal.$files_modal[$i];
									echo '<p><a href="'.$target_file_modal.'" class="link-dark" style="text-decoration: none;"><i class="bi bi-file-earmark-arrow-up me-3"></i>'.$files_modal[$i].'</a></p>';
								}	
							}
							?> 
						</div>	
				    </div>

		    	</div>
		  	</div>
		</div>

		<!--Modal-Point-homework--->
		<div class="modal fade" id="Point_homework">
		  	<div class="modal-dialog">
		    	<div class="modal-content">

		      		<!-- Modal Header -->
		      		<div class="modal-header">
		        		<h4 class="modal-title">Puncte</h4>
		        		<button type="button" class="btn-close" data-bs-dismiss="modal" data-bs-target="#Point_homework"></button>
		      		</div>

		      		<!-- Modal body -->
		      		<div class="modal-body">
		      			<form action="Add_homework1.php?edit=9" method="post">
		      				<?php
		      				$homework_id=$_SESSION['homework'];
							$homework_user_id=$_SESSION['homework_user_id'];
						    $sql_modal="SELECT * FROM answer_homework WHERE homework_id LIKE $homework_id AND user_id LIKE $homework_user_id";
						    $results_modal=mysqli_query($db,$sql_modal);
						    $row_modal=mysqli_fetch_array($results_modal);
		      				?>
		      				<div class="mt-3">
					    		<label for="point" class="form-label"><b>Puncte:</b></label>
					    		<?php echo '<input type="number" class="form-control" id="point" name="point" value="'.$row_modal["point"].'" onClick="this.select();">';?>
					    	</div>
					    	<div class="d-grid mt-3">
							    <button type="submit" class="btn btn-secondary btn-block">Salvează</button>
							</div>
		      			</form>
				    </div>
		    	</div>
		  	</div>
		</div>

	</body>
</html>
<!--Modal-->
<script type="text/javascript">
	$(document).ready(function() {
	    if(window.location.href.indexOf('#Answer_homework') != -1) {
	        $('#Answer_homework').modal('show');
	    }
	    else if(window.location.href.indexOf('#Point_homework') != -1) {
	        $('#Point_homework').modal('show');
	    }
	    window.history.pushState('', 'Homework_answer_table', 'Homework_answer_table.php');
	});
</script>