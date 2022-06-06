<?php include 'Conection.php'; ?>
<?php include 'Page_security.php'; ?>
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
    <title>Studlear</title>
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
                    <div class="card-body"></div> 
                  </div>
                </a>
                <br>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>
      <div class="col-md-2">
        <div class="me-4 mt-3">
          <h4>Evenimente:</h4>
          <?php 
          $user_id=$_SESSION['user_id'];
          for($i=0;$i<7;$i++)
          {
            $date_write=0;

            $plus_day='+'.$i.' day';
            $date=date('Y-m-d', strtotime($plus_day));

            $start_event_date=$date.' 00:00:00';
            $end_event_date=$date.' 23:59:59';

            $sql_event="SELECT * FROM calendar WHERE start_event >=STR_TO_DATE('$start_event_date', '%Y-%m-%d %H:%i:%s') AND end_event <=STR_TO_DATE('$end_event_date', '%Y-%m-%d %H:%i:%s') AND user_id like $user_id";
            $results_event=mysqli_query($db,$sql_event);
            $nr_event=mysqli_num_rows($results_event);
            if($nr_event>0 && $date_write==0)
            {
              echo '<div class="mt-3"><b>'.date('Y.m.d', strtotime($plus_day)).'</b></div>';
              $date_write=1;
            }
            while($row_event=mysqli_fetch_array($results_event,MYSQLI_ASSOC))
            {
              $start_event = strtotime($row_event["start_event"]);
              $end_event = strtotime($row_event["end_event"]);

              $id = $row_event["id"];
              echo '<a href="Calendar_change.php?button=save_id_home&id='.$id.'&event_type=">';
              echo '<div class="d-flex justify-content-between">';
              echo '<i class="bi bi-calendar-event me-2"></i>';
              echo '<div style="width: 100%; overflow: hidden; text-overflow: ellipsis;">'.$row_event['title'].'</div>';
              echo '</div>';
              echo '<div class="ms-4">'.date('H:i', $start_event).'-'.date('H:i', $end_event).'</div>';
              echo '</a>';
            }

            $sql_video_conference="SELECT * FROM video_conference WHERE start_event >=STR_TO_DATE('$start_event_date', '%Y-%m-%d %H:%i:%s') AND end_event <=STR_TO_DATE('$end_event_date', '%Y-%m-%d %H:%i:%s') AND lesson_group_id IN (SELECT l.id FROM lesson_group l LEFT JOIN course_user c ON l.course_id=c.course_id WHERE c.user_id LIKE $user_id)";
            $results_video_conference=mysqli_query($db,$sql_video_conference);
            $nr_video_conference=mysqli_num_rows($results_video_conference);
            if($nr_video_conference>0 && $date_write==0)
            {
              echo '<div class="mt-3"><b>'.date('Y.m.d', strtotime($plus_day)).'</b></div>';
              $date_write=1;
            }
            while($row_video_conference=mysqli_fetch_array($results_video_conference,MYSQLI_ASSOC))
            {
              $start_event = strtotime($row_video_conference["start_event"]);
              $end_event = strtotime($row_video_conference["end_event"]);

              $id = $row_video_conference["id"];

              echo '<a href="Video_conference.php?id='.$id.'">';
              echo '<div class="d-flex justify-content-between">';
              echo '<i class="bi bi-camera-video me-2"></i>';
              echo '<div style="width: 100%; overflow: hidden; text-overflow: ellipsis;">'.$row_video_conference['title'].'</div>';
              echo '</div>';
              echo '<div class="ms-4">'.date('H:i', $start_event).'-'.date('H:i', $end_event).'</div>';
              echo '</a>';
            }

            $sql_quiz="SELECT * FROM quiz WHERE start_event >=STR_TO_DATE('$start_event_date', '%Y-%m-%d %H:%i:%s') AND end_event <=STR_TO_DATE('$end_event_date', '%Y-%m-%d %H:%i:%s') AND lesson_group_id IN (SELECT l.id FROM lesson_group l LEFT JOIN course_user c ON l.course_id=c.course_id WHERE c.user_id LIKE $user_id)";
            $results_quiz=mysqli_query($db,$sql_quiz);
            $nr_quiz=mysqli_num_rows($results_quiz);
            if($nr_quiz>0 && $date_write==0)
            {
              echo '<div class="mt-3"><b>'.date('Y.m.d', strtotime($plus_day)).'</b></div>';
              $date_write=1;
            }
            while($row_quiz=mysqli_fetch_array($results_quiz,MYSQLI_ASSOC))
            {
              $start_event = strtotime($row_quiz["start_event"]);
              $end_event = strtotime($row_quiz["end_event"]);

              $id = $row_quiz["id"];
              if($_SESSION['user_type']=="student")
                echo '<a href="Quiz_start.php?id='.$id.'">';
              else
                echo '<a href="Quiz_teacher.php?id='.$id.'">';
              echo '<div class="d-flex justify-content-between">';
              echo '<i class="bi bi-question-diamond me-2"></i>';
              echo '<div style="width: 100%; overflow: hidden; text-overflow: ellipsis;">'.$row_quiz['title'].'</div>';
              echo '</div>';
              echo '<div class="ms-4">'.date('H:i', $start_event).'-'.date('H:i', $end_event).'</div>';
              echo '</a>';
            }

            $sql_homework="SELECT * FROM homework WHERE end_event >=STR_TO_DATE('$start_event_date', '%Y-%m-%d %H:%i:%s') AND end_event <=STR_TO_DATE('$end_event_date', '%Y-%m-%d %H:%i:%s') AND lesson_group_id IN (SELECT l.id FROM lesson_group l LEFT JOIN course_user c ON l.course_id=c.course_id WHERE c.user_id LIKE $user_id)";
            $results_homework=mysqli_query($db,$sql_homework);
            $nr_homework=mysqli_num_rows($results_homework);
            if($nr_homework>0 && $date_write==0)
            {
              echo '<div class="mt-3"><b">'.date('Y.m.d', strtotime($plus_day)).'</b></div>';
              $date_write=1;
            }
            while($row_homework=mysqli_fetch_array($results_homework,MYSQLI_ASSOC))
            {
              $end_event = strtotime($row_homework["end_event"]);

              $id = $row_homework["id"];
              echo '<a href="Homework.php?id='.$id.'">';
              echo '<div class="d-flex justify-content-between">';
              echo '<i class="bi bi-house-door me-2"></i>';
              echo '<div style="width: 100%; overflow: hidden; text-overflow: ellipsis;">'.$row_homework['title'].'</div>';
              echo '</div>';
              echo '<div class="ms-4">'.date('H:i', $end_event).'</div>';
              echo '</a>';
            }
          }
          ?>
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
            <form action="Create_course.php" class="needs-validation" method="post" novalidate>
              <div class="mb-3">
                <label for="Cours_name" class="form-label">Nume curs:</label>
                <input type="text" class="form-control" id="Cours_name" placeholder="Nume curs" name="Cours_name" required>
                <div class="invalid-feedback">Introduceți numele cursului</div>
              </div>
              <div class="mb-3">
                <label for="Cours_password" class="form-label">Parolă curs:</label>
                <input type="text" class="form-control" id="Cours_password" placeholder="Parolă curs" name="Cours_password">
                <div>*Nu este obligatoriu.</div>
              </div>
              <div class="d-grid">
                <button type="submit" class="btn btn-secondary btn-block mt-3">Crează</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!--Modal Description_event_Modal-->
    <div class="modal fade" id="Description_event_Modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Descriere eveniment</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" data-bs-target="#Description_event_Modal"></button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <?php 
                    if(isset($_SESSION['event_id'])){
                        $event_id=$_SESSION['event_id'];

                        $sql="SELECT * FROM calendar WHERE id LIKE $event_id";
                        $results=mysqli_query($db,$sql);
                        $row=mysqli_fetch_array($results,MYSQLI_ASSOC);

                        echo '<h5>'.$row["title"].'</h5><br>';
                        $start_event=date("Y-m-d H:i", strtotime($row["start_event"]));
                        echo '<p>Început: <b>'.$start_event.'</b></p>';
                        $end_event=date("Y-m-d H:i", strtotime($row["end_event"]));
                        echo '<p>Sfârșit: <b>'.$end_event.'</b></p>';
                        echo '<p>Descriere:<br>';
                        $target_file=$row['description'];
                        $file = fopen($target_file, "r");
                        while(!feof($file)) {
                            echo fgets($file)."<br>";
                        }
                        fclose($file);
                        echo '</p>'; 
                    }
                    ?>

                </div>
            </div>
        </div>
    </div>

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
<script type="text/javascript">
    $(document).ready(function() {
        if(window.location.href.indexOf('#Description_event_Modal') != -1){
           $('#Description_event_Modal').modal('show');
           window.history.pushState('', 'Home_page', 'Home_page.php');
        }
    });
</script>