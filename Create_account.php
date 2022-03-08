<?php include 'Conection.php'; ?>
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
          <img src="Images\Sistem\logo4.png" alt="Logo" style="width:300px;" class="mx-auto d-block">
        </a>
        <h2 class="text-center"><br>Întregistrare</h2>
        <form action="Create_account1.php" method="post">
          <div class="mb-3">
              <label for="name">Nume:</label>
              <input type="text" class="form-control" id="name" placeholder="Introduceți numele" name="name">
          </div>
          <div class="mb-3">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" placeholder="Introduceţi e-mailul" name="email">
          </div>
          <div class="mb-3">
            <label for="pswd1">Parolă:</label>
            <input type="password" class="form-control" id="password1" placeholder="Introduceți parola" name="password1">
          </div>
          <div class="mb-3">
            <label for="pswd2">Confirmați parola:</label>
            <input type="password" class="form-control" id="password2" placeholder="Confirmați parola" name="password2">
          </div>
          <div class="mb-3">
            <label for="user_type" class="form-label">Selectați tipul de utilizator:</label>
            <select class="form-select" name="user_type" id="user_type">
              <option value="-">-</option>
              <option value="teacher">Profesor</option>
              <option value="student">Elev, student</option>
            </select>
          </div>
          <div class="d-grid">
            <br>
            <button type="submit" class="btn btn-dark btn-block">Înregistrare</button>
          </div>
        </form>
      </div>
    </div>

    <div class="col-lg-4 col-md-3"></div>
  </body>
</html>