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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <script src="assets\js\bootstrap.bundle.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <title>Sign in</title>
  </head>
  <body>
    <?php if(isset($_SESSION['incorrect'])) {
      if($_SESSION['incorrect']!="Adresa de email nu există.")
        $_SESSION['incorrect']=""; 
      if($_SESSION['incorrect']!=""){?>
        <div class="alert alert-danger" role="alert">
          <div class="d-flex justify-content-center">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <?php echo $_SESSION['incorrect']; ?>
          </div>
        </div>
    <?php } } ?>
    <?php if(isset($_SESSION['corect'])) {
      if($_SESSION['correct']!=""){?>
        <div class="alert alert-success" role="alert">
          <div class="d-flex justify-content-center">
            <i class="bi bi-check-circle-fill me-2"></i>
            <?php echo $_SESSION['correct']; ?>
          </div>
        </div>
    <?php } } ?>
    <div class="container my-3 col-lg-4 col-md-6">
      <div class="row d-flex justify-content-center align-items-center">
        <p><br></p>
        <a href="Sign_in.php" class="">
          <img src="Images\Sistem\logo.png" alt="Logo" style="width:300px;" class="mx-auto d-block">
        </a>
        <h2 class="text-center"><br>Recuperare parolă</h2>
        <form action="Reset_password1.php?edit=3" class="needs-validation" method="post" novalidate>
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
          <div class="d-grid">
            <button type="submit" class="btn btn-dark btn-block">Salvează</button>
          </div>
          <div class="text-center">
            <br><a href="Sign_in.php">Autentificare</a>
          </div>
        </form>
      </div>
    </div>
  </body>
</html>
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
</script>