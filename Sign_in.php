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
    <title>Sign in</title>
  </head>
  <body class="bg-light">
    <div class="col-lg-4 col-md-3"></div>

    <div class="container my-3 col-lg-4 col-md-6">
      <div class="row d-flex justify-content-center align-items-center">
        <p><br></p>
        <a href="Sign_in.php" class="">
          <img src="Images\Sistem\logo4.png" alt="Logo" style="width:300px;" class="mx-auto d-block">
        </a>
        <h2 class="text-center"><br>Autentificare</h2>
        <form action="Sign_in1.php" method="post">
          <div class="mb-3 mt-3">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
          </div>
          <div class="mb-3">
            <label for="pwd">Parolă:</label>
            <input type="password" class="form-control" id="password" placeholder="Enter password" name="password">
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
            <p><br><a href="Create_account.php">Înregistrare</a></p>
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