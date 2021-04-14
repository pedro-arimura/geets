<?php
$mysqli = new mysqli('localhost','root','','id15265491_geets');

print_r($_POST);

$id = $_POST['categoria'];

$response = "<option class='d-none'>Selecione uma área ou nicho...</option>";

$subcategorias = $mysqli->query("SELECT * FROM subhabilidades WHERE id_habilidades = $id");

foreach($subcategorias as $subcategoria){
    $response .= "<option value='".$subcategoria['id']."'>".$subcategoria['nome']."</option>";
}
echo $response;
?>