<?php
$mysqli = new mysqli('localhost','root','','id15265491_geets');

$categorias = $mysqli->query("SELECT * FROM habilidades ORDER BY nome ASC");

$response = "<option class='d-none'>Selecione uma categoria...</option>";

foreach($categorias as $categoria){
    $response .= "<option value='".$categoria['id']."'>".ucfirst($categoria['nome'])."</option>";
}

echo $response;
?>