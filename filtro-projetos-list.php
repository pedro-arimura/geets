<?

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


        $sql1 = "SELECT * FROM projetos WHERE tipo_profissional LIKE '%".$_GET['tipo_profissional']."%' habilidades IN ('".implode("','", $_GET['habilidades'])."') AND id NOT IN (SELECT id_projetos FROM propostas WHERE status = 1)";
		$query1 = mysqli_query($mysqli, $sql1);

		
    	
    }else{
		$sql1 = "SELECT * FROM projetos WHERE status = 1 AND id NOT IN (SELECT id_projetos FROM propostas WHERE status = 1) ORDER BY data_cadastro DESC";
    	$query1 = mysqli_query($mysqli, $sql1);
    }
    	$contar_query1 = mysqli_num_rows($query1);

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
	<title>Projetos | Geets</title>

	<link rel="stylesheet" href="dist/css/vendor/bootstrap.min.css">

	<link rel="stylesheet" href="dist/css/main.css">
</head>
<body>
	<?
		include "header.php";
	?>
	<section id="feature-job-online-with-sidebar">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 col-md-12 col-sm-12">
					<div class="buttons-container">
						<ul class="list-grid-btn">
							<li>Projetos Geets</li>
							<li>
								<button class="view-btn active list-view" id="list" onclick="listShow()"><i class="fas fa-bars"></i></button>
							</li>
						</ul>
					</div>
					

					<? if ($contar_query1 > 0) { ?>

						<? while($dados1 = mysqli_fetch_array($query1)){ 

							$sql5 = "SELECT * FROM perfil_usuarios WHERE id_usuarios = '".$dados1['id_usuarios']."'";
							$query5 = mysqli_query($mysqli, $sql5);
							$dados5 = mysqli_fetch_array($query5);

						?>
							<div class="feature-job-items-sidebar">
								<article class="feature-full__job-posts">
									<div class="company-logo">

										<? if ($dados5['thumb'] == '') { ?>
											<img src="img/freelancer/freelancer-1.jpg" alt="">
										<? }else{ ?>
											<img style="width: 100px; height: 100px; border-radius: 50%;" src="thumb/<? echo $dados5['thumb']; ?>" alt="">
										<?}?>
										
									</div>
									<div class="job-description">
										<h5 class="job-title"><a href="#"><? echo $dados1['titulo']; ?> </a></h5>
										<span class="job-category cat-color-one"><a href="#"><? echo $dados1['habilidades']; ?></a></span>
										<span class="job-category cat-color-three"><a href="#"><? echo $dados1['tipo_profissional']; ?></a></span>
										
										<div style="font-size: 13px; width: 100%; margin-top: 10px;">Publicado em <b><? echo date('d/m/Y', strtotime($dados1['data_cadastro'])); ?></b> às <b><? echo date('H:i', strtotime($dados1['hora_cadastro'])); ?></b></div>
									</div>
									<div class="apply">
										<a href="detalhe-projeto?id=<? echo $dados1['id']; ?>" class="apply-btn">Proposta</a>
									</div>
								</article>
							</div>
						<?}?>

					<? }else{ ?>
					
							<div class="alert alert-warning alert-dismissible fade show col-md-12" role="alert">
							  <strong><? echo $_SESSION['usuarioNome']; ?></strong> nenhum projeto por enquanto, volte mais tarde.
							</div>	

					<? } ?>

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
		                              		<a href="filtro-projetos-list">Ver todos</a>
		                              	</li>
		                           	</ul>
						      	</div>

						      	<div class="sidebar-widget skill">
						      		<h5 class="widget-title">Formato</h5>
						      		<div class="form-group select-categories">
	                                    <select class="custom-select" name="tipo_profissional">
	                                       <option value="">...</option>
	                                       <option value="Coprodutor / Parceiro">Parceria</option>
	                                       <option value="Fixo">Fixo</option>
	                                       <option value="Prestador de Serviços">Prestação de Serviço</option>
	                                    </select>
                                 	</div>
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