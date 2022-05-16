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

    <link href="assets\css\calendar_event.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <script src="assets\js\bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <title>Studlear</title>
  </head>
  <body>
    <!--Top bar-->
    <?php include 'Top_bar.php' ?>

    <?php if($_SESSION['user_type']!="admin"){ ?>
      <nav class="ms-4" aria-label="breadcrumb">
          <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="Home_page.php" style="text-decoration: none;">Acasa</a></li>
            <li class="breadcrumb-item active" aria-current="page">Calendar</li>
          </ol>
      </nav>
    <?php } ?>

    <?php if($_SESSION['user_type']!="admin"){ ?>
    <div class="row">
      
      <!--Courses group-->
      <div class="col-md-3">
        <?php include 'Courses_group.php' ?>
      </div>


      <div class="col-md-9 row">
      <?php } 
      else
        echo '<div class="mx-4">';

        if(empty($_SESSION['calendar_date']))
          $_SESSION['calendar_date']=date("Y-m-d");

        include 'Calendar.php';
        
    if($_SESSION['user_type']!="admin"){ ?>
      </div>
    <?php } ?>
    </div>
    
  </body>



</html>
<?php //session_destroy(); ?>