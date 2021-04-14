<?php
$mysqli = new mysqli('localhost', 'id15265491_root', 'Genérica1234' , 'id15265491_geets');
$sql = "SELECT usuarios.id, perfil_negocio_digital.razao_social, perfil_negocio_digital.modelo_negocio, perfil_negocio_digital.thumb
        FROM usuarios
        INNER JOIN perfil_negocio_digital ON usuarios.id = perfil_negocio_digital.id_usuario
        WHERE usuarios.id_tipo_perfil = 1";
$teste = $mysqli->query($sql);

foreach ($teste as $key) {
    echo($key['id'] . "<br>");
    echo($key['razao_social'] . "<br>");
    echo($key['modelo_negocio'] . "<br>");
    echo($key['thumb'] . "<br>");
}
?>