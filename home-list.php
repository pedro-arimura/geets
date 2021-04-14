<?php 
	session_start();
	$mysqli = new mysqli('localhost','root','','new-bd-geets');
	$sql = "SELECT usuarios.id, perfil_negocio_digital.razao_social, perfil_negocio_digital.modelo_negocio, perfil_negocio_digital.thumb
			FROM usuarios
			INNER JOIN perfil_negocio_digital ON usuarios.id = perfil_negocio_digital.id_usuario
			WHERE usuarios.id_tipo_perfil = 1";
	$negocios = $mysqli->query($sql);
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
	<title>Profissionais | Geets</title>

	<link rel="stylesheet" href="dist/css/vendor/bootstrap.min.css">

	<link rel="stylesheet" href="dist/css/vendor/font-awesome/css/font-awesome.min.css">

	<link rel="stylesheet" href="dist/css/main.css">
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
							<li>Visualização: </li>
							<li>
								<form action="#">
									<a class="view-btn active list-view" id="list" href="home-list.php"><i class="fas fa-bars"></i></a>
								</form>
							</li>
							<li>
								<a class="view-btn grid-view" id="grid" href="home.php"><i class="fas fa-th-large"></i></a>
							</li>
						</ul>
				
					</div>

					<div class="row">
					<?php 
					foreach($negocios as $row){
					echo('
					<div class="freelancers-items col-lg-6 col-md-6">
							<article class="freelancers freelancer-list-view">
								<div class="left-align">
									<div class="feature-image">
											<img src="thumb/'.$row['thumb'].'" alt="" style="width:100px; height:100px">
									</div>

									<div class="name-designation">
											<h5 class="name">'.$row['razao_social'].'</h5>
											<p id="help" class="text-muted mb-3" style="font-size:1rem;">'.$row['modelo_negocio'].' </p>
									</div>
								</div>
								<div class="right-align">
									<div class="rate-hire mb-5">
										<div class="hire-button">
											<a href="profile-nd.php?id='.$row['id'].'" class="hire-btn col-md-12 text-center">Visitar perfil</a>
										</div>
									</div>
								</div>
							</article>
					</div>');
					}
					?>
					</div>

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
			</div>
		</div>
	</section>




	<script src="js/vendor/font-awesome.js"></script>
	<script src="js/vendor/popper.min.js"></script>
	<script src="js/vendor/bootstrap.min.js"></script>
	<script src="js/index.js"></script>
</body>
</html>