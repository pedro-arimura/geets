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

    $sql1 = "SELECT * FROM usuarios WHERE id = '".$_GET['id']."'";
    $query1 = mysqli_query($mysqli, $sql1);
    $dados1 = mysqli_fetch_assoc($query1);

    $sql11 = "SELECT * FROM perfil_usuarios WHERE id_usuarios = '".$_GET['id']."'";
    $query11 = mysqli_query($mysqli, $sql11);
    $dados11 = mysqli_fetch_assoc($query11);

    $sql15 = "SELECT * FROM habilidades_usuarios WHERE id_usuarios = '".$_GET['id']."'";
    $query15 = mysqli_query($mysqli, $sql15);

    if (isset($_POST['save_descricao'])) {
    		
    	$sql2 = "UPDATE perfil_usuarios SET descricao = '".$_POST['descricao']."' WHERE id_usuarios = '".$_POST['id']."'";
    	$query2 =  mysqli_query($mysqli, $sql2);

    	header("Location: perfil.php?id=".$_POST['id']."&success");


    }

    if (isset($_POST['save_titulo'])) {
    		
    	$sql2 = "UPDATE perfil_usuarios SET titulo = '".$_POST['titulo']."' WHERE id_usuarios = '".$_POST['id']."'";
    	$query2 =  mysqli_query($mysqli, $sql2);

    	header("Location: perfil.php?id=".$_POST['id']."&success");


    }

    if (isset($_POST['save_contatos'])) {
    		
    	$sql2 = "UPDATE perfil_usuarios SET facebook = '".$_POST['facebook']."',instagram = '".$_POST['instagram']."',linkedin = '".$_POST['linkedin']."'  WHERE id_usuarios = '".$_POST['id']."'";
    	$query2 =  mysqli_query($mysqli, $sql2);

    	header("Location: perfil.php?id=".$_POST['id']."&success");


    }


    if (isset($_POST['save_thumb'])) {
    	
    	$diretorio = "thumb/";

		$capa = isset($_FILES['capa']) ? $_FILES['capa'] : FALSE;
		$m = md5($_POST['id']);
		$destino1 = $diretorio."/"."1".$m.$capa['name'];
		move_uploaded_file($capa['tmp_name'], $destino1);

		$capa = "1".$m.$capa['name'];

		$sql2 = "UPDATE perfil_usuarios SET thumb = '".$capa."' WHERE id_usuarios = '".$_POST['id']."'";
    	$query2 =  mysqli_query($mysqli, $sql2);

    	header("Location: perfil.php?id=".$_POST['id']."&success");

    }

    if ($_SESSION['usuarioNiveisAcessoId'] == 2) {
    	$retorno = "profissional";
    }elseif ($_SESSION['usuarioNiveisAcessoId'] == 1) {
    	$retorno = "empresa";
    }

    if (isset($_POST['save_habilidades'])) {

    	$sql21 = "DELETE FROM habilidades_usuarios WHERE id_usuarios = '".$_POST['id']."'";
    	$query21 = mysqli_query($mysqli, $sql21);

    	$sql211 = "DELETE FROM subhabilidades_usuarios WHERE id_usuarios = '".$_POST['id']."'";
    	$query211 = mysqli_query($mysqli, $sql211);

    	foreach ($_POST['habilidades'] as $key => $value) {

	        $sql22 = "INSERT INTO habilidades_usuarios (id_usuarios, habilidade) VALUES ('".$_POST['id']."','".$value."')";
	        $query22 = mysqli_query($mysqli, $sql22);

    	}

    	foreach ($_POST['subhabilidades'] as $key => $value) {

    		$sql233 = "SELECT * FROM subhabilidades WHERE nome = '".$value."'";
    		$query233 = mysqli_query($mysqli, $sql233);
    		$dados233 = mysqli_fetch_assoc($query233);

	        $sql23 = "INSERT INTO subhabilidades_usuarios (id_usuarios, subhabilidade, id_habilidades) VALUES ('".$_POST['id']."','".$value."','".$dados233['id_habilidades']."')";
	        $query23 = mysqli_query($mysqli, $sql23);

    	}
    		
    
    	header("Location: perfil.php?id=".$_POST['id']."&success");


    }

    if (isset($_POST['save_treinamento'])) {
    		
    	$sql2 = "UPDATE perfil_usuarios SET treinamentos = '".$_POST['descricao']."' WHERE id_usuarios = '".$_POST['id']."'";
    	$query2 =  mysqli_query($mysqli, $sql2);

    	header("Location: perfil.php?id=".$_POST['id']."&success");


    }

    if (isset($_POST['save_resultado'])) {
    		
    	$sql2 = "UPDATE perfil_usuarios SET resultado = '".$_POST['descricao']."' WHERE id_usuarios = '".$_POST['id']."'";
    	$query2 =  mysqli_query($mysqli, $sql2);

    	header("Location: perfil.php?id=".$_POST['id']."&success");


    }

    // ANALISE PARA VER SE DESBLOQUEIA OS DADOS DESTE USUÁRIO

    $sql30 = "SELECT * FROM propostas WHERE status = 1 AND id_usuarios = '".$_GET['id']."' AND id_projetos IN (SELECT id FROM projetos WHERE id_usuarios = '".$_SESSION['usuarioId']."')";
    $query30 = mysqli_query($mysqli, $sql30);
    $dados30 = mysqli_fetch_assoc($query30);


    // VERIFICA SE É ESPECIALISTA
    $sql44 = "SELECT * FROM especialista_usuarios WHERE id_usuarios = '".$dados1['id']."' AND status = 1";
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
	<meta name="description" content="Perfil de <?php  echo $dados1['nome']; ?>">
	<title>Logado como <?php  echo $_SESSION['usuarioNome']; ?></title>

	<link rel="stylesheet" href="dist/css/vendor/bootstrap.min.css">
	<link rel="stylesheet" href="dist/css/main.css">
	<link rel="stylesheet" href="css/custom.css">
