<?php include 'Page_security.php'; ?>
<nav class="navbar navbar-expand-sm navbar-dark bg-dark fixed-top">
  <div class="container-fluid">
    <?php if($_SESSION['user_type']!="admin"){ ?>
      <a class="navbar-brand" href="Home_page.php"> 
        <img src="Images\Sistem\logo.png" alt="Logo" style="width:100px;" class="img-fluid">
      </a>
    <?php }
    else
      echo '<img src="Images\Sistem\logo.png" alt="Logo" style="width:100px;" class="img-fluid me-3">'; ?>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="collapsibleNavbar">

      <!--Left-->
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link" href="Calendar_page.php"><i class="bi bi-calendar-date"></i></i> Calendar</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="Enroll_in_course.php?enroll=8"><i class="bi bi-search"></i> Căutare curs</a>
        </li>
        <?php if($_SESSION['user_type']=="admin"){ ?>
          <li class="nav-item">
            <a class="nav-link" href="Search_users_admin1.php?edit=1"><i class="bi bi-search"></i> Căutare utilizatori</a>
          </li>
        <?php } ?>
      </ul>

      <!--Right-->
      <ul class="navbar-nav justify-content-end">
        <li class="nav-item">
          <div class="btn-group drop-down">
              <?php 
                $user_id=$_SESSION['user_id'];
                $sql="SELECT * FROM user WHERE id LIKE $user_id";
                $results=mysqli_query($db,$sql);
                $row=mysqli_fetch_array($results);
                $profile_image="Images\Profile\\".$row["profile_image"];
              
                if($profile_image=="Images\Profile\\") {
                  echo '<img src="Images\Sistem\user1.png" alt="Avatar Logo" id="profile_photo" style="width:50px; height:50px;" class="nav-item rounded-circle " data-bs-toggle="dropdown">';
                }
                else { 
                  echo '<img src="'.$profile_image.'" alt="Avatar Logo" id="profile_photo" style="width:50px; height:50px;" class="nav-item rounded-circle" data-bs-toggle="dropdown">';
                }
              ?>
            <ul class="dropdown-menu dropdown-menu-end">
              <?php echo '<li><a href="My_account.php?id='.$user_id.'" class="dropdown-item">Contul meu</a></li>'; ?>
              <li><a href="Log_out.php" class="dropdown-item">Log out</a></li>
            </ul>
          </div>
        </li>
      </ul> 
    </div>   
  </div>
</nav>
<div style="margin-top:80px"></div>