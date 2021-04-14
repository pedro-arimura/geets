<?php

	session_start();

    $mysqli = new mysqli('localhost','root','','id15265491_geets');
	// DEFINE O FUSO HORARIO COMO O HORARIO DE BRASILIA
    date_default_timezone_set('America/Sao_Paulo');

	// A sessão precisa ser iniciada em cada página diferente
	if (!isset($_SESSION)) session_start();

	$nivel_necessario = array('2','1');

	if (!isset($_SESSION['usuarioNiveisAcessoId'])) {
		// Destrói a sessão por segurança
		session_destroy();

		echo "Nível não definido";

		// Redireciona o visitante de volta pro login
		header("Location: index.php"); exit;
	}
	elseif ( ! in_array( $_SESSION['usuarioNiveisAcessoId'], $nivel_necessario ) )
	{
		session_destroy();
		echo "Sem permissão"; exit;
	}

	if ($_SESSION['usuarioNiveisAcessoId'] == 2) {
    	$retorno = "profissional";
    }elseif ($_SESSION['usuarioNiveisAcessoId'] == 1) {
    	$retorno = "empresa";
    }


	/*
    if (isset($_GET['realizar_filtro'])) {


        $sql1 = "SELECT * FROM usuarios WHERE niveis_acesso_id = 2 AND id IN (SELECT id_usuarios FROM habilidades_usuarios WHERE habilidade IN('".implode("','", $_GET['habilidades'])."') )";
		$query1 = mysqli_query($mysqli, $sql1);



    	
    }else{
		$sql1 = "SELECT * FROM usuarios WHERE niveis_acesso_id = 2 ";
    	$query1 = mysqli_query($mysqli, $sql1);
    }

    $sql4 = "SELECT * FROM habilidades ORDER BY nome ASC";
    $query4 = mysqli_query($mysqli, $sql4);
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
	<meta name="description" content="">
	<title>Usuários | Geets</title>

	<link rel="stylesheet" href="dist/css/vendor/bootstrap.min.css">

	<link rel="stylesheet" href="dist/css/vendor/font-awesome/css/font-awesome.min.css">

	<link rel="stylesheet" href="dist/css/main.css">

	<link rel="stylesheet" href="css/responsive.css">
</head>
<body>
	<?php
		include "header.php";
	?>
	<section id="freelancer-list-view-with-sidebar" style="padding-top: 100px;">
		<div class="container">
			<div class="row">
				<!-- Users area start -->
				<div class="col-lg-8 col-md-8 col-sm-12 order-last-md">
					<div class="buttons-container">
						<ul class="list-grid-btn">
							<li>Usuários: </li>
						</ul>
				
					</div>
						<?php
						// Se não houver uma pesquisa, lista
						if($_GET == [] || $_GET['user'] == "" && !isset($_GET['perfis'])){	
							$sql = "SELECT usuarios.*, habilidades.nome as 'titulo' FROM usuarios 
							INNER JOIN habilidades_usuarios ON usuarios.id = habilidades_usuarios.id_usuario
							INNER JOIN habilidades ON habilidades_usuarios.habilidade = habilidades.id";
    						$usuarios = $mysqli->query($sql);
							foreach($usuarios as $usuario){
								if($usuario['thumb'] == ""){
									switch($usuario['id_tipo_perfil']){
										case 1:
											echo('<div class="freelancers-items">
												<article class="freelancers freelancer-list-view">
													<div class="left-align">
														<div class="feature-image">
															<img src="img/freelancer/freelancer-1.jpg" alt="">
														</div>	
														<div class="name-designation">
															<strong><h5 class="name">'.$usuario['nome'].'</h5></strong>
															<h6 class="text-muted" style="font-size: 1rem;">'.$usuario['titulo'].'</h6>
														</div>
													</div>
													<div class="right-align">
														<div class="rate-hire" style=" margin-bottom: 10px;">
															<div class="hire-button">
																<a href="profile-nd.php?id='.$usuario['id'].'" class="hire-btn">Ver Perfil</a>
															</div>
														</div>
													</div>
												</article>
											</div>');
											break;

										case 2:
											echo('<div class="freelancers-items">
											<article class="freelancers freelancer-list-view">
												<div class="left-align">
													<div class="feature-image">
														<img src="img/freelancer/freelancer-1.jpg" alt="">
													</div>	
													<div class="name-designation">
														<strong><h5 class="name">'.$usuario['nome'].'</h5></strong>
														<h6 class="text-muted" style="font-size: 1rem;">'.$usuario['titulo'].'</h6>
													</div>
												</div>
												<div class="right-align">
													<div class="rate-hire" style=" margin-bottom: 10px;">
														<div class="hire-button">
															<a href="profile-exp.php?id='.$usuario['id'].'" class="hire-btn">Ver Perfil</a>
														</div>
													</div>
												</div>
											</article>
											</div>');
											break;

										case 3:
											echo('<div class="freelancers-items">
											<article class="freelancers freelancer-list-view">
												<div class="left-align">
													<div class="feature-image">
														<img src="img/freelancer/freelancer-1.jpg" alt="">
													</div>	
													<div class="name-designation">
														<strong><h5 class="name">'.$usuario['nome'].'</h5></strong>
														<h6 class="text-muted" style="font-size: 1rem;">'.$usuario['titulo'].'</h6>
													</div>
												</div>
												<div class="right-align">
													<div class="rate-hire" style=" margin-bottom: 10px;">
														<div class="hire-button">
															<a href="profile-pf.php?id='.$usuario['id'].'" class="hire-btn">Ver Perfil</a>
														</div>
													</div>
												</div>
											</article>
											</div>');
											break;
									}									
								}
								else{
									switch($usuario['id_tipo_perfil']){
										case 1:
											echo('<div class="freelancers-items">
												<article class="freelancers freelancer-list-view">
													<div class="left-align">
														<div class="feature-image">
															<img src="thumb/'.$usuario['thumb'].'" style="width: 100px; height: 100px" alt="Imagem de perfil">	
														</div>	
														<div class="name-designation">
															<strong><h5 class="name">'.$usuario['nome'].'</h5></strong>
															<h6 class="text-muted" style="font-size: 1rem;">'.$usuario['titulo'].'</h6>
														</div>
													</div>
													<div class="right-align">
														<div class="rate-hire" style=" margin-bottom: 10px;">
															<div class="hire-button">
																<a href="profile-nd.php?id='.$usuario['id'].'" class="hire-btn">Ver Perfil</a>
															</div>
														</div>
													</div>
												</article>
											</div>');
											break;

										case 2:
											echo('<div class="freelancers-items">
											<article class="freelancers freelancer-list-view">
												<div class="left-align">
													<div class="feature-image">
														<img src="thumb/'.$usuario['thumb'].'" style="width: 100px; height: 100px" alt="Imagem de perfil">			
													</div>	
													<div class="name-designation">
														<strong><h5 class="name">'.$usuario['nome'].'</h5></strong>
														<h6 class="text-muted" style="font-size: 1rem;">'.$usuario['titulo'].'</h6>
													</div>
												</div>
												<div class="right-align">
													<div class="rate-hire" style=" margin-bottom: 10px;">
														<div class="hire-button">
															<a href="profile-exp.php?id='.$usuario['id'].'" class="hire-btn">Ver Perfil</a>
														</div>
													</div>
												</div>
											</article>
											</div>');
											break;

										case 3:
											echo('<div class="freelancers-items">
											<article class="freelancers freelancer-list-view">
												<div class="left-align">
													<div class="feature-image">
														<img src="thumb/'.$usuario['thumb'].'" style="width: 100px; height: 100px" alt="Imagem de perfil">												</div>	
													</div>	
													<div class="name-designation">
														<strong><h5 class="name">'.$usuario['nome'].'</h5></strong>
														<h6 class="text-muted" style="font-size: 1rem;">'.$usuario['titulo'].'</h6>
													</div>
												</div>
												<div class="right-align">
													<div class="rate-hire" style=" margin-bottom: 10px;">
														<div class="hire-button">
															<a href="profile-pf.php?id='.$usuario['id'].'" class="hire-btn">Ver Perfil</a>
														</div>
													</div>
												</div>
											</article>
											</div>');
											break;
									}		
								}
							}
						}
						else{
							// Verifica se existe alguma pesquisa por classes
							if($_GET['user'] == "" && isset($_GET['perfis'])){
							    $perfis = $_GET['perfis'];
							    $perfis = preg_filter('/^/', "'", $perfis);
							    $perfis = preg_filter('/$/', "'", $perfis);
							    $perfis = implode(",", $perfis);
								$pesquisaUsuarios = $mysqli->query("SELECT * FROM usuarios WHERE id_tipo_perfil IN ($perfis)");
								foreach($pesquisaUsuarios as $usuario){
									if($usuario['thumb'] == ""){
										switch($usuario['id_tipo_perfil']){
											case 1:
												echo('<div class="freelancers-items">
													<article class="freelancers freelancer-list-view">
														<div class="left-align">
															<div class="feature-image">
																<img src="img/freelancer/freelancer-1.jpg" alt="">
															</div>	
															<div class="name-designation">
																<strong><h5 class="name">'.$usuario['nome'].'</h5></strong>
																<h6 class="text-muted" style="font-size: 1rem;">'.$usuario['titulo'].'</h6>
															</div>
														</div>
														<div class="right-align">
															<div class="rate-hire" style=" margin-bottom: 10px;">
																<div class="hire-button">
																	<a href="profile-nd.php?id='.$usuario['id'].'" class="hire-btn">Ver Perfil</a>
																</div>
															</div>
														</div>
													</article>
												</div>');
												break;
	
											case 2:
												echo('<div class="freelancers-items">
												<article class="freelancers freelancer-list-view">
													<div class="left-align">
														<div class="feature-image">
															<img src="img/freelancer/freelancer-1.jpg" alt="">
														</div>	
														<div class="name-designation">
															<strong><h5 class="name">'.$usuario['nome'].'</h5></strong>
															<h6 class="text-muted" style="font-size: 1rem;">'.$usuario['titulo'].'</h6>
														</div>
													</div>
													<div class="right-align">
														<div class="rate-hire" style=" margin-bottom: 10px;">
															<div class="hire-button">
																<a href="profile-exp.php?id='.$usuario['id'].'" class="hire-btn">Ver Perfil</a>
															</div>
														</div>
													</div>
												</article>
												</div>');
												break;
	
											case 3:
												echo('<div class="freelancers-items">
												<article class="freelancers freelancer-list-view">
													<div class="left-align">
														<div class="feature-image">
															<img src="img/freelancer/freelancer-1.jpg" alt="">
														</div>	
														<div class="name-designation">
															<strong><h5 class="name">'.$usuario['nome'].'</h5></strong>
															<h6 class="text-muted" style="font-size: 1rem;">'.$usuario['titulo'].'</h6>
														</div>
													</div>
													<div class="right-align">
														<div class="rate-hire" style=" margin-bottom: 10px;">
															<div class="hire-button">
																<a href="profile-pf.php?id='.$usuario['id'].'" class="hire-btn">Ver Perfil</a>
															</div>
														</div>
													</div>
												</article>
												</div>');
												break;
										}									
									}
									else{
										switch($usuario['id_tipo_perfil']){
											case 1:
												echo('<div class="freelancers-items">
													<article class="freelancers freelancer-list-view">
														<div class="left-align">
															<div class="feature-image">
																<img src="thumb/'.$usuario['thumb'].'" width="100px" height="100px" alt="Imagem de perfil">	
															</div>	
															<div class="name-designation">
																<strong><h5 class="name">'.$usuario['nome'].'</h5></strong>
																<h6 class="text-muted" style="font-size: 1rem;">'.$usuario['titulo'].'</h6>
															</div>
														</div>
														<div class="right-align">
															<div class="rate-hire" style=" margin-bottom: 10px;">
																<div class="hire-button">
																	<a href="profile-nd.php?id='.$usuario['id'].'" class="hire-btn">Ver Perfil</a>
																</div>
															</div>
														</div>
													</article>
												</div>');
												break;
	
											case 2:
												echo('<div class="freelancers-items">
												<article class="freelancers freelancer-list-view">
													<div class="left-align">
														<div class="feature-image">
															<img src="thumb/'.$usuario['thumb'].'" width="100px" height="100px" alt="Imagem de perfil">			
														</div>	
														<div class="name-designation">
															<strong><h5 class="name">'.$usuario['nome'].'</h5></strong>
															<h6 class="text-muted" style="font-size: 1rem;">'.$usuario['titulo'].'</h6>
														</div>
													</div>
													<div class="right-align">
														<div class="rate-hire" style=" margin-bottom: 10px;">
															<div class="hire-button">
																<a href="profile-exp.php?id='.$usuario['id'].'" class="hire-btn">Ver Perfil</a>
															</div>
														</div>
													</div>
												</article>
												</div>');
												break;
	
											case 3:
												echo('<div class="freelancers-items">
												<article class="freelancers freelancer-list-view">
													<div class="left-align">
														<div class="feature-image">
															<img src="thumb/'.$usuario['thumb'].'" width="100px" height="100px" alt="Imagem de perfil">												</div>	
														</div>	
														<div class="name-designation">
															<strong><h5 class="name">'.$usuario['nome'].'</h5></strong>
															<h6 class="text-muted" style="font-size: 1rem;">'.$usuario['titulo'].'</h6>
														</div>
													</div>
													<div class="right-align">
														<div class="rate-hire" style=" margin-bottom: 10px;">
															<div class="hire-button">
																<a href="profile-pf.php?id='.$usuario['id'].'" class="hire-btn">Ver Perfil</a>
															</div>
														</div>
													</div>
												</article>
												</div>');
												break;
										}		
									}
								}
							}
							// Verifica se existe uma pesquisa por nome
							elseif($_GET['user'] != "" && !isset($_GET['perfis'])){
								$pesquisaUsuarios = $mysqli->query("SELECT * FROM usuarios WHERE nome LIKE '%".$_GET['user']."%'");
								foreach($pesquisaUsuarios as $usuario){
									if($usuario['thumb'] == ""){
										switch($usuario['id_tipo_perfil']){
											case 1:
												echo('<div class="freelancers-items">
													<article class="freelancers freelancer-list-view">
														<div class="left-align">
															<div class="feature-image">
																<img src="img/freelancer/freelancer-1.jpg" alt="">
															</div>	
															<div class="name-designation">
																<strong><h5 class="name">'.$usuario['nome'].'</h5></strong>
																<h6 class="text-muted" style="font-size: 1rem;">'.$usuario['titulo'].'</h6>
															</div>
														</div>
														<div class="right-align">
															<div class="rate-hire" style=" margin-bottom: 10px;">
																<div class="hire-button">
																	<a href="profile-nd.php?id='.$usuario['id'].'" class="hire-btn">Ver Perfil</a>
																</div>
															</div>
														</div>
													</article>
												</div>');
												break;
	
											case 2:
												echo('<div class="freelancers-items">
												<article class="freelancers freelancer-list-view">
													<div class="left-align">
														<div class="feature-image">
															<img src="img/freelancer/freelancer-1.jpg" alt="">
														</div>	
														<div class="name-designation">
															<strong><h5 class="name">'.$usuario['nome'].'</h5></strong>
															<h6 class="text-muted" style="font-size: 1rem;">'.$usuario['titulo'].'</h6>
														</div>
													</div>
													<div class="right-align">
														<div class="rate-hire" style=" margin-bottom: 10px;">
															<div class="hire-button">
																<a href="profile-exp.php?id='.$usuario['id'].'" class="hire-btn">Ver Perfil</a>
															</div>
														</div>
													</div>
												</article>
												</div>');
												break;
	
											case 3:
												echo('<div class="freelancers-items">
												<article class="freelancers freelancer-list-view">
													<div class="left-align">
														<div class="feature-image">
															<img src="img/freelancer/freelancer-1.jpg" alt="">
														</div>	
														<div class="name-designation">
															<strong><h5 class="name">'.$usuario['nome'].'</h5></strong>
															<h6 class="text-muted" style="font-size: 1rem;">'.$usuario['titulo'].'</h6>
														</div>
													</div>
													<div class="right-align">
														<div class="rate-hire" style=" margin-bottom: 10px;">
															<div class="hire-button">
																<a href="profile-pf.php?id='.$usuario['id'].'" class="hire-btn">Ver Perfil</a>
															</div>
														</div>
													</div>
												</article>
												</div>');
												break;
										}									
									}
									else{
										switch($usuario['id_tipo_perfil']){
											case 1:
												echo('<div class="freelancers-items">
													<article class="freelancers freelancer-list-view">
														<div class="left-align">
															<div class="feature-image">
																<img src="thumb/'.$usuario['thumb'].'" width="100px" height="100px" alt="Imagem de perfil">	
															</div>	
															<div class="name-designation">
																<strong><h5 class="name">'.$usuario['nome'].'</h5></strong>
																<h6 class="text-muted" style="font-size: 1rem;">'.$usuario['titulo'].'</h6>
															</div>
														</div>
														<div class="right-align">
															<div class="rate-hire" style=" margin-bottom: 10px;">
																<div class="hire-button">
																	<a href="profile-nd.php?id='.$usuario['id'].'" class="hire-btn">Ver Perfil</a>
																</div>
															</div>
														</div>
													</article>
												</div>');
												break;
	
											case 2:
												echo('<div class="freelancers-items">
												<article class="freelancers freelancer-list-view">
													<div class="left-align">
														<div class="feature-image">
															<img src="thumb/'.$usuario['thumb'].'" width="100px" height="100px" alt="Imagem de perfil">			
														</div>	
														<div class="name-designation">
															<strong><h5 class="name">'.$usuario['nome'].'</h5></strong>
															<h6 class="text-muted" style="font-size: 1rem;">'.$usuario['titulo'].'</h6>
														</div>
													</div>
													<div class="right-align">
														<div class="rate-hire" style=" margin-bottom: 10px;">
															<div class="hire-button">
																<a href="profile-exp.php?id='.$usuario['id'].'" class="hire-btn">Ver Perfil</a>
															</div>
														</div>
													</div>
												</article>
												</div>');
												break;
	
											case 3:
												echo('<div class="freelancers-items">
												<article class="freelancers freelancer-list-view">
													<div class="left-align">
														<div class="feature-image">
															<img src="thumb/'.$usuario['thumb'].'" width="100px" height="100px" alt="Imagem de perfil">												</div>	
														</div>	
														<div class="name-designation">
															<strong><h5 class="name">'.$usuario['nome'].'</h5></strong>
															<h6 class="text-muted" style="font-size: 1rem;">'.$usuario['titulo'].'</h6>
														</div>
													</div>
													<div class="right-align">
														<div class="rate-hire" style=" margin-bottom: 10px;">
															<div class="hire-button">
																<a href="profile-pf.php?id='.$usuario['id'].'" class="hire-btn">Ver Perfil</a>
															</div>
														</div>
													</div>
												</article>
												</div>');
												break;
										}		
									}
								}
							}
							// Faz uma pesquisa com categorias e nome
							else{
								$pesquisaUsuarios = $mysqli->query("SELECT * FROM usuarios WHERE nome LIKE '%".$_GET['user']."%' AND id_tipo_perfil IN ('".implode(',',$_GET['perfis'])."')");
								foreach($pesquisaUsuarios as $usuario){
									if($usuario['thumb'] == ""){
										switch($usuario['id_tipo_perfil']){
											case 1:
												echo('<div class="freelancers-items">
													<article class="freelancers freelancer-list-view">
														<div class="left-align">
															<div class="feature-image">
																<img src="img/freelancer/freelancer-1.jpg" alt="">
															</div>	
															<div class="name-designation">
																<strong><h5 class="name">'.$usuario['nome'].'</h5></strong>
																<h6 class="text-muted" style="font-size: 1rem;">'.$usuario['titulo'].'</h6>
															</div>
														</div>
														<div class="right-align">
															<div class="rate-hire" style=" margin-bottom: 10px;">
																<div class="hire-button">
																	<a href="profile-nd.php?id='.$usuario['id'].'" class="hire-btn">Ver Perfil</a>
																</div>
															</div>
														</div>
													</article>
												</div>');
												break;
	
											case 2:
												echo('<div class="freelancers-items">
												<article class="freelancers freelancer-list-view">
													<div class="left-align">
														<div class="feature-image">
															<img src="img/freelancer/freelancer-1.jpg" alt="">
														</div>	
														<div class="name-designation">
															<strong><h5 class="name">'.$usuario['nome'].'</h5></strong>
															<h6 class="text-muted" style="font-size: 1rem;">'.$usuario['titulo'].'</h6>
														</div>
													</div>
													<div class="right-align">
														<div class="rate-hire" style=" margin-bottom: 10px;">
															<div class="hire-button">
																<a href="profile-exp.php?id='.$usuario['id'].'" class="hire-btn">Ver Perfil</a>
															</div>
														</div>
													</div>
												</article>
												</div>');
												break;
	
											case 3:
												echo('<div class="freelancers-items">
												<article class="freelancers freelancer-list-view">
													<div class="left-align">
														<div class="feature-image">
															<img src="img/freelancer/freelancer-1.jpg" alt="">
														</div>	
														<div class="name-designation">
															<strong><h5 class="name">'.$usuario['nome'].'</h5></strong>
															<h6 class="text-muted" style="font-size: 1rem;">'.$usuario['titulo'].'</h6>
														</div>
													</div>
													<div class="right-align">
														<div class="rate-hire" style=" margin-bottom: 10px;">
															<div class="hire-button">
																<a href="profile-pf.php?id='.$usuario['id'].'" class="hire-btn">Ver Perfil</a>
															</div>
														</div>
													</div>
												</article>
												</div>');
												break;
										}									
									}
									else{
										switch($usuario['id_tipo_perfil']){
											case 1:
												echo('<div class="freelancers-items">
													<article class="freelancers freelancer-list-view">
														<div class="left-align">
															<div class="feature-image">
																<img src="thumb/'.$usuario['thumb'].'" width="100px" height="100px" alt="Imagem de perfil">	
															</div>	
															<div class="name-designation">
																<strong><h5 class="name">'.$usuario['nome'].'</h5></strong>
																<h6 class="text-muted" style="font-size: 1rem;">'.$usuario['titulo'].'</h6>
															</div>
														</div>
														<div class="right-align">
															<div class="rate-hire" style=" margin-bottom: 10px;">
																<div class="hire-button">
																	<a href="profile-nd.php?id='.$usuario['id'].'" class="hire-btn">Ver Perfil</a>
																</div>
															</div>
														</div>
													</article>
												</div>');
												break;
	
											case 2:
												echo('<div class="freelancers-items">
												<article class="freelancers freelancer-list-view">
													<div class="left-align">
														<div class="feature-image">
															<img src="thumb/'.$usuario['thumb'].'" width="100px" height="100px" alt="Imagem de perfil">			
														</div>	
														<div class="name-designation">
															<strong><h5 class="name">'.$usuario['nome'].'</h5></strong>
															<h6 class="text-muted" style="font-size: 1rem;">'.$usuario['titulo'].'</h6>
														</div>
													</div>
													<div class="right-align">
														<div class="rate-hire" style=" margin-bottom: 10px;">
															<div class="hire-button">
																<a href="profile-exp.php?id='.$usuario['id'].'" class="hire-btn">Ver Perfil</a>
															</div>
														</div>
													</div>
												</article>
												</div>');
												break;
	
											case 3:
												echo('<div class="freelancers-items">
												<article class="freelancers freelancer-list-view">
													<div class="left-align">
														<div class="feature-image">
															<img src="thumb/'.$usuario['thumb'].'" width="100px" height="100px" alt="Imagem de perfil">												</div>	
														</div>	
														<div class="name-designation">
															<strong><h5 class="name">'.$usuario['nome'].'</h5></strong>
															<h6 class="text-muted" style="font-size: 1rem;">'.$usuario['titulo'].'</h6>
														</div>
													</div>
													<div class="right-align">
														<div class="rate-hire" style=" margin-bottom: 10px;">
															<div class="hire-button">
																<a href="profile-pf.php?id='.$usuario['id'].'" class="hire-btn">Ver Perfil</a>
															</div>
														</div>
													</div>
												</article>
												</div>');
												break;
										}		
									}
								}
							}
						}
						?>

					<!--
					<div class="pagination-area">
						<ul>
							<li>
								<a href="#"><i class="fas fa-chevron-left"></i></a>
							</li>
							<li>
								<a href="#">1</a>
							</li>
							<li>
								<a href="#">2</a>
							</li>
							<li>
								<a href="#">3</a>
							</li>
							<li>
								<a href="#">4</a>
							</li>
							<li>
								<a href="#">5</a>
							</li>
							<li>
								<a href="#"><i class="fas fa-chevron-right"></i></a>
							</li>
						</ul>
					</div>
					-->

				</div>
				<!-- Users area end -->

				<!-- Sidebar start -->
				<div class="col-lg-4 col-md-4 col-sm-12 order-first-md">
					<div class="sidebar-nav">
						<ul class="nav nav-tabs">
						    <li class=""><p class="m-2 ml-3 text-light">Filtros</p></li>
						</ul>
					</div>
					<div class="sidebar-tab-content">
						<div class="tab-content">
						    <div id="all" class="tab-pane in active">
								<form method="GET">
									<h6 class="mb-2">Pesquisar por nome:</h6>
									<input class="form-control mb-2 w-75" style="display: inline-block" name="user" type="text" placeholder="Pesquisar usuário..." aria-label="Search"><button type="submit" class="form-control w-25" style="display: inline-block"><i class="fas fa-search"></i></button>
									<p class="mt-3 mb-2">Tipos de usuário:</p>
									<li id="perfis_usuario">
										<?php 
										// Pega as categorias para as listar como checkbox
										$categorias = $mysqli->query("SELECT * FROM habilidades");

										// Por cada categoria, aparece um checkbox
										foreach($categorias as $categoria){
											if(isset($_GET['perfis']) && in_array($categoria['id'], $_GET['perfis'])){
												echo('<ul><input type="checkbox" name="perfis[]" id="'.$categoria['nome'].'" value="'.$categoria['id'].'" class="mr-2" checked><label for="'.$categoria['nome'].'">'.ucfirst($categoria['nome']).'</label></ul>');
											}
											else{
												echo('<ul><input type="checkbox" name="perfis[]" id="'.$categoria['nome'].'" value="'.$categoria['id'].'" class="mr-2"><label for="'.$categoria['nome'].'">'.ucfirst($categoria['nome']).'</label></ul>');
											}
										}
										?>
									</li>
									<button type="submit" class=" mx-auto w-100 mb-4 mt-3">Aplicar filtro</button>
								</form>
						    </div>
					  	</div>
				  	</div>
				</div>
				<!-- Sidebar end -->
			</div>
		</div>
	</section>




	<script src="js/vendor/font-awesome.js"></script>
	<script src="js/vendor/popper.min.js"></script>
	<script src="js/vendor/bootstrap.min.js"></script>
	<script src="js/index.js"></script>
</body>
</html>