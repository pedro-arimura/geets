<?php

session_start();
include "db.php";



$sql1 = "SELECT * FROM propostas";
$query1 = mysqli_query($mysqli, $sql1);
$contar_query1 = mysqli_num_rows($query1);


$mysqli = null;

?>



