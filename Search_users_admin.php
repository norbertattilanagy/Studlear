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
	</head>
	<body>
		<!--Top bar-->
    	<?php include 'Top_bar.php' ?>

		<?php 
    		if(empty($_SESSION["s"]))
    			$_SESSION['search']="";
    		else if(isset($_SESSION["s"]))
    		{
    			if($_SESSION['s']!=1)
    				$_SESSION['search']="";
    		}
    	?>

		<div class="mx-5">
			<a href="Add_users.php" class="btn btn-primary btn-sm mb-3"><i class="bi bi-person-plus-fill me-2"></i>Crează cont</a>
    		<form action="Search_users_admin1.php?edit=2" method="post">
			    <div class="input-group">
			        <?php 
			        echo '<input type="search" class="form-control" id="search" name="search" placeholder="Search" value="'.$_SESSION['search'].'" onClick="this.select();">'; ?>
			        <button type="submit" class="input-group-text btn-primary"><i class="bi bi-search me-2"></i> Search</button>
			    </div>
			</form>
			<table class="table">
 					<thead>
   					<tr>
				      	<th scope="col">Id</th>
				      	<th scope="col">Nume</th>
				      	<th scope="col">Email</th>
   					</tr>
 					</thead>
 					<tbody>
			    	<?php
			    	if(isset($_GET['page']))
				    	$page=$_GET['page'];
				    else
				    	$page=1;
				    $limit=20;
			    	$start=$limit*($page-1);					
			    	if(!empty($_POST['search']) || !empty($_SESSION['search']))
					{
						if(!empty($_POST['search']))
						{
							$search=$_POST['search'];
						}
						else
							$search=$_SESSION['search'];
						
						$search_email="'".$search."'";
						$search_name="'%".$search."%'";
						$user_id=$_SESSION['user_id'];
						$sql="SELECT * FROM user WHERE (email LIKE $search_email OR name LIKE $search_name) AND id NOT LIKE $user_id";
						$results=mysqli_query($db,$sql);
						$nr_row=mysqli_num_rows($results);
						$sql="SELECT * FROM user WHERE (email LIKE $search_email OR name LIKE $search_name) AND id NOT LIKE $user_id LIMIT $start, $limit";
						$results=mysqli_query($db,$sql);
					}
					else
					{
						$user_id=$_SESSION['user_id'];
						$sql="SELECT * FROM user WHERE id NOT LIKE $user_id";
						$results=mysqli_query($db,$sql);
						$nr_row=mysqli_num_rows($results);
						$sql="SELECT * FROM user WHERE id NOT LIKE $user_id LIMIT $start, $limit";
						$results=mysqli_query($db,$sql);
					}
					
					while ($row=mysqli_fetch_array($results,MYSQLI_ASSOC))
					{
						$user_id=$row["id"];
						
						echo '<tr>';
							echo '<td><a href="My_account.php?id='.$row['id'].'" class="link-dark" style="text-decoration: none;">'.$user_id.'.</a></td>';
							echo '<td><a href="My_account.php?id='.$row['id'].'" class="link-dark" style="text-decoration: none;">'.$row["name"].'</a></td>';
							echo '<td><a href="My_account.php?id='.$row['id'].'" class="link-dark" style="text-decoration: none;">'.$row["email"].'</a></td>';
							echo '<td><a href="Search_users_admin1.php?edit=3&delete_user_id='.$user_id.'" style="color:red;"><i class="bi bi-person-x-fill"></i></a></td>';
						echo '</tr>';
						
					} ?>
				</tbody>
			</table>

			<?php if($nr_row>$limit){ //pagination?>
				<ul class="pagination justify-content-center">
				    <?php
				    if($nr_row%$limit==0)
				    	$max_page=intdiv($nr_row,$limit);
				    else
				    	$max_page=intdiv($nr_row,$limit)+1;

				    if($page>1)
				    	echo '<li class="page-item"><a class="page-link" href="?page='.($page-1).'">Previous</a></li>'; 
				    else
				    	echo '<li class="page-item disabled"><a class="page-link" href="?page='.($page-1).'">Previous</a></li>';

				    if($page==$max_page and $page>4)
				    	echo '<li class="page-item"><a class="page-link" href="?page='.($page-4).'">'.($page-4).'</a></li>';
				    if(($page==$max_page or $page==$max_page-1) and $page>3)
				    	echo '<li class="page-item"><a class="page-link" href="?page='.($page-3).'">'.($page-3).'</a></li>';
				    if($page>2)
				    	echo '<li class="page-item"><a class="page-link" href="?page='.($page-2).'">'.($page-2).'</a></li>';
					if($page>1)
				    	echo '<li class="page-item"><a class="page-link" href="?page='.($page-1).'">'.($page-1).'</a></li>';

				    echo '<li class="page-item active"><a class="page-link" href="?page='.$page.'">'.$page.'</a></li>';
				    if(($page+1)<=$max_page)
				    	echo '<li class="page-item"><a class="page-link" href="?page='.($page+1).'">'.($page+1).'</a></li>';
					if(($page+2)<=$max_page)
				    	echo '<li class="page-item"><a class="page-link" href="?page='.($page+2).'">'.($page+2).'</a></li>';

				    if($page<=2 and ($page+3)<=$max_page)
				    	echo '<li class="page-item"><a class="page-link" href="?page='.($page+3).'">'.($page+3).'</a></li>';
					if($page==1 and ($page+4)<=$max_page)
				    	echo '<li class="page-item"><a class="page-link" href="?page='.($page+4).'">'.($page+4).'</a></li>';
				    if($page<$max_page)
				    	echo '<li class="page-item"><a class="page-link" href="?page='.($page+1).'">Next</a></li>';
				    else
				    	echo '<li class="page-item disabled"><a class="page-link" href="?page='.($page+1).'">Next</a></li>';
				    ?>
				</ul>
			<?php } ?>
		</div>

	  	<!--Modal--Delete-user--->
		<div class="modal fade" id="Delete_user">
		  	<div class="modal-dialog">
		    	<div class="modal-content">

		      		<!-- Modal Header -->
		      		<div class="modal-header">
		        		<h4 class="modal-title">Șterge utilizator</h4>
		        		<button type="button" class="btn-close" data-bs-dismiss="modal" data-bs-target="#Delete_user"></button>
		      		</div>

		      		<?php 
		      		$delete_user_id=$_SESSION['delete_user_id'];
		      		$sql_modal="SELECT * FROM user WHERE id LIKE $delete_user_id";
		      		$results_modal=mysqli_query($db,$sql_modal);
		      		$row_modal=mysqli_fetch_array($results_modal,MYSQLI_ASSOC);
		      		?>

		      		<!-- Modal body -->
		      		<div class="modal-body">
		      			<div class="d-flex justify-content-center">
		      				<?php echo '<p style="text-align: center;">Doriti să ștergeți utilizatorul '.$row_modal['name'].', '.$row_modal['email'].'?</p>'; ?>
		      			</div>
		      			<div class="d-flex justify-content-around">
		      				<div class="d-grid gap-1 col-4">
		      					<a href="Search_users_admin1.php?edit=4" class="btn btn-danger">Da</a>
		      				</div>
		      				<div class="d-grid gap-1 col-4">
		      					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" data-bs-target="#Delete_lesson_group">Nu</button>
		      				</div>
		      			</div>
		      		</div>
		    	</div>
		  	</div>

		</div>
		
	</body>
</html>
<!--Modal-->
<script type="text/javascript">
	$(document).ready(function() {
	    if(window.location.href.indexOf('#Delete_user') != -1) {
	        $('#Delete_user').modal('show');
	        window.history.pushState('', 'Search_users_admin', 'Search_users_admin.php');
	    }
	});
</script>