<?php 

	session_start();

	$mysqli = new mysqli('localhost', 'id15265491_root', 'genérica123' , 'id15265491_geets');
	// DEFINE O FUSO HORARIO COMO O HORARIO DE BRASILIA
    date_default_timezone_set('America/Sao_Paulo');

    /*
    if ($_SESSION['usuarioNiveisAcessoId'] != 1) {
    	session_destroy();
    	header("Location: entrar?error");
    }


    $sql1 = "SELECT * FROM projetos WHERE id_usuarios = '".$_SESSION['usuarioId']."'";
    $query1 = mysqli_query($mysqli, $sql1);
    $contar = mysqli_num_rows($query1);

    if (isset($_GET['cancel'])) {
    	
    	$sql2 = "DELETE FROM projetos WHERE id = '".$_GET['id']."' ";
    	$query2 = mysqli_query($mysqli, $sql2);

    	header("Location: empresa?deleted");

    }
    */

    // Selecionando os dados do perfil da tabela "perfil_usuarios", utilizando como parâmetro o id de acesso da tabela "usuarios" com INNER JOIN.
    $sql1 = "SELECT perfil_usuarios.razao_social, perfil_usuarios.titulo, perfil_usuarios.thumb, usuarios.id
    FROM usuarios 
    INNER JOIN perfil_usuarios
    ON usuarios.id = perfil_usuarios.id_usuarios
    WHERE niveis_acesso_id = 1 LIMIT 30";
    $query = $mysqli->query($sql1);
    $contar = $query->num_rows;
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>

	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<meta name="application-name" content="">
	<meta name="description" content="Geets - Painel de <?php  echo $_SESSION['usuarioNome']; ?>">
	<title>Logado como <?php  echo $_SESSION['usuarioNome']; ?></title>

    <link rel="stylesheet" href="dist/css/vendor/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.1/css/bootstrap.min.css">

	<link rel="stylesheet" href="dist/css/vendor/font-awesome/css/font-awesome.min.css">

    <link rel="stylesheet" href="dist/css/main.css">
    <link rel="stylesheet" href="css/custom.css">
</head>
<body>

	<?php 
		include "header.php";
    ?>
<div class="container row mx-auto position-relative w-100 mt-10">
    <?php 
    // Verifica se existem negócios digitais cadastrados
    if($contar == 0){
        echo("
        <div class='row justify-content-center text-center'>
            <div class='col-10'>
                <p>Ainda não foram cadastrados negócios digitais!</p>
            </div>
        </div>
        ");
    }
    else{
        foreach($query as $row){
            if($row['titulo'] != ""){
                echo('<div class="card p-3 mx-auto mb-5" style="width: 18rem;">
                <img class="card-img-top" src="thumb/'.$row['thumb'].'" alt="Card image cap">
                <div class="card-body text-center">
                    <hr class="horizontal"/>
                    <h5 class="card-title-custom font-weight-bold">'.$row['razao_social'].'</h5>
                    <p id="help" class="text-muted mb-3" style="font-size:1rem;">'.$row['titulo'].' <p>
                    <a href="profile-nd.php?id='.$row['id'].'" class="btn-visitar"> Visitar Perfil </a>
                </div>    
            </div>');
            }
            else{
                echo('<div class="card p-3 mx-auto mb-5" style="width: 18rem;">
                <img class="card-img-top" src="thumb/'.$row['thumb'].'" alt="Card image cap">
                <div class="card-body text-center">
                    <hr class="horizontal"/>
                    <h5 class="card-title-custom font-weight-bold">'.$row['razao_social'].'</h5>
                    <p id="help" class="text-muted mb-3" style="font-size:1rem;">-<p>
                    <a href="profile-nd.php?id='.$row['id'].'" class="btn-visitar"> Visitar Perfil </a>
                </div>    
            </div>');
            }
        }
    }
    ?>
</div>

	<script src="js/vendor/font-awesome.js"></script>
	<script src="js/vendor/popper.min.js"></script>
	<script src="js/vendor/bootstrap.min.js"></script>
	<script src="js/vendor/chart.min.js"></script>
	<script src="js/chart.js"></script>
	<script src="js/bid-milestone.js"></script>
	<script src="js/index.js"></script>
</body>
</html>