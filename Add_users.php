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
  		  		<li class="breadcrumb-item"><a href="Search_users_admin.php" style="text-decoration: none;">Căutare utilizatori</a></li>
    			<li class="breadcrumb-item active" aria-current="page">Adaugă utilizatori</li>
  			</ol>
		</nav>
		<div class="row d-flex justify-content-center align-items-center mx-3">
			<div class="col-md-6 ">
				<form action="Create_account1.php" class="needs-validation" method="post" novalidate>
		          	<div class="mb-3">
		              	<label for="name">Nume:</label>
		              	<input type="text" class="form-control" id="name" placeholder="Introduceți numele" name="name" required>
			            <div class="invalid-feedback">Introduceți un nume</div>
		          	</div>
		          	<div class="mb-3">
			            <label for="email">Email:</label>
			            <input type="email" class="form-control" id="email" placeholder="Introduceţi e-mailul" name="email" required>
			            <div class="invalid-feedback">Introduceți un email</div>
			        </div>
			        <div class="mb-3">
			            <label for="pswd1">Parolă:</label>
			            <input type="password" class="form-control" id="password1" placeholder="Introduceți parola" name="password1" required>
			            <div class="invalid-feedback password1"><p id="p1">Introduceți o parolă</p></div>
			        </div>
			        <div class="mb-3">
			            <label for="pswd2">Confirmați parola:</label>
			            <input type="password" class="form-control" id="password2" placeholder="Confirmați parola" name="password2" required>
			            <div class="invalid-feedback password2"><p id="p2">Introduceți o parolă</p></div>
			        </div>
			        <div class="mb-3">
			            <label for="user_type" class="form-label">Selectați tipul de utilizator:</label>
			            <select class="form-select" name="user_type" id="user_type" required>
			        	    <option value="-">-</option>
			              	<option value="teacher">Profesor</option>
			              	<option value="student">Student</option>
			              	<option value="admin">Administrator</option>
			            </select>
			            <div class="invalid-feedback">Alegeți un tip de utilizator</div>
			        </div>
			        <div class="d-grid">
			            <br>
			            <button type="submit" class="btn btn-dark btn-block">Creare cont</button>
			        </div>
		        </form>
			</div>
		</div>
		
	</body>
</html>
<script type="text/javascript">
var password1=document.getElementById("password1");
var password2=document.getElementById("password2");
var user_type=document.getElementById("user_type");

(function () {
	
  	var forms = document.querySelectorAll('.needs-validation') 
  	Array.prototype.slice.call(forms).forEach(function (form) {
			
      	form.addEventListener('submit', function (event)
      	{			
        	if (!form.checkValidity())
        	{	
        		validateUser_type();
          		event.preventDefault()
          		event.stopPropagation()
        	}
        	form.classList.add('was-validated')
      	}, false)
    })
})()

function validatePassword(){
	if(password1.value=="")
	{
		$("#p1").remove();
		$(".password1").append(`<p id="p1">Introduceți o parolă</p>`);
	} 			
	if(password2.value=="")
	{
		$("#p2").remove();
		$(".password2").append(`<p id="p2">Introduceți o parolă</p>`);
	}
  	if(password1.value != password2.value) {
	  	$("#p1").remove();
		$("#p2").remove();
		$(".password1").append(`<p id="p1">Parola nu coincide</p>`);
		$(".password2").append(`<p id="p2">Parola nu coincide</p>`);

	  	password1.setCustomValidity(' ');
	    password2.setCustomValidity(' ');
  	} else {
	  	password1.setCustomValidity('');
	    password2.setCustomValidity('');
  	}
}
password1.onchange = validatePassword;
password2.onkeyup = validatePassword;
function validateUser_type(){
	if(user_type.value=="-"){
		user_type.setCustomValidity(' ');
	} else {
		user_type.setCustomValidity('');
	}
}
user_type.onchange = validateUser_type;
</script>