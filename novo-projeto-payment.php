<?php 

	session_start();

    $mysqli = new mysqli('localhost','id15265491_root','Genérica1234','id15265491_geets');
	// DEFINE O FUSO HORARIO COMO O HORARIO DE BRASILIA
    date_default_timezone_set('America/Sao_Paulo');

     include_once("payment/vendor/autoload.php");


	// Configura credenciais
	  MercadoPago\SDK::setAccessToken('APP_USR-8973314729985759-092919-bf4366ea70ea090cfc0195890550d6ca-440248070');


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

    $sql1 = "SELECT * FROM projetos WHERE id = '".$_GET['id']."'";
    $query1 = mysqli_query($mysqli, $sql1);
    $dados1 = mysqli_fetch_assoc($query1);

    if (isset($_GET['publish'])) {

    	$sql22 = "INSERT INTO fatura (status, id_projetos, valor, data_cadastro, hora_cadastro, id_usuarios) VALUES ('Pendente','".$_GET['id']."','97.00','".date('Y-m-d')."','".date('H:i:s')."','".$_SESSION['usuarioId']."')";
    	$query22 = mysqli_query($mysqli, $sql22);

    	$sql222 = "SELECT MAX(id) AS ultimo FROM fatura WHERE id_usuarios = '".$_SESSION['usuarioId']."'";
    	$query222 = mysqli_query($mysqli, $sql222);
    	$dados222 = mysqli_fetch_assoc($query222);

    	// Cria um objeto de preferência
		$preference = new MercadoPago\Preference();

    	$external_reference = $dados222['ultimo'];

		// Cria um item na preferência
		$item = new MercadoPago\Item();
		$item->id = '123';
		$item->title = 'Publicação Geets';
		$item->quantity = 1;
		$item->unit_price = 97.00;



		/*$payer = new MercadoPago\Payer();
		$payer->name = "Joao";
		  $payer->surname = "Silva";
		  $payer->email = "user@email.com";
		  $payer->date_created = "2018-06-02T12:58:41.425-04:00";
		  $payer->phone = array(
		    "area_code" => "11",
		    "number" => "4444-4444"
		  );
		    
		  $payer->identification = array(
		    "type" => "CPF",
		    "number" => "19119119100"
		  );
		    
		  $payer->address = array(
		    "street_name" => "Street",
		    "street_number" => 123,
		    "zip_code" => "06233200"
		  );
		*/

		$preference->items = array($item);
		//$preference->payer = $payer;
		$preference->external_reference = $external_reference;

		$preference->back_urls = array(
			"success" => "http://geets.esy.es/novo-projeto-payment?published&id=".$_GET['id']."",
			"failure" => "http://geets.esy.es/novo-projeto-payment?pending&id=".$_GET['id']."",
			"pending" => "http://geets.esy.es/novo-projeto-payment?pending&id=".$_GET['id'].""
		);


		$preference->save();


    	header("Location:".$preference->init_point."");

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
	<meta name="description" content="">
	<title>Postar Projeto | Geets</title>

	<link rel="stylesheet" href="dist/css/vendor/bootstrap.min.css">

	<link rel="stylesheet" href="dist/css/main.css">
</head>
<body>
	<?php 
		include "header.php";
	?>	

	<section id="dispute-page">
		
		<?php  if (isset($_GET['published'])) { ?>
			
			<div class="container">
				<div class="dispute">
					<div class="row text-center">
						<div class="col-sm-12 col-md-12 col-lg-12">
							<h4 class="project-name">Projeto Publicado !</h4>
							<h5><?php  echo $_SESSION['usuarioNome']; ?>, acabamos de publicar seu projeto, em breve você comecará a receber diversas propostas para o projeto  <b><?php  echo $dados1['titulo']; ?></b></h5>
						</div>
					</div>
				</div>
				
				<div class="row" >
	
					<div class="col-md-12" style="margin-bottom: 40px;">
						<a class="btn btn-primary btn-block" href="<?php  echo $retorno; ?>" style="color: white;">Ir para menu principal</a>
					</div>
				</div>
			</div>

		<?php  }elseif (isset($_GET['pending'])) { ?>
			
			<div class="container">
				<div class="dispute">
					<div class="row text-center">
						<div class="col-sm-12 col-md-12 col-lg-12">
							<h4 class="project-name">Projeto Pendente !</h4>
							<h5><?php  echo $_SESSION['usuarioNome']; ?>,após a confirmação de seu pagamento, seu projeto será publicado imediatamente pela Geets</h5>
						</div>
					</div>
				</div>
				
				<div class="row" >
	
					<div class="col-md-12" style="margin-bottom: 40px;">
						<a class="btn btn-primary btn-block" href="<?php  echo $retorno; ?>" style="color: white;">Ir para menu principal</a>
					</div>
				</div>
			</div>

		<?php  }elseif (isset($_GET['error'])) { ?>
			
			<div class="container">
				<div class="dispute">
					<div class="row text-center">
						<div class="col-sm-12 col-md-12 col-lg-12">
							<h4 class="project-name">Pagamento Rejeitado !</h4>
							<h5><?php  echo $_SESSION['usuarioNome']; ?>, tente novamente ou utilize outro método de pagamento.</h5>
						</div>
					</div>
				</div>
				
				<div class="row" >
	
					<div class="col-md-12" style="margin-bottom: 40px;">
						<a class="btn btn-primary btn-block" href="<?php  echo $retorno; ?>" style="color: white;">Ir para menu principal</a>
					</div>
				</div>
			</div>

		<?php  }else{ ?>
		<div class="container">
			<div class="dispute">
				<div class="row">
					<div class="col-sm-12 col-md-12 col-lg-12">
						<h4 class="project-name"><?php  echo $dados1['titulo']; ?></h4>
						<h5>Tipo de Profissional: <?php  echo $dados1['tipo_profissional']; ?></h5>
						<p>Habilidade: <?php  echo $dados1['habilidades']; ?></p>
						<p>Valor Estimado: <?php  echo $dados1['valor_projeto']; ?></p>
						<div class="get-started-wrapper">
							<div class="row">
								<div class="col-sm-12 col-md-3 col-lg-3 mobile-padding">
									<img src="img/dispute/dispute-1.png" alt="">
									<p class="bar-ymp"></p>
									<h4 class="stage"><a href="#">Passo 1</a></h4>
									<p>Descreva seu projeto</p>
								</div>
								<div class="col-sm-12 col-md-3 col-lg-3 mobile-padding">
									<img src="img/dispute/dispute-2.png" alt="">
									<p class="bar-ymp"></p>
									<h4 class="stage"><a href="#">Passo 2</a></h4>
									<p>Selecione o tipo de profissional</p>
								</div>
								<div class="col-sm-12 col-md-3 col-lg-3 mobile-padding">
									<img src="img/dispute/dispute-3.png" alt="">
									<p class="bar-ymp"></p>
									<h4 class="stage"><a href="#">Passo 3</a></h4>
									<p>Realize o pagamento</p>
								</div>
								<div class="col-sm-12 col-md-3 col-lg-3 mobile-padding">
									<img src="img/dispute/dispute-4.png" alt="">
									<p class="bar-ymp"></p>
									<h4 class="stage"><a href="#">Passo 4</a></h4>
									<p>Projeto Publicado</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="row" >
				<div class="col-md-8">
					<div class="note" style="margin-bottom: 10px;">
						<div class="col-sm-12 col-md-12 col-lg-12">
							<h5>Instruções de Postagem</h5>
							<ul>
								<li>Você está proximo de receber diversas proposta e gerar conexões com os melhores profissionais do Brasil, para que possamos prosseguir e publicar seu projeto na Geets realize o pagamento no valor de R$ 97,00.</li>
							</ul>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="dispute-countdown clearfix" style="margin: 0; padding: 15px;">
						<h4>Postagem Geets</h4>
						<span class="respond-text">Válido para (1) Post </span>
						<span class="amount-disputed" style="border-bottom: 0px;">Total à pagar: <span>R$ 97,00</span></span>
						<div class="clearfix"></div>
					</div>
				</div>

				<div class="col-md-12" style="margin-bottom: 40px;">
					<a class="btn btn-primary btn-block" href="?publish&id=<?php  echo $_GET['id']; ?>" style="color: white;">clique aqui para prosseguir</a>

				</div>
			</div>
		</div>
		<?php }?>
	</section>

	<script src="js/vendor/font-awesome.js"></script>
	<script src="js/vendor/popper.min.js"></script>
	<script src="js/vendor/bootstrap.min.js"></script>
	<script src="js/bid-milestone.js"></script>
	<script src="js/index.js"></script>

</body>
</html>