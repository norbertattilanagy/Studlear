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
	    <title>Studlearn</title>
	    <style type="text/css">
	    	.text-underline-hover {
			    text-decoration: none;
			}

			.text-underline-hover:hover {
			    text-decoration: underline;
			}
	    </style>
	</head>
	<body>
		<!--Top bar-->
    	<?php include 'Top_bar.php' ?>
		<?php if($_SESSION['user_type']!="admin"){ ?>
	    	<nav class="ms-4" aria-label="breadcrumb">
	  			<ol class="breadcrumb">
	  		  		<li class="breadcrumb-item"><a href="Home_page.php" style="text-decoration: none;">Acasa</a></li>
	    			<li class="breadcrumb-item active" aria-current="page">Căutare curs</li>
	  			</ol>
			</nav>
		<?php } ?>
		<?php 
    		if(empty($_SESSION["s"]))
    			$_SESSION['search']="";
    		else if(isset($_SESSION["s"]))
    		{
    			if($_SESSION['s']!=1)
    				$_SESSION['search']="";
    		}
    	if($_SESSION['user_type']!="admin"){ ?>
    	<div class="row">
		    <!--Courses group-->
		    <div class="col-md-3">
		    	<?php include 'Courses_group.php' ?>
		    </div>

		    <div class="col-md-9">
		    <?php } ?>
		    	<div class="container">
		    		<form action="Enroll_in_course.php?enroll=7" method="post">
					    <div class="input-group">
					        <?php echo '<input type="search" class="form-control" id="search" name="search" placeholder="Search" value="'.$_SESSION['search'].'" onClick="this.select();">'; ?>
					        <button type="submit" class="input-group-text btn-primary"><i class="bi bi-search me-2"></i> Search</button>
					    </div>
					</form>
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
						
						$search_id="'".$search."'";
						$search_title="'%".$search."%'";
						$sql="SELECT * FROM course WHERE id LIKE $search_id OR title LIKE $search_title ORDER BY title";
						$results=mysqli_query($db,$sql);
						$nr_row=mysqli_num_rows($results);
						$sql="SELECT * FROM course WHERE id LIKE $search_id OR title LIKE $search_title ORDER BY title LIMIT $start, $limit";
						$results=mysqli_query($db,$sql);
					}
					else
					{
						$sql="SELECT * FROM course ORDER BY title";
						$results=mysqli_query($db,$sql);
						$nr_row=mysqli_num_rows($results);
						$sql="SELECT * FROM course ORDER BY title LIMIT $start, $limit";
						$results=mysqli_query($db,$sql);
					}
					$results=mysqli_query($db,$sql);
					$pagination=0;
					while ($row=mysqli_fetch_array($results,MYSQLI_ASSOC))
					{
						$user_id=$_SESSION["user_id"];
						$course_id=$row["id"];
						$sql_verify="SELECT * FROM course_user WHERE user_id LIKE $user_id and course_id LIKE $course_id";
						$results_verify=mysqli_query($db,$sql_verify);
						$nr_row_verify=mysqli_num_rows($results_verify);
						if($nr_row_verify==0){
							$pagination=1;
							if($_SESSION['user_type']=="admin")
								echo '<a class="link-dark text-underline-hover" href="Course_page.php?id='.$row['id'].'">';
							else
								echo '<a class="link-dark text-underline-hover" href="Enroll_in_course.php?enroll=0&course_id='.$row["id"].'">';
									echo '<div class="container-sm p-2 my-3 border border-2 rounded">';
										echo '<div class="d-flex justify-content-between align-items-center">';
											echo '<h4>'.$row["title"].'</h4>';
											echo '<h6>id: '.$row['id'].'</h6>';
										echo '</div>';
									echo '</div>';
								echo '</a>';
						}
					}
					?>
		    	</div>

		    	<?php if($pagination==1){ ?>
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
				<?php }
			if($_SESSION['user_type']!="admin"){ ?>
		    </div>
	  	</div>
	  	<?php } ?>
	  	<!--Enroll in course modal-->
	  	<div class="modal fade" id="Enroll_in_course">
      		<div class="modal-dialog">
        		<div class="modal-content">

        			<!-- Modal Header -->
			        <div class="modal-header">
			            <h4 class="modal-title">Înscriere la curs</h4>
			            <button type="button" class="btn-close" data-bs-dismiss="modal" data-bs-target="#Enroll_in_course"></button>
			        </div>

			        <!-- Modal body -->
			        <div class="modal-body">
			        	<form action="Enroll_in_course.php?enroll=1" class="needs-validation" method="post" novalidate>
			        		<?php
			        		$course_id=$_SESSION['course_id'];
			        		$sql="SELECT * FROM course WHERE id LIKE $course_id";
			        		$results=mysqli_query($db,$sql);
			        		$row=mysqli_fetch_array($results);
			        		if($row['password']!=""){ ?>
				        		<div class="mb-3">
									<?php if($_SESSION['incorect_password']==1)
										echo '<p style="color:red">Parolă incorectă</p>';
									?>
				        			<input type="password" class="form-control" placeholder="Introduceți parola" id="password" name="password" required>
				        			<div class="invalid-feedback">Introduceți parola</div>
				        		</div>
				        		<div class="mb-3">
				        			<label class="form-check-label">
						              	<input class="form-check-input" type="checkbox"  name="show_password" onclick="myFunction()"> Arată parola
						            </label>
				        		</div>
				        	<?php } ?>
				        	<div class="d-grid">
				        		<button type="submit" class="btn btn-dark btn-block">Înscriere</button>
				        	</div>
				            
			        	</form>
			        </div>

        		</div>
        	</div>
        </div>
        
	    
	</body>
</html>
<script type="text/javascript">
    $(document).ready(function() {
        if(window.location.href.indexOf('#Enroll_in_course') != -1) {
            $('#Enroll_in_course').modal('show');
            window.history.pushState('', 'Search_courses', 'Search_courses.php');
        }
    });
</script>
<!--Show password-->
<script>
   function myFunction() {
   	var x = document.getElementById("password");
     	if (x.type === "password") {
       		x.type = "text";
     	} else {
       		x.type = "password";
     	}
   }
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