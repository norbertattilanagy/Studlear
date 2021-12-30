<div class="container mt-3">

	<h5>Cursuri favorite:</h5>
	<button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#New_group_Modal">Grup nou +</button>

	<!--Modal-new-group--->
	<div class="modal fade" id="New_group_Modal">
	  	<div class="modal-dialog">
	    	<div class="modal-content">

	      		<!-- Modal Header -->
	      		<div class="modal-header">
	        		<h4 class="modal-title">Grup nou</h4>
	        		<button type="button" class="btn-close" data-bs-dismiss="modal" data-bs-target="#New_group_Modal"></button>
	      		</div>

	      		<!-- Modal body -->
	      		<div class="modal-body">
	      			<form action="Add_course_group.php?edit=0" method="post">
	      				<div class="mb-3">
						    <label for="group_name" class="form-label">Nume grup:</label>
						    <input type="text" class="form-control" id="group_name" placeholder="Nume grup" name="group_name">
						</div>
						<?php 
						$user_id=$_SESSION['user_id'];
						$sql_modal="SELECT * FROM course_user WHERE user_id LIKE $user_id";
			            $results_modal=mysqli_query($db,$sql_modal);
			           	$j=0;
			            while ($row_modal=mysqli_fetch_array($results_modal,MYSQLI_ASSOC))
			            {
			            	$course_id_modal=$row_modal['course_id'];
			              	$sql_course_modal="SELECT * FROM course WHERE id LIKE $course_id_modal";
			              	$results_course_modal=mysqli_query($db,$sql_course_modal);
			              	$row_course_modal=mysqli_fetch_array($results_course_modal,MYSQLI_ASSOC);
							
		        			echo '<div class="form-check">
							  		<input class="form-check-input" type="checkbox" id="check'.$j.'" name="option'.$j.'" value="'.$course_id_modal.'">
							  		<label class="form-check-label" for="check'.$j.'">'.$row_course_modal['title'].'</label>
								</div>';
							$j++;
						} ?>

					    <div class="d-grid">
					    	<button type="submit" class="btn btn-secondary btn-block mt-3">Crează</button>
					    </div>
					</form>
	      		</div>

	    	</div>
	  	</div>
	</div>

	<!--Modal-add-course--->
	<div class="modal fade" id="Add_course_Modal">
	  	<div class="modal-dialog">
	    	<div class="modal-content">

	      		<!-- Modal Header -->
	      		<div class="modal-header">
	        		<h4 class="modal-title">Adaugă cursuri</h4>
	        		<button type="button" class="btn-close" data-bs-dismiss="modal" data-bs-target="#Add_course_Modal"></button>
	      		</div>

	      		<!-- Modal body -->
	      		<div class="modal-body">
	      			<form action="Add_course_group.php?edit=1" method="post">
	      				<?php 
						$user_id=$_SESSION['user_id'];
						$sql_modal="SELECT * FROM course_user WHERE user_id LIKE $user_id";
			            $results_modal=mysqli_query($db,$sql_modal);
			           	$j=0;
			            while ($row_modal=mysqli_fetch_array($results_modal,MYSQLI_ASSOC))
			            {
			            	$course_id_modal=$row_modal['course_id'];
			              	$sql_course_modal="SELECT * FROM course WHERE id LIKE $course_id_modal";
			              	$results_course_modal=mysqli_query($db,$sql_course_modal);
			              	$row_course_modal=mysqli_fetch_array($results_course_modal,MYSQLI_ASSOC);
		        			echo '<div class="form-check">
							  		<input class="form-check-input" type="checkbox" id="check'.$j.'" name="option'.$j.'" value="'.$course_id_modal.'">
							  		<label class="form-check-label" for="check'.$j.'">'.$row_course_modal['title'].'</label>
								</div>';
							$j++;
						} ?>
					    <div class="d-grid">
					    	<button type="submit" class="btn btn-secondary btn-block mt-3">Adaugă</button>
					    </div>
					</form>
	      		</div>

	    	</div>
	  	</div>
	</div>
	<div class="accordion accordion-flush mt-3" id="accordionFlushExample">
		<?php 
		$user_id=$_SESSION['user_id'];
		$sql="SELECT * FROM course_group WHERE user_id LIKE $user_id ORDER BY group_name";
		$results=mysqli_query($db,$sql);
		$num_rows=mysqli_num_rows($results);
	    $i=1;
	    $close=0;
	    $open=1;
	    $acordeon_content="";
	    while($row=mysqli_fetch_array($results,MYSQLI_ASSOC))
	    {
	    	$course_id=$row['course_id'];
			$sql_course="SELECT * FROM course WHERE id LIKE $course_id";
			$results_course=mysqli_query($db,$sql_course);
			$row_course=mysqli_fetch_array($results_course,MYSQLI_ASSOC);

			//first loop
			if($i==1)
				$group_name=$row["group_name"];

			//when should the accordion be closed
	    	if($row["group_name"]!=$group_name || $i==$num_rows)
	    	{
				$close=1;
			}
			$group_name=$row["group_name"];

			//open acordeon
			if($open==1)
			{
				$open=0;
				echo '<div class="accordion-item">
				    	<h2 class="accordion-header" id="heading_group'.$i.'">
				      		<button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#collapse_group'.$i.'">'.$row['group_name'].'</button>
				    	</h2>
			    
				    	<div id="collapse_group'.$i.'" class="accordion-collapse collapse" data-bs-parent="#accordion_group">
				      		<div class="accordion-body">
				        		<div class="list-group">';
			}
			//if last row
			if($i==$num_rows)
				$acordeon_content.='<a href="#" class="list-group-item list-group-item-action">'.$row_course["title"].'</a>';

			if($close==1)
			{
				echo $acordeon_content;
				$acordeon_content="";
			}

			$acordeon_content.='<a href="Course_page.php?id='.$row["course_id"].'" class="list-group-item list-group-item-action">'.$row_course["title"].'</a>';

			//close acordeon
			if($close==1)
			{
				
				$close=0;
				$open=1;
				
								echo '<a class="btn btn-secondary btn-sm mt-3" href="Add_course_group.php?edit=2&group='.$row['group_name'].'">+</a>'; ?>
								</div>
				      		</div>
				    	</div>
					</div>

			<?php } 
			$i++;
		
		} ?>

	</div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        if(window.location.href.indexOf('#Add_course_Modal') != -1) {
            $('#Add_course_Modal').modal('show');
        }
    });
</script>
