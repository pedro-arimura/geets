<?php 
$mysqli = new mysqli('localhost', 'id15265491_root', 'genérica123' , 'id15265491_geets');
// DEFINE O FUSO HORARIO COMO O HORARIO DE BRASILIA
date_default_timezone_set('America/Sao_Paulo');

$verify = $mysqli->query("SELECT * FROM usuarios WHERE email ='".$_POST['email']."'");
$verify = $verify->num_rows;
if($verify < 1){
    if(isset($_POST['cadastrar'])){
        // Insere o usuário na tabela "usuarios", aqui você vai mudar o primeiro "1" por 2 e o segundo por 3
        $insertUsuario = $mysqli->query("INSERT INTO usuarios VALUES (DEFAULT,'$_POST[nome]','$_POST[email]','$_POST[senha]','2', '2','".date('Y-m-d')."','".date('H:i:s')."')");
        // Pega o id recém inserido
        $getId = $mysqli->query("SELECT * FROM usuarios WHERE email ='". $_POST['email']."'");
        $getId = $getId->fetch_assoc();
        //Seta o diretório "thumb" para receber as imagens
        $diretorio = "thumb/";

        $capa = isset($_FILES['imgPerfil']) ? $_FILES['imgPerfil'] : FALSE;
        $m = md5($getId['id']);
        $destino1 = $diretorio."/"."1".$m.$capa['name'];
        move_uploaded_file($capa['tmp_name'], $destino1);

        $capa = "1".$m.$capa['name'];
        // Insere os dados na tabela de perfil adequada
        $insertPerfil = $mysqli->query("INSERT INTO perfil_expert VALUES(DEFAULT, '$getId[id]', '$_POST[nome]', '$_POST[especialidade]', '$capa', '$_POST[desc]', '$_POST[diferencial]', '$_POST[estagio]', '$_POST[lancamento]', '$_POST[facebook]', '$_POST[instagram]', '$_POST[youtube]')") or die($myqli->error);
    }
}
?>