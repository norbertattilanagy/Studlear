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
    <title>Calendar</title>
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
        <?php include 'Calendar1.php';
        $date=$_GET['date'];

        if($date=='')
          $date=date("Y-m-d");

        echo calendar($date);
        /*$calendar = new Calendar('2021-04-02'); 
        $calendar->add_event('Birthday', '2021-04-04', 1, 'green');
        $calendar->add_event('Birth', '2021-04-04', 1, 'blue');
        $calendar->add_event('Doctors', '2021-04-04', 1, 'red');
        $calendar->add_event('Holiday', '2021-04-04', 4);*/
        ?>
    
    </div>


    <!--Footers-->
    <?php include 'Footers.php' ?>
  </body>



</html>