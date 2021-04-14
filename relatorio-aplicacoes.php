<?php 

	session_start();

    $mysqli = new mysqli('localhost','id15265491_root','Genérica1234','id15265491_geets');
	// DEFINE O FUSO HORARIO COMO O HORARIO DE BRASILIA
    date_default_timezone_set('America/Sao_Paulo');


    if ($_SESSION['usuarioNiveisAcessoId'] != 3) {
    	session_destroy();
    	header("Location: entrar?error");
    }


    // Pegar as informações das aplicações
    $sqlExp = "SELECT perfil_negocio_digital.razao_social, perfil_expert.nome, aplicacao_expert.id
    FROM aplicacao_expert 
    INNER JOIN perfil_expert ON aplicacao_expert.id_usuario = perfil_expert.id_usuario
    INNER JOIN perfil_negocio_digital ON aplicacao_expert.id_ND = perfil_negocio_digital.id_usuario";
    $queryExp = $mysqli->query($sqlExp);
    
    $sqlPf = "SELECT perfil_negocio_digital.razao_social, perfil_profissional.nome, aplicacao_profissional.id
    FROM aplicacao_profissional 
    INNER JOIN perfil_profissional ON aplicacao_profissional.id_usuario = perfil_profissional.id_usuario
    INNER JOIN perfil_negocio_digital ON aplicacao_profissional.id_ND = perfil_negocio_digital.id_usuario";
    $queryPf = $mysqli->query($sqlPf);

    $total = $queryExp->num_rows + $queryPf->num_rows;
    if (isset($_GET['del'])) {
    		
    		$sql4 = "DELETE FROM projetos WHERE id = '".$_GET['id']."'";
    		$query4 = mysqli_query($mysqli, $sql4);
    		header("Location: relatorio-projetos?deleted");

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
							<span><?php  echo($total); ?></span>
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
                                    <th>Negócio digital</th>
                                    <th>Usuário</th>
                                    <th>Tipo de usuário</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    foreach($queryExp as $row){
                                    echo('
                                    <tr>
                                    <td>'.$row['razao_social'].'</td>
                                    <td>'.$row['nome'].'</td>
                                    <td>Expert</td>
                                    <td>
                                    	<div class="btn-group">
										 
										  <button type="button" class="btn btn-sm btn-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										    Ações
										  </button>

										  <div class="dropdown-menu">
										    <a class="dropdown-item" href="?del&id='.$row['id'].'">Deletar</a>
										    <a target="_blank" class="dropdown-item" href="aplicacao-exp-view.php?id='.$row['id'].'">Ver aplicação</a>
										  </div>
										</div>
                                    </td>

                                </tr>');
                                    }
                                    foreach($queryPf as $row){
                                    echo('
                                    <tr>
                                    <td>'.$row['razao_social'].'</td>
                                    <td>'.$row['nome'].'</td>
                                    <td>Profissional</td>
                                    <td>
                                    	<div class="btn-group">
										 
										  <button type="button" class="btn btn-sm btn-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										    Ações
										  </button>

										  <div class="dropdown-menu">
										    <a class="dropdown-item" href="?del&id='.$row['id'].'">Deletar</a>
										    <a target="_blank" class="dropdown-item" href="aplicacao-pf-view.php?id='.$row['id'].'">Ver aplicação</a>
										  </div>
										</div>
                                    </td>

                                </tr>');
                                    }
                                ?>
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