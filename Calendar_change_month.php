<?php include 'Conection.php'; ?>
<?php

    $date=$_SESSION['calendar_date'];
    echo "qa=".$date;
    if($_GET['button']=="previous")
    {
        $_SESSION['calendar_date'] = date("Y-m-d", strtotime ( '-1 month' , strtotime ( $_SESSION['calendar_date'] ) )) ;
        echo "<br>qa=".$date;
        $link='location:Calendar_page.php';
        header("$link");
    }    
    else if($_GET['button']=="next")
    {
        $_SESSION['calendar_date'] = date("Y-m-d", strtotime ( '+1 month' , strtotime ( $_SESSION['calendar_date'] ) )) ;
        echo "qa=".$date;
        $link='location:Calendar_page.php';
        header("$link");
    }
    else if($_GET['button']=="today")
    {
        $_SESSION['calendar_date']=date("Y-m-d");
        echo "qa=".$date;
        $link='location:Calendar_page.php?';
        header("$link");
    }
?>