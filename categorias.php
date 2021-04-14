<?php 

	session_start();

    $mysqli = new mysqli('localhost','root','','id15265491_geets');
	// DEFINE O FUSO HORARIO COMO O HORARIO DE BRASILIA
    date_default_timezone_set('America/Sao_Paulo');


    if ($_SESSION['usuarioNiveisAcessoId'] != 3) {
    	session_destroy();
    	header("Location: login.php?error");
    }


    $sql3 = "SELECT * FROM habilidades ORDER BY nome DESC";
    $query3 = mysqli_query($mysqli, $sql3);
    $contar_query3 = mysqli_num_rows($query3);

    if (isset($_GET['deletar'])) {
    	

    	$sql5 = "DELETE FROM  habilidades WHERE id = '".$_GET['id']."' ";
    	$query5 = mysqli_query($mysqli, $sql5);

    	header("Location: categorias?deleted");

    }

    if (isset($_POST['editar'])) {

    	$sql5 = "UPDATE habilidades SET nome = '".$_POST['nome']."' WHERE id = '".$_POST['id']."'";
    	$query5 = mysqli_query($mysqli, $sql5);

    	header("Location: categorias?edited");

    }

    if (isset($_POST['novo'])) {
    	
    	$sql5 = "INSERT INTO habilidades (nome) VALUES ('".$_POST['nome']."')";
    	$query5 = mysqli_query($mysqli, $sql5);

    	header("Location: categorias?success");

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

	<link rel="stylesheet" type="text/css" href="dist/css/responsive.css">

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

				<div class="col-lg-12 col-md-12 col-sm-12">
					<a href="#categorias" data-toggle="modal" role="button" class="btn btn-success col-md-2" style="margin-bottom: 15px;">
						Nova categoria
					</a>

					<div class="modal fade text-left" id="categorias" tabindex="-1" role="dialog" aria-labelledby="myModalLabel11" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-primary white">
                                    <h4 class="modal-title" id="myModalLabel11" style="font-size: 12px; color: white;">Crie categorias para Geets.</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form method="POST" action="">
                                    

                                    <div class="modal-body">

                                        <div class="row container" style="font-size: 14px;">

                                            <div class="col-sm-12">
                                        		<div class="form-group">
                                                    <div class="form-line">
                                                    	Nome da categoria
                                                         <input required="" value="" type="text" placeholder="Digite um nome Ex: Copywriting" class="form-control"  name="nome">
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                     
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-outline-info" type="submit" value="salvar" name="novo">Salvar</button>
                                        <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Fechar</button>
                                    </div>

                                </form>


                            </div>
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
                                    <th>Categoria</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            <?php  while($dados3 = mysqli_fetch_array($query3)){  ?>
                                <tr>
                                    <td><?php  echo $dados3['nome']; ?></td>
                                  
                                    <td>
                                    	<div class="btn-group">
										 
										  <button type="button" class="btn btn-sm btn-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										    Ações
										  </button>

										  <div class="dropdown-menu">
										  		<a data-toggle="modal" role="button" class="dropdown-item" href="#editar<?php  echo $dados3['id']; ?>">Editar</a>
										    	<a  class="dropdown-item" href="?deletar&id=<?php  echo $dados3['id']; ?>">Deletar</a>
										  </div>
										</div>
                                    </td>

                                    <div class="modal fade text-left" id="editar<?php  echo $dados3['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel11" aria-hidden="true">
				                        <div class="modal-dialog modal-lg" role="document">
				                            <div class="modal-content">
				                                <div class="modal-header bg-primary white">
				                                    <h4 class="modal-title" id="myModalLabel11" style="font-size: 12px; color: white;">Editar categorias para Geets.</h4>
				                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				                                        <span aria-hidden="true">&times;</span>
				                                    </button>
				                                </div>

				                                <form method="POST" action="">
				                                    
				                                    <input type="hidden" name="id" value="<?php  echo $dados3['id']; ?>">

				                                    <div class="modal-body">

				                                        <div class="row container" style="font-size: 14px;">

				                                            <div class="col-sm-12">
				                                        		<div class="form-group">
				                                                    <div class="form-line">
				                                                    	Nome da categoria
				                                                         <input required="" value="<?php  echo $dados3['nome']; ?>" type="text" placeholder="Digite um nome Ex: Copywriting" class="form-control"  name="nome">
				                                                    </div>
				                                                </div>
				                                            </div>

				                                        </div>

				                                     
				                                    </div>
				                                    <div class="modal-footer">
				                                        <button class="btn btn-outline-info" type="submit" value="salvar" name="editar">Salvar</button>
				                                        <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Fechar</button>
				                                    </div>

				                                </form>


				                            </div>
				                        </div>
				                    </div>

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