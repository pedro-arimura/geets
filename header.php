<?php 
 // CONTA QUANTAS PROPOSTAS EXISTEM ATUALMENTE SEM LER

if($_SESSION['tipo_perfil'] == 1){
	$sql110 = "SELECT * FROM usuarios WHERE id = '".$_SESSION['usuarioId']."'";
	$query110 = mysqli_query($mysqli, $sql110) or die($mysqli->error);
	$dados110 = $query110->fetch_assoc();	
	
	/*
	$aplicacoesExp = $mysqli->query("SELECT usuarios.razao_social, perfil_expert.nome, aplicacao_expert.id
    FROM aplicacao_expert 
    INNER JOIN perfil_expert ON aplicacao_expert.id_usuario = perfil_expert.id_usuario
    INNER JOIN usuarios ON aplicacao_expert.id_ND = usuarios.id_usuario
    WHERE aplicacao_expert.id_ND = '".$_SESSION['usuarioId']."' AND aplicacao_expert.lido = 0");
	$aplicacoesPf = $mysqli->query("SELECT usuarios.razao_social, perfil_profissional.nome, aplicacao_profissional.id
    FROM aplicacao_profissional 
    INNER JOIN perfil_profissional ON aplicacao_profissional.id_usuario = perfil_profissional.id_usuario
	INNER JOIN usuarios ON aplicacao_profissional.id_ND = usuarios.id_usuario WHERE aplicacao_profissional.id_ND = '".$_SESSION['usuarioId']."' AND aplicacao_profissional.lido = 0");
	*/
	$total = 0 + 0;;
}
elseif($_SESSION['tipo_perfil'] == 2){
	$sql110 = "SELECT * FROM perfil_expert WHERE id_usuario = '".$_SESSION['usuarioId']."'";
	$query110 = mysqli_query($mysqli, $sql110);
	$dados110 = mysqli_fetch_assoc($query110);
}
elseif($_SESSION['tipo_perfil'] == 3){
	$sql110 = "SELECT * FROM perfil_profissional WHERE id_usuario = '".$_SESSION['usuarioId']."'";
	$query110 = mysqli_query($mysqli, $sql110);
	$dados110 = mysqli_fetch_assoc($query110);
}
if ($_SESSION['usuarioNiveisAcessoId'] == 2) {
	$retorno = "home.php";
}elseif ($_SESSION['usuarioNiveisAcessoId'] == 1) {
	$retorno = "home.php";
}elseif ($_SESSION['usuarioNiveisAcessoId'] == 3) {
	$retorno = "master.php";
}

?>

