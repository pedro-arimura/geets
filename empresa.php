<?php  

	session_start();

    $mysqli = new mysqli('localhost','id15265491_root','Genérica1234','id15265491_geets');
	// DEFINE O FUSO HORARIO COMO O HORARIO DE BRASILIA
    date_default_timezone_set('America/Sao_Paulo');


    if ($_SESSION['usuarioNiveisAcessoId'] != 1) {
    	session_destroy();
    	header("Location: login.php?error");
    }

	$sqlAplicacaoExp = "SELECT perfil_expert.nome, perfil_expert.especialidade, perfil_expert.thumb, aplicacao_expert.conteudo, aplicacao_expert.id_usuario, aplicacao_expert.id
	FROM aplicacao_expert
	INNER JOIN perfil_expert ON aplicacao_expert.id_usuario = perfil_expert.id_usuario
	WHERE aplicacao_expert.id_ND = '".$_SESSION['usuarioId']."'";
	$queryExp = $mysqli->query($sqlAplicacaoExp);

	$sqlAplicacaoPf = "SELECT perfil_profissional.nome, perfil_profissional.perfil, perfil_profissional.thumb, aplicacao_profissional.descricao, aplicacao_profissional.id_usuario, aplicacao_profissional.id
	FROM aplicacao_profissional
	INNER JOIN perfil_profissional ON aplicacao_profissional.id_usuario = perfil_profissional.id_usuario
	WHERE aplicacao_profissional.id_ND = '".$_SESSION['usuarioId']."'";
	$queryPf = $mysqli->query($sqlAplicacaoPf);

    if (isset($_GET['cancel'])) {
    	
    	$sql2 = "DELETE FROM projetos WHERE id = '".$_GET['id']."' ";
    	$query2 = mysqli_query($mysqli, $sql2);

    	header("Location: empresa?deleted");

    }
	$contar = $queryExp->num_rows + $queryPf->num_rows;
	$resultExp = $mysqli->query("SELECT * FROM aplicacao_expert WHERE id_ND = '".$_SESSION['usuarioId']."'");
	$resultPf = $mysqli->query("SELECT * FROM aplicacao_profissional WHERE id_ND = '".$_SESSION['usuarioId']."'");
	
	$visitas = $mysqli->query("SELECT * FROM visitas WHERE id_ND = '".$_SESSION['usuarioId']."'");
	$visitas = $visitas->num_rows;
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>

	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<meta name="application-name" content="">
	<meta name="description" content="Geets - Painel de <?php   echo $_SESSION['usuarioNome']; ?>">
	<title>Logado como <?php   echo $_SESSION['usuarioNome']; ?></title>

	<link rel="stylesheet" href="dist/css/vendor/bootstrap.min.css">

	<link rel="stylesheet" href="dist/css/vendor/font-awesome/css/font-awesome.min.css">

	<link rel="stylesheet" href="dist/css/main.css">
	
	<link rel="stylesheet" href="dist/css/custom.css">
	
	<link rel="stylesheet" href="css/responsive.css">
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

				<?php  if (isset($_GET['deleted'])){ ?>
					
					<div class="alert alert-danger alert-dismissible fade show col-md-12" role="alert">
					  Você acaba de remover um projeto com sucesso !
					  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    <span aria-hidden="true">&times;</span>
					  </button>
					</div>	

				<?php  } ?>		
				<div class="col-lg-3 col-md-6 col-sm-12">
					<div class="overview">
						<div class="stat-icon icon-color-one">
							<i class="fas fa-chart-pie"></i>
						</div>
						<div class="stat-text">
							<p>Total de Aplicações</p>
							<span><?php echo($resultPf->num_rows + $resultExp->num_rows) ?></span>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 col-sm-12">
					<div class="overview">
						<div class="stat-icon icon-color-two">
							<i class="fas fa-chart-line"></i>
						</div>
						<div class="stat-text">
							<p>Aplicações de Experts</p>
							<span><?php echo($resultExp->num_rows); ?></span>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 col-sm-12">
					<div class="overview">
						<div class="stat-icon icon-color-three">
							<i class="fas fa-chart-bar"></i>
						</div>
						<div class="stat-text">
							<p>Aplicações de Profissionais</p>
							<span><?php echo($resultPf->num_rows); ?></span>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 col-sm-12">
					<div class="overview">
						<div class="stat-icon icon-color-four">
							<i class="fas fa-chart-area"></i>
						</div>
						<div class="stat-text">
							<p>Visitas ao Perfil</p>
							<span><?php echo($visitas); ?></span>
						</div>
					</div>
				</div>
			</div>
		

			<div class="row">
		

				<div class="col-sm-12 col-md-12 col-lg-12" style="margin-bottom: 30px">
					<div class="milestone-wrapper">
						<div class="milestone">
							<h3 style="color: black; padding: 10px;">Aplicações Recebidas</h3>
						</div>
					</div>
					<div class="">
							<?php
							if($contar > 0){
								if($queryExp->num_rows > 0){
									foreach($queryExp as $row){
										if($row['thumb'] == ""){
											echo('
											<article class="freelancers freelancer-list-view mt-2 mb-2" style="border-radius: 0px; margin-bottom: 0px">
												<div class="left-align w-100-lg">
													<div class="feature-image">
														<img src="img/freelancer/freelancer-1.jpg" alt="Imagem de perfil do expert" style="width:100px; height:100px">
													</div>	
													<div class="name-designation">
														<h5 class="name">'.$row['nome'].'</h5>
														<div class="hire-btn btn btn-primary btn-sm" style="font-size: 14px; background-color: #2dced4;">'.$row['especialidade'].'</div>
													</div>
													<div class="contact-details ">
														<p>'.$row['conteudo'].'</p>
													</div>
												</div>
												<div class="right-align pt-lg-2">
													<div class="rate-hire" style=" margin-bottom: 10px;">
														<div class="hire-button">
															<a href="aplicacao-exp-view.php?id='.$row['id'].'" class="hire-btn">Ver aplicação</a>
														</div>
													</div>
												</div>
											</article>');
										}
										else{
											echo('
											<article class="freelancers freelancer-list-view mt-2 mb-2" style="border-radius: 0px; margin-bottom: 0px">
												<div class="left-align w-100-lg">
													<div class="feature-image">
														<img src="thumb/'.$row['thumb'].'" alt="Imagem de perfil do expert" style="width:100px; height:100px">
													</div>	
													<div class="name-designation">
														<h5 class="name">'.$row['nome'].'</h5>
														<div class="hire-btn btn btn-primary btn-sm" style="font-size: 14px; background-color: #2dced4;">'.$row['especialidade'].'</div>
													</div>
													<div class="contact-details">
														<p>'.$row['conteudo'].'</p>
													</div>
												</div>
												<div class="right-align pt-lg-2">
													<div class="rate-hire" style=" margin-bottom: 10px;">
														<div class="hire-button">
                                                            <a href="aplicacao-exp-view.php?id='.$row['id'].'" class="hire-btn">Ver aplicação</a>
														</div>
													</div>
												</div>
											</article>');
										}
									}
								}
								if($queryPf->num_rows > 0){
									foreach($queryPf as $row){
										if($row['thumb'] == ""){
											echo('
											<article class="freelancers freelancer-list-view mt-2 mb-2" style="border-radius: 0px; margin-bottom: 0px">
												<div class="left-align w-100-lg">
													<div class="feature-image">
														<img src="img/freelancer/freelancer-1.jpg" alt="Imagem de perfil do profissional" style="width:100px; height:100px">
													</div>	
													<div class="name-designation">
														<h5 class="name">'.$row['nome'].'</h5>
														<div class="hire-btn btn btn-primary btn-sm" style="font-size: 14px; background-color: #2dced4;">'.$row['perfil'].'</div>
													</div>
													<div class="contact-details">
														<p>'.$row['descricao'].'</p>
													</div>
												</div>
												<div class="right-align pt-lg-2">
													<div class="rate-hire" style=" margin-bottom: 10px;">
														<div class="hire-button">
                                                            <a href="aplicacao-pf-view.php?id='.$row['id'].'" class="hire-btn">Ver aplicação</a>
														</div>
													</div>
												</div>
											</article>');
										}
										else{
											echo('
											<article class="freelancers freelancer-list-view mt-2 mb-2" style="border-radius: 0px; margin-bottom: 0px">
												<div class="left-align w-100-lg">
													<div class="feature-image">
														<img src="thumb/'.$row['thumb'].'" alt="Imagem de perfil do profissional" style="width:100px; height:100px">
													</div>	
													<div class="name-designation">
														<h5 class="name">'.$row['nome'].'</h5>
														<div class="hire-btn btn btn-primary btn-sm" style="font-size: 14px; background-color: #2dced4;">'.$row['perfil'].'</div>
													</div>
													<div class="contact-details">
														<p>'.$row['descricao'].'</p>
													</div>
												</div>
												<div class="right-align pt-lg-2">
													<div class="rate-hire" style=" margin-bottom: 10px;">
														<div class="hire-button">
                                                            <a href="aplicacao-pf-view.php?id='.$row['id'].'" class="hire-btn">Ver aplicação</a>
														</div>
													</div>
												</div>
											</article>');
										}
									}
								}
							}
							else{
								echo('<p class="text-center mt-3">Nenhuma aplicação ainda!</p>');
							}
						?>
					</div>
				</div>
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