</head>
<body>
	<?php 
		include "header.php";
	?>

	<section id="freelancer-portfolio" style="background: url(img/freelancer/freelancer-profile-bg.jpg);">
        <div class="container">
            <div class="freelancer-portfolio">

            	<?php  if (isset($dados30)) { ?>
           			<div class="col-md-12 form-group" style="margin-bottom: 80px;">
           				<div class="alert alert-success alert-dismissible fade show col-md-12" role="alert">
					  <strong><?php  echo $_SESSION['usuarioNome']; ?> você já pode visualizar todas as formas de contato</strong> deste usuário abaixo.
					</div>	
           			</div>
				<?php  } ?>


               <div class="row">

               		<div class="col-sm-12 col-md-5 col-lg-4">
	                    <div class="freelancer-profile-sidebar">
	                        <div class="profile-image">

	                        	<?php  if ($dados1['id'] == $_SESSION['usuarioId']) { ?>

	                        		<a href="#thumb" data-toggle="modal" role="button">
	                        			<?php  if ($dados11['thumb'] == '') { ?>
	                        				<img src="img/freelancer/Profile-Image1.jpg" alt="">
	                        			<?php  }else{ ?>
	                        				<img src="thumb/<?php  echo $dados11['thumb']; ?>" alt="">
	                        			<?php  } ?>
	                        		</a>

	                        		<div class="modal fade text-left" id="thumb" tabindex="-1" role="dialog" aria-labelledby="myModalLabel11" aria-hidden="true">
		                                <div class="modal-dialog modal-lg" role="document">
		                                    <div class="modal-content">
		                                        <div class="modal-header bg-primary white">
		                                            <h4 class="modal-title" id="myModalLabel11" style="font-size: 12px; color: white;">Envie uma foto sua de perfil</h4>
		                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		                                                <span aria-hidden="true">&times;</span>
		                                            </button>
		                                        </div>

		                                        <form method="POST" autocomplete="off" enctype="multipart/form-data">
	                        						<input type="hidden" name="MAX_FILE_SIZE" value="10485760">

		                                            <input type="hidden" name="id" value="<?php  echo $_GET['id']; ?>">

		                                            <div class="modal-body">

		                                                <div class="row container">

		                                                    <div class="col-sm-12">
		                                                        <div class="form-group">
		                                                            <div class="form-line">
										                                        <input style="display: block !important;" class="form-control" required="" accept=".jpg, .png" name="capa" id="file-input-capa" type="file" onchange="document.getElementById('a').src = window.URL.createObjectURL(this.files[0])">
		                                                            </div>
		                                                        </div>
		                                                    </div>

		                                                        
		                                                </div>

		                                             
		                                            </div>
		                                            <div class="modal-footer">
		                                                <button class="btn btn-outline-info" type="submit" value="salvar" name="save_thumb">Salvar</button>
		                                                <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Fechar</button>
		                                            </div>

		                                        </form>


		                                    </div>
		                                </div>
		                            </div>

	                        	<?php }else{?>

	                        			<?php  if ($dados11['thumb'] == '') { ?>
	                        				<img src="img/freelancer/Profile-Image1.jpg" alt="">
	                        			<?php  }else{ ?>
	                        				<img src="thumb/<?php  echo $dados11['thumb']; ?>" alt="">
	                        			<?php  } ?>
	                        	<?php }?>


	                           

	                        </div>
	                        <div class="profile-info">
	                           <div class="hourly-rate text-center">
	                           	
	                           	<?php  if ($dados1['id'] == $_SESSION['usuarioId'] OR $_SESSION['usuarioNiveisAcessoId'] == 3) { ?>
	                              <a style="width: 100%;" href="tel:<?php  echo $dados11['celular']; ?>" class="button-ymp form-control" data-toggle="modal">Ligar para <?php  echo $dados1['nome']; ?></a>
	                            <?php }elseif ($dados1['id'] != $_SESSION['usuarioId']) { ?>

	                              

	                              <?php  if (isset($dados30)) { ?>

	                              		<a style="width: 100%;" href="tel:<?php  echo $dados11['celular']; ?>" class="button-ymp form-control">Ligar para <?php  echo $dados1['nome']; ?></a>

	                              <?php }else{?>

	                              		<a style="width: 100%;" href="#blocked" class="button-ymp form-control" data-toggle="modal">Ligar para <?php  echo $dados1['nome']; ?></a>

	                              <?php }?>

	                             

	                            <?php }?>

	                           </div>
	                           
	                           <?php  if (isset($dados44)){ ?>
	                           		<div class="overviews">
	                              		<ul>
		                                	<li><span class="icon color-2"><i class="fas fa-check-circle"></i></span> Especialista</li>
		                              	</ul>
		                           </div>
	                           <?php  } ?>
	                           
	                           <div class="verification">
	                              <h4>Contatos 


	                              	<?php  if ($dados1['id'] == $_SESSION['usuarioId'] OR $_SESSION['usuarioNiveisAcessoId'] == 3) { ?>
	                              		
	                              		<a data-toggle="modal" role="button" href="#contatos" class="online" style="color: #afafaf; padding: 0px; font-size: 14px; float: right;"><i class="fas fa-share"></i> Editar</a>

	                              		<div class="modal fade text-left" id="contatos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel11" aria-hidden="true">
	                                        <div class="modal-dialog modal-lg" role="document">
	                                            <div class="modal-content">
	                                                <div class="modal-header bg-primary white">
	                                                    <h4 class="modal-title" id="myModalLabel11" style="font-size: 12px; color: white;">Torne suas formas de contato públicas.</h4>
	                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                                                        <span aria-hidden="true">&times;</span>
	                                                    </button>
	                                                </div>

	                                                <form method="POST" action="">
	                                                    
	                                                    <input type="hidden" name="id" value="<?php  echo $_GET['id']; ?>">

	                                                    <div class="modal-body">

	                                                        <div class="row container" style="font-size: 14px;">

	                                                            <div class="col-sm-12">
                                                            		<div class="form-group">
	                                                                    <div class="form-line">
	                                                                    	WhatsApp
	                                                                         <input value="<?php  echo $dados11['celular']; ?>" type="text" placeholder="Digite seu WhatsApp" class="form-control"  name="whatsapp">
	                                                                    </div>
	                                                                </div>
	                                                            </div>

	                                                            <div class="col-sm-12">
	                                                                <div class="form-group">
	                                                                    <div class="form-line">
	                                                                    	Facebook
	                                                                         <input value="<?php  echo $dados11['facebook']; ?>" type="text" placeholder="" class="form-control"  name="facebook">
	                                                                    </div>
	                                                                </div>
	                                                            </div>

	                                                            <div class="col-sm-12">
	                                                                <div class="form-group">
	                                                                    <div class="form-line">
	                                                                    	Instagram
	                                                                         <input value="<?php  echo $dados11['instagram']; ?>" type="text" placeholder="" class="form-control"  name="instagram">
	                                                                    </div>
	                                                                </div>
	                                                            </div>

	                                                            <div class="col-sm-12">
	                                                                <div class="form-group">
	                                                                    <div class="form-line">
	                                                                    	Linkedin
	                                                                         <input value="<?php  echo $dados11['linkedin']; ?>" type="text" placeholder="" class="form-control"  name="linkedin">
	                                                                    </div>
	                                                                </div>
	                                                            </div>

	                                                            
	                                                            

	                                                                
	                                                        </div>

	                                                     
	                                                    </div>
	                                                    <div class="modal-footer">
	                                                        <button class="btn btn-outline-info" type="submit" value="salvar" name="save_contatos">Salvar</button>
	                                                        <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Fechar</button>
	                                                    </div>

	                                                </form>


	                                            </div>
	                                        </div>
	                                    </div>

	                              	<?php  } ?>

	                              	

	                              </h4>
	                              <ul>
	                                 

	                              	

	                             	<?php  if ($dados11['id_usuarios'] != $_SESSION['usuarioId']) { ?>
	                             		
	                             		<?php  if (isset($dados30)) { ?>
	                             			
			                                 <?php  if ($dados11['facebook'] == ''){ ?>
			                                 	<a href="#" data-toggle="modal" role="button">
			                                 		<li>Facebook
				                                 		<span><i class="fas fa-minus"></i></span>
				                                	</li>
				                            	</a>
			                                 <?php }else{?>
				                                <a href="<?php  echo $dados11['facebook']; ?>">
			                                 		<li>Facebook
				                                 		<span><i class="fas fa-check"></i></span>
				                                	</li>
				                            	</a>
			                                 <?php }?>

			                                 <?php  if ($dados11['instagram'] == ''){ ?>
			                                 	<a href="#" data-toggle="modal" role="button">
			                                 		<li>Instagram
				                                 		<span><i class="fas fa-minus"></i></span>
				                                	</li>
				                            	</a>
			                                 <?php }else{?>
				                                <a href="<?php  echo $dados11['instagram']; ?>">
			                                 		<li>Instagram
				                                 		<span><i class="fas fa-check"></i></span>
				                                	</li>
				                            	</a>
			                                 <?php }?>

			                                 <?php  if ($dados11['linkedin'] == ''){ ?>
			                                 	<a href="#" data-toggle="modal" role="button">
			                                 		<li>Linkedin
				                                 		<span><i class="fas fa-minus"></i></span>
				                                	</li>
				                            	</a>
			                                 <?php }else{?>
				                                <a href="<?php  echo $dados11['linkedin']; ?>">
			                                 		<li>Linkedin
				                                 		<span><i class="fas fa-check"></i></span>
				                                	</li>
				                            	</a>
			                                 <?php }?>

			                                 <?php  if ($dados11['celular'] == ''){ ?>
			                                 	<a href="#" data-toggle="modal" role="button">
			                                 		<li>WhatsApp
				                                 		<span><i class="fas fa-minus"></i></span>
				                                	</li>
				                            	</a>
			                                 <?php }else{?>
				                                <a href="tel:<?php  echo $dados11['celular']; ?>">
			                                 		<li>WhatsApp
				                                 		<span><i class="fas fa-check"></i></span>
				                                	</li>
				                            	</a>
			                                 <?php }?>

	                             		<?php  }else{ ?>

	                             			<?php  if ($dados11['facebook'] == ''){ ?>
			                                 	<a href="#blocked" data-toggle="modal" role="button">
			                                 		<li>Facebook
				                                 		<span><i class="fas fa-minus"></i></span>
				                                	</li>
				                            	</a>
			                                <?php }else{?>
				                                <a href="#blocked" data-toggle="modal" role="button">
			                                 		<li>Facebook
				                                 		<span><i class="fas fa-check"></i></span>
				                                	</li>
				                            	</a>
			                                <?php }?>

			                                <?php  if ($dados11['instagram'] == ''){ ?>
			                                 	<a href="#blocked" data-toggle="modal" role="button">
			                                 		<li>Instagram
				                                 		<span><i class="fas fa-minus"></i></span>
				                                	</li>
				                            	</a>
			                                <?php }else{?>
				                                <a href="#blocked" data-toggle="modal" role="button">
			                                 		<li>Instagram
				                                 		<span><i class="fas fa-check"></i></span>
				                                	</li>
				                            	</a>
			                                <?php }?>

			                                <?php  if ($dados11['linkedin'] == ''){ ?>
			                                 	<a href="#blocked" data-toggle="modal" role="button">
			                                 		<li>Linkedin
				                                 		<span><i class="fas fa-minus"></i></span>
				                                	</li>
				                            	</a>
			                                <?php }else{?>
				                                <a href="#blocked" data-toggle="modal" role="button">
			                                 		<li>Linkedin
				                                 		<span><i class="fas fa-check"></i></span>
				                                	</li>
				                            	</a>
			                                <?php }?>

			                                <?php  if ($dados11['celular'] == ''){ ?>
			                                 	<a href="#blocked" data-toggle="modal" role="button">
			                                 		<li>WhatsApp
				                                 		<span><i class="fas fa-minus"></i></span>
				                                	</li>
				                            	</a>
			                                <?php }else{?>
				                                <a href="#blocked" data-toggle="modal" role="button">
			                                 		<li>WhatsApp
				                                 		<span><i class="fas fa-check"></i></span>
				                                	</li>
				                            	</a>
			                                <?php }?>

	                             		<?php }?>

	                             	<?php  }else{ ?>

	                             		<?php  if ($dados11['facebook'] == ''){ ?>
		                                 	<a href="#" data-toggle="modal" role="button">
		                                 		<li>Facebook
			                                 		<span><i class="fas fa-minus"></i></span>
			                                	</li>
			                            	</a>
		                                <?php }else{?>
			                                <a href="<?php  echo $dados11['facebook']; ?>">
		                                 		<li>Facebook
			                                 		<span><i class="fas fa-check"></i></span>
			                                	</li>
			                            	</a>
		                                <?php }?>

		                                <?php  if ($dados11['instagram'] == ''){ ?>
		                                 	<a href="#" data-toggle="modal" role="button">
		                                 		<li>Instagram
			                                 		<span><i class="fas fa-minus"></i></span>
			                                	</li>
			                            	</a>
		                                <?php }else{?>
			                                <a href="<?php  echo $dados11['instagram']; ?>">
		                                 		<li>Instagram
			                                 		<span><i class="fas fa-check"></i></span>
			                                	</li>
			                            	</a>
		                                <?php }?>

		                                <?php  if ($dados11['linkedin'] == ''){ ?>
		                                 	<a href="#" data-toggle="modal" role="button">
		                                 		<li>Linkedin
			                                 		<span><i class="fas fa-minus"></i></span>
			                                	</li>
			                            	</a>
		                                <?php }else{?>
			                                <a href="<?php  echo $dados11['linkedin']; ?>">
		                                 		<li>Linkedin
			                                 		<span><i class="fas fa-check"></i></span>
			                                	</li>
			                            	</a>
		                                <?php }?>

		                                <?php  if ($dados11['celular'] == ''){ ?>
		                                 	<a href="#" data-toggle="modal" role="button">
		                                 		<li>WhatsApp
			                                 		<span><i class="fas fa-minus"></i></span>
			                                	</li>
			                            	</a>
		                                <?php }else{?>
			                                <a href="tel:<?php  echo $dados11['celular']; ?>">
		                                 		<li>WhatsApp
			                                 		<span><i class="fas fa-check"></i></span>
			                                	</li>
			                            	</a>
		                                <?php }?>

	                             	<?php }?>	             

	                              </ul>
	                           </div>
	                           <div class="top-skills">
	                              <h4>Área ou Nicho

	                              	<?php  if ($dados1['id'] == $_SESSION['usuarioId'] OR $_SESSION['usuarioNiveisAcessoId'] == 3) { ?>
	                              		
	                              		<a data-toggle="modal" role="button" href="#habilidades" class="online" style="color: #afafaf; padding: 0px; font-size: 14px; float: right;"><i class="fas fa-share"></i> Editar</a>

	                              		<div class="modal fade text-left" id="habilidades" tabindex="-1" role="dialog" aria-labelledby="myModalLabel11" aria-hidden="true">
	                                        <div class="modal-dialog modal-lg" role="document">
	                                            <div class="modal-content">
	                                                <div class="modal-header bg-primary white">
	                                                    <h4 class="modal-title" id="myModalLabel11" style="font-size: 15px; color: white;">Defina sua área de atuação.</h4>
	                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                                                        <span aria-hidden="true">&times;</span>
	                                                    </button>
	                                                </div>

	                                                <form method="POST" action="">
	                                                    
	                                                    <input type="hidden" name="id" value="<?php  echo $_GET['id']; ?>">

	                                                    <div class="modal-body">

	                                                        <div class="row container">

	                                                            <div class="col-sm-12">
	                                                                <div class="form-group">
	                                                                    <div class="form-line" style="font-size: 14px;">

	                                                                    	<?php 
	                                                                    		$sql13 = "SELECT * FROM habilidades";
	                                                                    		$query13 = mysqli_query($mysqli, $sql13);
	                                                                    	?>

	                                                                    	<?php  while($dados13 = mysqli_fetch_array($query13)){ 

	                                                                    		$sql14 = "SELECT * FROM habilidades_usuarios WHERE habilidade = '".$dados13['nome']."' AND id_usuarios = '".$_GET['id']."'";
	                                                                    		$query14 = mysqli_query($mysqli, $sql14);
	                                                                    		$dados14 = mysqli_fetch_assoc($query14);

	                                                                    	

	                                                                    		if (isset($dados14)) {
	                                                                    			$display = 'block';
	                                                                    		}else{
	                                                                    			$display = 'none';
	                                                                    		}

	                                                                    		// VAMOS MOSTRAR TODAS AS SUB HABILIDADES

	                                                                    		$sql16 = "SELECT * FROM subhabilidades WHERE id_habilidades = '".$dados13['id']."'";
	                                                                    		$query16 = mysqli_query($mysqli, $sql16);

	                                                                    	?>

		                                                                    	<?php  if (isset($dados14)) { ?>

		                                                                    		<input id="mycheck<?php  echo $dados13['id']; ?>" onclick="abrir<?php  echo $dados13['id']; ?>();" checked="" style="margin-right: 20px;" value="<?php  echo $dados14['habilidade'] ?>" type="checkbox" class=""  name="habilidades[]"> <?php  echo $dados14['habilidade'] ?>

		                                                                    		<br>	
		                                                                    	<?php }else{?>
		                                                                    		
		                                                                    		<input onclick="abrir<?php  echo $dados13['id']; ?>();" id="mycheck<?php  echo $dados13['id']; ?>" style="margin-right: 20px;" value="<?php  echo $dados13['nome'] ?>" type="checkbox" class=""  name="habilidades[]"> <?php  echo $dados13['nome'] ?>

		                                                                    		<br>
		                                                                    	<?php }?>

			                                                                    	<div id="cad<?php  echo $dados13['id']; ?>" style="display: <?php  echo $display; ?>; padding-left: 40px;">

	                                                                    				<?php  while($dados16 = mysqli_fetch_array($query16)){ 

	                                                                    						$sql17 = "SELECT * FROM subhabilidades_usuarios WHERE id_habilidades = '".$dados13['id']."' AND id_usuarios = '".$_GET['id']."' AND subhabilidade = '".$dados16['nome']."' ";
					                                                                    		$query17 = mysqli_query($mysqli, $sql17);
					                                                                    		$dados17 = mysqli_fetch_assoc($query17);

	                                                                    				?>

	                                                                    					<?php  if (isset($dados17)) { ?>
	                                                                    						<input checked="" style="margin-right: 20px;" value="<?php  echo $dados16['nome']; ?>" type="checkbox" class=""  name="subhabilidades[]"> <?php  echo $dados16['nome']; ?>
		                                                                    					<br>
	                                                                    					<?php }else{?>
	                                                                    						<input style="margin-right: 20px;" value="<?php  echo $dados16['nome']; ?>" type="checkbox" class=""  name="subhabilidades[]"> <?php  echo $dados16['nome']; ?>
		                                                                    					<br>
	                                                                    					<?php }?>

		                                                                    				
		                                                                    			<?php }?>

		                                                                    		</div>

		                                                                    	<script type="text/javascript">
                                    
													                                    function abrir<?php  echo $dados13['id']; ?>(){

													                                    	if(document.getElementById('mycheck<?php  echo $dados13['id']; ?>').checked) {
													                                    			document.getElementById('cad<?php  echo $dados13['id']; ?>').style.display="block";
													                                    		}else{
													                                    			document.getElementById('cad<?php  echo $dados13['id']; ?>').style.display="none";
													                                    		}

													                                        //document.getElementById('cad2').style.display="none";
													                                    }
													                            </script>



	                                                                    	<?php }?>

	                                                                    	
	                                                                         
	                                                                    </div>
	                                                                </div>
	                                                            </div>

	                                                        </div>

	                                                     
	                                                    </div>
	                                                    <div class="modal-footer">
	                                                        <button class="btn btn-outline-info" type="submit" value="salvar" name="save_habilidades">Salvar</button>
	                                                        <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Fechar</button>
	                                                    </div>

	                                                </form>


	                                            </div>
	                                        </div>
	                                    </div>

	                              	<?php  } ?>


	                              </h4>
	                              <ul>
	                              	<?php  while($dados15 = mysqli_fetch_array($query15)){ ?>
	                                 <li><?php  echo $dados15['habilidade']; ?></li>
	                                <?php }?>
	                              </ul>
	                           </div>
	                        </div>
                     	</div>
                  	</div>
                  	<div class="col-sm-12 col-md-7 col-lg-8">
	                    <div class="freelancer-info">
	                        <div class="freelancer-detail">
	                           <h4 class="freelancer-name"><?php  echo $dados1['nome']; ?></h4>
	                           <h4 class="profile-title">

	                           	<?php  if ($dados11['titulo'] == '') {
	                           		echo "Título";
	                           	}else{
	                           		echo $dados11['titulo']; 
	                           	} ?> 

	                           			<?php  if ($dados1['id'] == $_SESSION['usuarioId'] OR $_SESSION['usuarioNiveisAcessoId'] == 3) { ?>
			                           		<br><a data-toggle="modal" role="button" href="#titulo" class="online" style="color: #afafaf; padding: 0px;"><i class="fas fa-share"></i> Editar</a>


			                           		<div class="modal fade text-left" id="titulo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel11" aria-hidden="true">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-primary white">
                                                            <h4 class="modal-title" id="myModalLabel11" style="font-size: 12px; color: white;">Crie um título atraente para tornar publico em seu perfil</h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>

                                                        <form method="POST" action="">
                                                            
                                                            <input type="hidden" name="id" value="<?php  echo $_GET['id']; ?>">

                                                            <div class="modal-body">

                                                                <div class="row container">

                                                                    <div class="col-sm-12">
                                                                        <div class="form-group">
                                                                            <div class="form-line">
                                                                                 <textarea placeholder="Ex: Gestor de Tráfego" class="form-control" rows="5" name="titulo"><?php  echo $dados11['titulo']; ?></textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                        
                                                                </div>

                                                             
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button class="btn btn-outline-info" type="submit" value="salvar" name="save_titulo">Salvar</button>
                                                                <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Fechar</button>
                                                            </div>

                                                        </form>


                                                    </div>
                                                </div>
                                            </div>

			                           	<?php  } ?>

	                           </h4>
	                           <p>

	                           <?php  if ($dados11['descricao'] == '') {
	                           		echo "Descrição";
	                           	}else{
	                           		echo nl2br($dados11['descricao']); 
	                           	} ?>  

	                           	<?php  if ($dados1['id'] == $_SESSION['usuarioId'] OR $_SESSION['usuarioNiveisAcessoId'] == 3) { ?>
	                           		
	                           		<br><a data-toggle="modal" role="button" href="#descricao" class="online" style="color: #afafaf; padding: 0px;"><i class="fas fa-share"></i> Editar</a>

	                           		<div class="modal fade text-left" id="descricao" tabindex="-1" role="dialog" aria-labelledby="myModalLabel11" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header bg-primary white">
                                                    <h4 class="modal-title" id="myModalLabel11" style="font-size: 12px; color: white;">Fale um pouco sobre você e suas habilidades.</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>

                                                <form method="POST" action="">
                                                    
                                                    <input type="hidden" name="id" value="<?php  echo $_GET['id']; ?>">

                                                    <div class="modal-body">

                                                        <div class="row container">

                                                            <div class="col-sm-12">
                                                                <div class="form-group">
                                                                    <div class="form-line">
                                                                         <textarea placeholder="Ex: Sou especialista em criação de conteúdos, trabalho diretamente com copywriting e já participei de grandes projetos." class="form-control" rows="5" name="descricao"><?php  echo $dados11['descricao']; ?></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                                
                                                        </div>

                                                     
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-outline-info" type="submit" value="salvar" name="save_descricao">Salvar</button>
                                                        <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Fechar</button>
                                                    </div>

                                                </form>


                                            </div>
                                        </div>
                                    </div>

	                           	<?php  } ?>
	                           	

	                           </p>
	                        </div>

	                        <div class="recent-reviews">
	                           <h3>Resultados</h3>
	                           <?php  if ($dados1['id'] == $_SESSION['usuarioId'] OR $_SESSION['usuarioNiveisAcessoId'] == 3) { ?>
	                              		
	                              		<a data-toggle="modal" role="button" href="#resultados" class="online" style="color: #afafaf; padding: 0px; font-size: 14px; float: right;"><i class="fas fa-share"></i> Editar</a>

	                              		<div class="modal fade text-left" id="resultados" tabindex="-1" role="dialog" aria-labelledby="myModalLabel11" aria-hidden="true">
	                                        <div class="modal-dialog modal-lg" role="document">
	                                            <div class="modal-content">
	                                                <div class="modal-header bg-primary white">
	                                                    <h4 class="modal-title" id="myModalLabel11" style="font-size: 12px; color: white;">Qual a sua experiência nessa área e quais principais resultados já gerou?</h4>
	                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                                                        <span aria-hidden="true">&times;</span>
	                                                    </button>
	                                                </div>

	                                                <form method="POST" action="">
	                                                    
	                                                    <input type="hidden" name="id" value="<?php  echo $_GET['id']; ?>">

	                                                    <div class="modal-body">

	                                                        <div class="row container" style="font-size: 14px;">

	              												<textarea class="form-control" rows="5" name="descricao"><?php  echo $dados11['resultado']; ?></textarea>
	                 
	                                                                
	                                                        </div>

	                                                     
	                                                    </div>
	                                                    <div class="modal-footer">
	                                                        <button class="btn btn-outline-info" type="submit" value="salvar" name="save_resultado">Salvar</button>
	                                                        <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Fechar</button>
	                                                    </div>

	                                                </form>


	                                            </div>
	                                        </div>
	                                    </div>
	                           <?php  } ?>                           
	                        </div>

	                       	<p class="col-md-12 form-group" style="padding-bottom: 20px; padding-top: 10px; background-color: #e8e8e8; margin-bottom: 20px;">
	                       		<?php  echo nl2br($dados11['resultado']) ?>
	                       	</p>

	                        <div class="recent-reviews">
	                           <h3>Treinamentos</h3>
	                           <?php  if ($dados1['id'] == $_SESSION['usuarioId'] OR $_SESSION['usuarioNiveisAcessoId'] == 3) { ?>
	                              		
	                              		<a data-toggle="modal" role="button" href="#treinamento" class="online" style="color: #afafaf; padding: 0px; font-size: 14px; float: right;"><i class="fas fa-share"></i> Editar</a>

	                              		<div class="modal fade text-left" id="treinamento" tabindex="-1" role="dialog" aria-labelledby="myModalLabel11" aria-hidden="true">
	                                        <div class="modal-dialog modal-lg" role="document">
	                                            <div class="modal-content">
	                                                <div class="modal-header bg-primary white">
	                                                    <h4 class="modal-title" id="myModalLabel11" style="font-size: 12px; color: white;">Quais treinamentos, comunidades e eventos que você participa ou já participou e que foram relevantes para seu crescimento pessoal e profissional?</h4>
	                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                                                        <span aria-hidden="true">&times;</span>
	                                                    </button>
	                                                </div>

	                                                <form method="POST" action="">
	                                                    
	                                                    <input type="hidden" name="id" value="<?php  echo $_GET['id']; ?>">

	                                                    <div class="modal-body">

	                                                        <div class="row container" style="font-size: 14px;">

	              												<textarea placeholder="" class="form-control" rows="5" name="descricao"><?php  echo $dados11['treinamentos']; ?></textarea>
	                 
	                                                                
	                                                        </div>

	                                                     
	                                                    </div>
	                                                    <div class="modal-footer">
	                                                        <button class="btn btn-outline-info" type="submit" value="salvar" name="save_treinamento">Salvar</button>
	                                                        <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Fechar</button>
	                                                    </div>

	                                                </form>


	                                            </div>
	                                        </div>
	                                    </div>
	                           <?php  } ?>
	                        </div>

	                      	<p class="col-md-12" style="padding-bottom: 20px; padding-top: 10px; background-color: #e8e8e8; margin-bottom: 20px;">
	                      		<?php  echo nl2br($dados11['treinamentos']) ?>
	                      	</p>

	                      	<!--
	                        <div class="recent-reviews">
	                           <h3>Avaliações Recentes</h3>
	                        </div>
	                        
	                        <div class="review-wrapper">
	                           <a href="#"><img src="img/company-logo/logo1.jpg" alt=""></a>
	                           <div class="project-review">
		                            <h5>Coprodutor de projetos</h5>
		                              	<ul class="client-rating">
			                                <li>05</li>
			                                <li><i class="fas fa-star"></i></li>
			                                <li><i class="fas fa-star"></i></li>
			                                <li><i class="fas fa-star"></i></li>
			                                <li><i class="fas fa-star"></i></li>
			                                <li><i class="fas fa-star"></i></li>
		                              	</ul>
		                            <div class="review-detail">
		                                <p>“Excelente profissional”</p>
		                                <div class="client">
		                                    <p>- Jonas Silva</p>
		                                </div>
		                                <br>
		                                <ul class="category-ch">
		                                    <li><a href="#">TI e Programação</a></li>
		                                    <li><a href="#">Logo Design,</a></li>
		                                    <li><a href="#">Photoshop,</a></li>
		                                </ul>
		                            </div>
	                           </div>
	                        </div>
	                    	-->
	                    	
	                    </div>
	                </div>

	                <div class="modal fade" id="blocked" role="dialog" tabindex="-1" aria-hidden="true">
					    <div class="modal-dialog">
					      	<div class="modal-content unread-notification" style="margin-top: 140px;"> 
						        <div class="modal-body">
							    	<div class="chatting-page">
							    		<div class="chat-freelancers">


											<div class="">
												<ul>
													<li>
														<div class="notification-details">
															<p class="notification-text">
																Para liberar as formas de contato deste usuário, realiza uma proposta e selecione este profissional.
															</p>
														</div>
													</li>
												</ul>
											</div>

					                    
										</div>
							    	</div>
						    	</div>  
					    	</div>
						</div>
					</div>

               	</div>
            </div>
        </div>
	</section>
	
    <footer>
        <div class="container wow animate__animated animate__fadeIn animate__slow">
            <div class="footer-part-1">
                <div class="row">
                    <div class="col-md-6 mb-5 text-center text-sm-left">
                        <h2 class="sub-heading text-white">Inscreva-se em nossa Newsletter</h2>
                        <p class="footer-sub-title mt-3">Inscreva-se em nossa lista e fique por dentro de todas as novidades.</p>
                    </div>
                    <div class="col-md-5 col-lg-6 align-self-center text-center img-fluid">
                        <div class="row">
                            <div class="col-sm-8 align-self-center mb-4 img-fluid">
                              <input class="w-100 img-fluid text-center text-sm-left" type="email" placeholder="Seu E-mail">
                            </div>
                            <div class="col-sm-4 align-self-center mb-4 img-fluid">
                              <a class="w-100 d-block d-sm-inline img-fluid" href="#">Inscreva-se</a>
                            </div>
                        </div>
                    </div>
                </div>
              </div>
          <div class="footer-part-2">
            <div class="row text-center text-sm-left">
                <div class="col-sm-6 col-lg-3">
                  <img width="100" src="Geets_Logo_contorno1.png" alt="footer-logo">
                  <p class="footer-para mt-5">A Geets é para quem acredita na transformação através de negócios digitais. </p>
                  <div class="footer-social-icon mt-4 mb-5 pb-3">
                    <a href="#"><i class="fab fa-facebook-f text-light"></i></a>
                    <a href="#"><i class="fab fa-twitter text-light"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in text-light"></i></a>
                    <a href="#"><i class="fab fa-pinterest text-light"></i></a>
                  </div>
                </div>
                <div class="d-none d-lg-block col-lg-5"></div>
                <div class="col-sm-3 col-lg-2 mb-5">
                  <div class="footer-sub-heading">Navegação</div>
                  <div class="footer-link pt-2">
                    <p><a href="#">A Geets</a> </p>
                    <p><a href="#">Sobre</a></p>
                    <p><a href="#">Como Funciona</a></p>
                    <p><a href="#">Depoimentos</a></p>
                  </div>
                </div>
                <div class="col-sm-3 col-lg-2 mb-5">
                  <div class="footer-sub-heading">Contato</div>
                  <div class="footer-contact pt-2">
                    <p>contato@geets.com.br</p>
                    <p>Rua Conselheiro Laurindo, 1138. Curitiba/PR</p>
                  </div>
                </div>
            </div>
          </div>
          <div class="footer-part-3 copyright text-left">
            <div class="row">
              <div class="col-sm-6 col-md-7 mt-3 text-center text-sm-left align-self-center">
                <p>Todos os direitos reservados - Geets 2020</p>
              </div>
              <div class="col-sm-6 col-md-5 text-center align-self-center">
                <span class="mr-5 right-border">Termos de Uso</span>
                <span>Política de Privacidade</span>
              </div>
            </div>
          </div>
        </div>
      </footer>


	<script src="js/vendor/popper.min.js"></script>
	<script src="js/vendor/bootstrap.min.js"></script>
	<script src="js/vendor/font-awesome.js"></script>
  	<script src="js/vendor/isotope.pkgd.min.js"></script>
  	<script src="js/vendor/imagesloaded.pkgd.min.js"></script>
  	<script src="js/portfolio.js"></script>
	<script src="js/index.js"></script>

</body>
</html>