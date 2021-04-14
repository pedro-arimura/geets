<?php 

	session_start();

    $mysqli = new mysqli('localhost','id15265491_root','Genérica1234','id15265491_geets');
	// DEFINE O FUSO HORARIO COMO O HORARIO DE BRASILIA
    date_default_timezone_set('America/Sao_Paulo');


    if ($_SESSION['usuarioNiveisAcessoId'] != 2) {
    	session_destroy();
    	header("Location: entrar?error");
    }

    $sql1 = "SELECT * FROM habilidades_usuarios WHERE id_usuarios = '".$_SESSION['usuarioId']."' ";
    $query1 = mysqli_query($mysqli, $sql1);
    $dados1 = mysqli_fetch_assoc($query1);

    $sql2 = "SELECT * FROM perfil_usuarios WHERE id_usuarios = '".$_SESSION['usuarioId']."' ";
    $query2 = mysqli_query($mysqli, $sql2);
    $dados2 = mysqli_fetch_assoc($query2);

    $sql3 = "SELECT * FROM projetos WHERE id IN (SELECT id_projetos FROM propostas WHERE status = 1 AND id_usuarios = '".$_SESSION['usuarioId']."')";
    $query3 = mysqli_query($mysqli, $sql3);
    $contar_query3 = mysqli_num_rows($query3);

    if (isset($_POST['save_especialista'])) {

    	$sql23 = "DELETE FROM especialista_usuarios WHERE id_usuarios = '".$_SESSION['usuarioId']."'";
    	$query23 = mysqli_query($mysqli, $sql23);
    	
    	$diretorio = "anexos/";

		$capa = isset($_FILES['capa']) ? $_FILES['capa'] : FALSE;
		$m = md5($_POST['id']);
		$destino1 = $diretorio."/"."1".$m.$capa['name'];
		move_uploaded_file($capa['tmp_name'], $destino1);

		$capa = "1".$m.$capa['name'];

		$sql2 = "INSERT INTO especialista_usuarios (id_usuarios, titulo, anexo, data_cadastro, hora_cadastro) VALUES ('".$_SESSION['usuarioId']."','".$_POST['titulo']."','".$capa."','".date('Y-m-d')."','".date('H:i:s')."')";
		$query2 = mysqli_query($mysqli, $sql2);

    	header("Location: profissional?id=".$_POST['id']."&success_especialist"); 

    }

    $sql44 = "SELECT * FROM especialista_usuarios WHERE id_usuarios = '".$_SESSION['usuarioId']."'";
    $query44 = mysqli_query($mysqli, $sql44);
    $dados44 = mysqli_fetch_assoc($query44);


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


				<?php  if (isset($dados44) AND $dados44['status'] == 0){ ?>
					
					<div class="alert alert-warning alert-dismissible fade show col-md-12" role="alert">
					  <strong><?php  echo $_SESSION['usuarioNome']; ?></strong> você enviou comprovantes para adquirir nível especialista, em breve a Geets irá analisar seus documentos.
					  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    <span aria-hidden="true">&times;</span>
					  </button>
					</div>	

				<?php  } ?>

				<?php  if (!isset($dados1)){ ?>
					
					<div class="alert alert-warning alert-dismissible fade show col-md-12" role="alert">
					  <strong><?php  echo $_SESSION['usuarioNome']; ?></strong> parece que você não tem nenhuma habilidade cadastrada. acesse seu perfil e comece a cadastrar.
					  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    <span aria-hidden="true">&times;</span>
					  </button>
					</div>	

				<?php  } ?>

				<?php  if ($dados2['facebook'] == '' OR $dados2['instagram'] == '' OR $dados2['linkedin'] == ''){ ?>
					
					<div class="alert alert-warning alert-dismissible fade show col-md-12" role="alert">
					  <strong><?php  echo $_SESSION['usuarioNome']; ?></strong> aumente suas chances de contratação adicionando mais formas de contato em seu perfil.
					  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    <span aria-hidden="true">&times;</span>
					  </button>
					</div>	
					
				<?php  } ?>
							

				<div class="col-lg-6 col-md-6 col-sm-12">
					<div class="overview">
						<div class="stat-icon icon-color-one">
							<i class="fas fa-suitcase"></i>
						</div>
						<div class="stat-text">
							<p>Negócios</p>
							<a href="filtro-projetos-list" style="font-size: 18px;">Procurar negócios</a>
						</div>
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-12">
					<div class="overview">
						<div class="stat-icon icon-color-two">
							<i class="fas fa-trophy"></i>
						</div>
						<div class="stat-text">
							<p>Nível Especialista</p>

							<?php  if (isset($dados44) AND $dados44['status'] == 0){ ?>
					
								<a href="#" data-toggle="modal" role="button" style="font-size: 16px; font-size: 18px; background-color: antiquewhite; color: burlywood; padding: 5px;">Em análise</a>

							<?php  }elseif (isset($dados44) AND $dados44['status'] == 1){ ?>
					
								<a href="#" data-toggle="modal" role="button" style="font-size: 16px; font-size: 18px; background-color: #b0ffaa; color: #3eaf46; padding: 5px;">Aprovado</a>

							<?php  }elseif (isset($dados44) AND $dados44['status'] == 3){ ?>
					
								<a href="#especialista" data-toggle="modal" role="button" style="font-size: 16px; font-size: 18px; background-color: #ffb5bc; color: #ff2626; padding: 5px;">Reprovado, tente novamente</a>

							<?php  }else{ ?>
								<a href="#especialista" data-toggle="modal" role="button" style="font-size: 18px;">Aplicar</a>
							<?php  } ?>


							<div class="modal fade text-left" id="especialista" tabindex="-1" role="dialog" aria-labelledby="myModalLabel11" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary white">
                                            <h4 class="modal-title" id="myModalLabel11" style="font-size: 16px; color: white;">Adquira um selo de especialista enviando comprovantes para Geets</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                        <form method="POST" action="" enctype="multipart/form-data">

                                        	<input type="hidden" name="MAX_FILE_SIZE" value="10485760">
                                            
                                            <input type="hidden" name="id" value="<?php  echo $_GET['id']; ?>">

                                            <div class="modal-body">

                                                <div class="row container" style="font-size: 14px;">

                                                    <div class="col-sm-12" style="margin-bottom: 15px;">
                                                		<div class="form-group">
                                                            <div class="form-line">
                                                            	Título do anexo
                                                                 <input value="" type="text" placeholder="Digite o nome do anexo como: curso de web design" class="form-control"  name="titulo">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <div class="form-line">
                                                            	Anexo de documento
								                                    <input style="display: block !important;" class="form-control" required="" accept=".jpg, .png" name="capa" id="file-input-capa" type="file" onchange="document.getElementById('a').src = window.URL.createObjectURL(this.files[0])">
                                                            </div>
                                                        </div>
                                                    </div>

                                                        
                                                </div>

                                             
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-outline-info" type="submit" value="salvar" name="save_especialista">Salvar</button>
                                                <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Fechar</button>
                                            </div>

                                        </form>


                                    </div>
                                </div>
                            </div>

						</div>
					</div>
				</div>
			</div>
		

			<div class="row">
	

				<div class="col-sm-12 col-md-12 col-lg-12">
					<div class="milestone-wrapper">
						<div class="milestone">
							<h3 style="color: black; padding: 10px;">Negócios aceitos</h3>
						</div>
					</div>
					<div class="db-table table-responsive">
						<table class="table">
							<thead>
								<tr>
									<th>Tipo</th>
									<th>Título</th>
									<th>Status</th>
								</tr>
							</thead>
							<tbody>
								
								<?php  while($dados3 = mysqli_fetch_array($query3)){ ?>
								<tr>
									<td><?php  echo $dados3['tipo_profissional']; ?></td>
									<td>
										<a href="detalhe-projeto?id=<?php  echo $dados3['id']; ?>">
											<?php  echo $dados3['titulo']; ?>
										</a>
									</td>
									<td>Conexão aberta</td>
								</tr>
								<?php }?>
						
							</tbody>
						</table>
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