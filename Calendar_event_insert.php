<?php include 'Conection.php'; ?>
<?php

	$nameErr="";
	/*if(empty($_POST['title']))
	{
		$nameErr .="Este necesar sa introduceti titlul evenimentului.";
	}
	else
	{*/
		$title='eveniment3';//$_POST['title'];
		$start_event='2021-11-05 00:00:00';//$_POST['start'];
		$end_event='2021-11-05 12:00:00';//$_POST['end'];
		$color='green';

		$sql="INSERT INTO calendar (title,start_event,end_event,color) VALUES ('$title','$start_event','$end_event','$color')";
		$results= mysqli_query($db,$sql);
	      if (!$results)
	      {
	          die('Invalid querry:' .mysqli_error($db));
	      }
	      else
	        echo "Contul a fost creat cu succes.<br>";


		/*
		$statement=$conect->prepare($sql);
		$statement->execute(
			array(':title' => $_POST['title'] );
			array(':start_event' => $_POST['start'] );
			array(':end_event' => $_POST['end'] );
		)*/
	//}
?>