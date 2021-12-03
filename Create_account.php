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

    <div class="container mt-3 col-lg-4 col-md-6">
      <div class="row d-flex justify-content-center align-items-center">
        <p><br></p>
        <a href="Sign_in.php" class="">
          <img src="Images\Sistem\logo4.png" alt="Logo" style="width:300px;" class="mx-auto d-block">
        </a>
        <h2 class="text-center"><br>Întregistrare</h2>
        <form action="#">
          <div class="mb-3 mt-3 row">
            <div class="col">
              <label for="last_name">Nume:</label>
              <input type="text" class="form-control" placeholder="Introduceți numele" name="last_name">
            </div>
            <div class="col">
              <label for="first_name">Prenume:</label>
              <input type="text" class="form-control" placeholder="Introduceți prenumele" name="first_name">
            </div>
          </div>
          <div class="mb-3">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" placeholder="Introduceţi e-mailul" name="email">
          </div>
          <div class="mb-3">
            <label for="pswd1">Parolă:</label>
            <input type="password" class="form-control" id="password1" placeholder="Introduceți parola" name="pswd1">
          </div>
          <div class="mb-3">
            <label for="pswd2">Confirmați parola:</label>
            <input type="password" class="form-control" id="password2" placeholder="Confirmați parola" name="pswd2">
          </div>
          <div class="mb-3">
            <label for="user_type" class="form-label">Selectați tipul de utilizator:</label>
            <select class="form-select" name="user_type" id="user_type">
              <option>-</option>
              <option>Profesor</option>
              <option>Elev, student</option>
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