<?php include 'Conection.php'; ?>
<?php include 'Page_security.php'; ?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <!-- Bootstrap CSS -->
    <link href="assets\css\bootstrap.min.css" rel="stylesheet"/>
    <script src="assets\js\bootstrap.bundle.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <title>Create account</title>
  </head>
  <body class="bg-light">
    <div class="col-lg-4 col-md-3"></div>

    <div class="container my-3 col-lg-4 col-md-6">
      <div class="row d-flex justify-content-center align-items-center">
        
        <a href="Sign_in.php" class="">
          <img src="Images\Sistem\logo.png" alt="Logo" style="width:300px;" class="mx-auto d-block">
        </a>
        <h2 class="text-center"><br>Întregistrare</h2>
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
            <label for="password1">Parolă:</label>
            <input type="password" class="form-control" id="password1" placeholder="Introduceți parola" name="password1" required>
            <div class="invalid-feedback password1"><p id="p1">Introduceți o parolă</p></div>
          </div>
          <div class="mb-3">
            <label for="password2">Confirmați parola:</label>
            <input type="password" class="form-control" id="password2" placeholder="Confirmați parola" name="password2" required>
            <div class="invalid-feedback password2"><p id="p2">Introduceți o parolă</p></div>
          </div>
          <div class="mb-3">
            <label for="user_type" class="form-label">Selectați tipul de utilizator:</label>
            <select class="form-select" name="user_type" id="user_type" required>
              <option value="-">-</option>
              <option value="teacher">Profesor</option>
              <option value="student">Student</option>
            </select>
            <div class="invalid-feedback">Alegeți un tip de utilizator</div>
          </div>
          <div class="d-grid">
            <br>
            <button type="submit" class="btn btn-dark btn-block">Înregistrare</button>
          </div>
          <div class="text-center">
            <p><br><a href="Sign_in.php">Autentificare</a></p>
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