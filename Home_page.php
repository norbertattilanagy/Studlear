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
    <title>Home page</title>
  </head>
  <body>
    <!--Top bar-->
    <?php include 'Top_bar.php' ?>

    <div class="row">
      <!--Courses group-->
      <div class="col-md-3">
        <?php include 'Courses_group.php' ?>
      </div>
    </div>


    <!--Footers-->
    <?php include 'Footers.php' ?>
  </body>
</html>