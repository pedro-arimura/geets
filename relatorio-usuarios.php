<?php 

	session_start();

	$mysqli = new mysqli('localhost','root','','new-bd-geets');
	// DEFINE O FUSO HORARIO COMO O HORARIO DE BRASILIA
    date_default_timezone_set('America/Sao_Paulo');


    if ($_SESSION['usuarioNiveisAcessoId'] != 3) {
    	session_destroy();
    	header("Location: entrar?error");
    }


    $sql3 = "SELECT * FROM usuarios WHERE niveis_acesso_id != 3 ORDER BY id DESC";
    $query3 = mysqli_query($mysqli, $sql3);
    $contar_query3 = mysqli_num_rows($query3);

    if ($_GET['cat'] == 'profissionais') {
    	$sql3 = "SELECT * FROM usuarios WHERE niveis_acesso_id IN ('2') ORDER BY id DESC";
	    $query3 = mysqli_query($mysqli, $sql3);
	    $contar_query3 = mysqli_num_rows($query3);
    }elseif ($_GET['cat'] == 'empresas') {
    	$sql3 = "SELECT * FROM usuarios WHERE niveis_acesso_id IN ('1') ORDER BY id DESC";
	    $query3 = mysqli_query($mysqli, $sql3);
	    $contar_query3 = mysqli_num_rows($query3);
    }else{
    	$sql3 = "SELECT * FROM usuarios WHERE niveis_acesso_id IN ('1','2') ORDER BY id DESC";
	    $query3 = mysqli_query($mysqli, $sql3);
	    $contar_query3 = mysqli_num_rows($query3);
    }

    if (isset($_GET['del'])) {
    		
    		$sql4 = "DELETE FROM usuarios WHERE id = '".$_GET['id']."'";
    		$query4 = mysqli_query($mysqli, $sql4);
    		header("Location: relatorio-usuarios?deleted");

    }

