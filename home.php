<?php 
session_start();
$mysqli = new mysqli('localhost','root','','id15265491_geets');
$sql = "SELECT usuarios.id, usuarios.nome, usuarios.id_tipo_perfil, usuarios.thumb, habilidades.nome as 'titulo_user', publicacao.busca, publicacao.titulo, publicacao.data_publicacao, publicacao.descricao
        FROM usuarios
		INNER JOIN publicacao ON usuarios.id = publicacao.id_usuario
		INNER JOIN habilidades_usuarios ON habilidades_usuarios.id_usuario = usuarios.id
		INNER JOIN habilidades ON habilidades_usuarios.habilidade = habilidades.id
		ORDER BY publicacao.data_publicacao DESC";
$publicacoes = $mysqli->query($sql) or die($mysqli->error);
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
	<title>Home | Geets</title>

	<link rel="stylesheet" href="dist/css/vendor/bootstrap.min.css">

	<link rel="stylesheet" href="dist/css/vendor/font-awesome/css/font-awesome.min.css">

	<link rel="stylesheet" href="dist/css/main.css">
	
	<link rel="stylesheet" href="css/responsive.css">
</head>
<body>
	<?php  
		include "header.php";
	?>
	<section id="freelancer-list-view-with-sidebar">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-md-10 col-sm-18 w-100">
					<div class="buttons-container">
						
						<ul class="list-grid-btn">
							<li>Publicações de usuários: </li>
						</ul>
					</div>

					<div class="row">
					<?php 
					if($publicacoes->num_rows < 1){
						echo('
							<div class="col-12 text-center">
								<p style="font-size:1rem;">Não há nenhuma publicação!</p>
							</div>
						');
					}
					else{
						foreach($publicacoes as $row){
							if($row['busca'] == "servico"){
								if($row['thumb'] != ""){
									switch($row['id_tipo_perfil']){
										case 1:
											echo('
												<div class="col-lg-4 col-md-4 col-sm-4">
													<article class="freelancers freelancer-grid-view">
														<div class="w-75 position-absolute float-right">
															<p class="float-right tipo-pub">Serviço</p>
														</div>
														<div class="feature-image">
																<img src="thumb/'.$row['thumb'].'" alt="" style="width:100px; height:100px">

															<div class="name-designation" style="min-height: 150px">
																<h5 class="name">'.$row['nome'].'</h5>
																<p id="help" class="text-muted mb-3" style="font-size:1rem;">'.$row['titulo_user'].'</p>
																<p class="text-left" style="white-space: pre-line">'.$row['titulo'].'</p>
																<p class="text-left d-none descricao mt-2" style="white-space: pre-line">'.$row['descricao'].'</p>
																<p class="expandir text-right float-right mt-2" style="cursor:pointer;" onclick="expand(this);">Ler mais</p>
															</div>
														</div>
														<div class="rate-hire col-md-12 mt-2 mb-n5">
															<div class="hire-button col-md-12">
																<a href="profile-nd.php?id='.$row['id'].'" class="hire-btn col-md-12 text-center">Visitar perfil</a>
															</div>
														</div>
													</article>
												</div>');
											break;
										case 2:
											echo('
											<div class="col-lg-4 col-md-4 col-sm-4">
												<article class="freelancers freelancer-grid-view">
													<div class="w-75 position-absolute float-right">
														<p class="float-right tipo-pub">Serviço</p>
													</div>
													<div class="feature-image">
															<img src="thumb/'.$row['thumb'].'" alt="" style="width:100px; height:100px">

														<div class="name-designation" style="min-height: 150px">
															<h5 class="name">'.$row['nome'].'</h5>
															<p id="help" class="text-muted mb-3" style="font-size:1rem;">'.$row['titulo_user'].'</p>
															<p class="text-left" style="white-space: pre-line">'.$row['titulo'].'</p>
															<p class="text-left d-none descricao mt-2" style="white-space: pre-line">'.$row['descricao'].'</p>
															<p class="expandir text-right mt-2" style="cursor:pointer;" onclick="expand(this);">Ler mais</p>
														</div>
													</div>
													<div class="rate-hire col-md-12 mt-2 mb-n5">
														<div class="hire-button col-md-12">
															<a href="profile-exp.php?id='.$row['id'].'" class="hire-btn col-md-12 text-center">Visitar perfil</a>
														</div>
													</div>
												</article>
											</div>');
											break;
										case 3:
											echo('
											<div class="col-lg-4 col-md-4 col-sm-4">
												<article class="freelancers freelancer-grid-view">
													<div class="w-75 position-absolute float-right">
														<p class="float-right tipo-pub">Serviço</p>
													</div>
													<div class="feature-image">
															<img src="thumb/'.$row['thumb'].'" alt="" style="width:100px; height:100px">

														<div class="name-designation" style="min-height: 150px">
															<h5 class="name">'.$row['nome'].'</h5>
															<p id="help" class="text-muted mb-3" style="font-size:1rem;">'.$row['titulo_user'].'</p>
															<p class="text-left" style="white-space: pre-line">'.$row['titulo'].'</p>
															<p class="text-left d-none descricao mt-2" style="white-space: pre-line">'.$row['descricao'].'</p>
															<p class="expandir text-right mt-2" style="cursor:pointer;" onclick="expand(this);">Ler mais</p>
														</div>
													</div>
													<div class="rate-hire col-md-12 mt-2 mb-n5">
														<div class="hire-button col-md-12">
															<a href="profile-pf.php?id='.$row['id'].'" class="hire-btn col-md-12 text-center">Visitar perfil</a>
														</div>
													</div>
												</article>
											</div>');
											break;
									}
								}
								else{
									switch($row['id_tipo_perfil']){
										case 1:
											echo('
												<div class="col-lg-4 col-md-4 col-sm-4">
													<article class="freelancers freelancer-grid-view">
														<div class="w-75 position-absolute float-right">
															<p class="float-right tipo-pub">Serviço</p>
														</div>
														<div class="feature-image">
																<img src="img/freelancer/freelancer-1.jpg" alt="" style="width:100px; height:100px">

															<div class="name-designation" style="min-height: 150px">
																<h5 class="name">'.$row['nome'].'</h5>
																<p id="help" class="text-muted mb-3" style="font-size:1rem;">'.$row['titulo_user'].'</p>
																<p class="text-left" style="white-space: pre-line">'.$row['titulo'].'</p>
																<p class="text-left d-none descricao mt-2" style="white-space: pre-line">'.$row['descricao'].'</p>
																<p class="expandir text-right mt-2" style="cursor:pointer;" onclick="expand(this);">Ler mais</p>
															</div>
														</div>
														<div class="rate-hire col-md-12 mt-2 mb-n5">
															<div class="hire-button col-md-12">
																<a href="profile-nd.php?id='.$row['id'].'" class="hire-btn col-md-12 text-center">Visitar perfil</a>
															</div>
														</div>
													</article>
												</div>');
											break;
										case 2:
											echo('
											<div class="col-lg-4 col-md-4 col-sm-4">
												<article class="freelancers freelancer-grid-view">
													<div class="w-75 position-absolute float-right">
														<p class="float-right tipo-pub">Serviço</p>
													</div>
													<div class="feature-image">
															<img src="img/freelancer/freelancer-1.jpg" alt="" style="width:100px; height:100px">

														<div class="name-designation" style="min-height: 150px">
															<h5 class="name">'.$row['nome'].'</h5>
															<p id="help" class="text-muted mb-3" style="font-size:1rem;">'.$row['titulo_user'].'</p>
															<p class="text-left" style="white-space: pre-line">'.$row['titulo'].'</p>
															<p class="text-left d-none descricao mt-2" style="white-space: pre-line">'.$row['descricao'].'</p>
															<p class="expandir text-right mt-2" style="cursor:pointer;" onclick="expand(this);">Ler mais</p>
														</div>
													</div>
													<div class="rate-hire col-md-12 mt-2 mb-n5">
														<div class="hire-button col-md-12">
															<a href="profile-exp.php?id='.$row['id'].'" class="hire-btn col-md-12 text-center">Visitar perfil</a>
														</div>
													</div>
												</article>
											</div>');
											break;	
										case 3:
											echo('
											<div class="col-lg-4 col-md-4 col-sm-4">
												<article class="freelancers freelancer-grid-view">
													<div class="w-75 position-absolute float-right">
														<p class="float-right tipo-pub">Serviço</p>
													</div>
													<div class="feature-image">
															<img src="img/freelancer/freelancer-1.jpg" alt="" style="width:100px; height:100px">

														<div class="name-designation" style="min-height: 150px">
															<h5 class="name">'.$row['nome'].'</h5>
															<p id="help" class="text-muted mb-3" style="font-size:1rem;">'.$row['titulo_user'].'</p>
															<p class="text-left" style="white-space: pre-line">'.$row['titulo'].'</p>
															<p class="text-left d-none descricao mt-2" style="white-space: pre-line">'.$row['descricao'].'</p>
															<p class="expandir text-right mt-2" style="cursor:pointer;" onclick="expand(this);">Ler mais</p>
														</div>
													</div>
													<div class="rate-hire col-md-12 mt-2 mb-n5">
														<div class="hire-button col-md-12">
															<a href="profile-pf.php?id='.$row['id'].'" class="hire-btn col-md-12 text-center">Visitar perfil</a>
														</div>
													</div>
												</article>
											</div>');
											break;
									}
								}
							}
							else{
								if($row['thumb'] != ""){
									switch($row['id_tipo_perfil']){
										case 1:
											echo('
												<div class="col-lg-4 col-md-4 col-sm-4">
													<article class="freelancers freelancer-grid-view">
														<div class="w-75 position-absolute float-right">
															<p class="float-right tipo-pub2">Parceria</p>
														</div>
														<div class="feature-image">
																<img src="thumb/'.$row['thumb'].'" alt="" style="width:100px; height:100px">

															<div class="name-designation" style="min-height: 150px">
																<h5 class="name">'.$row['nome'].'</h5>
																<p id="help" class="text-muted mb-3" style="font-size:1rem;">'.$row['titulo_user'].'</p>
																<p class="text-left" style="white-space: pre-line;">'.$row['titulo'].'</p>
																<p class="text-left d-none descricao mt-2" style="white-space: pre-line">'.$row['descricao'].'</p>
																<p class="expandir text-right mt-2" style="cursor:pointer;" onclick="expand(this);">Ler mais</p>
															</div>
														</div>
														<div class="rate-hire col-md-12 mt-2 mb-n5">
															<div class="hire-button col-md-12">
																<a href="profile-nd.php?id='.$row['id'].'" class="hire-btn col-md-12 text-center">Visitar perfil</a>
															</div>
														</div>
													</article>
												</div>');
											break;
										case 2:
											echo('
											<div class="col-lg-4 col-md-4 col-sm-4">
												<article class="freelancers freelancer-grid-view">
													<div class="w-75 position-absolute float-right">
														<p class="float-right tipo-pub2">Parceria</p>
													</div>
													<div class="feature-image">
															<img src="thumb/'.$row['thumb'].'" alt="" style="width:100px; height:100px">

														<div class="name-designation" style="min-height: 150px">
															<h5 class="name">'.$row['nome'].'</h5>
															<p id="help" class="text-muted mb-3" style="font-size:1rem;">'.$row['titulo_user'].'</p>
															<p class="text-left" style="white-space: pre-line">'.$row['titulo'].'</p>
															<p class="text-left d-none descricao mt-2" style="white-space: pre-line">'.$row['descricao'].'</p>
															<p class="expandir text-right mt-2" style="cursor:pointer;" onclick="expand(this);">Ler mais</p>
														</div>
													</div>
													<div class="rate-hire col-md-12 mt-2 mb-n5">
														<div class="hire-button col-md-12">
															<a href="profile-exp.php?id='.$row['id'].'" class="hire-btn col-md-12 text-center">Visitar perfil</a>
														</div>
													</div>
												</article>
											</div>');
											break;
										case 3:
											echo('
											<div class="col-lg-4 col-md-4 col-sm-4">
												<article class="freelancers freelancer-grid-view">
													<div class="w-75 position-absolute float-right">
														<p class="float-right tipo-pub2">Parceria</p>
													</div>
													<div class="feature-image">
															<img src="thumb/'.$row['thumb'].'" alt="" style="width:100px; height:100px">

														<div class="name-designation" style="min-height: 150px">
															<h5 class="name">'.$row['nome'].'</h5>
															<p id="help" class="text-muted mb-3" style="font-size:1rem;">'.$row['titulo_user'].'</p>
															<p class="text-left" style="white-space: pre-line">'.$row['titulo'].'</p>
															<p class="text-left d-none descricao mt-2" style="white-space: pre-line">'.$row['descricao'].'</p>
															<p class="expandir text-right mt-2" style="cursor:pointer;" onclick="expand(this);">Ler mais</p>
														</div>
													</div>
													<div class="rate-hire col-md-12 mt-2 mb-n5">
														<div class="hire-button col-md-12">
															<a href="profile-pf.php?id='.$row['id'].'" class="hire-btn col-md-12 text-center">Visitar perfil</a>
														</div>
													</div>
												</article>
											</div>');
											break;
									}
								}
								else{
									switch($row['id_tipo_perfil']){
										case 1:
											echo('
												<div class="col-lg-4 col-md-4 col-sm-4">
													<article class="freelancers freelancer-grid-view">
														<div class="w-75 position-absolute float-right">
															<p class="float-right tipo-pub2">Parceria</p>
														</div>
														<div class="feature-image">
																<img src="img/freelancer/freelancer-1.jpg" alt="" style="width:100px; height:100px">

															<div class="name-designation" style="min-height: 150px">
																<h5 class="name">'.$row['nome'].'</h5>
																<p id="help" class="text-muted mb-3" style="font-size:1rem;">'.$row['titulo_user'].'</p>
																<p class="text-left" style="white-space: pre-line">'.$row['titulo'].'</p>
																<p class="text-left d-none descricao mt-2" style="white-space: pre-line">'.$row['descricao'].'</p>
																<p class="expandir text-right mt-2" style="cursor:pointer;" onclick="expand(this);">Ler mais</p>
															</div>
														</div>
														<div class="rate-hire col-md-12 mt-2 mb-n5">
															<div class="hire-button col-md-12">
																<a href="profile-nd.php?id='.$row['id'].'" class="hire-btn col-md-12 text-center">Visitar perfil</a>
															</div>
														</div>
													</article>
												</div>');
											break;
										case 2:
											echo('
											<div class="col-lg-4 col-md-4 col-sm-4">
												<article class="freelancers freelancer-grid-view">
													<div class="w-75 position-absolute float-right">
														<p class="float-right tipo-pub2">Parceria</p>
													</div>
													<div class="feature-image">
															<img src="img/freelancer/freelancer-1.jpg" alt="" style="width:100px; height:100px">
	
														<div class="name-designation" style="min-height: 150px">
															<h5 class="name">'.$row['nome'].'</h5>
															<p id="help" class="text-muted mb-3" style="font-size:1rem;">'.$row['titulo_user'].'</p>
															<p class="text-left" style="white-space: pre-line">'.$row['titulo'].'</p>
															<p class="text-left d-none descricao mt-2" style="white-space: pre-line">'.$row['descricao'].'</p>
															<p class="expandir text-right mt-2" style="cursor:pointer;" onclick="expand(this);">Ler mais</p>
														</div>
													</div>
													<div class="rate-hire col-md-12 mt-2 mb-n5">
														<div class="hire-button col-md-12">
															<a href="profile-exp.php?id='.$row['id'].'" class="hire-btn col-md-12 text-center">Visitar perfil</a>
														</div>
													</div>
												</article>
											</div>');
											break;
										case 3:
											echo('
											<div class="col-lg-4 col-md-4 col-sm-4">
												<article class="freelancers freelancer-grid-view">
													<div class="w-75 position-absolute float-right">
														<p class="float-right tipo-pub2">Parceria</p>
													</div>
													<div class="feature-image">
															<img src="img/freelancer/freelancer-1.jpg" alt="" style="width:100px; height:100px">
	
														<div class="name-designation" style="min-height: 150px">
															<h5 class="name">'.$row['nome'].'</h5>
															<p id="help" class="text-muted mb-3" style="font-size:1rem;">'.$row['titulo_user'].'</p>
															<p class="text-left" style="white-space: pre-line">'.$row['titulo'].'</p>
															<p class="text-left d-none descricao mt-2" style="white-space: pre-line">'.$row['descricao'].'</p>
															<p class="expandir text-right mt-2" style="cursor:pointer;" onclick="expand(this);">Ler mais</p>
														</div>
													</div>
													<div class="rate-hire col-md-12 mt-2 mb-n5">
														<div class="hire-button col-md-12">
															<a href="profile-pf.php?id='.$row['id'].'" class="hire-btn col-md-12 text-center">Visitar perfil</a>
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
					</div>

				</div>
			</div>
		</div>
	</section>



    <script src="js/functions.js"></script>
	<script src="js/vendor/font-awesome.js"></script>
	<script src="js/vendor/popper.min.js"></script>
	<script src="js/vendor/bootstrap.min.js"></script>
	<script src="js/index.js"></script>
</body>
</html>