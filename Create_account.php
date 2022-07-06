<?php include 'Connection.php'; ?>
<?php include 'Page_security.php'; ?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <!-- Bootstrap CSS -->
    <link href="assets\css\bootstrap.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <script src="assets\js\bootstrap.bundle.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <title>Studlearn</title>
  </head>
  <body class="bg-light">
    <?php
    if(isset($_SESSION['name']))
      $name=$_SESSION['name'];
    else
      $name="";
    if(isset($_SESSION['email_c']))
      $email=$_SESSION['email_c'];
    else
      $email="";
    ?>
    <?php 
    if(isset($_SESSION['incorrect_email'])) {
      if($_SESSION['incorrect_email']!=""){?>
        <div class="alert alert-danger" role="alert">
          <div class="d-flex justify-content-center">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <?php echo $_SESSION['incorrect_email']; ?>
          </div>
        </div>
    <?php } } ?>
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
              <?php echo '<input type="text" class="form-control" id="name" placeholder="Introduceți numele" name="name" value="'.$name.'" required>'; ?>
              <div class="invalid-feedback">Introduceți un nume</div>
          </div>
          <div class="mb-3">
            <label for="email">E-mail:</label>
            <?php echo '<input type="email" class="form-control" id="email" placeholder="Introduceţi e-mailul" name="email" value="'.$email.'" required>'; ?>
            <div class="invalid-feedback">Introduceți un e-mail</div>
          </div>
          <div class="mb-3">
            <label for="password1">Parolă:</label>
            <input type="password" class="form-control" id="password1" placeholder="Introduceți parola" name="password1" data-bs-toggle="popover" data-bs-trigger="focus" title="Parola trebuie să conțină cel puțin:" data-bs-content="6 caractere, o majusculă, o minusculă, o cifră" required>
            <div class="invalid-feedback password1"><p id="p1">Introduceți o parolă</p></div>
          </div>
          <div class="mb-3">
            <label for="password2">Confirmați parola:</label>
            <input type="password" class="form-control" id="password2" placeholder="Confirmați parola" name="password2" required>
            <div class="invalid-feedback password2"><p id="p2">Introduceți o parolă</p></div>
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
<script>
var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
  return new bootstrap.Popover(popoverTriggerEl)
})
var popover = new bootstrap.Popover(document.querySelector('.popover-dismiss'), {
  trigger: 'focus'
})
</script>
<script type="text/javascript">
var password1=document.getElementById("password1");
var password2=document.getElementById("password2");

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

function validatePassword(){
  var lower_case_letters = /[a-z]/g;
  var upper_case_letters = /[A-Z]/g;
  var numbers = /[0-9]/g;
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
  if(password1.value != password2.value)
  {
    $("#p1").remove();
    $("#p2").remove();
    $(".password1").append(`<p id="p1">Parola nu coincide</p>`);
    $(".password2").append(`<p id="p2">Parola nu coincide</p>`);
    password1.setCustomValidity(' ');
    password2.setCustomValidity(' ');
  }
  else
  {
    password1.setCustomValidity('');
    password2.setCustomValidity('');
  }
  if(password1.value.length<6)
  {
    $("#p1").remove();
    $(".password1").append(`<p id="p1">Parola trebuie să conțonă minim 6 carcatere</p>`);
    password1.setCustomValidity(' ');
  }
  else if(!password1.value.match(lower_case_letters))
  {
    $("#p1").remove();
    $(".password1").append(`<p id="p1">Parola nu conține litere mici</p>`);
    password1.setCustomValidity(' ');
  }
  else if(!password1.value.match(upper_case_letters))
  {
    $("#p1").remove();
    $(".password1").append(`<p id="p1">Parola nu conține litere mari</p>`);
    password1.setCustomValidity(' ');
  }
  else if(!password1.value.match(numbers))
  {
    $("#p1").remove();
    $(".password1").append(`<p id="p1">Parola nu conține cifre</p>`);
    password1.setCustomValidity(' ');
  }
  else if(password1.value == password2.value)
  {
    password1.setCustomValidity('');
    password2.setCustomValidity('');
  }
}
password1.onchange = validatePassword;
password2.onkeyup = validatePassword;
</script>