<?php include 'Connection.php'; ?>
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
      <nav class="mx-3" aria-label="breadcrumb">
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

        if(empty($_SESSION['calendar_date']))
          $_SESSION['calendar_date']=date("Y-m-d");

        $date = DateTime::createFromFormat("Y-m-d", $_SESSION['calendar_date']);
        $active_year=$date->format('Y');
        $active_month=$date->format('m');
        $active_day=$date->format('d');

        $num_days = date('t', strtotime($active_day . '-' .$active_month . '-' .$active_year));
        $num_days_last_month = date('j', strtotime('last day of previous month', strtotime($active_day . '-' . $active_month . '-' .$active_year)));
        $days = [0 => 'Mon', 1 => 'Tue', 2 => 'Wed', 3 => 'Thu', 4 => 'Fri', 5 => 'Sat', 6 => 'Sun'];
        $first_day_of_week = array_search(date('D', strtotime($active_year . '-' . $active_month . '-1')), $days);
        $days_write=['Lu','Ma','Mi','Jo','Vi','Sa','Du'];
        $month_write=['Ianuarie','Februarie','Martie','Aprilie','Mai','Iunie','Iulie','August','Septembrie','Octombrie','Noiembrie','Decembrie'];
        $a_month=(int) $active_month;

        ?>
        <div class="calendar mb-3">
            <div class="header">
                <div class="month-year">
                    <div class="d-none d-md-block">
                        <div class="row">
                            <!--Left button group-->
                            <div class="col-sm-4">
                                <div class="btn-group">
                                    <a class="btn btn-outline-dark" href="Calendar_change.php?button=previous"><</a>
                                    <a class="btn btn-outline-dark" href="Calendar_change.php?button=today">Azi</a>
                                    <a class="btn btn-outline-dark" href="Calendar_change.php?button=next">></a>
                                </div>
                                <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#Add_event_Modal">+</button>
                            </div>

                            <div class="col-sm-4">
                                <h4>
                                    <?php echo $month_write[$a_month-1].' '.$active_year; ?>
                                </h4>
                            </div>
                        </div>
                    </div>
                    <?php //phone view?>
                    <div class="d-md-none d-block">
                        <h4>
                            <?php echo $month_write[$a_month-1].' '.$active_year; ?>
                        </h4>
                        <div class="btn-group">
                            <a class="btn btn-outline-dark" href="Calendar_change.php?button=previous"><</a>
                            <a class="btn btn-outline-dark" href="Calendar_change.php?button=today">Azi</a>
                            <a class="btn btn-outline-dark" href="Calendar_change.php?button=next">></a>
                        </div>
                        <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#Add_event_Modal">+</button>
                    </div>
                </div>
            </div>
            <div class="days ms-4">
                <?php
                //calendar
                    foreach ($days_write as $day) {
                        echo '<div class="day_name">' . $day . '</div>';
                    }
                    //day before and after view month
                    for ($i = $first_day_of_week; $i > 0; $i--) {
                        echo '<div class="day_num ignore">' . ($num_days_last_month-$i+1) . '</div>';
                    }
                    $nr_event=0;
                    $nr_video_conference=0;
                    $nr_quiz=0;
                    $nr_homework=0;
                    for ($i = 1; $i <= $num_days; $i++) {
                        $selected = '';
                        if ($i == date("d") && $active_month == date("m") && $active_year == date("Y"))
                            $selected = ' selected';

                        echo '<a class="day_num'.$selected.'" href="Calendar_change.php?button=change_day&day='.$i.'" style="text-decoration: none">';
                        echo '<span>'.$i.'</span>';
                        //event
                        $start_event_date=$active_year.'-'.$active_month.'-'.$i.' 00:00:00';
                        $end_event_date=$active_year.'-'.$active_month.'-'.$i.' 23:59:59';
                        $user_id=$_SESSION['user_id'];
                        $sql="SELECT * FROM calendar WHERE start_event >=STR_TO_DATE('$start_event_date', '%Y-%m-%d %H:%i:%s') AND end_event <=STR_TO_DATE('$end_event_date', '%Y-%m-%d %H:%i:%s') AND user_id LIKE $user_id";
                        $results=mysqli_query($db,$sql);


                        $nr_event=mysqli_num_rows($results);
                        $sql_lesson_group="SELECT l.id FROM lesson_group l LEFT JOIN course_user c ON l.course_id=c.course_id WHERE c.user_id LIKE $user_id";
                        $results_lesson_group=mysqli_query($db,$sql_lesson_group);
                        while($row_lesson_group=mysqli_fetch_array($results_lesson_group,MYSQLI_ASSOC))
                        {
                            
                            $lesson_group_id=$row_lesson_group['id'];
                            $sql_video_conference="SELECT * FROM video_conference WHERE start_event >=STR_TO_DATE('$start_event_date', '%Y-%m-%d %H:%i:%s') AND end_event <=STR_TO_DATE('$end_event_date', '%Y-%m-%d %H:%i:%s') AND lesson_group_id IN (SELECT l.id FROM lesson_group l LEFT JOIN course_user c ON l.course_id=c.course_id WHERE c.user_id LIKE $user_id)";
                            $results_video_conference=mysqli_query($db,$sql_video_conference);
                            $nr_video_conference=mysqli_num_rows($results_video_conference);
                            
                            $sql_quiz="SELECT * FROM quiz WHERE start_event >=STR_TO_DATE('$start_event_date', '%Y-%m-%d %H:%i:%s') AND end_event <=STR_TO_DATE('$end_event_date', '%Y-%m-%d %H:%i:%s') AND lesson_group_id IN (SELECT l.id FROM lesson_group l LEFT JOIN course_user c ON l.course_id=c.course_id WHERE c.user_id LIKE $user_id)";
                            $results_quiz=mysqli_query($db,$sql_quiz);
                            $nr_quiz=mysqli_num_rows($results_quiz);
                           
                            $sql_homework="SELECT * FROM homework WHERE end_event >=STR_TO_DATE('$start_event_date', '%Y-%m-%d %H:%i:%s') AND end_event <=STR_TO_DATE('$end_event_date', '%Y-%m-%d %H:%i:%s') AND lesson_group_id IN (SELECT l.id FROM lesson_group l LEFT JOIN course_user c ON l.course_id=c.course_id WHERE c.user_id LIKE $user_id)";
                            $results_homework=mysqli_query($db,$sql_homework);
                            $nr_homework=mysqli_num_rows($results_homework);
                            
                        }
                        $nr_total_event=$nr_event+$nr_video_conference+$nr_quiz+$nr_homework;
                        $limit=2;
                        //more than 3 events
                        if($nr_total_event>3)
                        {
                            if($limit>0 && $nr_event)
                            {
                                $sql="SELECT * FROM calendar WHERE start_event >=STR_TO_DATE('$start_event_date', '%Y-%m-%d %H:%i:%s') AND end_event <=STR_TO_DATE('$end_event_date', '%Y-%m-%d %H:%i:%s') AND user_id LIKE $user_id LIMIT $limit";
                                $results=mysqli_query($db,$sql);
                                while($row=mysqli_fetch_array($results,MYSQLI_ASSOC))
                                    echo '<div class="event '.$row['color'].'">'.$row['title'].'</div>';
                                $limit-=$nr_event;
                            }
                            if($limit>0 && $nr_video_conference)
                            {
                                $sql_video_conference="SELECT * FROM video_conference WHERE start_event >=STR_TO_DATE('$start_event_date', '%Y-%m-%d %H:%i:%s') AND end_event <=STR_TO_DATE('$end_event_date', '%Y-%m-%d %H:%i:%s') AND lesson_group_id IN (SELECT l.id FROM lesson_group l LEFT JOIN course_user c ON l.course_id=c.course_id WHERE c.user_id LIKE $user_id) LIMIT $limit";
                                $results_video_conference=mysqli_query($db,$sql_video_conference);
                                while($row_video_conference=mysqli_fetch_array($results_video_conference,MYSQLI_ASSOC))
                                    echo '<div class="event video_conference">'.$row_video_conference['title'].'</div>';
                                $limit-=$nr_video_conference;
                            }
                            if($limit>0 && $nr_quiz)
                            {
                                $sql_quiz="SELECT * FROM quiz WHERE start_event >=STR_TO_DATE('$start_event_date', '%Y-%m-%d %H:%i:%s') AND end_event <=STR_TO_DATE('$end_event_date', '%Y-%m-%d %H:%i:%s') AND lesson_group_id IN (SELECT l.id FROM lesson_group l LEFT JOIN course_user c ON l.course_id=c.course_id WHERE c.user_id LIKE $user_id) LIMIT $limit";
                                $results_quiz=mysqli_query($db,$sql_quiz);
                                while($row_quiz=mysqli_fetch_array($results_quiz,MYSQLI_ASSOC))
                                    echo '<div class="event quiz">'.$row_quiz['title'].'</div>';
                                $limit-=$nr_quiz;
                            }
                            if($limit>0 && $nr_homework)
                            {
                                $sql_homework="SELECT * FROM homework WHERE end_event >=STR_TO_DATE('$start_event_date', '%Y-%m-%d %H:%i:%s') AND end_event <=STR_TO_DATE('$end_event_date', '%Y-%m-%d %H:%i:%s') AND lesson_group_id IN (SELECT l.id FROM lesson_group l LEFT JOIN course_user c ON l.course_id=c.course_id WHERE c.user_id LIKE $user_id) LIMIT $limit";
                                $results_homework=mysqli_query($db,$sql_homework);
                                while($row_homework=mysqli_fetch_array($results_homework,MYSQLI_ASSOC))
                                    echo '<div class="event homework">'.$row_homework['title'].'</div>';
                                $limit-=$nr_homework;
                            }
                            echo '<div class="event">+'.$nr_total_event-2 .'</div>';
                        }
                        //less than 3 events
                        else
                        {
                            if($nr_event>0)
                            {
                                while($row=mysqli_fetch_array($results,MYSQLI_ASSOC))
                                    echo '<div class="event '.$row['color'].'">'.$row['title'].'</div>';
                            }
                            if($nr_video_conference>0)
                            {
                                while($row_video_conference=mysqli_fetch_array($results_video_conference,MYSQLI_ASSOC))
                                    echo '<div class="event video_conference">'.$row_video_conference['title'].'</div>';
                            }
                            if($nr_quiz>0)
                            {
                                while($row_quiz=mysqli_fetch_array($results_quiz,MYSQLI_ASSOC))
                                    echo '<div class="event quiz">'.$row_quiz['title'].'</div>';
                            }
                            if($nr_homework>0)
                            {
                                while($row_homework=mysqli_fetch_array($results_homework,MYSQLI_ASSOC))
                                    echo '<div class="event homework">'.$row_homework['title'].'</div>';
                            }
                        }
                        echo '</a>';
                    }

                    if((42-$num_days-max($first_day_of_week, 0))>=14)
                        $table_element=28;
                    else if((42-$num_days-max($first_day_of_week, 0))>=7)
                        $table_element=35;
                    else
                        $table_element=42;

                    for ($i = 1; $i <= ($table_element-$num_days-max($first_day_of_week, 0)); $i++) {
                        echo '<div class="day_num ignore">'.$i.'</div>';
                    } ?>
                </div>
            </div>
        </div>

        <?php $curent_date=$_SESSION['calendar_date'];?>

        <!--Modal Add_event_Modal-->
        <div class="modal fade" id="Add_event_Modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Adaugă eveniment</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" data-bs-target="#Add_event_Modal"></button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <form class="needs-validation" novalidate action="Calendar_change.php?button=add_event" method="post">
                            <div class="mb-3">
                                <label for="title" class="form-label">Titlu:</label>
                                <input type="text" class="form-control" id="title" name="title" required>
                                <div class="invalid-feedback">Introduceți titlul.</div>
                            </div>
                            <div class="mb-3">
                                <label for="date" class="form-label">Început:</label>
                                <div class="row">
                                    <div class="col">
                                        <?php echo '<input type="date" class="form-control" id="event_date_start" name="event_date_start" value="'.$curent_date.'" min='.date("Y-m-d").'>'; ?>
                                    </div>
                                    <div class="col">
                                        <input type="time" class="form-control" id="event_time_start" name="event_time_start" value="08:00">
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="date" class="form-label">Sfârșit:</label>
                                <div class="row">
                                    <div class="col">
                                        <?php echo '<input type="date" class="form-control" id="event_date_end" name="event_date_end" value="'.$curent_date.'" min='.date("Y-m-d").'>'; ?>
                                    </div>
                                    <div class="col">
                                        <input type="time" class="form-control" id="event_time_end" name="event_time_end" value="08:00">
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                Culoare:
                                <div class="form-check">
                                    <input type="radio" class="btn-check" name="event_color" id="yellow" value="yellow" autocomplete="off" checked>
                                    <label class="btn circle-button" for="yellow" value="yellow"></label>

                                    <input type="radio" class="btn-check" name="event_color" id="green" value="green" autocomplete="off">
                                    <label class="btn circle-button green" for="green"></label>

                                    <input type="radio" class="btn-check" name="event_color" id="blue" value="blue" autocomplete="off">
                                    <label class="btn circle-button blue" for="blue"></label>

                                    <input type="radio" class="btn-check" name="event_color" id="red" value="red" autocomplete="off">
                                    <label class="btn circle-button red" for="red"></label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="description">Descriere:</label>
                                <textarea class="form-control" rows="3" id="description" name="description"></textarea>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-secondary btn-block mt-3">Crează</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!--Modal Event_Modal-->
        <div class="modal fade" id="Event_Modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <?php echo '<h4 class="modal-title">Evenimente</h4>'; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" data-bs-target="#Event_Modal"></button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <?php 

                        $start_event_date=$_SESSION['calendar_date'].' 00:00:00';
                        $end_event_date=$_SESSION['calendar_date'].' 23:59:59';

                        $sql="SELECT * FROM calendar WHERE start_event >=STR_TO_DATE('$start_event_date', '%Y-%m-%d %H:%i:%s') AND end_event <=STR_TO_DATE('$end_event_date', '%Y-%m-%d %H:%i:%s') AND user_id LIKE $user_id";
                        $results=mysqli_query($db,$sql);
                        while($row=mysqli_fetch_array($results,MYSQLI_ASSOC)) {
                            $start_event = strtotime($row["start_event"]);
                            $end_event = strtotime($row["end_event"]);
                            $id = $row["id"];
                            echo '<a href="Calendar_change.php?button=save_id&id='.$id.'&event_type=event" class="link-dark" style="text-decoration: none">';
                                echo '<div class="event '.$row['color'].'">';
                                    echo '<div class="row">';
                                        echo '<div class="col-md-8">';
                                            echo $row['title'];
                                        echo '</div>';
                                        echo '<div class="col-md-4">';
                                            echo date('H:i', $start_event).'-'.date('H:i', $end_event);
                                        echo '</div>';
                                    echo '</div>';
                                echo '</div>';
                            echo '</a>';
                        }

                        $sql_video_conference="SELECT * FROM video_conference WHERE start_event >=STR_TO_DATE('$start_event_date', '%Y-%m-%d %H:%i:%s') AND end_event <=STR_TO_DATE('$end_event_date', '%Y-%m-%d %H:%i:%s') AND lesson_group_id IN (SELECT l.id FROM lesson_group l LEFT JOIN course_user c ON l.course_id=c.course_id WHERE c.user_id LIKE $user_id)";
                        $results_video_conference=mysqli_query($db,$sql_video_conference);
                        while($row_video_conference=mysqli_fetch_array($results_video_conference,MYSQLI_ASSOC))
                        {
                            $start_event = strtotime($row_video_conference["start_event"]);
                            $end_event = strtotime($row_video_conference["end_event"]);
                            $id = $row_video_conference["id"];
                            echo '<a href="Calendar_change.php?button=save_id&id='.$id.'&event_type=video_conference" class="link-dark" style="text-decoration: none">';
                                echo '<div class="event video_conference">';
                                    echo '<div class="row">';
                                        echo '<div class="col-md-8">';
                                            echo $row_video_conference['title'];
                                        echo '</div>';
                                        echo '<div class="col-md-4">';
                                            echo date('H:i', $start_event).'-'.date('H:i', $end_event);
                                        echo '</div>';
                                    echo '</div>';
                                echo '</div>';
                            echo '</a>';
                        }

                        $sql_quiz="SELECT * FROM quiz WHERE start_event >=STR_TO_DATE('$start_event_date', '%Y-%m-%d %H:%i:%s') AND end_event <=STR_TO_DATE('$end_event_date', '%Y-%m-%d %H:%i:%s') AND lesson_group_id IN (SELECT l.id FROM lesson_group l LEFT JOIN course_user c ON l.course_id=c.course_id WHERE c.user_id LIKE $user_id)";
                        $results_quiz=mysqli_query($db,$sql_quiz);
                        while($row_quiz=mysqli_fetch_array($results_quiz,MYSQLI_ASSOC))
                        {
                            $start_event = strtotime($row_quiz["start_event"]);
                            $end_event = strtotime($row_quiz["end_event"]);
                            $id = $row_quiz["id"];
                            echo '<a href="Calendar_change.php?button=save_id&id='.$id.'&event_type=quiz" class="link-dark" style="text-decoration: none">';
                                echo '<div class="event quiz">';
                                    echo '<div class="row">';
                                        echo '<div class="col-md-8">';
                                            echo $row_quiz['title'];
                                        echo '</div>';
                                        echo '<div class="col-md-4">';
                                            echo date('H:i', $start_event).'-'.date('H:i', $end_event);
                                        echo '</div>';
                                    echo '</div>';
                                echo '</div>';
                            echo '</a>';
                        }

                        $sql_homework="SELECT * FROM homework WHERE end_event >=STR_TO_DATE('$start_event_date', '%Y-%m-%d %H:%i:%s') AND end_event <=STR_TO_DATE('$end_event_date', '%Y-%m-%d %H:%i:%s') AND lesson_group_id IN (SELECT l.id FROM lesson_group l LEFT JOIN course_user c ON l.course_id=c.course_id WHERE c.user_id LIKE $user_id)";
                        $results_homework=mysqli_query($db,$sql_homework);
                        while($row_homework=mysqli_fetch_array($results_homework,MYSQLI_ASSOC))
                        {
                            $end_event = strtotime($row_homework["end_event"]);
                            $id = $row_homework["id"];
                            echo '<a href="Calendar_change.php?button=save_id&id='.$id.'&event_type=homework" class="link-dark" style="text-decoration: none">';
                                echo '<div class="event homework">';
                                    echo '<div class="row">';
                                        echo '<div class="col-8">';
                                            echo $row_homework['title'];
                                        echo '</div>';
                                        echo '<div class="col-md-1"></div>';
                                        echo '<div class="col-md-2">';
                                            echo '-'.date('H:i', $end_event);
                                        echo '</div>';
                                    echo '</div>';
                                echo '</div>';
                            echo '</a>';
                        }
                        ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#Add_event_Modal">Adaugă eveniment</button>
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
                        if(isset($_SESSION['event_id']) and isset($_SESSION['event_type'])){
                            $event_id=$_SESSION['event_id'];
                            if($_SESSION['event_type']=='event')
                                $sql="SELECT * FROM calendar WHERE id LIKE $event_id";
                            if($_SESSION['event_type']=="video_conference")
                                $sql="SELECT * FROM video_conference WHERE id LIKE $event_id";
                            if($_SESSION['event_type']=="quiz")
                                $sql="SELECT * FROM quiz WHERE id LIKE $event_id";
                            if($_SESSION['event_type']=="homework")
                                $sql="SELECT * FROM homework WHERE id LIKE $event_id";
                          
                            $results=mysqli_query($db,$sql);
                            $row=mysqli_fetch_array($results,MYSQLI_ASSOC);
                            echo '<h5>'.$row["title"].'</h5><br>';
                            if($_SESSION['event_type']!="homework")
                            {
                                $start_event=date("Y-m-d H:i", strtotime($row["start_event"]));
                                echo '<p>Început: <b>'.$start_event.'</b></p>';
                            }
                            $end_event=date("Y-m-d H:i", strtotime($row["end_event"]));
                            echo '<p>Sfârșit: <b>'.$end_event.'</b></p>';
                            if($_SESSION['event_type']=="event")
                            { 
                                echo '<p>Descriere:<br>';
                                if(isset($row['description']))
                                {
                                    $target_file=$row['description'];
                                    $file = fopen($target_file, "r");
                                    while(!feof($file)) {
                                        echo fgets($file)."<br>";
                                    }
                                    fclose($file);
                                }
                                echo '</p>';
                            }
                            if($_SESSION['event_type']=="video_conference")
                            {
                                echo '<div class="d-grid">';
                                    echo '<a href="Video_conference.php?id='.$event_id.'" class="btn btn-secondary" type="button">Accesează</a>';
                                echo '</div>';
                            }
                            else if($_SESSION['event_type']=="quiz")
                            {
                                echo '<div class="d-grid">';
                                    if($_SESSION['user_type']=="student")
                                        echo '<a href="Quiz_start.php?id='.$event_id.'" class="btn btn-secondary" type="button">Accesează</a>';
                                    else
                                        echo '<a href="Quiz_teacher.php?id='.$event_id.'" class="btn btn-secondary" type="button">Accesează</a>';
                                echo '</div>';
                            }
                            else if($_SESSION['event_type']=="homework")
                            {
                                echo '<div class="d-grid">';
                                    echo '<a href="Homework.php?id='.$event_id.'" class="btn btn-secondary" type="button">Accesează</a>';
                                echo '</div>';
                            }   
                        }
                        ?>
                        <?php if($_SESSION['event_type']=="event"){ ?>
                            <div class="d-grid">
                                <button type="button" class="btn btn-primary btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#Edit_event"><i class="bi bi-pencil-square me-2"></i>Editează</button>
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#Delete_event"><i class="bi bi-trash me-2"></i>Șterge</button>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        
        <!--Modal Edit_event_Modal-->
        <div class="modal fade" id="Edit_event">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Editează eveniment</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" data-bs-target="#Edit_event"></button>
                    </div>
                    <?php
                    $event_id=$_SESSION['event_id'];
                    $sql="SELECT * FROM calendar WHERE id LIKE $event_id";
                    $results=mysqli_query($db,$sql);
                    $row=mysqli_fetch_array($results);
                    ?>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <form action="Calendar_change.php?button=edit_event" class="needs-validation" method="post" novalidate>
                            <div class="mb-3">
                                <label for="title" class="form-label">Titlu:</label>
                                <?php echo '<input type="text" class="form-control" id="title" name="title" value="'.$row['title'].'" onClick="this.select();">'; ?>
                                <div class="invalid-feedback">Introduseți titlul.</div>
                            </div>
                            <div class="mb-3">
                                <label for="date" class="form-label">Început:</label>
                                <div class="row">
                                    <div class="col">
                                        <?php $start_event=date("Y-m-d", strtotime($row["start_event"]));
                                        if($start_event<date("Y-m-d"))
                                            $min_date=$start_event;
                                        else
                                            $min_date=date("Y-m-d");
                                        echo '<input type="date" class="form-control" id="event_date_start" name="event_date_start" value="'.$start_event.'" min='.$min_date.'>'; ?>
                                    </div>
                                    <div class="col">
                                        <?php $start_event=date("H:i", strtotime($row["start_event"]));
                                        echo '<input type="time" class="form-control" id="event_time_start" name="event_time_start" value="'.$start_event.'">'; ?>
                                    </div>
                                </div>
                            </div>
                           <div class="mb-3">
                                <label for="date" class="form-label">Sfârșit:</label>
                                <div class="row">
                                    <div class="col">
                                        <?php $end_event=date("Y-m-d", strtotime($row["end_event"]));
                                        echo '<input type="date" class="form-control" id="event_date_end" name="event_date_end" value="'.$end_event.'" min='.$min_date.'>'; ?>
                                    </div>
                                    <div class="col">
                                        <?php $end_event=date("H:i", strtotime($row["end_event"]));
                                        echo '<input type="time" class="form-control" id="event_time_end" name="event_time_end" value="'.$end_event.'">'; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Descriere:</label>
                                <textarea class="form-control" rows="3" id="description" name="description" onClick="this.select();"><?php
                                    if(isset($row['description']))
                                    {
                                        $target_file=$row['description'];
                                        $file = fopen($target_file,"r");
                                        while(!feof($file)) {
                                            echo fgets($file);
                                        }
                                        fclose($file);
                                    }  
                                ?></textarea>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-secondary btn-block mt-3">Salvează</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <!--Modal Delete_event_Modal-->
        <div class="modal fade" id="Delete_event">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Șterge eveniment</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" data-bs-target="#Delete_event"></button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="d-flex justify-content-center">
                          <p>Doriti să ștergeți evenimentul?</p>
                        </div>
                        <div class="d-flex justify-content-around">
                          <div class="d-grid gap-1 col-4">
                            <a href="Calendar_change.php?button=delete_event" class="btn btn-danger">Da</a>
                          </div>
                          <div class="d-grid gap-1 col-4">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" data-bs-target="#Delete_event">Nu</button>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    <?php    
    if($_SESSION['user_type']!="admin"){ ?>
      </div>
    <?php } ?>
    </div> 
  </body>
</html>
<script type="text/javascript">
  $(document).ready(function() {
      if(window.location.href.indexOf('#Event_Modal') != -1) {
          $('#Event_Modal').modal('show');
          window.history.pushState('', 'Calendar_page', 'Calendar_page.php');
      }
      else if(window.location.href.indexOf('#Description_event_Modal') != -1){
         $('#Description_event_Modal').modal('show');
         window.history.pushState('', 'Calendar_page', 'Calendar_page.php');
      }
  });
</script>
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