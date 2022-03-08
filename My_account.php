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
  		  		<li class="breadcrumb-item"><a href="Home_page.php" style="text-decoration: none;">Acasa</a></li>
    			<li class="breadcrumb-item active" aria-current="page">Contul meu</li>
  			</ol>
		</nav>

    	<div class="row">
		    <!--Courses group-->
		    <div class="col-md-3">
		    	<?php include 'Courses_group.php' ?>
		    </div>

		    <div class="col-md-9">
		      	<?php 
		      		$user_id=$_SESSION['user_id'];
		      		$sql="SELECT * FROM user WHERE id LIKE $user_id";
		      		$results=mysqli_query($db,$sql);
		      		$row=mysqli_fetch_array($results,MYSQLI_ASSOC);
		      	?>
		      	<div class="row">
		      		<div class="col-xl-3 col-md-4">
		      			<div class="d-flex align-items-center flex-column">
		      				<div class="p-2">
		      					<?php 
		      					$sql="SELECT * FROM user WHERE id LIKE $user_id";
								$results=mysqli_query($db,$sql);
								$row=mysqli_fetch_array($results);
								$profile_image="Images\Profile\\".$row["profile_image"];
								
								if($profile_image=="Images\Profile\\") {
		      					?>
			      					<img src="Images\Sistem\user.png" alt="Profile image" style="width:200px; height:200px;" class="rounded-circle">
			      				<?php }
			      				else { 

			      					echo '<img src="'.$profile_image.'" alt="Profile image" style="width:200px; height:200px;" class="rounded-circle">';
			      				}
			      				?>
			      			</div>
			      			<div class="p-2">
			      				<p><a href="#" style="text-decoration: none;" data-bs-toggle="modal" data-bs-target="#Edit_profile_photo">Scimbă fotografia de profil</a></p>
			      			</div>
			      		</div>
			      	</div>
			      	<div class="col-xl-9 col-md-8 mt-4">
			      		<div class="mx-4">
				      		<div class="container p-3 border border-3 rounded-1">
					      		<?php echo '<h5><b>Nume: '.$row['name'].'</b></h5>'; ?>
					      		<?php echo '<h5><b>Email: '.$row['email'].'</b></h5>'; ?>
					      		<?php echo '<h5><b>Tip cont: '.$row['type'].'</b></h5>'; ?>	
				      		</div>
				      		<div class="d-grid mt-3">
							  	<button type="button" class="btn btn-primary btn-block" data-bs-toggle="modal" data-bs-target="#Edit_profile_data">Editeză datele</button>
							</div>
							<div class="d-grid mt-3">
							  	<button type="button" class="btn btn-primary btn-block" data-bs-toggle="modal" data-bs-target="#Change_password">Schimbă parola</button>
							</div>
							<div class="d-grid mt-3">
							  	<button type="button" class="btn btn-danger btn-block" data-bs-toggle="modal" data-bs-target="#Delete_account">Șterge contul</button>
							</div>	
			      		</div>
			      	</div>
		      	</div>
		      	
		    </div>
	  	</div>
	  	
	  	<!--Modal--Edit-profile-photo-->
	  	<div class="modal fade" id="Edit_profile_photo">
		  	<div class="modal-dialog">
		    	<div class="modal-content">

		      		<!-- Modal Header -->
		      		<div class="modal-header">
		        		<h4 class="modal-title">Scimbă fotografia de profil</h4>
		        		<button type="button" class="btn-close" data-bs-dismiss="modal" data-bs-target="#Edit_profile_photo"></button>
		      		</div>

		      		<!-- Modal body -->
		      		<div class="modal-body">
		      			<form action="My_account_edit.php?edit=0" method="post" enctype="multipart/form-data">
		      				<div class="d-flex justify-content-center mb-3">
							  	<?php 
		      					$sql="SELECT * FROM user WHERE id LIKE $user_id";
								$results=mysqli_query($db,$sql);
								$row=mysqli_fetch_array($results);
								$profile_image="Images\Profile\\".$row["profile_image"];
								
								if($profile_image=="Images\Profile\\") {
		      					?>
			      					<img src="Images\Sistem\user.png" alt="Profile image" id="profile_photo" style="width:200px; height:200px;" class="rounded-circle">
			      				<?php }
			      				else { 

			      					echo '<img src="'.$profile_image.'" alt="Profile image" id="profile_photo" style="width:200px; height:200px;" class="rounded-circle">';
			      				}
			      				?>
							</div>
							<div class="mb-3">
							  	<input class="form-control" type="file" name="photo" id="photo" onchange="loadFile(event)">
							</div>
							<div class="d-grid">
						    	<button type="submit" class="btn btn-secondary btn-block mt-3">Salvează</button>
						    </div>
		      			</form>
		      			<div class="d-grid mt-3">
		      				<button type="button" class="btn btn-danger btn-block" data-bs-toggle="modal" data-bs-target="#Delete_profile_photo">Șterge fotografia de profil</button>
		      			</div>
		      		</div>

		    	</div>
		  	</div>
		</div>

		<!--Modal--Delete-profile-photo--->
		<div class="modal fade" id="Delete_profile_photo">
		  	<div class="modal-dialog">
		    	<div class="modal-content">

		      		<!-- Modal Header -->
		      		<div class="modal-header">
		        		<h4 class="modal-title">Șterge fotografia de profil</h4>
		        		<button type="button" class="btn-close" data-bs-dismiss="modal" data-bs-target="#Delete_profile_photo"></button>
		      		</div>

		      		<!-- Modal body -->
		      		<div class="modal-body">
		      			<div class="d-flex justify-content-center">
		      				<p>Sunteși sigur că vreți să ștergeți fotografia de profil?</p>
		      			</div>
		      			<div class="d-flex justify-content-around">
		      				<div class="d-grid gap-1 col-4">
		      					<a href="My_account_edit.php?edit=1" class="btn btn-danger">Da</a>
		      				</div>
		      				<div class="d-grid gap-1 col-4">
		      					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" data-bs-target="#Delete_lesson_group">Nu</button>
		      				</div>
		      			</div>
		      		</div>

		    	</div>
		  	</div>
		</div>

	  	<!--Modal--Edit-profile-data-->
	  	<div class="modal fade" id="Edit_profile_data">
		  	<div class="modal-dialog">
		    	<div class="modal-content">

		      		<!-- Modal Header -->
		      		<div class="modal-header">
		        		<h4 class="modal-title">Editează datele</h4>
		        		<button type="button" class="btn-close" data-bs-dismiss="modal" data-bs-target="#Edit_profile_data"></button>
		      		</div>

		      		<!-- Modal body -->
		      		<div class="modal-body">
		      			<form action="My_account_edit.php?edit=2" method="post">
		      				<?php
			      				$user_id=$_SESSION['user_id'];
			      				$sql="SELECT * FROM user WHERE id LIKE $user_id";
			      				$results=mysqli_query($db,$sql);
			      				$row=mysqli_fetch_array($results,MYSQLI_ASSOC);
		      				?>
		      				<div class="mb-3">
				              	<label for="name">Nume:</label>
				              	<?php echo '<input type="text" class="form-control" id="name" name="name" value="'.$row["name"].'" onClick="this.select();">'; ?>
				          	</div>
				          	<div class="mb-3">
				            	<label for="email">Email:</label>
				            	<?php echo '<input type="email" class="form-control" id="email" name="email" value="'.$row["email"].'" onClick="this.select();">'; ?>
				          	</div>
				          	<div class="d-grid">
						    	<button type="submit" class="btn btn-secondary btn-block mt-3">Salvează</button>
						    </div>
		      			</form>
		      		</div>

		    	</div>
		  	</div>
		</div>

		<!--Modal--Change-password-->
	  	<div class="modal fade" id="Change_password">
		  	<div class="modal-dialog">
		    	<div class="modal-content">

		      		<!-- Modal Header -->
		      		<div class="modal-header">
		        		<h4 class="modal-title">Schimbă parola</h4>
		        		<button type="button" class="btn-close" data-bs-dismiss="modal" data-bs-target="#Change_password"></button>
		      		</div>

		      		<!-- Modal body -->
		      		<div class="modal-body">
		      			<form action="My_account_edit.php?edit=3" method="post">
		      				<div class="mb-3">
				              	<label for="old_password">Parolă veche:</label>
				              	<?php echo '<input type="password" class="form-control" id="old_password" name="old_password">'; ?>
				          	</div>
				          	<div class="mb-3">
				            	<label for="new_password1">Parolă nouă:</label>
				            	<?php echo '<input type="password" class="form-control" id="new_password1" name="new_password1">'; ?>
				          	</div>
				          	<div class="mb-3">
				            	<label for="new_password2">Confirmare parolă:</label>
				            	<?php echo '<input type="password" class="form-control" id="new_password2" name="new_password2">'; ?>
				          	</div>
				          	<div class="d-grid">
						    	<button type="submit" class="btn btn-secondary btn-block mt-3">Salvează</button>
						    </div>
		      			</form>
		      		</div>

		    	</div>
		  	</div>
		</div>

		<!--Modal--Delete-account--->
		<div class="modal fade" id="Delete_account">
		  	<div class="modal-dialog">
		    	<div class="modal-content">

		      		<!-- Modal Header -->
		      		<div class="modal-header">
		        		<h4 class="modal-title">Șterge contul</h4>
		        		<button type="button" class="btn-close" data-bs-dismiss="modal" data-bs-target="#Delete_account"></button>
		      		</div>

		      		<!-- Modal body -->
		      		<div class="modal-body">
		      			<div class="d-flex justify-content-center">
		      				<p>Sunteși sigur că vreți să ștergeți contul?</p>
		      			</div>
		      			<div class="d-flex justify-content-around">
		      				<div class="d-grid gap-1 col-4">
		      					<a href="My_account_edit.php?edit=4" class="btn btn-danger">Da</a>
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
<script type="text/javascript">
	 var loadFile = function(event)
	 {
    	var output = document.getElementById('profile_photo');
    	output.src = URL.createObjectURL(event.target.files[0]);
    	output.onload = function()
    	{
      		URL.revokeObjectURL(output.src)
    	}
  	};
</script>
