<?php include 'Conection.php'; ?>
<?php include 'Page_security.php'; ?>
<?php
session_start();
$_SESSION = array();
unset($_SESSION);
session_destroy();
header("location:Sign_in.php");
exit;
?>