<?php
error_reporting( E_ALL & ~E_DEPRECATED & ~E_NOTICE );
$db=mysqli_connect("127.0.0.1","root","");
mysqli_select_db($db,"studlear.ro");
session_start();
require_once 'functions.php';
session_start();
?>