<?php 
session_start();

$mysqli = new mysqli('localhost','root','','id15265491_geets');
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

// Verifica se o usuário já visitou esse perfil
if($_SESSION['usuarioId'] != $_GET['id']){
    $consultaQuery = $mysqli->query("SELECT * FROM visitas WHERE id_visitante = ".$_SESSION['usuarioId']." AND id_ND = ".$_GET['id']."");
    $consulta = $consultaQuery->num_rows;
    if($consulta == 0){
        $regVisit = $mysqli->query("INSERT INTO visitas VALUES (default, ".$_SESSION['usuarioId'].",".$_GET['id'].")");
    }
}

// Conta as visitas que o perfil já recebeu
$visitas = $mysqli->query("SELECT * FROM visitas WHERE id_ND = ".$_GET['id']."");
$visitas = $visitas->num_rows;
if($dados1['id_tipo_perfil'] == 1){
	$sql11 = "SELECT * FROM usuarios WHERE id = '".$_GET['id']."'";
	$query11 = mysqli_query($mysqli, $sql11);
	$dados11 = mysqli_fetch_assoc($query11);
}
elseif($dados1['id_tipo_perfil'] == 2){
	$sql11 = "SELECT * FROM perfil_expert WHERE id_usuario = '".$_GET['id']."'";
	$query11 = mysqli_query($mysqli, $sql11);
	$dados11 = mysqli_fetch_assoc($query11);
}
elseif($dados1['id_tipo_perfil'] == 3){
	$sql11 = "SELECT * FROM perfil_profissional WHERE id_usuario = '".$_GET['id']."'";
	$query11 = mysqli_query($mysqli, $sql11);
	$dados11 = mysqli_fetch_assoc($query11);
}
$sql15 = "SELECT * FROM habilidades_usuarios WHERE id_usuario = '".$_GET['id']."'";
$query15 = mysqli_query($mysqli, $sql15);

if (isset($_POST['save_descricao'])) {
        
    $sql2 = "UPDATE usuarios SET descricao = '".$mysqli->real_escape_string($_POST['descricao'])."' WHERE id_usuario = '".$_POST['id']."'";
    $query2 =  mysqli_query($mysqli, $sql2);

    header("Location: profile-nd.php?id=".$_POST['id']."&success");

}

if (isset($_POST['save_modelo_negocio'])) {
        
	$sql2 = "UPDATE usuarios SET modelo_negocio = '".$mysqli->real_escape_string($_POST['modelo_negocio'])."' WHERE id_usuario = '".$_POST['id']."'";
	$query2 =  mysqli_query($mysqli, $sql2);
	$mysqli->query("UPDATE usuarios SET titulo = '".$mysqli->real_escape_string($_POST['modelo_negocio'])."' WHERE id = '".$_POST['id']."'");

    header("Location: profile-nd.php?id=".$_POST['id']."&success");


}

if (isset($_POST['save_contatos'])) {
        
    $sql2 = "UPDATE usuarios SET facebook = '".$_POST['facebook']."',instagram = '".$_POST['instagram']."',youtube = '".$_POST['youtube']."'  WHERE id_usuario = '".$_POST['id']."'";
    $query2 =  mysqli_query($mysqli, $sql2);

    header("Location: profile-nd.php?id=".$_POST['id']."&success");


}

if (isset($_POST['save_pilares'])) {
        
    $sql2 = "UPDATE usuarios SET pilares = '".$mysqli->real_escape_string($_POST['pilares'])."' WHERE id_usuario = '".$_POST['id']."'";
    $query2 =  mysqli_query($mysqli, $sql2);

    header("Location: profile-nd.php?id=".$_POST['id']."&success");


}

if (isset($_POST['save_sede'])) {
        
    $sql2 = "UPDATE usuarios SET sede = '".$mysqli->real_escape_string($_POST['sede'])."' WHERE id_usuario = '".$_POST['id']."'";
    $query2 =  mysqli_query($mysqli, $sql2);

    header("Location: profile-nd.php?id=".$_POST['id']."&success");


}

if (isset($_POST['save_resultados'])) {
        
    $sql2 = "UPDATE usuarios SET resultados = '".$mysqli->real_escape_string($_POST['resultados'])."' WHERE id_usuario = '".$_POST['id']."'";
    $query2 =  mysqli_query($mysqli, $sql2);

    header("Location: profile-nd.php?id=".$_POST['id']."&success");


}

