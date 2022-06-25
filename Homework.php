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

    	<?php 
    	$homework_id=$_GET['id'];
    	if(empty($_SESSION['course_id']))
    	{
    		$sql="SELECT * FROM homework AS h JOIN lesson_group AS lg ON h.lesson_group_id=lg.id WHERE h.id LIKE $homework_id";
    		$results=mysqli_query($db,$sql);
			$row=mysqli_fetch_array($results);
			$_SESSION['course_id']=$row['course_id'];
    	}
    	?>

    	<nav class="mx-3" aria-label="breadcrumb">
  			<ol class="breadcrumb">
  		  		<?php
  		  		if($_SESSION['user_type']=="admin")
  					echo '<li class="breadcrumb-item"><a href="Search_courses.php" style="text-decoration: none;">Căutare curs</a></li>';
  				else
  		  			echo '<li class="breadcrumb-item"><a href="Home_page.php" style="text-decoration: none;">Acasă</a></li>';
  		  		echo '<li class="breadcrumb-item"><a href="Course_page.php?id='.$_SESSION['course_id'].'" style="text-decoration: none;">Curs</a></li>'; ?>
    			<li class="breadcrumb-item active" aria-current="page">Temă</li>
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
				    $_SESSION['homework']=$homework_id;
					$sql="SELECT * FROM homework WHERE id LIKE $homework_id";
					$results=mysqli_query($db,$sql);
					$row=mysqli_fetch_array($results);

					if($_SESSION['user_type']!="student" and $row['visibility']==0){?>
						<h3><b><?php echo $row['title']; ?></b><i class="bi bi-eye-slash ms-4"></i></h3>
					<?php } else { ?>
						<h3><b><?php echo $row['title']; ?></b></h3>
					<?php }
					if($_SESSION['user_type']!="student") { ?>
						<a href="Add_homework1.php?edit=4&add=0" class="btn btn-primary btn-sm me-2"><i class="bi bi-pencil-square"></i> Editează</a>
						<button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#Delete_homework"><i class="bi bi-trash"></i> Șterge</button>
					<?php } ?>

					<div class="mt-3">
						<p>
							<?php
							$target_file=$row['requirement'];
							$file = fopen($target_file, "r");
							while(!feof($file)) {
			  					echo fgets($file)."<br>";
							}
							fclose($file);
					    	?>
						</p>
					</div>
					<div class="mt-3">
						<?php
						$target_folder=$row["folder_name"];
						$files = scandir($target_folder);
						$nr_files = count($files);
						for($i=0; $i<$nr_files; $i++)
						{
							if($files[$i]!="." and $files[$i]!="..")
							{
								$target_file=$target_folder.$files[$i];
								echo '<p><a href="'.$target_file.'" class="link-dark" style="text-decoration: none;"><i class="bi bi-file-earmark me-3"></i>'.$files[$i].'</a></p>';
							}
							
						}
						
						?>
						<a href=""></a>
					</div>
					<div class="mt-3">
						<?php
							$date_limit=date_create($row['end_event']);
			    			$date_limit=date_format($date_limit,"Y.m.d. H:i");
						?>
						<p><b>Data de predare limită: <?php echo $date_limit;?></b></p>
					</div>
					<?php if($_SESSION['user_type']=="student") {?>
						<button type="button" class="btn btn-primary btn-sm mt-3" data-bs-toggle="modal" data-bs-target="#Upload_homework">Încarcă tema</button>
					<?php } else { ?>
						<a href="Homework_answer_table.php" class="btn btn-primary btn-sm mt-3">Teme încărcate</a>
					<?php } ?>

					<?php
					$homework_id=$_SESSION['homework'];
					$user_id=$_SESSION['user_id'];
				    $sql_modal="SELECT * FROM answer_homework WHERE homework_id LIKE $homework_id AND user_id LIKE $user_id";
				    $results_modal=mysqli_query($db,$sql_modal);
				    $row_modal=mysqli_fetch_array($results_modal); 

				    if(!empty($row_modal["folder_name"])) { ?>
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
				    <?php } ?>
				</div>
			</div>
		</div>

		<!--Modal--Delete-homework--->
		<div class="modal fade" id="Delete_homework">
		  	<div class="modal-dialog">
		    	<div class="modal-content">

		      		<!-- Modal Header -->
		      		<div class="modal-header">
		        		<h4 class="modal-title">Șterge tema</h4>
		        		<button type="button" class="btn-close" data-bs-dismiss="modal" data-bs-target="#Delete_homework"></button>
		      		</div>

		      		<!-- Modal body -->
		      		<div class="modal-body">
		      			<div class="d-flex justify-content-center">
		      				<p><b>Doriti să ștergeți tema?</b></p>
		      			</div>
		      			<div class="d-flex justify-content-around">
		      				<div class="d-grid gap-1 col-4">
		      					<a href="Add_homework1.php?edit=2" class="btn btn-danger">Da</a>
		      				</div>
		      				<div class="d-grid gap-1 col-4">
		      					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" data-bs-target="#Delete_lesson_group">Nu</button>
		      				</div>
		      			</div>
		      		</div>

		    	</div>
		  	</div>
		</div>

		<!--Modal--Upload-homework--->
		<div class="modal fade" id="Upload_homework">
		  	<div class="modal-dialog">
		    	<div class="modal-content">

		      		<!-- Modal Header -->
		      		<div class="modal-header">
		        		<h4 class="modal-title">Încarcă tema</h4>
		        		<button type="button" class="btn-close" data-bs-dismiss="modal" data-bs-target="#Upload_homework"></button>
		      		</div>

		      		<!-- Modal body -->
		      		<div class="modal-body">
		      			<?php
						$homework_id=$_SESSION['homework'];
						$user_id=$_SESSION['user_id'];
			    		$sql_modal="SELECT * FROM answer_homework WHERE homework_id LIKE $homework_id AND user_id LIKE $user_id";
			    		$results_modal=mysqli_query($db,$sql_modal);
			    		$row_modal=mysqli_fetch_array($results_modal); 
			    		if(empty($row_modal["folder_name"]))//add
			    			$action="Add_homework1.php?edit=5";
			    		else//edit
			    			$action="Add_homework1.php?edit=6";
			    		
		      			echo '<form action="'.$action.'" method="post" enctype="multipart/form-data">';
		      				if(!empty($row_modal["folder_name"])) { ?>
			      				<div class="mb-3">
					    			<div class="mb-2">
					    				<b>Șterge fișiere:</b><br>
					    			</div>

									<?php
				    				$target_folder_modal = $row_modal["folder_name"];
									$files_modal = scandir($target_folder_modal);
									$nr_files_modal = count($files_modal);
									for($i=0; $i<$nr_files_modal; $i++)
									{
										if($files_modal[$i]!="." and $files_modal[$i]!="..")
										{
											$target_file_modal=$target_folder_modal.$files_modal[$i];
											echo '<div class="form-check">';
												echo '<label class="form-check-label" for="file'.$i.'"><a href="'.$target_file_modal.'" class="link-dark" style="text-decoration: none;">'.$files_modal[$i].'</a></label>';
												echo '<input class="form-check-input" type="checkbox" id="file'.$i.'" name="file'.$i.'">';
											echo '</div>';
										}	
									} ?>
								</div>
							<?php } ?>
							<div>
					    		<label for="files" class="form-label"><b>Adaugă fișiere:</b></label>
	  							<input class="form-control" type="file" id="files" name="files[]" multiple>
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