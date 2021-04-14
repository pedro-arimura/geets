<?php 

	session_start();

    $mysqli = new mysqli('localhost','id15265491_root','Genérica1234','id15265491_geets');
	// DEFINE O FUSO HORARIO COMO O HORARIO DE BRASILIA
    date_default_timezone_set('America/Sao_Paulo');


    if ($_SESSION['usuarioNiveisAcessoId'] != 3) {
    	session_destroy();
    	header("Location: entrar?error");
    }


    $sql3 = "SELECT * FROM especialista_usuarios ORDER BY id DESC";
    $query3 = mysqli_query($mysqli, $sql3);
    $contar_query3 = mysqli_num_rows($query3);

    if (isset($_GET['aprove'])) {
    	

    	$sql5 = "UPDATE especialista_usuarios SET status = 1, justificativa = 'Aprovado' WHERE id = '".$_GET['id']."' ";
    	$query5 = mysqli_query($mysqli, $sql5);

    	header("Location: relatorio-especialistas?approved");

    }

    if (isset($_GET['reprove'])) {
    	

    	$sql5 = "UPDATE especialista_usuarios SET status = 3, justificativa = 'Reprovado' WHERE id = '".$_GET['id']."'";
    	$query5 = mysqli_query($mysqli, $sql5);

    	header("Location: relatorio-especialistas?reproved");

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
                                    <th>Usuário</th>
                                    <th>Título</th>
                                    <th>Anexo</th>
                                    <th>Cadastrado em</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            <?php  while($dados3 = mysqli_fetch_array($query3)){ 

                            	$sql4 = "SELECT * FROM usuarios WHERE id = '".$dados3['id_usuarios']."'";
                            	$query4 = mysqli_query($mysqli, $sql4);
                            	$dados4 = mysqli_fetch_assoc($query4);

                            ?>
                                <tr>
                                    <td><?php  echo $dados4['nome']; ?></td>
                                    <td><?php  echo $dados3['titulo']; ?></td>
                                    <td>
                                    	<a style="color: black" target="_blank" href="anexos/<?php  echo $dados3['anexo']; ?>">
                                    		<u>abrir anexo</u>
                                    	</a>
                                    </td>
                                    <td><?php  echo date('d/m/Y', strtotime($dados3['data_cadastro'])); ?> às <?php  echo date('H:i', strtotime($dados3['hora_cadastro'])); ?></td>
                                    <td>
                                    		<?php  if ($dados3['status'] == 0) { ?>
										  		Pendente
										  	<?php  }elseif ($dados3['status'] == 1) { ?>
										  		Aprovado
										  	<?php  }elseif ($dados3['status'] == 3) { ?>
										    	Reprovado
										  	<?php  } ?>
                                    </td>
                                    <td>
                                    	<div class="btn-group">
										 
										  <button type="button" class="btn btn-sm btn-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										    Ações
										  </button>

										  <div class="dropdown-menu">
										  	<?php  if ($dados3['status'] == 0) { ?>
										  		<a  class="dropdown-item" href="?reprove&id=<?php  echo $dados3['id']; ?>">Reprovar</a>
										    	<a  class="dropdown-item" href="?aprove&id=<?php  echo $dados3['id']; ?>">Aprovar</a>
										  	<?php  }elseif ($dados3['status'] == 1) { ?>
										  		<a  class="dropdown-item" href="?reprove&id=<?php  echo $dados3['id']; ?>">Reprovar</a>
										  	<?php  }elseif ($dados3['status'] == 3) { ?>
										    	<a  class="dropdown-item" href="?aprove&id=<?php  echo $dados3['id']; ?>">Aprovar</a>
										  	<?php  } ?>
										    
										  </div>
										</div>
                                    </td>

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