if (isset($_POST['save_fat-mercado'])) {
        
    $sql2 = "UPDATE usuarios SET tempo_mercado = '".$_POST['tempo_mercado']."', movimentacao = '".$_POST['movimentacao']."' WHERE id_usuario = '".$_POST['id']."'";
    $query2 =  mysqli_query($mysqli, $sql2);

    header("Location: profile-nd.php?id=".$_POST['id']."&success");

}

if (isset($_POST['save_thumb'])) {
    
    $diretorio = "thumb/";

    $capa = isset($_FILES['capa']) ? $_FILES['capa'] : FALSE;
    $m = md5($_POST['id']);
    $destino1 = $diretorio."/"."1".$m.$capa['name'];
    move_uploaded_file($capa['tmp_name'], $destino1);

    $capa = "1".$m.$capa['name'];

    $sql2 = "UPDATE usuarios SET thumb = '".$capa."' WHERE id_usuario = '".$_POST['id']."'";
    $query2 =  mysqli_query($mysqli, $sql2);
	$updateImagem = $mysqli->query("UPDATE usuarios SET thumb = '$capa' WHERE id = ".$_POST['id']."");

    header("Location: profile-nd.php?id=".$_POST['id']."&success");

}

if ($_SESSION['usuarioNiveisAcessoId'] == 2) {
    $retorno = "home.php";
}elseif ($_SESSION['usuarioNiveisAcessoId'] == 1) {
    $retorno = "home.php";
}

if (isset($_POST['save_habilidades'])) {

    $sql21 = "DELETE FROM habilidades_usuarios WHERE id_usuario = '".$_POST['id']."'";
    $query21 = mysqli_query($mysqli, $sql21);

    $sql211 = "DELETE FROM subhabilidades_usuarios WHERE id_usuario = '".$_POST['id']."'";
    $query211 = mysqli_query($mysqli, $sql211);

    foreach ($_POST['habilidades'] as $key => $value) {

        $sql22 = "INSERT INTO habilidades_usuarios (id_usuario, habilidade) VALUES ('".$_POST['id']."','".$value."')";
        $query22 = mysqli_query($mysqli, $sql22);

    }

    foreach ($_POST['subhabilidades'] as $key => $value) {

        $sql233 = "SELECT * FROM subhabilidades WHERE nome = '".$value."'";
        $query233 = mysqli_query($mysqli, $sql233);
        $dados233 = mysqli_fetch_assoc($query233);

        $sql23 = "INSERT INTO subhabilidades_usuarios (id_usuario, subhabilidade, id_habilidades) VALUES ('".$_POST['id']."','".$value."','".$dados233['id_habilidades']."')";
        $query23 = mysqli_query($mysqli, $sql23);

    }
        

    header("Location: profile-nd.php?id=".$_POST['id']."&success");


}

if (isset($_POST['save_treinamento'])) {
        
    $sql2 = "UPDATE usuarios SET treinamentos = '".$_POST['descricao']."' WHERE id_usuario = '".$_POST['id']."'";
    $query2 =  mysqli_query($mysqli, $sql2);

    header("Location: profile-nd.php?id=".$_POST['id']."&success");


}

if (isset($_POST['save_resultado'])) {
        
    $sql2 = "UPDATE usuarios SET resultado = '".$_POST['descricao']."' WHERE id_usuario = '".$_POST['id']."'";
    $query2 =  mysqli_query($mysqli, $sql2);

    header("Location: profile-nd.php?id=".$_POST['id']."&success");


}

// ANALISE PARA VER SE DESBLOQUEIA OS DADOS DESTE USUÁRIO

$sql30 = "SELECT * FROM propostas WHERE status = 1 AND id_usuario = '".$_GET['id']."' AND id_projeto IN (SELECT id FROM projetos WHERE id_usuario = '".$_SESSION['usuarioId']."')";
$query30 = mysqli_query($mysqli, $sql30);
$dados30 = mysqli_fetch_assoc($query30);

