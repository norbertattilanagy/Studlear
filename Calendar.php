<?php
    include 'Conection.php';
    if(!isset($_SESSION['calendar_type']))
        $_SESSION['calendar_type']="month";
        //$events[] = [$txt, $date, $days, $color];

    $date = DateTime::createFromFormat("Y-m-d", $_SESSION['calendar_date']);
    $active_year=$date->format('Y');
    $active_month=$date->format('m');
    $active_day=$date->format('d');
    //$active_year.'-'.$active_month.'-'.$active_day;

    $num_days = date('t', strtotime($active_day . '-' .$active_month . '-' .$active_year));
    $num_days_last_month = date('j', strtotime('last day of previous month', strtotime($active_day . '-' . $active_month . '-' .$active_year)));
    $days = [0 => 'Mon', 1 => 'Tue', 2 => 'Wed', 3 => 'Thu', 4 => 'Fri', 5 => 'Sat', 6 => 'Sun'];
    $first_day_of_week = array_search(date('D', strtotime($active_year . '-' . $active_month . '-1')), $days);

    $days_write=['Lu','Ma','Mi','Jo','Vi','Sa','Du'];

    //$_SESSION['calendar_date']=$date;

    //above the calendar
?>

<div class="calendar">
    <div class="header">
        <div class="month-year">
            <div class="row">
                <!--Left button group-->
                <div class="col-sm-4">
                    <div class="btn-group">
                        <a class="btn btn-outline-dark" href="Calendar_change.php?button=previous"><</a>
                        <a class="btn btn-outline-dark" href="Calendar_change.php?button=today">Today</a>
                        <a class="btn btn-outline-dark" href="Calendar_change.php?button=next">></a>
                    </div>
                    <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#Add_event_Modal">+</button>
                </div>

                <div class="col-sm-4">
                    <h4>
                        <?php echo date('F Y', strtotime($active_year . '-' . $active_month . '-' . $active_day)); ?>
                    </h4>
                </div>
       
                <div class="col-sm-4">
                    <div class="btn-group">
                        <?php
                        if($_SESSION["calendar_type"]=="day")
                            echo '<a class="btn btn-outline-dark active" href="Calendar_change.php?button=day">Zi</a>';
                        else
                            echo '<a class="btn btn-outline-dark" href="Calendar_change.php?button=day">Zi</a>';
                        if($_SESSION["calendar_type"]=="week")
                            echo '<a class="btn btn-outline-dark active" href="Calendar_change.php?button=week">Saptamana</a>';
                        else
                            echo '<a class="btn btn-outline-dark" href="Calendar_change.php?button=week">Saptamana</a>';
                        if($_SESSION["calendar_type"]=="month")
                            echo '<a class="btn btn-outline-dark active" href="Calendar_change.php?button=month">Luna</a>';
                        else
                            echo '<a class="btn btn-outline-dark" href="Calendar_change.php?button=month">Luna</a>';
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="days">
        <?php
        //calendar
        if($_SESSION['calendar_type']=="month") {
            //calendar header
            foreach ($days_write as $day) {
                echo '<div class="day_name">' . $day . '</div>';
            }
            //day before and after view month
            for ($i = $first_day_of_week; $i > 0; $i--) {
                echo '<div class="day_num ignore">' . ($num_days_last_month-$i+1) . '</div>';
            }

            for ($i = 1; $i <= $num_days; $i++) {
                $selected = '';
                if ($i == date("d") && $active_month == date("m") && $active_year == date("Y"))
                    $selected = ' selected';

                echo '<a class="day_num'.$selected.'" href="Calendar_change.php?button=change_day&day='.$i.'">';
                    echo '<span>'.$i.'</span>';

                    //event
                    $start_event_date=$active_year.'-'.$active_month.'-'.$i.' 23:59:59';
                    $end_event_date=$active_year.'-'.$active_month.'-'.$i.' 00:00:00';
                    $sql="SELECT * FROM calendar WHERE start_event <=STR_TO_DATE('$start_event_date', '%Y-%m-%d %H:%i:%s') and end_event >=STR_TO_DATE('$end_event_date', '%Y-%m-%d %H:%i:%s')";
                    $results=mysqli_query($db,$sql);
                    $row=mysqli_fetch_array($results,MYSQLI_ASSOC);

                    //more than 3 events
                    if(mysqli_num_rows($results)>3){
                        for ($j=0; $j<2; $j++) { 
                            echo '<div class="event '.$row['color'].'">'.$row['title'].'</div>';
                        }
                        echo '<div class="event ">+'.mysqli_num_rows($results)-2 .'</div>';
                    }
                    //less than 3 events
                    else{
                        foreach ($results as $row) {
                            echo '<div class="event '.$row['color'].'">'.$row['title'].'</div>';
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
            }
            
            echo 'q='.$_SESSION['calendar_date'];
        } ?>
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
                <form clsa="needs-validation" novalidate action="Add_event.php" method="post">
                    <div class="mb-3">
                        <label for="title" class="form-label">Titlu:</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                            <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="mb-3">
                        <label for="date" class="form-label">Început:</label>
                        <div class="row">
                            <div class="col">
                                <input type="date" class="form-control" id="event_date_start" name="event_date_start" value="'.$curent_date.'" min='.date("Y-m-d").'>
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
                                <input type="date" class="form-control" id="event_date_end" name="event_date_end" value="'.$curent_date.'" min='.date("Y-m-d").'>
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
                <h4 class="modal-title">Evenimente</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" data-bs-target="#Event_Modal"></button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <?php 
                //echo '<p class="select_date" id=select_date>'.$_SESSION['calendar_date'].'</p>';

                $start_event_date=$_SESSION['calendar_date'].' 23:59:59';
                $end_event_date=$_SESSION['calendar_date'].' 00:00:00';
                $sql="SELECT * FROM calendar WHERE start_event <=STR_TO_DATE('$start_event_date', '%Y-%m-%d %H:%i:%s') and end_event >=STR_TO_DATE('$end_event_date', '%Y-%m-%d %H:%i:%s')";
                $results=mysqli_query($db,$sql);
                $row=mysqli_fetch_array($results,MYSQLI_ASSOC);

                foreach ($results as $row) {
                    $start_event = strtotime($row["start_event"]);
                    $end_event = strtotime($row["end_event"]);
                    $id = $row["id"];
                    //echo '<div class="d-grid">';
                    //echo '<a data-bs-toggle="modal" data-bs-target="#Description_event_Modal">';
                    echo '<a href="Calendar_change.php?button=save_id&id='.$id.'">';
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
                   // echo '</button></div>';
                } ?>
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
                $event_id=$_SESSION['event_id'];
                $sql="SELECT * FROM calendar WHERE id LIKE $event_id";
                $results=mysqli_query($db,$sql);
                $row=mysqli_fetch_array($results,MYSQLI_ASSOC);

                $start_event=date("Y-m-d H:i", strtotime($row["start_event"]));
                $end_event=date("Y-m-d H:i", strtotime($row["end_event"]));

                echo '<h5>'.$row["title"].'</h5><br>';
                echo '<p>Început: <b>'.$start_event.'</b></p>';
                echo '<p>Sfârșit: <b>'.$end_event.'</b></p>';
                echo '<p>Descriere:<br>'.$row["description"].'</p>';
                ?>

            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        if(window.location.href.indexOf('#Event_Modal') != -1) {
            $('#Event_Modal').modal('show');
        }
        else if(window.location.href.indexOf('#Description_event_Modal') != -1){
            $('#Description_event_Modal').modal('show');
        }
    });
</script>