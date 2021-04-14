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

    if (isset($_POST['postar_projeto'])) {
    	
    	$sql1 = "INSERT INTO  projetos (titulo, habilidades, descricao, tipo_profissional, id_usuarios, data_cadastro, hora_cadastro) VALUES ('".$_POST['titulo']."','".$_POST['habilidades']."','".$_POST['descricao']."','".$_POST['tipo_profissional']."','".$_SESSION['usuarioId']."','".date('Y-m-d')."','".date('H:i:s')."')";
    	$query1 = mysqli_query($mysqli, $sql1);

    	$sql2 = "SELECT MAX(id) AS ultimo FROM projetos WHERE id_usuarios = '".$_SESSION['usuarioId']."'";
    	$query2 = mysqli_query($mysqli, $sql2);
    	$dados2 = mysqli_fetch_assoc($query2);

    	header("Location: novo-projeto-payment?id=".$dados2['ultimo']."&new_project");

    }

    $sql3 = "SELECT * FROM habilidades ORDER BY nome ASC";
    $query3 = mysqli_query($mysqli, $sql3);


   


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
	<title>Novo Projeto | Geets</title>

	<link rel="stylesheet" href="dist/css/vendor/bootstrap.min.css">

	<link rel="stylesheet" href="dist/css/vendor/font-awesome/css/font-awesome.min.css">

	<link rel="stylesheet" href="dist/css/main.css">
</head>
<body>
	<?php 
		include "header.php";
	?>
	<section id="post-project">
		<div class="container">
			<div class="post-project">
				<div class="row">
					<div class="col-sm-12 col-md-12 col-lg-12">
						<form class="submit-info row" method="POST" action="">
							<div class="need-info col-md-6">
								<p class="info-title">Quem você está buscando?</p>
								<p class="tooltip-icon"><a href="#"><i class="fas fa-question-circle"></i></a></p>
								<input name="titulo" required="" type="text" class="form-control" placeholder="Ex: Especialista ou Profissional.">
							</div>
							<div class="pick-category col-md-6">
								<p class="info-title">Área ou Nicho</p>
									<div class="form-group select-work-type col-md-12">
									    <select required="" class="custom-select col-md-12" name="habilidades">

									      <option value="">...</option>
									      <?php  while($dados3 = mysqli_fetch_array($query3)){ ?>
									      <option value="<?php  echo $dados3['nome']; ?>"><?php  echo $dados3['nome']; ?></option>
									      <?php }?>
									    </select>
							 		</div>
							</div>
							<div class="get-description col-md-12">
								<p class="info-title">Descrição</p>
								<p class="tooltip-icon"><a href="#" data-toggle="tooltip"><i class="fas fa-question-circle"></i></a></p>
								<textarea required="" name="descricao" class="form-control" cols="30" rows="10" placeholder="Escreva habilidades e características que você busca nesse profissional ou especialista."></textarea>
							</div>
			
			
							<div class="experience-level">
								<p class="info-title">Qual será o formato?</p>
								<div class="row">
									<div class="col-sm-12 col-md-4 col-lg-4 xpbox">
										<input required="" class="form-control" name="tipo_profissional" id="entry" type="radio" value="Coprodutor / Parceiro">
										<label for="entry">
											<div class="header">Parceira</div>
											<div class="body">
												Quero encontrar um parceiro/coprodutor para um projeto.
												<span class="symbols">$</span>
											</div>
										</label>
									</div>
									<div class="col-sm-12 col-md-4 col-lg-4 xpbox">
										<input required="" class="form-control" name="tipo_profissional" id="intermediate" type="radio" value="Fixo">
										<label for="intermediate">
											<div class="header">Fixo</div>
											<div class="body">
												Quero encontrar um profissional para fazer parte do meu time.
												<span class="symbols">$$</span>
											</div>
										</label>
									</div>
									<div class="col-sm-12 col-md-4 col-lg-4 xpbox">
										<input required="" class="form-control" name="tipo_profissional" id="expert" type="radio" value="Prestador de Serviços">
										<label for="expert">
											<div class="header">Prestação de Serviço</div>
											<div class="body">
												Quero encontrar um profissional que me preste um serviço.
												<span class="symbols">$$$</span>
											</div>
										</label>
									</div>
									<div class="post-job-btn col-md-12 text-center">
										<input type="submit" name="postar_projeto" class="button-ymp" value="Postar Projeto">
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>


	<script src="js/vendor/popper.min.js"></script>
	<script src="js/vendor/bootstrap.min.js"></script>
	<script src="js/vendor/font-awesome.js"></script>
	<script src="js/index.js"></script>
</body>
</html>