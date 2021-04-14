<?php 
session_start();
$mysqli = new mysqli('localhost','root','','id15265491_geets');
// Registra a publicação no banco de dados
if(isset($_POST['publicar'])){
    if($_POST['tipo'] == "parceria"){
        $mysqli->query("INSERT INTO publicacao VALUES (default, ".$_SESSION['usuarioId'].", '".$mysqli->real_escape_string($_POST['tipo'])."', '".$mysqli->real_escape_string($_POST['titulo_parceria'])."', '".$mysqli->real_escape_string($_POST['descricao_parceria'])."', NOW())") or die($mysqli->error);
        header("Location: home.php?success");
    }
    else{
        $mysqli->query("INSERT INTO publicacao VALUES (default, ".$_SESSION['usuarioId'].", '".$mysqli->real_escape_string($_POST['tipo'])."','".$mysqli->real_escape_string($_POST['titulo_servico'])."', '".$mysqli->real_escape_string($_POST['descricao_servico'])."', NOW())");
        header("Location: home.php?success");
    }
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
    <title>Negócios Digitais | Geets</title>
    
    <link rel="stylesheet" href="css/responsive.css">

	<link rel="stylesheet" href="dist/css/vendor/bootstrap.min.css">

	<link rel="stylesheet" href="dist/css/vendor/font-awesome/css/font-awesome.min.css">

    <link rel="stylesheet" href="dist/css/main.css">

    <style>
        .error-alert{
            color: red;
        }
    </style>
    
    
</head>
<body>
	<?php  
		include "header.php";
    ?>

		<div class="container-fluid mt-12">
            <!-- Formulário de cadastro de publicações -->
            <form id="formPublicacao" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="tipo" id="tipo">
                <section class="mx-auto tab"> <!-- First Section -->
                    <div class="form-register-pub mx-auto position-relative">
                        <div class="content-register mx-auto text-center w-75"> <!-- Div for content-center -->
                            <p class="h1 tsize-2 pt-5 mb-2"> O que você está buscando? </p>
                            <p class="form-text text-muted mb-5">Clique em uma das opções.</p>
                            <div class="text-center mx-auto button-group">
                                <button type="button" class="btn-parceria select-tipo" id="parceria">Parceria</button>
                                <button type="button" class="btn-servico select-tipo" id="servico">Serviço</button>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="mx-auto d-none tab-parceria">
                    <div class="form-register-pub mx-auto position-relative">
                        <div class="content-register mx-auto text-center">
                            <p class="h1 tsize-2 pt-5"> Escreva um título para sua publicação! </p>
                            <small id="help" class="form-text text-muted mb-5"> Ex: Procuro alguém para fazer o marketing da minha loja. </small>
                                <div class="form-group w-75 mx-auto">
                                    <input type="text" class="form-control input-small-pub" id="titulo_parceria" name="titulo_parceria">
                                    <span class="error-alert d-none" id="erro-parceria1">* Preencha o campo acima!</span>
                                </div>
                                <button type="button" class="btn-next-form w-75 mt-2 mb-5 pass-button"> Próximo </button>
                        </div>
                    </div>
                </section>

                <section class="mx-auto d-none tab-parceria">
                    <div class="form-register-pub mx-auto position-relative">
                        <div class="content-register mx-auto text-center">
                            <p class="h1 tsize-2 pt-5 mb-5"> Escreva detalhes sobre a parceria que está buscando! </p>
                                <div class="form-group w-75 mx-auto">
                                    <textarea class="form-control input-big-pub" id="descricao_parceria" name="descricao_parceria"> </textarea>
                                    <span class="error-alert d-none" id="erro-parceria2">* Preencha o campo acima!</span>
                                </div>
                                <button type="submit" class="btn-next-form w-75 mt-2 mb-5" name="publicar">Publicar!</button>
                        </div>
                    </div>
                </section>

                <section class="mx-auto d-none tab-servico" id="tab-servico">
                    <div class="form-register-pub mx-auto position-relative">
                        <div class="content-register mx-auto text-center">
                            <p class="h1 tsize-2 pt-5 mb-5"> Escreva um título para sua publicação! </p>
                            <small id="help" class="form-text text-muted mb-5"> Ex: Procuro alguém para fazer o marketing da minha loja. </small>
                                <div class="form-group w-75 mx-auto">
                                    <input type="text" class="form-control input-small-pub" id="titulo_servico" name="titulo_servico">
                                    <span class="error-alert d-none" id="erro-servico1">* Preencha o campo acima!</span>
                                </div>
                                <button type="button" class="btn-next-form w-75 mt-2 mb-5 pass-button">Próximo </button>
                        </div>
                    </div>
                </section>

                <section class="mx-auto d-none tab-servico" id="tab-servico">
                    <div class="form-register-pub mx-auto position-relative">
                        <div class="content-register mx-auto text-center">
                            <p class="h1 tsize-2 pt-5 mb-5"> Escreva detalhes sobre o serviço que está buscando! </p>
                                <div class="form-group w-75 mx-auto">
                                    <textarea class="form-control input-big-pub" id="descricao_servico" name="descricao_servico"> </textarea>
                                    <span class="error-alert d-none" id="erro-servico2">* Preencha o campo acima!</span>
                                </div>
                                <button type="submit" class="btn-next-form w-75 mt-2 mb-5" name="publicar">Publicar!</button>
                        </div>
                    </div>
                </section>
                
            </form>
            <!-- Fim do formulário de cadastro -->
		</div>

	<script src="js/vendor/font-awesome.js"></script>
	<script src="js/vendor/popper.min.js"></script>
	<script src="js/vendor/bootstrap.min.js"></script>
    <script src="js/vendor/jquery.min.js"></script>
    <script src="js/index.js"></script>
    <script src="js/functions.js"></script>
</body>
</html>