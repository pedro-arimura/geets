<?php 

	session_start();

    $mysqli = new mysqli('localhost','id15265491_root','Genérica1234','id15265491_geets');
	// DEFINE O FUSO HORARIO COMO O HORARIO DE BRASILIA
    date_default_timezone_set('America/Sao_Paulo');


	// A sessão precisa ser iniciada em cada página diferente
	if (!isset($_SESSION)) session_start();

	$nivel_necessario = array('2','1','3');

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

    $sql1 = "SELECT * FROM projetos WHERE id = '".$_GET['id']."'";
    $query1 = mysqli_query($mysqli, $sql1);
    $dados1 = mysqli_fetch_assoc($query1);

    $sql2 = "SELECT * FROM perfil_usuarios WHERE id = '".$dados1['id_usuarios']."'";
    $query2 = mysqli_query($mysqli, $sql2);
    $dados2 = mysqli_fetch_assoc($query2);

    $sql3 = "SELECT * FROM usuarios WHERE id = '".$dados1['id_usuarios']."'";
    $query3 = mysqli_query($mysqli, $sql3);
    $dados3 = mysqli_fetch_assoc($query3);

    if (isset($_POST['enviar_proposta'])) {
    	
    	$sql4 = "INSERT INTO propostas (id_usuarios, id_projetos, descricao, data_cadastro, hora_cadastro) VALUES ('".$_SESSION['usuarioId']."','".$_POST['id']."','".$_POST['descricao']."','".date('Y-m-d')."','".date('H:i:s')."')";
    	$query4 = mysqli_query($mysqli, $sql4);

    	header("Location: detalhe-projeto?id=".$_POST['id']."&success_proposal");


    }

    if (isset($_POST['update_proposta'])) {

    	$sql4 = "UPDATE propostas SET descricao = '".$_POST['descricao']."', data_cadastro = '".date('Y-m-d')."', hora_cadastro = '".date('H:i:s')."' WHERE id_usuarios = '".$_SESSION['usuarioId']."' AND id_projetos = '".$_POST['id']."'";
    	$query4 = mysqli_query($mysqli, $sql4);

    	header("Location: detalhe-projeto?id=".$_POST['id']."&modify_proposal");
    	
    }

    if (isset($_GET['accept'])) {
    	
    	$sql4 = "UPDATE propostas SET status = 1 WHERE id = '".$_GET['id']."'";
    	$query4 = mysqli_query($mysqli, $sql4);



    	header("Location: detalhe-projeto?id=".$_GET['id_project']."&accept_proposal");


    }

    

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>

	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>


	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<meta name="application-name" content="">
	<meta name="description" content="<?php  echo $dados1['descricao']; ?>">
	<title><?php  echo $dados1['titulo']; ?></title>

	<link rel="stylesheet" href="dist/css/vendor/bootstrap.min.css">

	<link rel="stylesheet" href="dist/css/main.css">
