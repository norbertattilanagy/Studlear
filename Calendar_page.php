<?php include 'Conection.php'; ?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <!-- Bootstrap CSS -->
    <link href="assets\css\bootstrap.min.css" rel="stylesheet"/>
    <link href="assets\css\calendar.css" rel="stylesheet"/>
    <script src="assets\js\bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <title>Calendar</title>
    <style>
    a {
      text-decoration: none;
    }
    .event {
      margin-top: 5px;
      font-weight: 500;
      font-size: 18px;
      padding: 1px 30px;
      border-radius: 5px;
      background-color: #f7c30d;
      color: #fff;
    }
    .event.green {
      background-color: #51ce57;
    }
    .event.blue {
      background-color: #518fce;
    }
    .event.red {
      background-color: #ce5151;
    }

    </style>
  </head>
  <body>
    <!--Top bar-->
    <?php include 'Top_bar.php' ?>

    <div class="row">
      <!--Courses group-->
      <div class="col-md-3">
        <?php include 'Courses_group.php' ?>
      </div>


      <div class="col-md-9 row">
        <?php 

        //$_SESSION['calendar_date']=date("Y-m-d");
        //echo $_SESSION['calendar_date'];
        if(empty($_SESSION['calendar_date']))
          $_SESSION['calendar_date']=date("Y-m-d");

        include 'Calendar.php';
        ?>
    
    </div>


    <!--Footers-->
    <?php include 'Footers.php' ?>
  </body>



</html>
<?php //session_destroy(); ?>