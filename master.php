<?php 

	session_start();

    $mysqli = new mysqli('localhost','root','','id15265491_geets');
	// DEFINE O FUSO HORARIO COMO O HORARIO DE BRASILIA
    date_default_timezone_set('America/Sao_Paulo');


    if ($_SESSION['usuarioNiveisAcessoId'] != 3) {
    	session_destroy();
    	header("Location: login.error?error");
    }


    $sql1 = "SELECT * FROM usuarios ORDER BY id DESC LIMIT 10";
    $query1 = mysqli_query($mysqli, $sql1);
    $contar = mysqli_num_rows($query1);


    // APLICAÇÕES
	$countAplExp = 0;
	$countAplPf = 0;
	$totalApl = $countAplExp + $countAplPf;

    // EMPRESAS
    $sql4 = "SELECT COUNT(id) AS total FROM usuarios WHERE niveis_acesso_id = 1";
    $query4 = mysqli_query($mysqli, $sql4);
    $dados4 = mysqli_fetch_assoc($query4);

    // PROFISSIONAIS
    $sql5 = "SELECT COUNT(id) AS total FROM usuarios WHERE niveis_acesso_id = 2";
    $query5 = mysqli_query($mysqli, $sql5);
    $dados5 = mysqli_fetch_assoc($query5);

	// PROFISSIONAIS
	/*
    $sql6 = "SELECT COUNT(id) AS total FROM especialista_usuarios WHERE status = 0";
    $query6 = mysqli_query($mysqli, $sql6);
    $dados6 = mysqli_fetch_assoc($query6);
	*/
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

	<link rel="stylesheet" href="dist/css/vendor/font-awesome/css/font-awesome.min.css">

	<link rel="stylesheet" href="dist/css/main.css">
</head>
<body>

	<?php 
		include "header.php";
	?>


	<section id="dashboard-map">
		<div class="container">
			<div class="row">
				
				<div class="col-lg-12 col-md-12 col-sm-12 form-group" style="padding-bottom: 20px;">
					<h1>Olá, <b><?php  echo $_SESSION['usuarioNome']; ?></b></h1>
				</div>				

				<div class="col-lg-4 col-md-4 col-sm-12">
					<div class="overview">
						<div class="stat-icon icon-color-one">
							<i class="fas fa-chart-pie"></i>
						</div>
						<div class="stat-text">
							<p>Aplicações enviadas</p>
							<span><?php  echo $totalApl; ?></span>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-12">
					<div class="overview">
						<div class="stat-icon icon-color-two">
							<i class="fas fa-chart-line"></i>
						</div>
						<div class="stat-text">
							<p>Empresas</p>
							<span><?php  echo $dados4['total']; ?></span>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-12">
					<div class="overview">
						<div class="stat-icon icon-color-three">
							<i class="fas fa-chart-bar"></i>
						</div>
						<div class="stat-text">
							<p>Profissionais</p>
							<span><?php  echo $dados5['total']; ?></span>
						</div>
					</div>
				</div>
				<!--
				<div class="col-lg-6 col-md-6 col-sm-12">
					<div class="overview">
						<div class="stat-icon icon-color-four">
							<i class="fas fa-chart-area"></i>
						</div>
						<div class="stat-text">
							<p>Financeiro</p>
							<span>0</span>
						</div>
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-12">
					<div class="overview">
						<div class="stat-icon icon-color-four">
							<i class="fas fa-chart-area"></i>
						</div>
						<div class="stat-text">
							<p>Análise de Especialistas</p>
							<span></span>
						</div>
					</div>
				</div>
				-->
			</div>
		

		</div>
	</section>



	<script src="js/vendor/font-awesome.js"></script>
	<script src="js/vendor/popper.min.js"></script>
	<script src="js/vendor/bootstrap.min.js"></script>
	<script src="js/vendor/chart.min.js"></script>
	<script src="js/chart.js"></script>
	<script src="js/bid-milestone.js"></script>
	<script src="js/index.js"></script>
</body>
</html>