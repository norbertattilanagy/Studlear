<?php
   

    function calendar($date) {
        include 'Conection.php';
        //$events[] = [$txt, $date, $days, $color];

        $date = DateTime::createFromFormat("Y-m-d", $date);
        //echo $date->format("Y");
        $active_year=$date->format('Y');
        $active_month=$date->format('m');
        $active_day=$date->format('d');

        $date=$active_year.'-'.$active_month.'-'.$active_day;

        echo "active=".$date;

        $num_days = date('t', strtotime($active_day . '-' .$active_month . '-' .$active_year));
        $num_days_last_month = date('j', strtotime('last day of previous month', strtotime($active_day . '-' . $active_month . '-' .$active_year)));
        $days = [0 => 'Mon', 1 => 'Tue', 2 => 'Wed', 3 => 'Thu', 4 => 'Fri', 5 => 'Sat', 6 => 'Sun'];
        $first_day_of_week = array_search(date('D', strtotime($active_year . '-' . $active_month . '-1')), $days);

        $days_write=['Lu','Ma','Mi','Jo','Vi','Sa','Du'];

        $_SESSION['calendar_date']=$date;
        //above the calendar
        $html = '<div class="calendar">';
        $html .= '<div class="header">';
        $html .= '<div class="month-year">';
        $html .= '<div class="row">';
        
        $html .= '<div class="col-sm-4">';
        $html .= '<div class="btn-group">
                    <a class="btn btn-outline-dark" href="Calendar_change_month.php?button=previous"><</a>
                    <a class="btn btn-outline-dark" href="Calendar_change_month.php?button=today">Today</a>
                    <a class="btn btn-outline-dark" href="Calendar_change_month.php?button=next">></a>
                  </div>';

        $html .= '  <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#Add_event_Modal">+</button>';
        $html .= '</div>';

        $html .= '<div class="col-sm-4">';
        $html .= '<h4>';
        $html .= date('F Y', strtotime($active_year . '-' . $active_month . '-' . $active_day));
        $html .= '</h4>';
        $html .= '</div>';
       
        $html .= '<div class="col-sm-4">';
        $html .= '<div class="btn-group">
                    <button type="button" class="btn btn-outline-dark">Zi</button>
                    <button type="button" class="btn btn-outline-dark">Saptamana</button>
                    <button type="button" class="btn btn-outline-dark active">Luna</button>
                  </div>';
        $html .= '</div>';

        $html .= '</div>';//row
        $html .= '</div>';//month-year
        $html .= '</div>';//header
        $html .= '<div class="days">';

        //Modal Add_event_Modal
        $html .= '<div class="modal fade" id="Add_event_Modal">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title">Adauga evniment</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" data-bs-target="#Add_event_Modal"></button>
                            </div>

                            <!-- Modal body -->
                            <div class="modal-body">
                                <form action="#">
                                    <div class="mb-3">
                                        <label for="Title" class="form-label">Titlu:</label>
                                        <input type="text" class="form-control" id="Title" placeholder="Title" name="Title">
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check1" name="option1" value="something">
                                        <label class="form-check-label" for="check1">Curs 1</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="check2" name="option2" value="something">
                                        <label class="form-check-label" for="check2">Curs 2</label>
                                    </div>

                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-secondary btn-block mt-3">Crează</button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>';

        //Modal Event_Modal

        
        //echo "<br>".$sql;
        $html .= '<div class="modal fade" id="Event_Modal">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title">Evenimente</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" data-bs-target="#Event_Modal"></button>
                            </div>

                            <!-- Modal body -->
                            <div class="modal-body">';
                                echo "ad=".$_SESSION['calendar_date'];

                                $html .= '<p>'.$_SESSION['calendar_date'].'</p>';
                                $event_date=$_SESSION['calendar_date'] .' 00:00:00';
                                $sql="SELECT * FROM calendar WHERE start_event <=STR_TO_DATE('$event_date', '%Y-%m-%d %H:%i:%s') and end_event >=STR_TO_DATE('$event_date', '%Y-%m-%d %H:%i:%s')";
                                $results=mysqli_query($db,$sql);
                                $row=mysqli_fetch_array($results,MYSQLI_ASSOC);


                                foreach ($results as $row) {
                                    $start_event = DateTime::createFromFormat("h:i", $row['start_event']);
                                    $end_event = DateTime::createFromFormat("h:i", $row['end_event']);

                                    $html .= '<div class="event ' . $row['color'] . '">';
                                    $html .= $row['title'].'    '.$start_event.'-'.$end_event;
                                    $html .= '</div>';
                                }  
        $html .=           '</div>
                        </div>
                    </div>
                </div><p id="demo"></p>';

        //calendar
        foreach ($days_write as $day) {
            $html .= '
                <div class="day_name">
                    ' . $day . '
                </div>
            ';
        }

        for ($i = $first_day_of_week; $i > 0; $i--) {

            $html .= '
                <div class="day_num ignore">
                    ' . ($num_days_last_month-$i+1) . '
                </div>
            ';
        }

        for ($i = 1; $i <= $num_days; $i++) {
            $selected = '';
            if ($i == date("d") && $active_month == date("m") && $active_year == date("Y")) {
                $selected = ' selected';
            }
            $html .= '<div class="day_num' . $selected . '" data-bs-toggle="modal" data-bs-target="#Event_Modal" onclick="switch_day('.$i.')">';
            $html .= '<span>' . $i . '</span>';

            //event max 3 event
            $event_date=$active_year . '-' . $active_month . '-' . $i.' 00:00:00';
            $sql="SELECT * FROM calendar WHERE start_event <=STR_TO_DATE('$event_date', '%Y-%m-%d %H:%i:%s') and end_event >=STR_TO_DATE('$event_date', '%Y-%m-%d %H:%i:%s')";
            $results=mysqli_query($db,$sql);
            $row=mysqli_fetch_array($results,MYSQLI_ASSOC);

            if(mysqli_num_rows($results)>3){
                for ($j=0; $j<2; $j++) { 
                    $html .= '<div class="event ' . $row['color'] . '">';
                    $html .= $row['title'];
                    $html .= '</div>';
                }
                $html .= '<div class="event ">';
                $html .= '+'.mysqli_num_rows($results)-2;
                $html .= '</div>';
            }
            else{
                foreach ($results as $row) {
                    $html .= '<div class="event ' . $row['color'] . '">';
                    $html .= $row['title'];
                    $html .= '</div>';
                }
            }

            $html .= '</div>';
        }

        if((42-$num_days-max($first_day_of_week, 0))>=14)
            $table_element=28;
        else if((42-$num_days-max($first_day_of_week, 0))>=7)
            $table_element=35;
        else
            $table_element=42;

        for ($i = 1; $i <= ($table_element-$num_days-max($first_day_of_week, 0)); $i++) {
            $html .= '
                <div class="day_num ignore">
                    ' . $i . '
                </div>
            ';
        }
        $html .= '</div>';
        $html .= '</div>';
        echo 'qqqqqqqqqqqqq='.$_SESSION['calendar_date'];
        return $html;
    }

?>    
<script type="text/javascript">
    function switch_day(day,month,year)
    {
        const calendar_day = new Date();
        calendar_day ="<?php echo $_SESSION['calendar_date']; ?>";
        "<?php $_SESSION['calendar_date']?>"=calendar_day;
        calendar_day.setDate(day);
        alert(calendar_day);        
    }
</script>