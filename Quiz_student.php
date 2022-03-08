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
  		  		<li class="breadcrumb-item"><a href="Home_page.php" style="text-decoration: none;">Acasă</a></li>
  		  		<?php echo '<li class="breadcrumb-item"><a href="Course_page.php?id='.$_SESSION['course_id'].'" style="text-decoration: none;">Curs</a></li>'; ?>
    			<li class="breadcrumb-item active" aria-current="page">Start quiz</li>
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
			    	$quiz_id=$_GET['id'];
				    $_SESSION['quiz']=$quiz_id;
				    $_SESSION['question_order']=1;
			    	$sql="SELECT * FROM quiz WHERE id LIKE $quiz_id";
					$results=mysqli_query($db,$sql);
					$row=mysqli_fetch_array($results);
			    	?>
			    	<h3><b><?php echo $row['title']; ?></b></h3>

			    	<hr>

			    	<div class="text-center mt-3">
						<p>
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
					<div class="text-center mt-3">
						<?php 
						if($row['solving_time']>0)
						{
							$solving_time=$row["solving_time"];
				    		$solving_time_hour=intdiv($solving_time,3600);
				    		$solving_time=$solving_time%3600;
				    		$solving_time_min=intdiv($solving_time,60);
				    		$solving_time_sec=$solving_time%60;

				    		if($solving_time_hour<10)
				    			$solving_time_hour="0".$solving_time_hour;
				    		else if($solving_time_hour==0)
				    			$solving_time_hour="00";

				    		if($solving_time_min<10)
				    			$solving_time_min="0".$solving_time_min;
				    		else if($solving_time_min==0)
				    			$solving_time_min="00";

				    		if($solving_time_sec<10)
				    			$solving_time_sec="0".$solving_time_sec;
				    		else if($solving_time_sec==0)
				    			$solving_time_sec="00";

							echo 'Timp de rezolvare: <b>'.$solving_time_hour.':'.$solving_time_min.':'.$solving_time_sec.'</b><br>';
						}

						$start_event=date_create($row['start_event']);
			    		$start_event=date_format($start_event,"Y.m.d. H:i");
			    		$end_event=date_create($row['end_event']);
			    		$end_event=date_format($end_event,"Y.m.d. H:i");

			    		echo 'Început: <b>'.$start_event.'</b><br>';
						echo 'Final: <b>'.$end_event.'</b>';
						?>
					</div>
					<div class="d-grid mt-3">
						<a class="btn btn-secondary" href="Quiz.php">Start quiz</a>
					</div>
				</div>
		    </div>
		</div>

		<!--Footers-->
    	<?php include 'Footers.php' ?>

	</body>
</html>