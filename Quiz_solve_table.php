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

    	<nav class="ms-4" aria-label="breadcrumb">
  			<ol class="breadcrumb">
  		  		<?php
  		  		if($_SESSION['user_type']=="admin")
  					echo '<li class="breadcrumb-item"><a href="Search_courses.php" style="text-decoration: none;">Căutare curs</a></li>';
  				else
  		  			echo '<li class="breadcrumb-item"><a href="Home_page.php" style="text-decoration: none;">Acasă</a></li>';
  		  		echo '<li class="breadcrumb-item"><a href="Course_page.php?id='.$_SESSION['course_id'].'" style="text-decoration: none;">Curs</a></li>'; 
  		  		echo '<li class="breadcrumb-item"><a href="Quiz_teacher.php?id='.$_SESSION['quiz'].'" style="text-decoration: none;">Quiz</a></li>';
  		  		?>
    			<li class="breadcrumb-item active" aria-current="page">Tabel rezolvări</li>
  			</ol>
		</nav>
		<div class="row">

    		<!--Courses group-->
		    <div class="col-md-3">
		    	<?php include 'Courses_group.php' ?>
		    </div>
		    <div class="col-md-9">
		    	<div class="me-4">
			    	<table class="table">
	  					<thead>
	    					<tr>
						      	<th scope="col">#</th>
						      	<th scope="col">Nume</th>
						      	<th scope="col">Email</th>
						      	<th scope="col">Puncte</th>
						      	<th scope="col">Rezolvare</th>
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
					    	
					    	$course_id=$_SESSION['course_id'];
					    	$sql="SELECT u.id, u.name, u.email, u.type, c.course_id, c.user_id FROM user AS u JOIN course_user AS c ON u.id=c.user_id WHERE c.course_id LIKE $course_id AND u.type LIKE 'student'";
					    	$results=mysqli_query($db,$sql);
							$nr_row=mysqli_num_rows($results);

					    	$sql="SELECT u.id, u.name, u.email, u.type, c.course_id, c.user_id FROM user AS u JOIN course_user AS c ON u.id=c.user_id WHERE c.course_id LIKE $course_id AND u.type LIKE 'student' ORDER BY name LIMIT $start, $limit";
					    	$results=mysqli_query($db,$sql);
					    	

					    	$quiz_id=$_SESSION['quiz'];
					    	
					    	$nr=($page-1)*$limit+1;

					    	while($row=mysqli_fetch_array($results))
					    	{	
					    		$resolved=0;
					    		$sql_verify="SELECT * FROM question_order WHERE quiz_id LIKE $quiz_id ORDER BY order_number";
						    	$results_verify=mysqli_query($db,$sql_verify);
						    	$user_id=$row['id'];
					    		$point=0;
					    		$max_point=0;
					    		
					    		//point,resolved verification
						    	while($row_verify=mysqli_fetch_array($results_verify))
						    	{
							    	$answer_id=$row_verify['answer_id'];
							    	if($row_verify['element']=="radio_button")
									{
										$sql_answer="SELECT * FROM answer_quiz_option WHERE quiz_option_id IN (SELECT id FROM quiz_option WHERE question_id LIKE $answer_id AND element LIKE 'radio_button') AND user_id LIKE $user_id";
										$results_answer=mysqli_query($db,$sql_answer);
										$row_answer=mysqli_fetch_array($results_answer);
										if(isset($row_answer['point']))
										{
											$resolved=1;
											$point+=$row_answer['point'];
										}
										$sql_max_point="SELECT `point` FROM radio_button WHERE id LIKE $answer_id LIMIT 1";
										$results_max_point=mysqli_query($db,$sql_max_point);
										$row_max_point=mysqli_fetch_array($results_max_point);
										$max_point+=$row_max_point['point'];
									}
									else if($row_verify['element']=="checkbox")
									{
										$sql_answer="SELECT * FROM answer_quiz_option WHERE quiz_option_id IN (SELECT id FROM quiz_option WHERE question_id LIKE $answer_id AND element LIKE 'checkbox') AND user_id LIKE $user_id";
										$results_answer=mysqli_query($db,$sql_answer);
										$row_answer=mysqli_fetch_array($results_answer);
										if(isset($row_answer['point']))
										{
											$resolved=1;
											$point+=$row_answer['point'];
										}
										$sql_max_point="SELECT `point` FROM checkbox WHERE id LIKE $answer_id LIMIT 1";
										$results_max_point=mysqli_query($db,$sql_max_point);
										$row_max_point=mysqli_fetch_array($results_max_point);
										$max_point+=$row_max_point['point'];
									}
									else if($row_verify['element']=="true_false")
									{
										$sql_answer="SELECT * FROM answer_true_false WHERE true_false_id IN (SELECT id FROM true_false WHERE id LIKE $answer_id) AND user_id LIKE $user_id";
										$results_answer=mysqli_query($db,$sql_answer);
										$row_answer=mysqli_fetch_array($results_answer);
										if(isset($row_answer['point']))
										{
											$resolved=1;
											$point+=$row_answer['point'];
										}
										$sql_max_point="SELECT `point` FROM true_false WHERE id LIKE $answer_id LIMIT 1";
										$results_max_point=mysqli_query($db,$sql_max_point);
										$row_max_point=mysqli_fetch_array($results_max_point);
										$max_point+=$row_max_point['point'];
									}
									else if($row_verify['element']=="text")
									{
										$sql_answer="SELECT * FROM answer_text_question WHERE text_question_id IN (SELECT id FROM text_question WHERE id LIKE $answer_id) AND user_id LIKE $user_id";
										$results_answer=mysqli_query($db,$sql_answer);
										$row_answer=mysqli_fetch_array($results_answer);
										if(isset($row_answer['point']))
										{
											$resolved=1;
											$point+=$row_answer['point'];
										}
										$sql_max_point="SELECT `point` FROM text_question WHERE id LIKE $answer_id LIMIT 1";
										$results_max_point=mysqli_query($db,$sql_max_point);
										$row_max_point=mysqli_fetch_array($results_max_point);
										$max_point+=$row_max_point['point'];
									}
									else if($row_verify['element']=="select")
									{
										$sql_answer="SELECT * FROM answer_select_question WHERE select_option_id IN (SELECT id FROM select_option WHERE select_question_id LIKE $answer_id) AND user_id LIKE $user_id";
										$results_answer=mysqli_query($db,$sql_answer);
										$row_answer=mysqli_fetch_array($results_answer);
										if(isset($row_answer['point']))
										{
											$resolved=1;
											$point+=$row_answer['point'];
										}
										$sql_max_point="SELECT `point` FROM select_question WHERE id LIKE $answer_id LIMIT 1";
										$results_max_point=mysqli_query($db,$sql_max_point);
										$row_max_point=mysqli_fetch_array($results_max_point);
										$max_point+=$row_max_point['point'];
									}
								}

					    		echo '<tr>';
						    		echo '<th>'.$nr.'</th>';
						    		echo '<td><a href="My_account.php?id='.$row['id'].'" class="link-dark" style="text-decoration:none;">'.$row['name'].'</a></td>';
						    		echo '<td><a href="My_account.php?id='.$row['id'].'" class="link-dark" style="text-decoration:none;">'.$row['email'].'</a></td>';
						    		echo '<td><b>'.$point.'</b> / '.$max_point.'</td>';
						    		if($resolved==0)
						    			echo '<td><i class="bi bi-x-circle ms-4" style="color:red;"></i></td>';
						    		else
						    			echo '<td><a class="ms-4" href="Quiz_solve.php?id='.$row['id'].'" style="color:green;"><i class="bi bi-check-circle"></i></a></td>';
						    	echo '</tr>';
						    	$nr++;
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

	</body>
</html>