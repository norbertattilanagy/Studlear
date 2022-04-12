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
  		  			echo '<li class="breadcrumb-item"><a href="Home_page.php" style="text-decoration: none;">Acasă</a></li>'; ?>
    			<li class="breadcrumb-item active" aria-current="page">Contul meu</li>
  			</ol>
		</nav>

		<?php if($_SESSION['user_type']!="admin"){ ?>
    	<div class="row">
		    <!--Courses group-->
		    
		    <div class="col-md-3">
		    	<?php include 'Courses_group.php' ?>
		    </div>

		    <div class="col-md-9">
		    <?php } ?>
		      	<?php 
		      		$search_user_id=$_GET['id'];
		      		$user_id=$_SESSION['user_id'];
		      		$sql="SELECT * FROM user WHERE id LIKE $search_user_id";
		      		$results=mysqli_query($db,$sql);
		      		$row=mysqli_fetch_array($results,MYSQLI_ASSOC);
		      	?>
		      	<div class="row">
		      		<div class="col-xl-3 col-md-4">
		      			<div class="d-flex align-items-center flex-column">
		      				<div class="p-2">
		      					<?php 
		      					$sql="SELECT * FROM user WHERE id LIKE $search_user_id";
								$results=mysqli_query($db,$sql);
								$row=mysqli_fetch_array($results);

								$correct_old_password=$row['password'];
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
			      			<?php if($_SESSION['user_type']=="admin" or $search_user_id==$user_id){ ?>
				      			<div class="p-2">
				      				<p><a href="#" style="text-decoration: none;" data-bs-toggle="modal" data-bs-target="#Edit_profile_photo">Scimbă fotografia de profil</a></p>
				      			</div>
				      		<?php } ?>
			      		</div>
			      	</div>
			      	<div class="col-xl-9 col-md-8 mt-4">
			      		<div class="mx-4">
				      		<div class="container p-3 border border-3 rounded-1">
					      		<?php echo '<h5><b>Nume: '.$row['name'].'</b></h5>'; ?>
					      		<?php echo '<h5><b>Email: '.$row['email'].'</b></h5>'; ?>
					      		<?php echo '<h5><b>Tip cont: '.$row['type'].'</b></h5>'; ?>	
				      		</div>
				      		<?php if($_SESSION['user_type']=="admin"){ ?>
				      			<div class="d-grid mt-3">
								  	<button type="button" class="btn btn-primary btn-block" data-bs-toggle="modal" data-bs-target="#Edit_user_type">Editeză tipul de utilizator</button>
								</div>
				      		<?php } ?>
				      		<?php if($_SESSION['user_type']=="admin" or $search_user_id==$user_id){ ?>
					      		<div class="d-grid mt-3">
								  	<button type="button" class="btn btn-primary btn-block" data-bs-toggle="modal" data-bs-target="#Edit_profile_data">Editeză datele</button>
								</div>
								<div class="d-grid mt-3">
								  	<button type="button" class="btn btn-primary btn-block" data-bs-toggle="modal" data-bs-target="#Change_password">Schimbă parola</button>
								</div>
								<div class="d-grid mt-3">
								  	<button type="button" class="btn btn-danger btn-block" data-bs-toggle="modal" data-bs-target="#Delete_account">Șterge contul</button>
								</div>
							<?php } ?>
			      		</div>
			      	</div>
		      	</div>
		
		<?php if($_SESSION['user_type']!="admin"){ ?>      	
		    </div>
	  	</div>
	  	<?php } ?>
	  	
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
		      			<form action="My_account_edit.php?edit=0" class="needs-validation" method="post" enctype="multipart/form-data" novalidate>
		      				<div class="d-flex justify-content-center mb-3">
							  	<?php 								
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
							  	<input class="form-control" type="file" name="photo" id="photo" accept=".jpg, .jpeg, .png" onchange="loadFile(event)" required>
								<p class="text-muted">*Fișiere acceptate: .jpg .jpeg .png</p>
							  	<div class="invalid-feedback">alegeți o fotografie</div>
							</div>
							<div class="d-grid">
						    	<button type="submit" class="btn btn-secondary btn-block mt-3">Salvează</button>
						    </div>
		      			</form>
		      			<?php if($profile_image!="Images\Profile\\"){ ?> 
			      			<div class="d-grid mt-3">
			      				<button type="button" class="btn btn-danger btn-block" data-bs-toggle="modal" data-bs-target="#Delete_profile_photo">Șterge fotografia de profil</button>
			      			</div>
			      		<?php } ?>
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

		<!--Modal--Edit-user-type-->
	  	<div class="modal fade" id="Edit_user_type">
		  	<div class="modal-dialog">
		    	<div class="modal-content">

		      		<!-- Modal Header -->
		      		<div class="modal-header">
		        		<h4 class="modal-title">Editează tipul de utilizator</h4>
		        		<button type="button" class="btn-close" data-bs-dismiss="modal" data-bs-target="#Edit_user_type"></button>
		      		</div>

		      		<!-- Modal body -->
		      		<div class="modal-body">
		      			<?php echo '<form action="My_account_edit.php?edit=5&search_user_id='.$search_user_id.'" class="needs-validation" method="post" novalidate>';
		      				
			      				$sql="SELECT * FROM user WHERE id LIKE $search_user_id";
			      				$results=mysqli_query($db,$sql);
			      				$row=mysqli_fetch_array($results,MYSQLI_ASSOC);
		      				?>
		      				<div class="mb-3">
				              	<label for="user_type" class="form-label">Selectați tipul de utilizator:</label>
					            <select class="form-select" name="user_type" id="user_type">
					            	<?php 
					            	if($row['type']=="teacher") 
					              		echo '<option value="teacher" selected>Profesor</option>';
					              	else
					              		echo '<option value="teacher">Profesor</option>';
					              	if($row['type']=="student") 
					              		echo '<option value="student" selected>Student</option>';
					              	else
					              		echo '<option value="student">Student</option>';
					              	if($row['type']=="admin") 
					              		echo '<option value="admin" selected>Administrator</option>';
					              	else
					              		echo '<option value="admin">Administrator</option>';
					              	?>
					            </select>
				          	</div>
				          	<div class="d-grid">
						    	<button type="submit" class="btn btn-secondary btn-block mt-3">Salvează</button>
						    </div>
		      			</form>
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
		      			<form action="My_account_edit.php?edit=2" class="needs-validation" method="post" novalidate>
		      				<?php
			      				$sql="SELECT * FROM user WHERE id LIKE $search_user_id";
			      				$results=mysqli_query($db,$sql);
			      				$row=mysqli_fetch_array($results,MYSQLI_ASSOC);
		      				?>
		      				<div class="mb-3">
				              	<label for="name">Nume:</label>
				              	<?php echo '<input type="text" class="form-control" id="name" name="name" value="'.$row["name"].'" onClick="this.select();" required>'; ?>
				              	<div class="invalid-feedback">Introduceți numele</div>
				          	</div>
				          	<div class="mb-3">
				            	<label for="email">Email:</label>
				            	<?php echo '<input type="email" class="form-control" id="email" name="email" value="'.$row["email"].'" onClick="this.select();" required>'; ?>
				            	<div class="invalid-feedback">Introduceți email-ul</div>
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
		      			<form action="My_account_edit.php?edit=3" class="needs-validation" method="post" novalidate>
		      				<div class="mb-3">
				              	<label for="old_password">Parolă veche:</label>
				              	<?php echo '<input type="password" class="form-control" id="old_password" name="old_password" required>'; ?>
				              	<div class="invalid-feedback old_password"><p id="op">Introduceți parola veche</p></div>
				          	</div>
				          	<div class="mb-3">
				            	<label for="new_password1">Parolă nouă:</label>
				            	<?php echo '<input type="password" class="form-control" id="new_password1" name="new_password1" required>'; ?>
				            	<div class="invalid-feedback new_password1"><p id="np1">Introduceți o parolă nouă</p></div>
				          	</div>
				          	<div class="mb-3">
				            	<label for="new_password2">Confirmare parolă:</label>
				            	<?php echo '<input type="password" class="form-control" id="new_password2" name="new_password2" required>'; ?>
				            	<div class="invalid-feedback new_password2"><p id="np2">Introduceți o parolă nouă</p></div>
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
<script type="text/javascript">//form verification
var correct_old_password=<?php echo $correct_old_password; ?>;
var old_password=document.getElementById("old_password");
var new_password1=document.getElementById("new_password1");
var new_password2=document.getElementById("new_password2");
(function () {
	
  	var forms = document.querySelectorAll('.needs-validation') 
  	Array.prototype.slice.call(forms).forEach(function (form) {
			
      	form.addEventListener('submit', function (event)
      	{			
        	if (!form.checkValidity())
        	{	
        		validateOld_password();
          		event.preventDefault()
          		event.stopPropagation()
        	}
        	form.classList.add('was-validated')
      	}, false)
    })
})()

