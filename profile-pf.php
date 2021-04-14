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

if($dados1['id_tipo_perfil'] == 1){
	$sql11 = "SELECT * FROM perfil_negocio_digital WHERE id_usuario = '".$_GET['id']."'";
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
        
    $sql2 = "UPDATE perfil_profissional SET descricao = '".$_POST['descricao']."' WHERE id_usuario = '".$_POST['id']."'";
    $query2 =  mysqli_query($mysqli, $sql2);

    header("Location: profile-pf.php?id=".$_POST['id']."&success");

}

if (isset($_POST['save_perfil'])) {
        
    $sql2 = "UPDATE perfil_profissional SET perfil = '".$_POST['perfil']."' WHERE id_usuario = '".$_POST['id']."'";
    $query2 =  mysqli_query($mysqli, $sql2);
	$mysqli->query("UPDATE usuarios SET titulo = '".$_POST['perfil']."' WHERE id = '".$_POST['id']."'");

    header("Location: profile-pf.php?id=".$_POST['id']."&success");


}

if (isset($_POST['save_contatos'])) {
        
    $sql2 = "UPDATE perfil_profissional SET facebook = '".$_POST['facebook']."',instagram = '".$_POST['instagram']."',youtube = '".$_POST['youtube']."'  WHERE id_usuario = '".$_POST['id']."'";
    $query2 =  mysqli_query($mysqli, $sql2);

    header("Location: profile-pf.php?id=".$_POST['id']."&success");


}

if (isset($_POST['save_experiencia'])) {
        
    $sql2 = "UPDATE perfil_profissional SET experiencia = '".$_POST['experiencia']."' WHERE id_usuario = '".$_POST['id']."'";
    $query2 =  mysqli_query($mysqli, $sql2);

    header("Location: profile-pf.php?id=".$_POST['id']."&success");


}

if (isset($_POST['save_caracteristicas'])) {
        
    $sql2 = "UPDATE perfil_profissional SET caracteristicas = '".$_POST['caracteristicas']."' WHERE id_usuario = '".$_POST['id']."'";
    $query2 =  mysqli_query($mysqli, $sql2);

    header("Location: profile-pf.php?id=".$_POST['id']."&success");


}

if (isset($_POST['save_treinamentos'])) {
        
    $sql2 = "UPDATE perfil_profissional SET treinamentos = '".$_POST['treinamentos']."' WHERE id_usuario = '".$_POST['id']."'";
    $query2 =  mysqli_query($mysqli, $sql2);

    header("Location: profile-pf.php?id=".$_POST['id']."&success");


}

if (isset($_POST['save_fat-mercado'])) {
        
    $sql2 = "UPDATE perfil_profissional SET tempo_atuacao = '".$_POST['tempo_atuacao']."', movimentacao = '".$_POST['movimentacao']."' WHERE id_usuario = '".$_POST['id']."'";
    $query2 =  mysqli_query($mysqli, $sql2);

    header("Location: profile-pf.php?id=".$_POST['id']."&success");

}

if (isset($_POST['save_thumb'])) {
    
    $diretorio = "thumb/";

    $capa = isset($_FILES['capa']) ? $_FILES['capa'] : FALSE;
    $m = md5($_POST['id']);
    $destino1 = $diretorio."/"."1".$m.$capa['name'];
    move_uploaded_file($capa['tmp_name'], $destino1);

    $capa = "1".$m.$capa['name'];

    $sql2 = "UPDATE perfil_profissional SET thumb = '".$capa."' WHERE id_usuario = '".$_POST['id']."'";
    $query2 =  mysqli_query($mysqli, $sql2);
	$updateImagem = $mysqli->query("UPDATE usuarios SET thumb = '$capa' WHERE id = ".$_POST['id']."");

    header("Location: profile-pf.php?id=".$_POST['id']."&success");

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
        

    header("Location: profile-pf.php?id=".$_POST['id']."&success");


}

