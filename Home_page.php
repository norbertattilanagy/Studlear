<?php include 'Conection.php'; ?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <!-- Bootstrap CSS -->
    <link href="assets\css\bootstrap.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <script src="assets\js\bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <title>Home page</title>
    <style type="text/css">
      a{
        text-decoration: none;
        color: black;
      }
      a:hover {
        color: black;
        text-decoration: underline;
      }
    </style>
  </head>
  <body>
    <!--Top bar-->
    <?php include 'Top_bar.php' ?>

    <div class="row">
      <!--Courses group-->
      <div class="col-md-3 mt-3">
        <?php include 'Courses_group.php' ?>
      </div>

      <div class="col-md-7">
        
        <div class="container mt-3">
          <?php

           if($_SESSION['user_type']=='teacher'){ ?>
            <button type="button" class="btn btn-primary btn-sm mb-3" data-bs-toggle="modal" data-bs-target="#Create_course">Crează curs +</button>
          <?php } ?>
          <div class="row">
            <?php 
            $user_id=$_SESSION['user_id'];
            $sql="SELECT * FROM course_user WHERE user_id LIKE $user_id";
            $results=mysqli_query($db,$sql);
            while ($row=mysqli_fetch_array($results,MYSQLI_ASSOC))
            {
              $course_id=$row['course_id'];
              $sql_course="SELECT * FROM course WHERE id LIKE $course_id";
              $results_course=mysqli_query($db,$sql_course);
              $row_course=mysqli_fetch_array($results_course,MYSQLI_ASSOC);?>

              <div class="col-md-4">
                <?php echo '<a href="Course_page.php?id='.$row["course_id"].'">'; ?>
                  <div class="card" >
                    <div class="card-header">
                      <?php echo $row_course['title']; ?>
                    </div>
                    <div class="card-body">Content</div> 
                  </div>
                </a>
                <br>
              </div>

              
              
            <?php } ?>
          </div>
          
          
        </div>
      </div>
    </div>

    <!--Create course modal-->
    <div class="modal fade" id="Create_course">
      <div class="modal-dialog">
        <div class="modal-content">

          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title">Crează curs</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" data-bs-target="#Create_course"></button>
          </div>

          <!-- Modal body -->
          <div class="modal-body">
            <form action="Create_course.php" method="post">
              <div class="mb-3">
                <label for="Cours_name" class="form-label">Nume curs:</label>
                <input type="text" class="form-control" id="Cours_name" placeholder="Nume curs" name="Cours_name">
              </div>
              <div class="mb-3">
                <label for="Cours_password" class="form-label">Parolă curs:</label>
                <input type="text" class="form-control" id="Cours_password" placeholder="Parolă curs" name="Cours_password">
              </div>
              <div class="d-grid">
                <button type="submit" class="btn btn-secondary btn-block mt-3">Crează</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!--Footers-->
    <?php include 'Footers.php' ?>
  </body>
</html>