function validatePassword(){
	if(new_password1.value=="")
	{
		$("#np1").remove();
		$(".new_password1").append(`<p id="np1">Introduceți o parolă</p>`);
	} 			
	if(new_password2.value=="")
	{
		$("#np2").remove();
		$(".new_password2").append(`<p id="np2">Introduceți o parolă</p>`);
	}
  	if(new_password1.value!=new_password2.value) {
	  	$("#np1").remove();
		$("#np2").remove();
		$(".new_password1").append(`<p id="np1">Parola nu coincide</p>`);
		$(".new_password2").append(`<p id="np2">Parola nu coincide</p>`);

	  	new_password1.setCustomValidity(' ');
	    new_password2.setCustomValidity(' ');
  	} else {
	  	new_password1.setCustomValidity('');
	    new_password2.setCustomValidity('');
  	}
}
new_password1.onchange = validatePassword;
new_password2.onkeyup = validatePassword;

function validateOld_password(){
	if(old_password.value=="")
	{
		$("#op").remove();
		$(".old_password").append(`<p id="op">Introduceți parola veche</p>`);
	}
	if(old_password.value!=correct_old_password && old_password.value!=""){
		$("#op").remove();
		$(".old_password").append(`<p id="op">Parolă incorectă</p>`);
		old_password.setCustomValidity(' ');
	} else {
		old_password.setCustomValidity('');
	}
}
old_password.onchange = validateOld_password;
</script>
