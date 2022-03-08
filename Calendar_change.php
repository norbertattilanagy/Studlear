<?php include 'Conection.php'; ?>
<?php

    

    if($_GET['button']=="day")
    {
        echo "<br>da<br>";
        $_SESSION["calendar_type"]="day";
    }
    else if($_GET['button']=="week")
        $_SESSION["calendar_type"]="week";
    else if($_GET['button']=="month")
        $_SESSION["calendar_type"]="month";
    echo $_SESSION['calendar_type'];

    //change month
    if($_GET['button']=="previous" && $_SESSION["calendar_type"]=="month")
    {
        $_SESSION['calendar_date'] = date("Y-m-d", strtotime ( '-1 month' , strtotime ( $_SESSION['calendar_date'] ) )) ;
        echo "<br>qa=".$_SESSION['calendar_date'];
        $link='location:Calendar_page.php';
        header("$link");
    }    
    else if($_GET['button']=="next"  && $_SESSION["calendar_type"]=="month")
    {
        $_SESSION['calendar_date'] = date("Y-m-d", strtotime ( '+1 month' , strtotime ( $_SESSION['calendar_date'] ) )) ;
        echo "qa=".$date;
        $link='location:Calendar_page.php';
        header("$link");
    }
    //go today
    else if($_GET['button']=="today"  && $_SESSION["calendar_type"]=="month")
    {
        $_SESSION['calendar_date']=date("Y-m-d");
        echo "qa=".$date;
        $link='location:Calendar_page.php';
        header("$link");
    }

    if($_GET['button']=="change_day")
    {
        echo "i=".$_GET['day'];
        $date = DateTime::createFromFormat("Y-m-d", $_SESSION['calendar_date']);
        $year=$date->format('Y');
        $month=$date->format('m');
        $_SESSION['calendar_date']=date($year.'-'.$month.'-'.$_GET['day']);
        //$_SESSION['calendar_type']="day";
        $link='location:Calendar_page.php#Event_Modal';
        header("$link");
        ?>
    <?php }

    if($_GET['button']=="save_id")
    {
        $_SESSION['event_id']=$_GET['id'];
        $link='location:Calendar_page.php#Description_event_Modal';
        header("$link");
    }

    //$date=$_SESSION['calendar_date'];
    //echo "<br>qa=".$_SESSION['calendar_date'];

    //$link='location:Calendar_page.php';
    //header("$link");
?>
