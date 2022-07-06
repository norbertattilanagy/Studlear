<?php include 'Connection.php'; ?>
<?php include 'Page_security.php'; ?>
<?php
if(empty($_SESSION['error_message']))//security
{
	if($_SESSION['user_type']=="admin")
		header("location:Search_courses.php");
	else
	{
		header("location:Home_page.php");
		exit();
	}
}
?>
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
	    <title>Studlearn</title>
	</head>
	<body>
		<!--Top bar-->
    	<?php include 'Top_bar.php' ?>

    	<nav class="ms-4" aria-label="breadcrumb">
  			<ol class="breadcrumb">
  		  		<?php
  		  		if($_SESSION['user_type']=="admin")
  					echo '<li class="breadcrumb-item"><a href="Search_courses.php" style="text-decoration: none;">Căutare curs</a></li>';
  				else
  		  			echo '<li class="breadcrumb-item"><a href="Home_page.php" style="text-decoration: none;">Acasă</a></li>';
  		  		?>
    			<li class="breadcrumb-item active" aria-current="page">Error</li>
  			</ol>
		</nav>
		
		<div class="row">
			<?php if($_SESSION['user_type']!="admin"){ ?>
	    		<!--Courses group-->
			    <div class="col-md-3">
			    	<?php include 'Courses_group.php' ?>
			    </div>
			    <div class="col-md-9">
			    	<div class="alert alert-danger mx-4 mt-5" role="alert">
          				<h2 style="text-align: center;"><i class="bi bi-exclamation-triangle-fill me-4"></i><?php echo $_SESSION['error_message']; ?><i class="bi bi-exclamation-triangle-fill ms-4"></i></h2>
        			</div>
			    </div>
			<?php } ?> 
		
		</div>
	</body>
</html>