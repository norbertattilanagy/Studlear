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
    			<li class="breadcrumb-item active" aria-current="page">Sondaj</li>
  			</ol>
		</nav>

    	<div class="row">

    		<!--Courses group-->
		    <div class="col-md-3">
		    	<?php include 'Courses_group.php' ?>
		    </div>
		    <div class="col-md-9">
		    	<?php
			    $poll_id=$_GET['id'];
			    $_SESSION['poll']=$poll_id;
				$sql="SELECT * FROM poll WHERE id LIKE $poll_id";
				$results=mysqli_query($db,$sql);
				$row=mysqli_fetch_array($results);

				if($_SESSION['user_type']!="student" and $row['visibility']==0){?>
					<h3><b><?php echo $row['title']; ?></b><i class="bi bi-eye-slash ms-4"></i></h3>
				<?php } else { ?>
					<h3><b><?php echo $row['title']; ?></b></h3>
				<?php }

				if($_SESSION['user_type']!="student") { ?>
					<a href="Add_poll1.php?edit=4&add=0" class="btn btn-primary btn-sm me-2"><i class="bi bi-pencil-square"></i> Editează</a>
					<button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#Delete_poll"><i class="bi bi-trash"></i> Șterge</button>
				<?php } ?>

				<div class="mt-3">
					<p>
						<?php
						$target_file=$row['question'];
						$file = fopen($target_file, "r");
						while(!feof($file)) {
		  					echo fgets($file)."<br>";
						}
						fclose($file);
				    	?>
					</p>
				</div>
				
				<?php
				$user_id=$_SESSION['user_id'];
				$sql_option="SELECT * FROM answer_quiz_option WHERE user_id LIKE $user_id";
				$results_option=mysqli_query($db,$sql_option);
				$row_option=mysqli_fetch_array($results_option);

				if(empty($row_option["id"]) && $_SESSION['user_type']=="student") { ?>
					<div class="me-4">
						<form action="Add_poll1.php?edit=5" method="post" enctype="multipart/form-data">
							<div class="mt-3">
								<?php
								if($row['radio_button']==1)
									$type="radio";
								else
									$type="checkbox";

								$sql_option="SELECT * FROM quiz_option WHERE element LIKE 'poll' AND question_id LIKE $poll_id";
								$results_option=mysqli_query($db,$sql_option);
								$i=0;
								while($row_option=mysqli_fetch_array($results_option))
								{
									echo '<div class="form-check">';
										echo '<input class="form-check-input" type="'.$type.'" value="'.$row_option["id"].'" name="option'.$i.'" id="option'.$i.'">';
										echo '<label class="form-check-label" for="option'.$i.'">'.$row_option["option"].'</label>';
									echo '</div>';
									$i++;
								}
								?>
							</div>
							<div class="d-grid mt-3">
								<button type="submit" class="btn btn-secondary btn-block">Salvează</button>
							</div>
						</form>
					</div>
				<?php } else {

					$poll_id=$_SESSION['poll'];
					$element='"poll"';

					$sql_option="SELECT * FROM quiz_option WHERE element LIKE 'poll' AND question_id LIKE $poll_id";
					$results_option=mysqli_query($db,$sql_option);

					$i=0;
					while($row_option=mysqli_fetch_array($results_option))
					{
						$option_value[$i]=0;
						$option[$i]=$row_option["option"];

						$sql_diagram="SELECT * FROM answer_quiz_option AS aqo JOIN quiz_option AS qo ON aqo.quiz_option_id=qo.id WHERE qo.question_id LIKE $poll_id AND qo.element LIKE $element";
						$results_diagram=mysqli_query($db,$sql_diagram);

						while($row_diagram=mysqli_fetch_array($results_diagram))
						{
							if($row_option["id"]==$row_diagram["quiz_option_id"])
								$option_value[$i]++;

						}
						$i++;
					}
					$nr_answer=0;
					foreach($option_value as $i)
						$nr_answer+=$i;

					$j=0;
					foreach($option_value as $i)
					{
						if ($i==0)
							$percent=0;
						else
							$percent=round(100/$nr_answer*$i);

						echo '<div class="me-4 mb-2">';
							echo '<div class="d-flex justify-content-between ms-1 me-2">';
								echo '<div><b>'.$option[$j].'</b></div><div>'.$i.'</div>';
							echo '</div>';
							
							echo '<div class="progress" style="height: 30px;">';
		  						echo '<div class="progress-bar bg-info" style="width:'.$percent.'%">'.$percent.'%</div>';
							echo '</div>';
						echo '</div>';
						//echo $i." ";

						$j++;
					}
				} ?>
				
		    </div>
		</div>

		<!--Modal--Delete-poll--->
		<div class="modal fade" id="Delete_poll">
		  	<div class="modal-dialog">
		    	<div class="modal-content">

		      		<!-- Modal Header -->
		      		<div class="modal-header">
		        		<h4 class="modal-title">Șterge sondaj</h4>
		        		<button type="button" class="btn-close" data-bs-dismiss="modal" data-bs-target="#Delete_poll"></button>
		      		</div>

		      		<!-- Modal body -->
		      		<div class="modal-body">
		      			<div class="d-flex justify-content-center">
		      				<p><b>Doriti să ștergeți sondajul?</b></p>
		      			</div>
		      			<div class="d-flex justify-content-around">
		      				<div class="d-grid gap-1 col-4">
		      					<a href="Add_poll1.php?edit=2" class="btn btn-danger">Da</a>
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