?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<meta name="application-name" content="">
	<meta name="description" content="Geets - Painel de <?php  echo $_SESSION['usuarioNome']; ?>">
	<title>Logado como <?php  echo $_SESSION['usuarioNome']; ?></title>

	<link rel="stylesheet" href="dist/css/vendor/bootstrap.min.css">

	<link rel="stylesheet" href="dist/css/vendor/font-awesome/css/font-awesome.min.css">

	<link rel="stylesheet" href="dist/css/main.css">

	<link rel="stylesheet" type="text/css" href="datatable/datatables.min.css">

    <style type="text/css">
        .buttons-html5{
            background-color: indigo !important;
            color: white !important;
            padding: 5px ;
            margin: 5px !important;
        }

        div.dataTables_wrapper div.dataTables_filter input{
        	border-right: 0px !important;
        	border-left: 0px !important;
        	border-top: 0px !important;
        }
    </style>


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

				<?php  if (isset($_GET['edited'])){ ?>
					
					<div class="alert alert-primary alert-dismissible fade show col-md-12" role="alert">
					  Editado com sucesso !
					  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    <span aria-hidden="true">&times;</span>
					  </button>
					</div>	

				<?php  } ?>

				<?php  if (isset($_GET['deleted'])){ ?>
					
					<div class="alert alert-danger alert-dismissible fade show col-md-12" role="alert">
					  Deletado com sucesso !
					  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    <span aria-hidden="true">&times;</span>
					  </button>
					</div>	

				<?php  } ?>

				<?php  if (isset($_GET['success'])){ ?>
					
					<div class="alert alert-success alert-dismissible fade show col-md-12" role="alert">
					  Adicionado com sucesso !
					  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    <span aria-hidden="true">&times;</span>
					  </button>
					</div>	

				<?php  } ?>					


				<div class="col-lg-12 col-md-12 col-sm-12">
					<div class="overview">
						<div class="stat-icon icon-color-four">
							<i class="fas fa-chart-area"></i>
						</div>
						<div class="stat-text">
							<p>Total de registros</p>
							<span><?php  echo $contar_query3; ?></span>
						</div>
					</div>
				</div>

			</div>
		

			<div class="row">

				<div class="col-sm-12 col-md-12 col-lg-12">
					
					<div class="db-table table-responsive" style="padding: 20px;">
                        <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Tipo de usuário</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    foreach($query3 as $row){
                                        if($row['id_tipo_perfil'] == 1){
                                        echo('<tr>
                                            <td>'.$row['nome'].'</td>
                                            <td>Negócio digital</td>
                                            <td>
                                            	<div class="btn-group">
        										 
        										  <button type="button" class="btn btn-sm btn-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        										    Ações
        										  </button>
        
        										  <div class="dropdown-menu">
        										    <a class="dropdown-item" href="?del&id='.$row['id'].'">Deletar</a>
        										    <a target="_blank" class="dropdown-item" href="profile-nd.php?id='.$row['id'].'">Ver Perfil</a>
        										  </div>
        										</div>
                                            </td>
        
                                        </tr>');
                                        }
                                        elseif($row['id_tipo_perfil'] == 2){
                                            echo('<tr>
                                            <td>'.$row['nome'].'</td>
                                            <td>Expert</td>
                                            <td>
                                            	<div class="btn-group">
        										 
        										  <button type="button" class="btn btn-sm btn-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        										    Ações
        										  </button>
        
        										  <div class="dropdown-menu">
        										    <a class="dropdown-item" href="?del&id='.$row['id'].'">Deletar</a>
        										    <a target="_blank" class="dropdown-item" href="profile-exp.php?id='.$row['id'].'">Ver Perfil</a>
        										  </div>
        										</div>
                                            </td>
        
                                        </tr>');
                                        }
                                        else{
                                            echo('<tr>
                                            <td>'.$row['nome'].'</td>
                                            <td>Profissional</td>
                                            <td>
                                            	<div class="btn-group">
        										 
        										  <button type="button" class="btn btn-sm btn-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        										    Ações
        										  </button>
        
        										  <div class="dropdown-menu">
        										    <a class="dropdown-item" href="?del&id='.$row['id'].'">Deletar</a>
        										    <a target="_blank" class="dropdown-item" href="profile-pf.php?id='.$row['id'].'">Ver Perfil</a>
        										  </div>
        										</div>
                                            </td>
        
                                        </tr>');
                                        }
                                    }
                                    ?>
                            </tbody>
                        </table>
					</div>
				</div>
			</div>

		</div>
	</section>


	<section id="copyright-area">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12">
					<div class="copyright-area">
				      	<div class="copyright-wrapper">
			               	<div class="copyright-text">
			                  	© 2019 Geets</a>					
			               	</div>
			               	<div class="footer-nav">
				                <ul id="menu-footer-nav" class="footer_nav">
				                     <li id="menu-item-439" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-439"><a href="#">Terms &amp; Condition</a></li>
				                     <li id="menu-item-440" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-440"><a href="#">Privacy Policy</a></li>
				                </ul>
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



    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" type="text/javascript"></script>



	<script type="text/javascript">
        
        $('#example23').DataTable({
            "language": {
                    "search": "Procurar:",
                    "lengthMenu": "Mostrando _MENU_",
                    "zeroRecords": "Nada encontrado",
                    "info": " _PAGE_ de _PAGES_",
                    "infoEmpty": "Nenhum registro disponível",     
                    "oPaginate": {
                                                          "sFirst":    "Primeiro",
                                                          "sPrevious": "Anterior",
                                                          "sNext":     "Próximo",
                                                          "sLast":     "Último"
                                                                },                              
                    "infoFiltered": "(filtrando de _MAX_ registros)"
                },
            dom: 'Bfrtip',
            buttons: [
                'csv', 'excel', 'pdf', 'print'
            ]
        });

    </script>
</body>
</html>