</head>
<body>
	<?php 
		include "header.php";
	?>

	<section id="project-bid-page">
		<div class="container">

			<?php  if (isset($_GET['success_proposal'])) { ?>
				<div class="alert alert-success alert-dismissible fade show col-md-12" role="alert">
				  <strong><?php  echo $_SESSION['usuarioNome']; ?></strong> Parabéns, você acaba de enviar uma proposta, vamos aguardar e torcer para que a empresa selecione seu perfil.
				</div>	
			<?php  } ?>

			<?php  if (isset($_GET['accept_proposal'])) { ?>
				<div class="alert alert-success alert-dismissible fade show col-md-12" role="alert">
				  <strong><?php  echo $_SESSION['usuarioNome']; ?></strong> Você acaba de aceitar uma proposta, acabamos de liberar as formas de contato para que você possa começar a gerar conexões.
				</div>	
			<?php  } ?>

			

			<?php  if (isset($_GET['modify_proposal'])) { ?>
				<div class="alert alert-success alert-dismissible fade show col-md-12" role="alert">
				  <strong><?php  echo $_SESSION['usuarioNome']; ?></strong> Ótimo, você acaba de modificar sua proposta, vamos aguardar e torcer para que a empresa selecione seu perfil.
				</div>	
			<?php  } ?>

			<div class="bid-project-page">


				<div class="row">
					<div class="col-sm-12 col-md-12 col-lg-12">
						<div class="bidding-title">
							<h4><?php  echo $dados1['titulo']; ?></h4>
						</div>
					</div>
				</div>
				<div class="bidding-header">
					<div class="col-sm-12 col-md-12 col-lg-12">
						<div class="bidding-info">
							<div class="row">
								<div class="col-sm-12 col-md-12 col-lg-7">
									<div class="bid-info">
										<div class="freelancer-bidding">
											<h5>Data da Publicação</h5>
											<h4 class="project-amount" style="font-size: 15px;">
												<?php  if ($dados1['data_cadastro'] == date('Y-m-d')) { ?>
													Hoje às <?php  echo date('H:i', strtotime($dados1['hora_cadastro'])); ?>
												<?php  }elseif($dados1['data_cadastro'] == date('Y-m-d', strtotime('- 1 DAYS'))){ ?>
													Ontem às <?php  echo date('H:i', strtotime($dados1['hora_cadastro'])); ?>
												<?php  }else{ ?>
													Em <?php  echo date('d/m/Y', strtotime($dados1['data_cadastro'])); ?> às <?php  echo date('H:i', strtotime($dados1['hora_cadastro'])); ?>
												<?php }?>
											</h4>
										</div>
										<div class="avg-bidding">
											<h5>Tipo de Profissional</h5>
											<h4 class="project-amount" style="font-size: 15px; color: black;"><?php  echo $dados1['tipo_profissional']; ?></h4>
										</div>
									</div>
								</div>
								<div class="col-sm-12 col-md-12 col-lg-2"></div>
								<div class="col-sm-12 col-md-12 col-lg-3">
									<div class="get-button bidding">
										<a href="#new-proposta" class="get-btn">Proposta</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12 col-md-8 col-lg-8">
						<div class="project-description">
							<h4 class="title">Detalhes do projeto</h4>
							<p><?php  echo nl2br($dados1['descricao']); ?></p><br>
						</div>
					</div>
					<div class="col-sm-12 col-md-4 col-lg-4">
						<div class="employee-info">
							<h4 class="title">Sobre a empresa</h4>
							<div class="feature-image">

								<?php  if ($dados2['thumb'] == '') { ?>
										<img src="img/employer/employer1.jpg" alt="">
								<?php  }else{ ?>
										<img style="width: 100px; height: 100px;" src="thumb/<?php  echo $dados2['thumb']; ?>" alt="">
								<?php }?>

								<div class="name-designation">
									<h5 class="name"><?php  echo $dados3['nome']; ?></h5>
									<hr>
									<h5 class="designation"><?php  echo $dados2['titulo']; ?></h5>
								</div>
							</div>
						
							<div class="contact-details">
								<ul>
									<li><a href="#"><i class="fas fa-dollar-sign"></i></a></li>
									<li><a href="#"><i class="fas fa-envelope"></i></a></li>
									<li class="address-book"><a href="#"><i class="fas fa-address-book"></i></a></li>
									<li class="phone"><a href="#"><i class="fas fa-phone"></i></a></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
				<hr>
				<div class="row">
					<div class="col-sm-12 col-md-12 col-lg-12">
						<div class="skill-requirement">
							<h4 class="title">Resumo do projeto</h4>

							<ul>
								<li style="width: 100%;">Estamos contratando profissionais como <b><?php  echo $dados1['tipo_profissional']; ?></b></li>
								<li style="width: 100%;">
										Publicamos este projeto

										<b>
											<?php  if ($dados1['data_cadastro'] == date('Y-m-d')) { ?>
												hoje às <?php  echo date('H:i', strtotime($dados1['hora_cadastro'])); ?>
											<?php  }elseif($dados1['data_cadastro'] == date('Y-m-d', strtotime('- 1 DAYS'))){ ?>
												ontem às <?php  echo date('H:i', strtotime($dados1['hora_cadastro'])); ?>
											<?php  }else{ ?>
												em <?php  echo date('d/m/Y', strtotime($dados1['data_cadastro'])); ?> às <?php  echo date('H:i', strtotime($dados1['hora_cadastro'])); ?>
											<?php }?>
										</b>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="row" id="new-proposta" style="padding: 40px; background-color: #ffffff;">
				<div class="col-lg-12 col-md-12 col-sm-12">
					

					<?php  if ($_SESSION['usuarioNiveisAcessoId'] == 2) { 

						$sql5 = "SELECT * FROM propostas WHERE id_projetos = '".$_GET['id']."' AND id_usuarios = '".$_SESSION['usuarioId']."' ";
						$query5 = mysqli_query($mysqli, $sql5);
						$dados5 = mysqli_fetch_assoc($query5);

						$sql6 = "SELECT * FROM propostas WHERE id_projetos = '".$_GET['id']."' AND status = 1";
						$query6 = mysqli_query($mysqli, $sql6);
						$dados6 = mysqli_fetch_assoc($query6);
					?>



						<?php  if ($dados5['status'] == 1) { ?>
							<div class="alert alert-success alert-dismissible fade show col-md-12" role="alert">
							  <strong><?php  echo $_SESSION['usuarioNome']; ?></strong> sua proposta foi aceita pela empresa, fique atendo, logo entrarão em contato com você.
							</div>
						<?php  }else{ ?>

							<?php  if (isset($dados5)) { ?>

								<div class="alert alert-warning alert-dismissible fade show col-md-12" role="alert">
								  <strong><?php  echo $_SESSION['usuarioNome']; ?></strong> você só pode enviar uma proposta por projetos, vamos cruzar os dedos e esperar que esta empresa selecione a sua.
								</div>

								<form method="POST" action="">

									<input type="hidden" name="id" value="<?php  echo $_GET['id']; ?>">

									<div class="proposal">
										<h4 class="title">Você pode melhorar sua proposta</h4>
										<p>Você acha melhor modificar sua proposta? fique a vontade.</p>
										<textarea required="" name="descricao" class="form-control" cols="30" rows="10" placeholder="Conquiste este cliente enviando uma proposta completa rica em detalhes."><?php  echo $dados5['descricao']; ?></textarea>
									</div>

									<div class="get-button bidding text-center">
										<input required="" class="get-btn col-md-12" type="submit" name="update_proposta" value="Enviar minha nova proposta" style="border-style: none;">
									</div>
								</form>	

							<?php  }else{ ?>

								<?php  if (isset($dados6)){ ?>
									<div class="alert alert-warning alert-dismissible fade show col-md-12" role="alert">
									  Este projeto não está mais disponivel, a empresa aceitou a proposta de outro usuário.
									</div>
								<?php  }else{ ?>

									<form method="POST" action="">

										<input type="hidden" name="id" value="<?php  echo $_GET['id']; ?>">

										<div class="proposal">
											<h4 class="title">Envio de Propostas</h4>
											<p>Seja específico, informe como você vai trabalhar neste projeto e tenha mais chances de conseguir este trabalho.</p>
											<textarea required="" name="descricao" class="form-control" cols="30" rows="10" placeholder="Conquiste este cliente enviando uma proposta completa rica em detalhes."></textarea>
										</div>

										<div class="get-button bidding text-center">
											<input required="" class="get-btn col-md-12" type="submit" name="enviar_proposta" value="Enviar Proposta" style="border-style: none;">
										</div>
									</form>

								<?php }?>

								

							<?php }?>

						<?php }?>
						


					<?php  }elseif($_SESSION['usuarioNiveisAcessoId'] == 1){ ?>


						<?php 
							$sql7 = "SELECT * FROM propostas WHERE id_projetos = '".$_GET['id']."'";
							$query7 = mysqli_query($mysqli, $sql7);
						?>

						<?php  while($dados7 = mysqli_fetch_array($query7)){ 

							$sql8 = "SELECT * FROM usuarios WHERE id = '".$dados7['id_usuarios']."' ";
							$query8 = mysqli_query($mysqli, $sql8);
							$dados8 = mysqli_fetch_assoc($query8);

							$sql88 = "SELECT * FROM perfil_usuarios WHERE id = '".$dados7['id_usuarios']."' ";
							$query88 = mysqli_query($mysqli, $sql88);
							$dados88 = mysqli_fetch_assoc($query88);

						?>
							<div class="row">
								<div class="col-sm-12 col-md-6 col-lg-6">
									<div class="freelancers-awared">
										<h4 class="title" style="font-size: 14px;">Proposta realizada em <?php  echo date('d/m/Y', strtotime($dados7['data_cadastro'])); ?> às <?php  echo date('H:i', strtotime($dados7['hora_cadastro'])); ?></h4>
										<div class="freelancer">
											<div class="about-freelancer">
												<img src="img/freelancer/freelancer-7.jpg" alt="">
											</div>
											<div class="award-info">
												<ul>
													<li><a href="perfil?id=<?php  echo $dados8['id']; ?>"><?php  echo $dados8['nome']; ?></a></li>
													<li><?php  echo $dados88['titulo']; ?></li>
												</ul>
											</div>
										</div>
										<?php  if ($dados1['id_usuarios'] == $_SESSION['usuarioId']){ ?>
											<div class="buttons">
												
												<?php  if ($dados7['status'] == 0) { ?>
													<div class="accept-btn">
														<a href="?accept&id=<?php  echo $dados7['id']; ?>&id_project=<?php  echo $_GET['id']; ?>">Aceitar</a>
													</div>
												<?php  }elseif ($dados7['status'] == 1) { ?>
													<i style="margin-right: 20px; color: lime; border-style: solid; border-width: 1px; padding: 5px; border-radius: 20px; font-size: 14px;">Proposta aceita</i>
												<?php  } ?>
												
												<div class="reject-btn">
													<a target="_blank" href="perfil?id=<?php  echo $dados8['id']; ?>">Ver Perfil</a>
												</div>
											</div>
										<?php }?>
									</div>
								</div>
								<div class="col-sm-12 col-md-6 col-lg-6 mobile-float-1">
									<div class="reputation">
										<h4 class="title">Detalhamento</h4>
										<div class="award-details">
												

												<?php  if ($dados1['id_usuarios'] == $_SESSION['usuarioId']){ ?>

													<p><?php  echo $dados7['descricao']; ?></p>
					

												<?php  }else{ ?>

													<div class="alert alert-warning alert-dismissible fade show col-md-12" role="alert">
													  <strong><?php  echo $_SESSION['usuarioNome']; ?></strong> somente o criador deste projeto pode visualizar a proposta feita por <?php  echo $dados8['nome']; ?>
													</div>	

												<?php }?>
										</div>
									</div>
								</div>
							</div>
							<hr>
						<?php }?>


					<?php  } ?>

					
					
				
				</div>
			</div>
		</div>
	</section>



	<script src="js/vendor/font-awesome.js"></script>
	<script src="js/vendor/popper.min.js"></script>
	<script src="js/vendor/bootstrap.min.js"></script>
	<script src="js/bid-milestone.js"></script>
	<script src="js/index.js"></script>
</body>
</html>