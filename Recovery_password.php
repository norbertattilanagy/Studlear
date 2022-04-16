<?php include 'Conection.php'; ?>
<?php //include 'Page_security.php'; ?>
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
    <?php
    $_SESSION['correct']="";
    if(isset($_SESSION['incorrect'])) {
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
        <form action="Reset_password1.php?edit=1" class="needs-validation" method="post" novalidate>
          <div class="mb-3 mt-3">
            <label for="email">Email:</label>
            <?php echo '<input type="email" class="form-control" id="email" placeholder="Enter email" name="email" required>'; ?>
            <div class="invalid-feedback email"><p id="em">Introduceți email-ul</p></div>
          </div>
          <div class="d-grid">
            <button type="submit" class="btn btn-dark btn-block">Trimite</button>
          </div>
          <div class="text-center">
            <br><a href="Sign_in.php">Autentificare</a>
          </div>
        </form>
      </div>
    </div>
  </body>
</html>