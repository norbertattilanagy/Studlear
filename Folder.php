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
  		  		echo '<li class="breadcrumb-item"><a href="Course_page.php?id='.$_SESSION['course_id'].'" style="text-decoration: none;">Curs</a></li>'; ?>
    			<li class="breadcrumb-item active" aria-current="page">Folder</li>
  			</ol>
		</nav>

    	<div class="row">

    		<!--Courses group-->
		    <div class="col-md-3">
		    	<?php include 'Courses_group.php' ?>
		    </div>
		    <div class="col-md-9">
		    	<?php
			    $folder_id=$_GET['id'];
			    $_SESSION['folder']=$folder_id;
				$sql="SELECT * FROM folder WHERE id LIKE $folder_id";
				$results=mysqli_query($db,$sql);
				$row=mysqli_fetch_array($results);

				if($_SESSION['user_type']!="student" and $row['visibility']==0){?>
					<h3><b><?php echo $row['title']; ?></b><i class="bi bi-eye-slash ms-4"></i></h3>
				<?php } else { ?>
					<h3><b><?php echo $row['title']; ?></b></h3>
				<?php }
				if($_SESSION['user_type']!="student") { ?>
					<a href="Add_folder1.php?edit=4&add=0" class="btn btn-primary btn-sm me-2"><i class="bi bi-pencil-square"></i> Editează</a>
					<button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#Delete_folder"><i class="bi bi-trash"></i> Șterge</button>
				<?php } ?>

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
			</div>
		</div>

		<!--Modal--Delete-folder--->
		<div class="modal fade" id="Delete_folder">
		  	<div class="modal-dialog">
		    	<div class="modal-content">

		      		<!-- Modal Header -->
		      		<div class="modal-header">
		        		<h4 class="modal-title">Șterge videoconferința</h4>
		        		<button type="button" class="btn-close" data-bs-dismiss="modal" data-bs-target="#Delete_folder"></button>
		      		</div>

		      		<!-- Modal body -->
		      		<div class="modal-body">
		      			<div class="d-flex justify-content-center">
		      				<p><b>Doriti să ștergeți folderul?</b></p>
		      			</div>
		      			<div class="d-flex justify-content-around">
		      				<div class="d-grid gap-1 col-4">
		      					<a href="Add_folder1.php?edit=2" class="btn btn-danger">Da</a>
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