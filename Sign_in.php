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
    <title>Studlear</title>
  </head>
  <?php
  if(isset($_SESSION['email']))
    $email=$_SESSION['email'];
  else
    $email="";
  ?>

  <body class="bg-light">
    <?php $_SESSION['incorrect_email']=""; 
    $_SESSION['name']="";
    $_SESSION['email_c']="";?>
    <?php 
    if(isset($_SESSION['incorrect'])) {
      if($_SESSION['incorrect']=="Adresa de email nu există.")
        $_SESSION['incorrect']=""; 
      if($_SESSION['incorrect']!=""){?>
        <div class="alert alert-danger" role="alert">
          <div class="d-flex justify-content-center">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <?php echo $_SESSION['incorrect']; ?>
          </div>
        </div>
    <?php } } ?>
    <div class="col-lg-4 col-md-3"></div>
    <div class="container my-3 col-lg-4 col-md-6">
      <div class="row d-flex justify-content-center align-items-center">
        <p><br></p>
        <a href="Sign_in.php" class="">
          <img src="Images\Sistem\logo.png" alt="Logo" style="width:300px;" class="mx-auto d-block">
        </a>
        <h2 class="text-center"><br>Autentificare</h2>
        <form action="Sign_in1.php" class="needs-validation" name="form1" method="post" novalidate>
          <div class="mb-3 mt-3">
            <label for="email">E-mail:</label>
            <?php echo '<input type="email" class="form-control" id="email" placeholder="Introduceți e-mailul" value="'.$email.'" name="email" required>'; ?>
            <div class="invalid-feedback email"><p id="em">Introduceți un e-mail</p></div>
          </div>
          <div class="mb-3">
            <label for="pwd">Parolă:</label>
            <input type="password" class="form-control" id="password" placeholder="Introduceți parola" name="password" required>
            <div class="invalid-feedback password"><p id="pas">Introduceți parola</p></div>
          </div>
          <div class="form-check mb-3">
            <label class="form-check-label">
              <input class="form-check-input" type="checkbox" name="show_password" onclick="myFunction()"> Arată parola
            </label>
          </div>
          <div class="d-grid">
            <button type="submit" class="btn btn-dark btn-block">Autentificare</button>
          </div>
          <div class="text-center">
            <br><a href="Create_account.php">Înregistrare</a>
          </div>
        </form>
      </div>
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
    </div>

    <div class="col-lg-4 col-md-3"></div>
    
  </body>
</html>
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