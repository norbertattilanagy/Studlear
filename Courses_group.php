<?php include 'Connection.php'; ?>
<?php include 'Page_security.php'; ?>
<?php if($_SESSION['user_type']!='admin'){ ?>
	<div class="d-none d-md-block">
		<div class="mx-3">

			<button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#New_group_Modal">Grup nou +</button>
			
			<div class="accordion accordion-flush mt-3" id="accordionFlushExample">
				<?php 
				$user_id=$_SESSION['user_id'];
				$sql="SELECT * FROM course_group AS cg JOIN course AS c ON cg.course_id=c.id WHERE user_id LIKE $user_id  ORDER BY group_name , title";
				$results=mysqli_query($db,$sql);
				$num_rows=mysqli_num_rows($results);
			    $i=1;
			    $close=0;
			    $open=1;
			    $acordeon_content="";
			    while($row=mysqli_fetch_array($results,MYSQLI_ASSOC))
			    {
					//first loop
					if($i==1)
					{
						$group_name=$row["group_name"];
						$link_group_name=$row["group_name"];
					}

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
						echo '<div class="accordion-item">';
							echo '<h2 class="accordion-header" id="heading_group'.$i.'">';
						      	echo '<button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#collapse_group'.$i.'">'.$group_name.'</button>';
						    echo '</h2>';
					    
						    echo '<div id="collapse_group'.$i.'" class="accordion-collapse collapse" data-bs-parent="#accordion_group">';
						      	echo '<div class="accordion-body">';
						        	echo '<div class="list-group">';
					}
					//if last row
					if($i==$num_rows)
						$acordeon_content.='<a href="#" class="list-group-item list-group-item-action">'.$row["title"].'</a>';

					if($close==1)
					{
						echo $acordeon_content;
						$acordeon_content="";
					}

					$acordeon_content.='<a href="Course_page.php?id='.$row["course_id"].'" class="list-group-item list-group-item-action">'.$row["title"].'</a>';

					//close acordeon
					if($close==1)
					{
						
						$close=0;
						$open=1;
						
										echo '<a class="btn btn-secondary btn-sm mt-3 text-decoration-none" href="Add_course_group.php?edit=3&group='.$link_group_name.'"><i class="bi bi-pencil-square"></i> Editează</a>'; ?>
										</div>
						      		</div>
						    	</div>
							</div>

					<?php 
						$link_group_name=$row["group_name"];
					} 
					$i++;
				
				} ?>

			</div>
		</div>
	</div>
	<div class="d-md-none d-block">
		<button class="btn btn-secondary btn-sm mb-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#favorite_course">
	    	<i class="bi bi-caret-left-fill"></i>
	  	</button>

		<div class="offcanvas offcanvas-start" id="favorite_course">
			<div class="offcanvas-header">
			    <h1 class="offcanvas-title">Cursuri favorite:</h1>
			    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
			</div>
			<div class="offcanvas-body">

			<button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#New_group_Modal">Grup nou +</button>
			
			<div class="accordion accordion-flush mt-3" id="accordionFlushExample">
				<?php 
				$user_id=$_SESSION['user_id'];
				$sql="SELECT * FROM course_group AS cg JOIN course AS c ON cg.course_id=c.id WHERE user_id LIKE $user_id  ORDER BY group_name , title";
				$results=mysqli_query($db,$sql);
				$num_rows=mysqli_num_rows($results);
			    $i=1;
			    $close=0;
			    $open=1;
			    $acordeon_content="";
			    while($row=mysqli_fetch_array($results,MYSQLI_ASSOC))
			    {
					//first loop
					if($i==1)
					{
						$group_name=$row["group_name"];
						$link_group_name=$row["group_name"];
					}

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
						echo '<div class="accordion-item">';
							echo '<h2 class="accordion-header" id="heading_group'.$i.'">';
						      	echo '<button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#collapse_group'.$i.'">'.$group_name.'</button>';
						    echo '</h2>';
					    
						    echo '<div id="collapse_group'.$i.'" class="accordion-collapse collapse" data-bs-parent="#accordion_group">';
						      	echo '<div class="accordion-body">';
						        	echo '<div class="list-group">';
					}
					//if last row
					if($i==$num_rows)
						$acordeon_content.='<a href="#" class="list-group-item list-group-item-action">'.$row["title"].'</a>';

					if($close==1)
					{
						echo $acordeon_content;
						$acordeon_content="";
					}

					$acordeon_content.='<a href="Course_page.php?id='.$row["course_id"].'" class="list-group-item list-group-item-action">'.$row["title"].'</a>';

					//close acordeon
					if($close==1)
					{
						
						$close=0;
						$open=1;
						
										echo '<a class="btn btn-secondary btn-sm mt-3 text-decoration-none" href="Add_course_group.php?edit=3&group='.$link_group_name.'"><i class="bi bi-pencil-square"></i> Editează</a>'; ?>
										</div>
						      		</div>
						    	</div>
							</div>

					<?php 
						$link_group_name=$row["group_name"];
					} 
					$i++;
				
				} ?>
			</div>
			</div>
		</div>
	</div>


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
	      			<form action="Add_course_group.php?edit=0" class="needs-validation" method="post" novalidate>
	      				<div class="mb-3">
						    <label for="group_name" class="form-label">Nume grup:</label>
						    <input type="text" class="form-control" id="group_name" placeholder="Nume grup" name="group_name" required>
						    <div class="invalid-feedback">Introduceți numele grupului</div>
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
								
		        			echo '<div class="form-check">';
								echo '<input class="form-check-input" type="checkbox" id="check'.$j.'" name="option'.$j.'" value="'.$course_id_modal.'">';
								echo '<label class="form-check-label" for="check'.$j.'">'.$row_course_modal['title'].'</label>';
							echo '</div>';
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

	<!--Modal-Edit-course--->
	<div class="modal fade" id="Edit_course_Modal">
	  	<div class="modal-dialog">
	    	<div class="modal-content">

	      		<!-- Modal Header -->
	      		<div class="modal-header">
	        		<h4 class="modal-title">Editează grup</h4>
	        		<button type="button" class="btn-close" data-bs-dismiss="modal" data-bs-target="#Edit_course_Modal"></button>
	      		</div>

	      		<!-- Modal body -->
	      		<div class="modal-body">
	      			<form action="Add_course_group.php?edit=1" class="needs-validation" method="post" novalidate>
	      				<?php
	      				$group_name=$_SESSION['group_name'];
	      				?>
	      				<div class="mb-3">
						    <label for="group_name" class="form-label">Nume grup:</label>
						    <?php echo '<input type="text" class="form-control" id="group_name" value="'.$group_name.'" name="group_name" onClick="this.select();" required>'; ?>
						    <div class="invalid-feedback">Introduceți numele grupului</div>
						</div>
	      				<?php 
						$user_id=$_SESSION['user_id'];
						$sql_modal="SELECT * FROM course_user WHERE user_id LIKE $user_id";
			            $results_modal=mysqli_query($db,$sql_modal);
			           	$j=0;
			            while ($row_modal=mysqli_fetch_array($results_modal,MYSQLI_ASSOC))
			            {
			            	$group_name='"'.$_SESSION['group_name'].'"';
			            	$course_id=$row_modal["course_id"];
			            	$sql_verify="SELECT * FROM course_group WHERE user_id LIKE $user_id AND course_id LIKE $course_id AND group_name LIKE $group_name";
							$results_verify=mysqli_query($db,$sql_verify);
							$nr_row_verify=mysqli_num_rows($results_verify);
							
							$course_id_modal=$row_modal['course_id'];
				            $sql_course_modal="SELECT * FROM course WHERE id LIKE $course_id_modal";
				            $results_course_modal=mysqli_query($db,$sql_course_modal);
				            $row_course_modal=mysqli_fetch_array($results_course_modal,MYSQLI_ASSOC);

							echo '<div class="form-check">';
							if($nr_row_verify==0){
								echo'<input class="form-check-input" type="checkbox" id="check'.$j.'" name="option'.$j.'" value="'.$course_id_modal.'">';
							}
							else
							{
								echo'<input class="form-check-input" type="checkbox" id="check'.$j.'" name="option'.$j.'" value="'.$course_id_modal.'" checked>';
							}
							echo '<label class="form-check-label" for="check'.$j.'">'.$row_course_modal['title'].'</label>
								</div>';
							$j++;
						} ?>
					    <div class="d-grid">
					    	<button type="submit" class="btn btn-secondary btn-block mt-3">Salvează</button>
					    </div>
					</form>
					<div class="d-grid">
						<button type="button" class="btn btn-secondary btn-block mt-3" data-bs-toggle="modal" data-bs-target="#Delete_course_group">Șterge grup</button>
					</div>
	      		</div>

	    	</div>
	  	</div>
	</div>
	<!--Modal--Delete-course-group--->
	<div class="modal fade" id="Delete_course_group">
	  	<div class="modal-dialog">
	    	<div class="modal-content">      		
	    		<!-- Modal Header -->
	      		<div class="modal-header">
	        		<h4 class="modal-title">Editare lecție</h4>
	        		<button type="button" class="btn-close" data-bs-dismiss="modal" data-bs-target="#Delete_course_group"></button>
	      		</div>
	      		<!-- Modal body -->
	      		<div class="modal-body">
	      			<div class="d-flex justify-content-center">
	      				<p>Doriti să ștergeți grupul de curs?</p>
	      			</div>
	      			<div class="d-flex justify-content-around">
		      			<div class="d-grid gap-1 col-4">
		      				<a href="Add_course_group.php?edit=2" class="btn btn-danger text-decoration-none">Da</a>
		      			</div>
		      			<div class="d-grid gap-1 col-4">
		      				<button type="button" class="btn btn-secondary btn-block" data-bs-dismiss="modal" data-bs-target="#Delete_course_group">Nu</button>
		      			</div>
	      			</div>
	      		</div> 
	      	</div>
	  	</div>
	</div>
	<?php $url="'".$_SERVER['REQUEST_URI']."'"; ?>
	<script type="text/javascript">
	    $(document).ready(function() {
	    	var url=<?php echo $url; ?>;
	        if(window.location.href.indexOf('#Edit_course_Modal') != -1) {
	            $('#Edit_course_Modal').modal('show');
	            window.history.pushState('', '', url);
	        }
	        
	    });
	</script>
	<script type="text/javascript">
	(function () {
		
	  	var forms = document.querySelectorAll('.needs-validation') 
	  	Array.prototype.slice.call(forms).forEach(function (form) {
				
	      	form.addEventListener('submit', function (event)
	      	{			
	        	if (!form.checkValidity())
	        	{	
	          		event.preventDefault()
	          		event.stopPropagation()
	        	}
	        	form.classList.add('was-validated')
	      	}, false)
	    })
	})()
	</script>
<?php } ?>	