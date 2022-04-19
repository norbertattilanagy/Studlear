<?php include 'Conection.php'; ?>
<?php include 'Page_security.php'; ?>
<?php
if(empty($_GET['button']))
{
    if($_SESSION['user_type']=="admin")
        header("location:Search_courses.php");
    else
    {
        header("location:Home_page.php");
        exit();
    }
}
if($_GET['button']=="previous")//change month
{
    $_SESSION['calendar_date'] = date("Y-m-d", strtotime ( '-1 month' , strtotime ( $_SESSION['calendar_date'] ) )) ;
    echo "<br>qa=".$_SESSION['calendar_date'];
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
else if($_GET['button']=="today")//go today
{
    $_SESSION['calendar_date']=date("Y-m-d");
    $link='location:Calendar_page.php';
    header("$link");
}
else if($_GET['button']=="change_day")
{
    echo "i=".$_GET['day'];
    $date = DateTime::createFromFormat("Y-m-d", $_SESSION['calendar_date']);
    $year=$date->format('Y');
    $month=$date->format('m');
    $_SESSION['calendar_date']=date($year.'-'.$month.'-'.$_GET['day']);
    $link='location:Calendar_page.php#Event_Modal';
    header("$link");
}
else if($_GET['button']=="save_id")
{
    $_SESSION['event_id']=$_GET['id'];
    $_SESSION['event_type']=$_GET['event_type'];
    $link='location:Calendar_page.php#Description_event_Modal';
    header("$link");
}
else if($_GET['button']=="save_id_home")
{
    $_SESSION['event_id']=$_GET['id'];
    $link='location:Home_page.php#Description_event_Modal';
    header("$link");
}
else if($_GET['button']=="add_event")//add event
{
    $user_id=$_SESSION['user_id'];
    $title=$_POST['title'];
    $start_event=$_POST['event_date_start'].' '.$_POST['event_time_start'];
    $end_event=$_POST['event_date_end'].' '.$_POST['event_time_end'];
    $color=$_POST['event_color'];
    $description=$_POST['description'];

    $target_dir="Cours_items/Calendar/";
    $files_name=date("YmdHis").$user_id.'.txt';
    $target_files=$target_dir.$files_name;

    $file=fopen($target_files,"w");
    fwrite($file, $description);
    fclose($file);

    $sql="INSERT INTO calendar (title,start_event,end_event,color,description,user_id) VALUES ('$title','$start_event','$end_event','$color','$target_files','$user_id')";
    $results=mysqli_query($db,$sql);

    $link='location:'.$_SERVER['HTTP_REFERER'];
        header("$link");
}
else
{
    if($_SESSION['user_type']=="admin")
        header("location:Search_courses.php");
    else
        header("location:Home_page.php");
}
?>
