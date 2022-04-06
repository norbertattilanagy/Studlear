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
  		  		<li class="breadcrumb-item"><a href="Home_page.php" style="text-decoration: none;">Acasă</a></li>
  		  		<?php echo '<li class="breadcrumb-item"><a href="Course_page.php?id='.$_SESSION['course_id'].'" style="text-decoration: none;">Curs</a></li>'; ?>
    			<li class="breadcrumb-item active" aria-current="page">Link</li>
  			</ol>
		</nav>

    	<div class="row">

    		<!--Courses group-->
		    <div class="col-md-3">
		    	<?php include 'Courses_group.php' ?>
		    </div>
		    <div class="col-md-9">
		    	<?php
			    $link_id=$_GET['id'];
			    $_SESSION['link']=$link_id;
				$sql="SELECT * FROM link WHERE id LIKE $link_id";
				$results=mysqli_query($db,$sql);
				$row=mysqli_fetch_array($results);

				if($_SESSION['user_type']=="teacher" and $row['visibility']==0){?>
					<h3><b><?php echo $row['title']; ?></b><i class="bi bi-eye-slash ms-4"></i></h3>
				<?php } else { ?>
					<h3><b><?php echo $row['title']; ?></b></h3>
				<?php }
				if($_SESSION['user_type']=="teacher") { ?>
					<a href="Add_link1.php?edit=4&add=0" class="btn btn-primary btn-sm me-2"><i class="bi bi-pencil-square"></i> Editează</a>
					<button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#Delete_link"><i class="bi bi-trash"></i> Șterge</button>
				<?php } ?>

				<div class="mt-3">
					<?php echo '<p><a href="'.$row["link"].'">'.$row["link"].'</a></p>'; ?>
					<p class="mt-3">
						<?php
						$target_file=$row['description'];
						$file = fopen($target_file, "r");
						while(!feof($file)) {
		  					echo fgets($file)."<br>";
						}
						fclose($file);
				    	?>
				    </p>
				</div>
			</div>
		</div>

		<!--Modal--Delete-lesson-group--->
		<div class="modal fade" id="Delete_link">
		  	<div class="modal-dialog">
		    	<div class="modal-content">

		      		<!-- Modal Header -->
		      		<div class="modal-header">
		        		<h4 class="modal-title">Șterge videoconferința</h4>
		        		<button type="button" class="btn-close" data-bs-dismiss="modal" data-bs-target="#Delete_link"></button>
		      		</div>

		      		<!-- Modal body -->
		      		<div class="modal-body">
		      			<div class="d-flex justify-content-center">
		      				<p><b>Doriti să ștergeți linkul?</b></p>
		      			</div>
		      			<div class="d-flex justify-content-around">
		      				<div class="d-grid gap-1 col-4">
		      					<a href="Add_link1.php?edit=2" class="btn btn-danger">Da</a>
		      				</div>
		      				<div class="d-grid gap-1 col-4">
		      					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" data-bs-target="#Delete_lesson_group">Nu</button>
		      				</div>
		      			</div>
		      		</div>

		    	</div>
		  	</div>
		</div>

		<!--Footers-->
    	<?php include 'Footers.php' ?>

	</body>
</html>