if (isset($_POST['save_treinamento'])) {
        
    $sql2 = "UPDATE perfil_profissional SET treinamentos = '".$_POST['descricao']."' WHERE id_usuario = '".$_POST['id']."'";
    $query2 =  mysqli_query($mysqli, $sql2);

    header("Location: profile-pf.php?id=".$_POST['id']."&success");


}

if (isset($_POST['save_treinamento'])) {
        
    $sql2 = "UPDATE perfil_profissional SET treinamento = '".$_POST['descricao']."' WHERE id_usuario = '".$_POST['id']."'";
    $query2 =  mysqli_query($mysqli, $sql2);

    header("Location: profile-pf.php?id=".$_POST['id']."&success");


}

// ANALISE PARA VER SE DESBLOQUEIA OS DADOS DESTE USUÁRIO

$sql30 = "SELECT * FROM propostas WHERE status = 1 AND id_usuario = '".$_GET['id']."' AND id_projeto IN (SELECT id FROM projetos WHERE id_usuario = '".$_SESSION['usuarioId']."')";
$query30 = mysqli_query($mysqli, $sql30);
$dados30 = mysqli_fetch_assoc($query30);

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width,initial-scale=1">
		<meta name="application-name" content="">
		<meta name="description" content="">
		<title>Perfil de <?php echo($dados1['nome']); ?></title>
	
		<link rel="stylesheet" href="dist/css/vendor/bootstrap.min.css">
		<link rel="stylesheet" href="dist/css/main.css">
		<link rel="stylesheet" href="css/custom.css">
		<link rel="stylesheet" href="css/responsive.css">
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
	                           <!--<div class="overviews md-none">
									<a data-toggle="modal" role="button" href="#contatos" class="online" style="color: #afafaf; padding: 0px; font-size: 14px; float: right;"><i class="fas fa-share"></i> Editar</a>
	                              <ul>
	                                 <li><span class="icon color-1"><i class="fas fa-star"></i></span> Aplicações Recebidas<span class="yellow">5.0</span></li>
	                                 <li><span class="icon color-2"><i class="fas fa-check-circle"></i></span> Visitas ao Perfil <span class="blue">100%</span></li>
	                                 <li><span class="icon color-3"><i class="fas fa-dollar-sign"></i></span> Faturamento </li>
	                                 <li><span class="icon color-4"><i class="fas fa-clock"></i></span> Tempo de Mercado <span class="red"></span></li>
	                              </ul>
							   </div>-->
							   
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
                                  <?php  if ($dados11['id_usuario'] != $_SESSION['usuarioId']) { ?>
	                             		
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

			                                <?php  if ($dados11['youtube'] == ''){ ?>
			                                 	<a href="#blocked" data-toggle="modal" role="button">
			                                 		<li>Youtube
				                                 		<span><i class="fas fa-minus"></i></span>
				                                	</li>
				                            	</a>
			                                <?php }else{?>
				                                <a href="#blocked" data-toggle="modal" role="button">
			                                 		<li>Youtube
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
		                                <?php }?>

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
            <a data-toggle="modal" role="button" href="#perfil" class="online" style="color: #afafaf; padding: 0px;"><i class="fas fa-share"></i> Editar</a>


            <div class="modal fade text-left" id="perfil" tabindex="-1" role="dialog" aria-labelledby="myModalLabel11" aria-hidden="true">
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
                                              <textarea placeholder="Ex: Gestor de Tráfego" class="form-control" rows="5" name="perfil"><?php  echo $dados11['perfil']; ?></textarea>
                                         </div>
                                     </div>
                                 </div>

                                     
                             </div>

                          
                         </div>
                         <div class="modal-footer">
                             <button class="btn btn-outline-info" type="submit" value="salvar" name="save_perfil">Salvar</button>
                             <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Fechar</button>
                         </div>

                     </form>


                 </div>
             </div>
         </div>

        <?php  } ?>
                               <h4 class="profile-title text-muted">

                                <?php  if ($dados11['perfil'] == '') {
                                    echo "Título";
                                }else{
                                    echo $dados11['perfil']; 
                                } ?> 

                                </h4>
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
                                
								  <p><?php  if ($dados11['descricao'] == '') {
								   	echo('<h4 class="profile-title text-muted"> Descrição</h4>');
	                           		echo "Descrição";
	                           	}else{
									echo('<h4 class="profile-title text-muted"> Descrição </h4>');
	                           		echo($dados11['descricao']); 
	                           	} ?>  
	                           	</p>
							</div>
							<div class="profile-info md-block">
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
                                  <?php  if ($dados11['id_usuario'] != $_SESSION['usuarioId']) { ?>
	                             		
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

			                                <?php  if ($dados11['youtube'] == ''){ ?>
			                                 	<a href="#blocked" data-toggle="modal" role="button">
			                                 		<li>Youtube
				                                 		<span><i class="fas fa-minus"></i></span>
				                                	</li>
				                            	</a>
			                                <?php }else{?>
				                                <a href="#blocked" data-toggle="modal" role="button">
			                                 		<li>Youtube
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
		                                <?php }?>

	                             	<?php }?>	 
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

        <div class="container mt-n5" style="margin-top: -9rem;">
            <div class="freelancer-portfolio">
               <div class="row">
                  	<div class="w-75 ml-5">
	                    <div class="freelancer-info">
							
							<div class="space-between-items">				   
                                <?php  if ($dados1['id'] == $_SESSION['usuarioId'] OR $_SESSION['usuarioNiveisAcessoId'] == 3) { ?>
	                           		
	                           		<br><a data-toggle="modal" role="button" href="#caracteristicas" class="online" style="color: #afafaf; padding: 0px;"><i class="fas fa-share"></i> Editar</a>

	                           		<div class="modal fade text-left" id="caracteristicas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel11" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header bg-primary white">
                                                    <h4 class="modal-title" id="myModalLabel11" style="font-size: 12px; color: white;">Fale sobre suas características.</h4>
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
                                                                         <textarea placeholder="Cidade Tal, Bairro Tal, Rua Tal, Número" class="form-control" rows="5" name="caracteristicas"><?php  echo $dados11['caracteristicas']; ?></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                                
                                                        </div>

                                                     
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-outline-info" type="submit" value="salvar" name="save_caracteristicas">Salvar</button>
                                                        <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Fechar</button>
                                                    </div>

                                                </form>


                                            </div>
                                        </div>
                                    </div>

									<div class="modal fade text-left" id="caracteristicas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel11" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header bg-primary white">
                                                    <h4 class="modal-title" id="myModalLabel11" style="font-size: 12px; color: white;">Fale sobre suas características.</h4>
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
                                                                         <textarea placeholder="Cidade Tal, Bairro Tal, Rua Tal, Número" class="form-control" rows="5" name="caracteristicas"><?php  echo $dados11['caracteristicas']; ?></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>

                                                     
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-outline-info" type="submit" value="salvar" name="save_caracteristicas">Salvar</button>
                                                        <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Fechar</button>
                                                    </div>

                                                </form>


                                            </div>
                                        </div>
                                    </div>

                                   <?php  } ?>
                                
	                           <p><?php  if ($dados11['caracteristicas'] == '') {
								   	echo('<h4 class="profile-title text-muted"> Características </h4>');
	                           		echo "Sede";
	                           	}else{
									echo('<h4 class="profile-title text-muted"> Características </h4>');
	                           		echo($dados11['caracteristicas']); 
	                           	} ?>  
	                           	</p>
							</div>

							<div class="space-between-items">				   
                                <?php  if ($dados1['id'] == $_SESSION['usuarioId'] OR $_SESSION['usuarioNiveisAcessoId'] == 3) { ?>
	                           		
	                           		<br><a data-toggle="modal" role="button" href="#experiencia" class="online" style="color: #afafaf; padding: 0px;"><i class="fas fa-share"></i> Editar</a>

	                           		<div class="modal fade text-left" id="experiencia" tabindex="-1" role="dialog" aria-labelledby="myModalLabel11" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header bg-primary white">
                                                    <h4 class="modal-title" id="myModalLabel11" style="font-size: 12px; color: white;">Fale um pouco sobre as suas experiências.</h4>
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
                                                                         <textarea class="form-control" rows="5" name="experiencia"><?php  echo $dados11['experiencia']; ?></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                                
                                                        </div>

                                                     
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-outline-info" type="submit" value="salvar" name="save_experiencia">Salvar</button>
                                                        <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Fechar</button>
                                                    </div>

                                                </form>


                                            </div>
                                        </div>
                                    </div>

									<div class="modal fade text-left" id="experiencia" tabindex="-1" role="dialog" aria-labelledby="myModalLabel11" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header bg-primary white">
                                                    <h4 class="modal-title" id="myModalLabel11" style="font-size: 12px; color: white;">Fale um pouco sobre as suas experiências.</h4>
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
                                                                         <textarea class="form-control" rows="5" name="experiencia"><?php  echo $dados11['experiencia']; ?></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                                
                                                        </div>

                                                     
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-outline-info" type="submit" value="salvar" name="save_experiencia">Salvar</button>
                                                        <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Fechar</button>
                                                    </div>

                                                </form>


                                            </div>
                                        </div>
                                    </div>

                                   <?php  } ?>
                                
	                           <p><?php  if ($dados11['experiencia'] == '') {
								   	echo('<h4 class="profile-title text-muted"> Experiências </h4>');
	                           		echo "Experiências";
	                           	}else{
									echo('<h4 class="profile-title text-muted"> Experiências </h4>');
	                           		echo($dados11['experiencia']); 
	                           	} ?>  

	                           	</p>
							</div>

							<div class="space-between-items">				   
                                <?php  if ($dados1['id'] == $_SESSION['usuarioId'] OR $_SESSION['usuarioNiveisAcessoId'] == 3) { ?>
	                           		
	                           		<br><a data-toggle="modal" role="button" href="#treinamentos" class="online" style="color: #afafaf; padding: 0px;"><i class="fas fa-share"></i> Editar</a>

	                           		<div class="modal fade text-left" id="treinamentos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel11" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header bg-primary white">
                                                    <h4 class="modal-title" id="myModalLabel11" style="font-size: 12px; color: white;">Fale um pouco sobre seus treinamentos.</h4>
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
                                                                         <textarea class="form-control" rows="5" name="treinamentos"><?php  echo $dados11['treinamentos']; ?></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                                
                                                        </div>

                                                     
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-outline-info" type="submit" value="salvar" name="save_treinamentos">Salvar</button>
                                                        <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Fechar</button>
                                                    </div>

                                                </form>


                                            </div>
                                        </div>
                                    </div>

									<div class="modal fade text-left" id="treinamentos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel11" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header bg-primary white">
                                                    <h4 class="modal-title" id="myModalLabel11" style="font-size: 12px; color: white;">Fale um pouco sobre seus treinamentos.</h4>
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
                                                                         <textarea class="form-control" rows="5" name="treinamentos"><?php  echo $dados11['treinamentos']; ?></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                                
                                                        </div>

                                                     
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-outline-info" type="submit" value="salvar" name="save_treinamentos">Salvar</button>
                                                        <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Fechar</button>
                                                    </div>

                                                </form>


                                            </div>
                                        </div>
                                    </div>

                                   <?php  } ?>
                                
	                           <p><?php  if ($dados11['treinamentos'] == '') {
								   	echo('<h4 class="profile-title text-muted"> Treinamentos </h4>');
	                           		echo "Treinamentos";
	                           	}else{
									echo('<h4 class="profile-title text-muted"> Treinamentos </h4>');
	                           		echo($dados11['treinamentos']); 
	                           	} ?>  
	                           	</p>
							</div>

						</div>
	                </div>
               	</div>
            </div>
        </div>
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