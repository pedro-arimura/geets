<?php
session_start();
$mysqli = new mysqli('localhost','id15265491_root','Genérica1234','id15265491_geets');
$queryExp = $mysqli->query("SELECT * FROM aplicacao_profissional WHERE id= ".$_GET['id']."");
$resultado = $queryExp->fetch_assoc();
if($resultado['lido'] == 0){
    $mysqli->query("UPDATE aplicacao_profissional SET lido = 1 WHERE id = ".$_GET['id']."");
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplicar para negócio digital</title>
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
            <div class="w-75 mx-auto">
                <h2 class="text-center mt-4 mb-4"> Detalhes da Aplicação </h2>
                <form method="POST">
                    <input type="hidden" name="id_nd" value="<?php echo($_POST['id_nd']); ?>">
                    <div class="form-group">
                        <label for="desc">Fale brevemente sobre você e o que você faz.</label>
                        <textarea name="desc" class="form-control" style="display:block; margin-bottom:1.6rem;" cols="70" rows="5" placeholder="<?php  echo $resultado['descricao']; ?>" readOnly="true"></textarea>
                    </div>
                    <div class="form-group mt-5">
                        <label for="conhecimentos">Quais os seus principais conhecimentos?</label>
                        <textarea name="conhecimentos" class="form-control" style="display:block; margin-bottom:1.6rem;" cols="70" rows="5" placeholder="<?php  echo $resultado['conhecimentos']; ?>" readOnly="true"></textarea>
                    </div>
                    <div class="form-group mt-5">
                        <label for="experiencia">Já trabalhou ou trabalha em outros projetos de negócios digitais? Conte sua experiência.</label>
                        <textarea name="experiencia" class="form-control" style="display:block; margin-bottom:1.6rem;" cols="70" rows="5" placeholder="<?php  echo $resultado['experiencia']; ?>" readOnly="true"></textarea>
                    </div>
                    <div class="form-group mt-5">
                        <label for="modelo_trabalho">De que forma você pretende trabalhar? (ex: prestação de serviço, estágio ou CLT)</label>
                        <textarea name="modelo_trabalho" class="form-control" style="display:block; margin-bottom:1.6rem;" cols="70" rows="5" placeholder="<?php  echo $resultado['modelo_trabalho']; ?>" readOnly="true"></textarea>
                    </div>
                    <div class="form-group mt-5">
                        <label for="expectativa">Porque gostaria de ser selecionado?</label>
                        <textarea name="expectativa" class="form-control" style="display:block; margin-bottom:1.6rem;" cols="70" rows="5" placeholder="<?php  echo $resultado['expectativa']; ?>" readOnly="true"></textarea>
                    </div>
                    <div class="form-group mt-5">
                        <label for="contatos">Escreva seus contatos para que em caso de interesse possam entrar em contato com você.</label>
                        <textarea name="contatos" class="form-control" style="display:block; margin-bottom:1.6rem;" cols="70" rows="5" placeholder="<?php  echo $resultado['contatos']; ?>" readOnly="true"></textarea>
                    </div>
                    <div class="button-aplicacao-container">
                        <a href="profile-pf.php?id=<?php  echo $resultado['id_usuario']; ?>" class="btn-aplicacao btn-default mt-4"> Visualizar Perfil </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

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

</body>
</html>