$resultExp = $mysqli->query("SELECT * FROM aplicacao_expert WHERE id_ND = '".$_GET['id']."'");
$resultPf = $mysqli->query("SELECT * FROM aplicacao_profissional WHERE id_ND = '".$_GET['id']."'");
$categoria = $mysqli->query("SELECT * FROM habilidades 
INNER JOIN habilidades_usuarios 
ON habilidades.id = habilidades_usuarios.habilidade
WHERE habilidades_usuarios.id_usuario = '".$_GET['id']."'");
$categoria = $categoria->fetch_assoc();
$subcategoria = $mysqli->query("SELECT * FROM subhabilidades INNER JOIN  subhabilidades_usuarios WHERE subhabilidades_usuarios.id_usuario = '".$_GET['id']."'");
$subcategoria = $subcategoria->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width,initial-scale=1">
		<meta name="application-name" content="">
		<meta name="description" content="">
		<title><?php echo("Perfil de ".$dados11['nome']) ?></title>
	
		<link rel="stylesheet" href="dist/css/vendor/bootstrap.min.css">
		<link rel="stylesheet" href="dist/css/main.css">
		<link rel="stylesheet" href="css/custom.css">
		<link rel="stylesheet" href="css/responsive.css">

		<style>
		    .overviews ul li p.blue {
              background-color: var(--color-two);
              color: #ffffff;
              width: 7rem;
              max-width: 10rem;
            }
		</style>
	</head>
<body>
<?php 
	include "header.php";
?>

<!-- header.php -->
	<section id="freelancer-portfolio" style="background: url(img/freelancer/freelancer-profile-bg.jpg);">
        <div class="container">
            <div class="freelancer-portfolio">
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
							<?php  
							if($_SESSION['usuarioId'] != $_GET['id']){
								echo('
									<form class="aplicacao-button mb-5" action="aplicacao-exp.php" method="POST">
										<button type="submit" class="form-control button-aplicacao w-75 text-center" data-toggle="modal" data-target="#hire-me">Enviar mensagem</button>
									</form>');
							}
							?>
	                           <!--<div class="overviews md-none">
									<a data-toggle="modal" role="button" href="#contatos" class="online" style="color: #afafaf; padding: 0px; font-size: 14px; float: right;"><i class="fas fa-share"></i> Editar</a>
	                              <ul>
	                                 <li><span class="icon color-1"><i class="fas fa-star"></i></span> Aplicações Recebidas<span class="yellow">5.0</span></li>
	                                 <li><span class="icon color-2"><i class="fas fa-check-circle"></i></span> Visitas ao Perfil <span class="blue">100%</span></li>
	                                 <li><span class="icon color-3"><i class="fas fa-dollar-sign"></i></span> Faturamento </li>
	                                 <li><span class="icon color-4"><i class="fas fa-clock"></i></span> Tempo de Mercado <span class="red"></span></li>
	                              </ul>
							   </div>-->
							   
								<!--== INÍCIO DO MODAL ==-->
								   <?php  if ($dados1['id'] == $_SESSION['usuarioId'] || $_SESSION['usuarioNiveisAcessoId'] == 3) { ?>
									
									<br><a data-toggle="modal" role="button" href="#overview" class="online" style="color: #afafaf; padding: 0px;"><i class="fas fa-share"></i> Editar</a>
	                              	
	                              		<div class="modal fade text-left" id="overview" tabindex="-1" role="dialog" aria-labelledby="myModalLabel11" aria-hidden="true">
	                                        <div class="modal-dialog modal-lg" role="document">
	                                            <div class="modal-content">
	                                                <div class="modal-header bg-primary white">
	                                                    <h4 class="modal-title" id="myModalLabel11" style="font-size: 12px; color: white;">Editar Informações.</h4>
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
																			Faturamento
                                                                                <select class="form-control form-control-lg" id="movimentacao" name="movimentacao">
                                                                                    <option value="0 a 4 dígitos"> 0 a 4 dígitos </option>
                                                                                    <option value="+ 4 dígitos"> + 4 dígitos </option>
                                                                                    <option value="5 dígitos"> 5 dígitos </option>
                                                                                    <option value="+ 5 dígitos"> + 5 dígitos </option>
                                                                                    <option value="6 dígitos"> 6 dígitos </option>
                                                                                    <option value="+ 6 dígitos"> + 6 dígitos </option>
                                                                                    <option value="7 dígitos"> 7 dígitos </option>
                                                                                    <option value="+ 7 dígitos"> + 7 dígitos </option>
                                                                                    <option value="8 dígitos"> 8 dígitos </option>
                                                                                    <option value="+ 8 dígitos"> + 8 dígitos </option>
                                                                                </select>
	                                                                    </div>
	                                                                </div>
	                                                            </div>

	                                                            <div class="col-sm-12 mt-3">
	                                                                <div class="form-group">
	                                                                    <div class="form-line">
																			Tempo de Mercado
                                                                                <select class="form-control" id="idade" name="tempo_mercado">
                                                                                    <option value="Até 1 ano"> Até 1 ano </option>
                                                                                    <option value=" 1 a 3 anos"> 1 a 3 anos </option>
                                                                                    <option value="4 a 7 anos"> 4 a 7 anos </option>
                                                                                    <option value="7 a 10 anos"> 7 a 10 anos </option>
                                                                                    <option value="+10 anos"> +10 anos </option>
                                                                                </select>
	                                                                    </div>
	                                                                </div>
	                                                            </div>
	                                                        </div>

	                                                     
	                                                    </div>
	                                                    <div class="modal-footer">
	                                                        <button class="btn btn-outline-info" type="submit" value="salvar" name="save_fat-mercado">Salvar</button>
	                                                        <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Fechar</button>
	                                                    </div>

	                                                </form>


	                                            </div>
	                                        </div>
	                                    </div>

									  <?php  } ?>
							<div class="overviews md-none">
								<ul>
	                                <li><span class="icon color-2"><i class="fas fa-check-circle"></i></span> Visitas ao Perfil <span class="blue"><?php echo($visitas); ?></span></li>
	                                <li><span class="icon color-3"><i class="fas fa-dollar-sign"></i></span> Faturamento <span class="violet"><?php  echo $dados1['faturamento']; ?></span></li>
	                                <li><span class="icon color-4"><i class="fas fa-clock"></i></span> Tempo de Mercado <span class="red"><?php  echo $dados1['tempo_mercado']; ?></span></li>
								</ul>
							</div>
							<!--== FIM DA OVERVIEW ==-->
							   
	                           <div class="verification md-none">
	                              <h4>Contatos<?php  if ($dados1['id'] == $_SESSION['usuarioId'] || $_SESSION['usuarioNiveisAcessoId'] == 3) { ?>
	                              		
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
	                                                                    	Youtube
	                                                                         <input value="<?php  echo $dados11['youtube']; ?>" type="text" placeholder="" class="form-control"  name="youtube">
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
			                                 <?php  if ($dados11['facebook'] == ''){ ?>
			                                 	<a href="#" data-toggle="modal" role="button">
			                                 		<li>Facebook
				                                 		<span><i class="fas fa-minus"></i></span>
				                                	</li>
				                            	</a>
			                                 <?php }else{?>
				                                <a href="https://<?php  echo $dados11['facebook']; ?>" rel="noopener noreferrer" target="_blank">
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
				                                <a href="https://<?php  echo $dados11['instagram']; ?>" rel="noopener noreferrer" target="_blank">
			                                 		<li>Instagram
				                                 		<span><i class="fas fa-check"></i></span>
				                                	</li>
				                            	</a>
			                                 <?php }?>

			                                 <?php  if ($dados11['youtube'] == ''){ ?>
			                                 	<a href="#" data-toggle="modal" role="button">
			                                 		<li>Youtube
				                                 		<span><i class="fas fa-minus"></i></span>
				                                	</li>
				                            	</a>
			                                 <?php }else{?>
				                                <a href="https://<?php  echo $dados11['youtube']; ?>" rel="noopener noreferrer" target="_blank">
			                                 		<li>Youtube
				                                 		<span><i class="fas fa-check"></i></span>
				                                	</li>
				                            	</a>
			                                 <?php }?>
	                              </ul>
	                           </div>
	                        </div>
                     	</div>
                  	</div>
                  	<div class="col-sm-12 col-md-7 col-lg-8">
	                    <div class="freelancer-info">
	                        <div class="freelancer-detail">
                               <h2 class="freelancer-name"><?php  echo($dados1['nome']); ?></h2>
                               <?php  if ($dados1['id'] == $_SESSION['usuarioId'] OR $_SESSION['usuarioNiveisAcessoId'] == 3) { ?>
            <a data-toggle="modal" role="button" href="#modelo_negocio" class="online" style="color: #afafaf; padding: 0px;"><i class="fas fa-share"></i> Editar</a>


            <div class="modal fade text-left" id="modelo_negocio" tabindex="-1" role="dialog" aria-labelledby="myModalLabel11" aria-hidden="true">
             <div class="modal-dialog modal-lg" role="document">
                 <div class="modal-content">
                     <div class="modal-header bg-primary white">
                         <h4 class="modal-title" id="myModalLabel11" style="font-size: 12px; color: white;">Crie um título atraente para tornar público em seu perfil.</h4>
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
                                              <textarea placeholder="Ex: Gestor de Tráfego" class="form-control" rows="5" name="modelo_negocio"><?php  echo $dados11['modelo_negocio']; ?></textarea>
                                         </div>
                                     </div>
                                 </div>

                                     
                             </div>

                          
                         </div>
                         <div class="modal-footer">
                             <button class="btn btn-outline-info" type="submit" value="salvar" name="save_modelo_negocio">Salvar</button>
                             <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Fechar</button>
                         </div>

                     </form>


                 </div>
             </div>
         </div>

        <?php  } ?>         
								<h4 class="profile-title text-muted"><?php echo($categoria['nome']); ?></h2>
								<h4 class="profile-title text-muted"><?php echo($subcategoria['nome']); ?></h2>
                                <?php  if ($dados1['id'] == $_SESSION['usuarioId'] OR $_SESSION['usuarioNiveisAcessoId'] == 3) { ?>
	                           		
	                           		<br><a data-toggle="modal" role="button" href="#descricao" class="online" style="color: #afafaf; padding: 0px;"><i class="fas fa-share"></i> Editar</a>

	                           		<div class="modal fade text-left" id="descricao" tabindex="-1" role="dialog" aria-labelledby="myModalLabel11" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header bg-primary white">
                                                    <h4 class="modal-title" id="myModalLabel11" style="font-size: 12px; color: white;">Fale um pouco sobre o seu negócio.</h4>
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
                                                                         <textarea placeholder="Ex: Somos especialistas em criação de conteúdos, trabalhamos diretamente com copywriting e já participamos de grandes projetos." class="form-control" rows="5" name="descricao"><?php  echo $dados11['descricao']; ?></textarea>
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
                                
								<p><?php  if ($dados11['sobre'] == '') {
								   	echo('<h4 class="profile-title text-muted"> Sobre:</h4>');
	                           		echo "-";
	                           	}else{
									echo('<h4 class="profile-title text-muted"> Sobre: </h4>');
	                           		echo($dados11['sobre']); 
	                           	} ?>  
	                           	</p>
							</div>
							<div class="profile-info md-block">
<!--== INÍCIO DO MODAL ==-->
								   <?php  if ($dados1['id'] == $_SESSION['usuarioId'] || $_SESSION['usuarioNiveisAcessoId'] == 3) { ?>
									
									<br><a data-toggle="modal" role="button" href="#overview" class="online" style="color: #afafaf; padding: 0px;"><i class="fas fa-share"></i> Editar</a>
	                              	
	                              		<div class="modal fade text-left" id="overview" tabindex="-1" role="dialog" aria-labelledby="myModalLabel11" aria-hidden="true">
	                                        <div class="modal-dialog modal-lg" role="document">
	                                            <div class="modal-content">
	                                                <div class="modal-header bg-primary white">
	                                                    <h4 class="modal-title" id="myModalLabel11" style="font-size: 12px; color: white;">Editar Informações.</h4>
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
																			Faturamento
                                                                                <select class="form-control form-control-lg" id="movimentacao" name="movimentacao">
                                                                                    <option value="0 a 4 dígitos"> 0 a 4 dígitos </option>
                                                                                    <option value="+ 4 dígitos"> + 4 dígitos </option>
                                                                                    <option value="5 dígitos"> 5 dígitos </option>
                                                                                    <option value="+ 5 dígitos"> + 5 dígitos </option>
                                                                                    <option value="6 dígitos"> 6 dígitos </option>
                                                                                    <option value="+ 6 dígitos"> + 6 dígitos </option>
                                                                                    <option value="7 dígitos"> 7 dígitos </option>
                                                                                    <option value="+ 7 dígitos"> + 7 dígitos </option>
                                                                                    <option value="8 dígitos"> 8 dígitos </option>
                                                                                    <option value="+ 8 dígitos"> + 8 dígitos </option>
                                                                                </select>
	                                                                    </div>
	                                                                </div>
	                                                            </div>

	                                                            <div class="col-sm-12 mt-3">
	                                                                <div class="form-group">
	                                                                    <div class="form-line">
																			Tempo de Mercado
                                                                                <select class="form-control" id="idade" name="tempo_mercado">
                                                                                    <option value="Até 1 ano"> Até 1 ano </option>
                                                                                    <option value=" 1 a 3 anos"> 1 a 3 anos </option>
                                                                                    <option value="4 a 7 anos"> 4 a 7 anos </option>
                                                                                    <option value="7 a 10 anos"> 7 a 10 anos </option>
                                                                                    <option value="+10 anos"> +10 anos </option>
                                                                                </select>
	                                                                    </div>
	                                                                </div>
	                                                            </div>
	                                                        </div>

	                                                     
	                                                    </div>
	                                                    <div class="modal-footer">
	                                                        <button class="btn btn-outline-info" type="submit" value="salvar" name="save_fat-mercado">Salvar</button>
	                                                        <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Fechar</button>
	                                                    </div>

	                                                </form>


	                                            </div>
	                                        </div>
	                                    </div>

									  <?php  } ?>
							<div class="overviews">
								<ul>
	                                 <li><span class="icon color-2"><i class="fas fa-check-circle"></i></span> Visitas ao Perfil <p class="blue" style="width: 7rem;"><?php echo($visitas); ?></p></li>
	                                 <li><span class="icon color-3"><i class="fas fa-dollar-sign"></i></span> Faturamento <p class="violet"><?php  echo $dados1['faturamento']; ?></p></li>
	                                 <li><span class="icon color-4"><i class="fas fa-clock"></i></span> Tempo de Mercado <p class="red"><?php  echo $dados1['tempo_mercado']; ?></p></li>
								</ul>
							</div>
							<!--== FIM DA OVERVIEW ==-->
								<div class="verification">
										<h4>Contatos<?php  if ($dados1['id'] == $_SESSION['usuarioId'] || $_SESSION['usuarioNiveisAcessoId'] == 3) { ?>
	                              		
	                              		<a data-toggle="modal" role="button" href="#contatos-2" class="online" style="color: #afafaf; padding: 0px; font-size: 14px; float: right;"><i class="fas fa-share"></i> Editar</a>


	                              		<div class="modal fade text-left" id="contatos-2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel11" aria-hidden="true">
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
	                                                                    	Youtube
	                                                                         <input value="<?php  echo $dados11['youtube']; ?>" type="text" placeholder="" class="form-control"  name="youtube">
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

			                                 <?php  if ($dados11['youtube'] == ''){ ?>
			                                 	<a href="#" data-toggle="modal" role="button">
			                                 		<li>Youtube
				                                 		<span><i class="fas fa-minus"></i></span>
				                                	</li>
				                            	</a>
			                                 <?php }else{?>
				                                <a href="<?php  echo $dados11['youtube']; ?>">
			                                 		<li>Youtube
				                                 		<span><i class="fas fa-check"></i></span>
				                                	</li>
				                            	</a>
											 <?php } ?>
										</ul>
								</div>
							</div>
						</div>
	                </div>
               	</div>
            </div>
        </div>
    </section>

<!-- ================ NOVA SEÇÃO ======================= -->
		<?php /*
        <div class="container mt-n5" style="margin-top: -9rem;">
            <div class="freelancer-portfolio">
               <div class="row">
                  	<div class="w-75 ml-5">
	                    <div class="freelancer-info">
							
							<div class="space-between-items">				   
                                <?php  if ($dados1['id'] == $_SESSION['usuarioId'] OR $_SESSION['usuarioNiveisAcessoId'] == 3) { ?>
	                           		
	                           		<br><a data-toggle="modal" role="button" href="#sede" class="online" style="color: #afafaf; padding: 0px;"><i class="fas fa-share"></i> Editar</a>

	                           		<div class="modal fade text-left" id="sede" tabindex="-1" role="dialog" aria-labelledby="myModalLabel11" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header bg-primary white">
                                                    <h4 class="modal-title" id="myModalLabel11" style="font-size: 12px; color: white;">Edite a localização da sede do seu negócio.</h4>
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
                                                                         <textarea placeholder="Cidade Tal, Bairro Tal, Rua Tal, Número" class="form-control" rows="5" name="sede"><?php  echo $dados11['sede']; ?></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                                
                                                        </div>

                                                     
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-outline-info" type="submit" value="salvar" name="save_sede">Salvar</button>
                                                        <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Fechar</button>
                                                    </div>

                                                </form>


                                            </div>
                                        </div>
                                    </div>

									<div class="modal fade text-left" id="sede" tabindex="-1" role="dialog" aria-labelledby="myModalLabel11" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header bg-primary white">
                                                    <h4 class="modal-title" id="myModalLabel11" style="font-size: 12px; color: white;">Edite a localização da sede do seu negócio.</h4>
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
                                                                         <textarea placeholder="Cidade Tal, Bairro Tal, Rua Tal, Número" class="form-control" rows="5" name="sede"><?php  echo $dados11['sede']; ?></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>

                                                     
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-outline-info" type="submit" value="salvar" name="save_sede">Salvar</button>
                                                        <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Fechar</button>
                                                    </div>

                                                </form>


                                            </div>
                                        </div>
                                    </div>

                                   <?php  } ?>
                                
	                           <p><?php  if ($dados11['sede'] == '') {
								   	echo('<h4 class="profile-title text-muted"> Localização da Sede </h4>');
	                           		echo "Sede";
	                           	}else{
									echo('<h4 class="profile-title text-muted"> Localização da Sede </h4>');
	                           		echo($dados11['sede']); 
	                           	} ?>  
	                           	</p>
							</div>

							<div class="space-between-items">				   
                                <?php  if ($dados1['id'] == $_SESSION['usuarioId'] OR $_SESSION['usuarioNiveisAcessoId'] == 3) { ?>
	                           		
	                           		<br><a data-toggle="modal" role="button" href="#pilares" class="online" style="color: #afafaf; padding: 0px;"><i class="fas fa-share"></i> Editar</a>

	                           		<div class="modal fade text-left" id="pilares" tabindex="-1" role="dialog" aria-labelledby="myModalLabel11" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header bg-primary white">
                                                    <h4 class="modal-title" id="myModalLabel11" style="font-size: 12px; color: white;">Fale um pouco sobre os pilares do seu negócio.</h4>
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
                                                                         <textarea class="form-control" rows="5" name="pilares"><?php  echo $dados11['pilares']; ?></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                                
                                                        </div>

                                                     
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-outline-info" type="submit" value="salvar" name="save_pilares">Salvar</button>
                                                        <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Fechar</button>
                                                    </div>

                                                </form>


                                            </div>
                                        </div>
                                    </div>

									<div class="modal fade text-left" id="pilares" tabindex="-1" role="dialog" aria-labelledby="myModalLabel11" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header bg-primary white">
                                                    <h4 class="modal-title" id="myModalLabel11" style="font-size: 12px; color: white;">Fale um pouco sobre os pilares do seu negócio.</h4>
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
                                                                         <textarea class="form-control" rows="5" name="pilares"><?php  echo $dados11['pilares']; ?></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                                
                                                        </div>

                                                     
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-outline-info" type="submit" value="salvar" name="save_pilares">Salvar</button>
                                                        <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Fechar</button>
                                                    </div>

                                                </form>


                                            </div>
                                        </div>
                                    </div>

                                   <?php  } ?>
                                
	                           <p><?php  if ($dados11['pilares'] == '') {
								   	echo('<h4 class="profile-title text-muted"> Pilares </h4>');
	                           		echo "Pilares";
	                           	}else{
									echo('<h4 class="profile-title text-muted"> Pilares </h4>');
	                           		echo($dados11['pilares']); 
	                           	} ?>  

	                           	</p>
							</div>

							<div class="space-between-items">				   
                                <?php  if ($dados1['id'] == $_SESSION['usuarioId'] OR $_SESSION['usuarioNiveisAcessoId'] == 3) { ?>
	                           		
	                           		<br><a data-toggle="modal" role="button" href="#resultados" class="online" style="color: #afafaf; padding: 0px;"><i class="fas fa-share"></i> Editar</a>

	                           		<div class="modal fade text-left" id="resultados" tabindex="-1" role="dialog" aria-labelledby="myModalLabel11" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header bg-primary white">
                                                    <h4 class="modal-title" id="myModalLabel11" style="font-size: 12px; color: white;">Fale um pouco sobre os resultados do seu negócio.</h4>
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
                                                                         <textarea class="form-control" rows="5" name="resultados"><?php  echo $dados11['resultados']; ?></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                                
                                                        </div>

                                                     
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-outline-info" type="submit" value="salvar" name="save_resultados">Salvar</button>
                                                        <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Fechar</button>
                                                    </div>

                                                </form>


                                            </div>
                                        </div>
                                    </div>

									<div class="modal fade text-left" id="resultados" tabindex="-1" role="dialog" aria-labelledby="myModalLabel11" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header bg-primary white">
                                                    <h4 class="modal-title" id="myModalLabel11" style="font-size: 12px; color: white;">Fale um pouco sobre os resultados do seu negócio.</h4>
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
                                                                         <textarea class="form-control" rows="5" name="resultados"><?php  echo $dados11['resultados']; ?></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                                
                                                        </div>

                                                     
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-outline-info" type="submit" value="salvar" name="save_resultados">Salvar</button>
                                                        <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Fechar</button>
                                                    </div>

                                                </form>


                                            </div>
                                        </div>
                                    </div>

                                   <?php  } ?>
                                
	                           <p><?php  if ($dados11['resultados'] == '') {
								   	echo('<h4 class="profile-title text-muted"> Resultados </h4>');
	                           		echo "Resultados";
	                           	}else{
									echo('<h4 class="profile-title text-muted"> Resultados </h4>');
	                           		echo($dados11['resultados']); 
	                           	} ?>  
	                           	</p>
							</div>

						</div>
	                </div>
               	</div>
            </div>
		</div>
		*/ ?>
		<!-- ================ NOVA SEÇÃO - PUBLICAÇÕES DE PARCERIAS ======================= -->
		<?php
			$parcerias = $mysqli->query("SELECT * FROM publicacao WHERE id_usuario = '".$_GET['id']."' AND busca = 'parceria' ORDER BY data_publicacao DESC");
			if($parcerias->num_rows > 0){
				echo('
				<div class="container mt-n5 mb-5" style="margin-top: -9rem;">            
					<div class="freelancer-portfolio">
						<div class="row">
							<div class="w-100 ml-5 mr-5">
								<div class="freelancer-info">
										<h2 class="pb-2">Parcerias</h2>');
				foreach($parcerias as $parceria){
					echo('
					<div class="space-between-items card-publicacao mb-4">
						<div class="w-100 content-card-publicacao">
							<p style="white-space: pre-line" class="text-light">'.$parceria['titulo'].'</p>
							<p style="white-space: pre-line" class="text-light d-none descricao">'.$parceria['descricao'].'</p>
							<a class="text-light expandir" onclick="expand(this)">Ler mais</a>
						</div>
					</div>');
				}
				echo('
							</div>
						</div>
					</div>
				</div>
			</div>');
			}
		?>
		<!-- ================ NOVA SEÇÃO - PUBLICAÇÕES DE SERVIÇOS ======================= -->
		<?php
			$servicos = $mysqli->query("SELECT * FROM publicacao WHERE id_usuario = '".$_GET['id']."' AND busca = 'servico' ORDER BY data_publicacao DESC");
			if($servicos->num_rows > 0){
				echo('
				<div class="container mt-n5 mb-5" style="margin-top: -9rem;">            
					<div class="freelancer-portfolio">
						<div class="row">
							<div class="w-100 ml-5 mr-5">
								<div class="freelancer-info">
										<h2 class="pb-2">Serviços</h2>');
				foreach($servicos as $servico){
					echo('
					<div class="space-between-items card-publicacao mb-4">
						<div class="w-100 content-card-publicacao">
							<p style="white-space: pre-line" class="text-light">'.$servico['titulo'].'</p>
							<p style="white-space: pre-line" class="text-light d-none descricao">'.$servico['descricao'].'</p>
							<a class="text-light expandir" onclick="expand(this)">Ler mais</a>
						</div>
					</div>');
				}
				echo('
								</div>
							</div>
						</div>
					</div>
				</div>');
			}
		?>

	<script src="js/vendor/popper.min.js"></script>
    <script src="js/vendor/jquery-3.3.1.slim.min.js"></script>
	<script src="js/vendor/bootstrap.min.js"></script>
	<script src="js/vendor/jquery.min.js"></script>
	<script src="js/vendor/jquery.easing.min.js"></script>
	<script src="js/vendor/font-awesome.js"></script>
  	<script src="js/vendor/isotope.pkgd.min.js"></script>
  	<script src="js/vendor/imagesloaded.pkgd.min.js"></script>
  	<script src="js/portfolio.js"></script>
	<script src="js/index.js"></script>
	<script src="js/functions.js"></script>
</body>
</html>