<input type="hidden" id="antigo" value="<?php  echo(""); ?>">

	<header class="computer-view">
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-9 col-sm-12 col-md-9 primary-menu order-sm-1 order-2">
					<nav class="navbar navbar-expand-lg">
					    <div class="navbar-brand">
					    	<a style="color: black;" class="logo js-scroll-trigger" href="<?php  echo $retorno ?>">
					    		<img src="new.png" width="75">
					    	</a>
					    	<a style="color: white;" class="s-logo js-scroll-trigger" href="<?php  echo $retorno ?>">
					    		<img src="new.png" width="60">
					    	</a>
					    </div>
						<!--<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
					  	<span class="navbar-toggler-icon"></span>
					  	</button>-->
					
						<div class="navbar-collapse" id="navbarNavDropdown">
						    <ul class="navbar-nav mr-auto">


						    <?php  if ($_SESSION['usuarioNiveisAcessoId'] == 1) { ?>
						    		
						    	  <li class="nav-item">
							        <a class="nav-link" href="<?php  echo $retorno ?>">Home</a>
							      </li>
								  <li class="nav-item">
							        <a class="nav-link" href="filtro-profissionais-list.php">Buscar</a>
							      </li>
						    	  <li class="nav-item">
							        <a class="nav-link" href="empresa.php">Painel</a>
								  </li>

						    <?php  }elseif ($_SESSION['usuarioNiveisAcessoId'] == 2) { 
								if($_SESSION['tipo_perfil'] == 2){ ?>
									<li class="nav-item">
										<a class="nav-link" href="<?php  echo $retorno ?>">Home</a>
									</li>
									<li class="nav-item">
							        	<a class="nav-link" href="filtro-profissionais-list.php">Buscar</a>
							      	</li>
								<?php  }else{ ?>
									<li class="nav-item">
										<a class="nav-link" href="<?php  echo $retorno ?>">Home</a>
									</li>
									<li class="nav-item">
							        	<a class="nav-link" href="filtro-profissionais-list.php">Buscar</a>
							      	</li>
								<?php  } ?>
						    <?php  }elseif ($_SESSION['usuarioNiveisAcessoId'] == 3) { ?>
						    	   <li class="nav-item">
							        <a class="nav-link" href="relatorio-usuarios.php">Usuários</a>
							      </li>
						    	  <li class="nav-item">
							        <a class="nav-link" href="relatorio-usuarios?cat=profissionais.php">Profissionais</a>
							      </li>
							      <li class="nav-item">
							        <a class="nav-link" href="relatorio-usuarios?cat=empresas.php">Empresas</a>
							      </li>
							      <li class="nav-item">
							        <a class="nav-link" href="relatorio-aplicacoes.php">Aplicações</a>
							      </li>
							      <li class="nav-item">
							        <a class="nav-link" href="categorias.php">Categorias</a>
							      </li>
							      <li class="nav-item">
							        <a class="nav-link" href="subcategorias.php">Subcategorias</a>
							      </li>
                                  <li class="nav-item">
							        <a class="nav-link" href="sair.php">Deslogar</a>
							      </li>
						    <?php  } ?>

						      
						    </ul>
						</div>
					</nav>
				</div>

				<div class="col-lg-3 col-md-3 col-sm-12 header-notification order-sm-2 order-1">
					<nav class="navbar navbar-expand-lg">
						<ul class="navbar-nav ml-auto right-menu">

							<li class="nav-button">
							    <a class="btn-link-nav" href="publicacao.php">Publicar</a>
							</li>

							<?php  if ($_SESSION['usuarioNiveisAcessoId'] == 1) { ?>
								<li class="nav-item">
							        <a class="nav-link bell" href="#notification" data-toggle="modal" role="button"><i class="far fa-bell"></i>
									<span id="sino"><?php echo($total); ?></span>
							        </a>
								</li>
								
							<?php  } ?>
							
						    <li class="nav-item dropdown menu-padding dropdown-user">
						        <a class="nav-link user-img" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						        	

	                        			<?php  if ($dados110['thumb'] == '') { ?>
	                        				<img src="img/user.png" alt="">
	                        			<?php  }else{ ?>
	                        				<img style="width: 45px !important; height: 45px !important;" src="thumb/<?php  echo $dados110['thumb']; ?>" alt="">
	                        			<?php  } ?>

						        </a>
								<?php 
								if($_SESSION['tipo_perfil'] == 1){
								echo('
								<ul class="dropdown-menu">
						        	<li class="nav-item"><a href="profile-nd.php?id='.$_SESSION['usuarioId'].'" class="dropdown-item">Meu Perfil</a></li>
						        	<li class="nav-item"><a href="sair" class="dropdown-item">Logout</a></li>
								</ul>');
								}
								elseif ($_SESSION['tipo_perfil'] == 2) {
									echo('
									<ul class="dropdown-menu">
										<li class="nav-item"><a href="profile-exp.php?id='.$_SESSION['usuarioId'].'" class="dropdown-item">Meu Perfil</a></li>
										<li class="nav-item"><a href="sair" class="dropdown-item">Logout</a></li>
									</ul>');
								}
								elseif ($_SESSION['tipo_perfil'] == 3) {
									echo('
									<ul class="dropdown-menu">
										<li class="nav-item"><a href="profile-pf.php?id='.$_SESSION['usuarioId'].'" class="dropdown-item">Meu Perfil</a></li>
										<li class="nav-item"><a href="sair" class="dropdown-item">Logout</a></li>
									</ul>');
								}
								
								?>
							</li>
							
						</ul>
					</nav>
				</div>
			</div>
		</div>
	</header>

	<header class="cell-view">
		<div class="container-fluid fixed-bottom bg-padrao navbar-mobile">
			<div class="row mt-auto mb-auto mx-auto align-items-center" style="justify-content: center;">
				<div class="col">
					<li class="nav-item mx-auto text-center">
						<a class="btn-link-nav mx-auto icon-nav-mobile" href="home.php"><i class="fas fa-home"></i><p> Home </p></a>
					</li>
				</div>
				<div class="col">
					<li class="nav-item text-center">
						<a class="btn-link-nav user-img mx-auto icon-nav-mobile" href="filtro-profissionais-list.php" ><i class="fas fa-search"></i><p> Buscar </p></a>
					</li>
				</div>
				<div class="col">
					<li class="nav-item text-center">
						<a class="btn-link-nav mx-auto icon-nav-mobile" href="publicacao.php"><i class="fas fa-plus"></i><p> Publicar </p></a>
					</li>
				</div>
				<div class="col">
					<li class="nav-item text-center">
						<a class="btn-link-nav mx-auto icon-nav-mobile" href="#"><i class="fas fa-desktop"></i><p> Painel </p></a>
					</li>
				</div>
				<div class="col">
					<li class="nav-item text-center">
					    <?php
					    if($_SESSION['tipo_perfil'] == 1){
					        echo('
    						<a class="btn-link-nav user-img mx-auto icon-nav-mobile" href="profile-nd.php?id='.$_SESSION['usuarioId'].'"><i class="fas fa-user"></i><p> Perfil </p></a>');
					    }
					    elseif($_SESSION['tipo_perfil'] == 2){
					        echo('
    						<a class="btn-link-nav user-img mx-auto icon-nav-mobile" href="profile-exp.php?id='.$_SESSION['usuarioId'].'"><i class="fas fa-user"></i><p> Perfil </p></a>');
					    }
					    elseif($_SESSION['tipo_perfil'] == 3){
					        echo('
    						<a class="btn-link-nav user-img mx-auto icon-nav-mobile" href="profile-pf.php?id='.$_SESSION['usuarioId'].'"><i class="fas fa-user"></i><p> Perfil </p></a>');
					    }
						?>
					</li>
				</div>
			</div>
		</div>
	</header>

	<header class="cell-view">
		<div class="container-fluid position-relative pb-1">
			<div class="row mt-auto mb-auto mx-auto float-right" style="justify-content: center;">
				<div class="col">
					<li class="nav-item text-center">
						<a class="nav-link user-img mx-auto" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<?php  if ($dados110['thumb'] == '') { ?>
								<img src="img/user.png" alt="">
							<?php  }else{ ?>
								<img style="width: 45px !important; height: 45px !important;" src="thumb/<?php  echo $dados110['thumb']; ?>" alt="">
							<?php  } ?>
							<?php 
								if($_SESSION['tipo_perfil'] == 1){
								echo('
								<ul class="dropdown-menu">
									<li class="nav-item"><a href="filtro-profissionais-list.php" class="dropdown-item">Buscar</a></li>
						        	<li class="nav-item"><a href="profile-nd.php?id='.$_SESSION['usuarioId'].'" class="dropdown-item">Meu Perfil</a></li>
						        	<li class="nav-item"><a href="sair" class="dropdown-item">Logout</a></li>
								</ul>');
								}
								elseif ($_SESSION['tipo_perfil'] == 2) {
									echo('
									<ul class="dropdown-menu">
										<li class="nav-item"><a href="filtro-profissionais-list.php" class="dropdown-item">Buscar</a></li>
										<li class="nav-item"><a href="profile-exp.php?id='.$_SESSION['usuarioId'].'" class="dropdown-item">Meu Perfil</a></li>
										<li class="nav-item"><a href="sair" class="dropdown-item">Logout</a></li>
									</ul>');
								}
								elseif ($_SESSION['tipo_perfil'] == 3) {
									echo('
									<ul class="dropdown-menu">
										<li class="nav-item"><a href="filtro-profissionais-list.php" class="dropdown-item">Buscar</a></li>
										<li class="nav-item"><a href="profile-pf.php?id='.$_SESSION['usuarioId'].'" class="dropdown-item">Meu Perfil</a></li>
										<li class="nav-item"><a href="sair" class="dropdown-item">Logout</a></li>
									</ul>');
								}
								
								?>
						</a>
					</li>
				</div>
			</div>
		</div>
	</header>

	<?php  if ($_SESSION['usuarioNiveisAcessoId'] == 1) { ?>
		<div class="modal fade" id="notification" role="dialog" tabindex="-1" aria-hidden="true">
		    <div class="modal-dialog">
		      	<div class="modal-content unread-notification"> 
			        <div class="modal-body">
				    	<div class="chatting-page">
				    		<div class="chat-freelancers">


				    		<audio id="notificacao" preload="auto">
							  <source src="beep.mp3" type="audio/mpeg">
							</audio>


							<div class="users">
							    <?php 
							    if($total == 0){
							        echo('
							        <ul id="qqId">
							        	<li>
                                            <p class="mx-auto">Não há nenhuma nova aplicação!</p>
										</li>
									</ul>');
							    }
							    else{
							        echo('<ul id="qqId">');
							        foreach($aplicacoesExp as $row){
                                        echo('
										<li>
											<a href="aplicacao-exp-view.php?id='.$row['id'].'&notification=true" style="color: black;">
												<div class="notification-details">
													<p class="notification-text"><b>Você recebeu uma proposta de '.$row['nome'].'</b>
													<p>Clique aqui para visualizar!</p>
												</div>
											</a>
										</li>');
							            
							        }
							        foreach($aplicacoesPf as $row){
							            echo('
										<li>
											<a href="aplicacao-pf-view.php?id='.$row['id'].'&notification=true" style="color: black;">
												<div class="notification-details">
													<p class="notification-text"><b>Você recebeu uma proposta de '.$row['nome'].'!</b>
													<p>Clique aqui para visualizar!</p>
												</div>
											</a>
										</li>');
							        }
							        echo('</ul>');
								}
								?>
							</div>



	                            <!--<script type="text/javascript">
	                                $( document ).ready(function() {


	                                    var tempo = 2000; //Dois segundos

	                                    (function selectNumUsuarios () {


	                                        $.ajax({
	                                          cache: false,
	                                          url: "count-proposal.php",

	                                          success: function (n) {
	                                              //essa é a function success, será executada se a requisição obtiver exito

	                                              $("#countTotal").remove();
	                                              

	                                              // COLOCA O CONTADOR EM VARIAVEL
	                                              contar = $("#contagem").val();
	                                              // ADICIONA O CONTADOR NO SINO
	                                              $("#sino").text(contar);

	                                              // REMOVE O CONTADOR PARA ENTRAR EM LOOP
	                                              $("#contagem").remove();


	                                              $("#qqId").append(n);

	                                              antigo = $("#antigo").val();
	                                              atualizado = $("#countTotal").val();


	                                              if (atualizado > 0) {
	                                              	$('#notificacao').trigger('play');
	                                              }
	                                              

	                                          },
	                                          complete: function () {
	                                              setTimeout(selectNumUsuarios, tempo);
	                                          }


	                                       });


	                                    })();
	                                });
	                            </script>-->

	             
	                    
						</div>
				    	</div>
			    	</div>  
		    	</div>
				</div>
		</div>
	<?php }?>	