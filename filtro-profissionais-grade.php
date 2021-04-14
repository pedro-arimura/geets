<?php

	session_start();

    $mysqli = new mysqli('localhost','id15265491_root','Genérica1234','id15265491_geets');
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

    

    if (isset($_GET['realizar_filtro'])) {


        $sql1 = "SELECT * FROM usuarios WHERE niveis_acesso_id = 2 AND id IN (SELECT id_usuarios FROM habilidades_usuarios WHERE habilidade IN('".implode("','", $_GET['habilidades'])."') )";
		$query1 = mysqli_query($mysqli, $sql1);



    	
    }else{
		$sql1 = "SELECT * FROM usuarios WHERE niveis_acesso_id = 2 ";
    	$query1 = mysqli_query($mysqli, $sql1);
    }

    $sql4 = "SELECT * FROM habilidades ORDER BY nome ASC";
    $query4 = mysqli_query($mysqli, $sql4);


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
	
	<link rel="stylesheet" href="css/responsive.css">
</head>
<body>
	<?
		include "header.php";
	?>
	<section id="freelancer-list-view-with-sidebar">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 col-md-8 col-sm-12">
					<div class="buttons-container">
						
						<ul class="list-grid-btn">
							<li>Visualização: </li>
							<li>
								<form action="#">
									<a class="view-btn list-view" id="list" href="filtro-profissionais-list"><i class="fas fa-bars"></i></a>
								</form>
							</li>
							<li>
								<a class="view-btn active grid-view" id="grid" href="filtro-profissionais-grade"><i class="fas fa-th-large"></i></a>
							</li>
						</ul>
					</div>

					<div class="row">
						<? while($dados1 = mysqli_fetch_array($query1)){ 

							$sql2 = "SELECT * FROM perfil_usuarios WHERE id_usuarios = '".$dados1['id']."'";
							$query2 = mysqli_query($mysqli, $sql2);
							$dados2 = mysqli_fetch_assoc($query2);

							$sql3 = "SELECT * FROM subhabilidades_usuarios WHERE id_usuarios = '".$dados1['id']."'";
							$query3 = mysqli_query($mysqli, $sql3);
							$contar_query3 = mysqli_num_rows($query3);


						?>
							
						<div class="col-lg-6 col-md-6 col-sm-12">
							<article class="freelancers freelancer-grid-view">
								<div class="feature-image">

									<? if ($dados2['thumb'] == '') { ?>
										<img src="img/freelancer/freelancer-1.jpg" alt="">
									<? }else{ ?>
										<img style="width: 100px; height: 100px;" src="thumb/<? echo $dados2['thumb']; ?>" alt="">
									<?}?>

									<div class="name-designation">
										<h5 class="name"><? echo $dados1['nome']; ?></h5>
										<? if ($contar_query3 > 0) { ?>
											<? while($dados3 = mysqli_fetch_array($query3)){ ?>
												<div class="hire-btn btn btn-primary btn-sm" style="font-size: 11px; background-color: #2dced4;"><? echo $dados3['subhabilidade']; ?></div>
											<?}?>
										<? }else{ ?>
											<div class="hire-btn btn btn-danger btn-sm" style="font-size: 11px;">Nenhuma habilidade</div>
										<?}?>
										
									</div>
								</div>
								<div class="rate-hire col-md-12">
									<div class="hire-button col-md-12">
										<a href="perfil?id=<? echo $dados1['id']; ?>" class="hire-btn col-md-12 text-center">Visitar perfil</a>
									</div>
								</div>
							
								<div class="contact-details text-center">

									<?
										// VERIFICA SE É ESPECIALISTA
									    $sql44 = "SELECT * FROM especialista_usuarios WHERE id_usuarios = '".$dados1['id']."' AND status = 1";
									    $query44 = mysqli_query($mysqli, $sql44);
									    $dados44 = mysqli_fetch_assoc($query44);
									?>

										<ul>
											<? if (isset($dados44)){ ?>
												<li><span class="verified">Especialista</span></li>
											<? } ?>
											
											<li><a href="#"><i class="fas fa-phone"></i></a></li>
											<li><a href="#"><i class="fas fa-envelope"></i></a></li>
										</ul>

								</div>
							</article>
						</div>

						<?}?>
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
				<div class="col-lg-4 col-md-4 col-sm-12">
					<div class="sidebar-nav">
						<ul class="nav nav-tabs">
						    <li class=""><a data-toggle="tab" href="#all">Filtro Avançado</a></li>
						</ul>
					</div>
					<div class="sidebar-tab-content">
						<div class="tab-content">
						    <div id="all" class="tab-pane in active">
				

							<form method="GET" action="">
								
						      	<div class="sidebar-widget country">
						      		<h5 class="widget-title">Área ou Nicho</h5>
						      		<ul>


						      			
						      			<? while($dados4 = mysqli_fetch_array($query4)){ 

						      				$sql16 = "SELECT * FROM subhabilidades WHERE id_habilidades = '".$dados4['id']."'";
	                                        $query16 = mysqli_query($mysqli, $sql16);
						      			?>

						      			

						      
											<?if (in_array($dados4['nome'], $_GET['habilidades'])){?>

												<?
													$display = 'block';
												?>

												<li>
				                                 	<label onclick="abrir<? echo $dados4['id']; ?>();" class="checkbox-btn"><? echo $dados4['nome']; ?>
				                                 		<input checked="checked" name="habilidades[]" value="<? echo trim($dados4['nome']); ?>" id="mycheck<? echo $dados4['id']; ?>" type="checkbox">
				                                 		<span class="checkmark"></span>
				                                 	</label>
				                              	</li>
											    
											<?}else{?>

												<?
													$display = 'none';
												?>

												<li>
				                                 	<label onclick="abrir<? echo $dados4['id']; ?>();" class="checkbox-btn"><? echo $dados4['nome']; ?>
				                                 		<input name="habilidades[]" value="<? echo trim($dados4['nome']); ?>" id="mycheck<? echo $dados4['id']; ?>" type="checkbox">
				                                 		<span class="checkmark"></span>
				                                 	</label>
				                              	</li>

											<?}?>

		                              	

		                              	<div id="cad<? echo $dados4['id']; ?>" style="display: <? echo $display; ?>; padding-left: 40px;">

                            				<? while($dados16 = mysqli_fetch_array($query16)){ ?>

                            					<input style="margin-right: 20px;" value="<? echo $dados16['nome']; ?>" type="checkbox" class=""  name="subhabilidades[]"> <? echo $dados16['nome']; ?>
                                				<br>

                                				
                                			<?}?>

                                		</div>


		                              	<script type="text/javascript">
                                    
			                                    function abrir<? echo $dados4['id']; ?>(){

			                                    	if(document.getElementById('mycheck<? echo $dados4['id']; ?>').checked) {
			                                    			document.getElementById('cad<? echo $dados4['id']; ?>').style.display="block";
			                                    		}else{
			                                    			document.getElementById('cad<? echo $dados4['id']; ?>').style.display="none";
			                                    		}

			                                        //document.getElementById('cad2').style.display="none";
			                                    }
			                            </script>

		                              	<?}?>
		                              	<li class="view-all">
		                              		<a href="filtro-profissionais-grade">Ver todos</a>
		                              	</li>
		                           	</ul>
						      	</div>


						      	<div class="sidebar-widget skill">
						      		<button name="realizar_filtro" value="Filtrar" type="submit" class="btn btn-primary col-md-12" style="color: white;">
						      			Filtrar
						      		</button>

						      	</div>

						    </form>

						    </div>
					  	</div>
				  	</div>
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