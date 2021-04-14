<?php
session_start();
$mysqli = new mysqli('localhost','id15265491_root','Genérica1234','id15265491_geets');
$queryExp = $mysqli->query("SELECT * FROM aplicacao_expert WHERE id= ".$_GET['id']."");
$resultado = $queryExp->fetch_assoc();
if($resultado['lido'] == 0){
    $mysqli->query("UPDATE aplicacao_expert SET lido = 1 WHERE id = ".$_GET['id']."");
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
	<link rel="stylesheet" href="css/responsive.css">
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
                    <div class="form-group">
                        <label for="expertise">Fale sobre a sua expertise e seu nicho de atuação.</label>
                        <textarea name="expertise" class="form-control" style="display:block; margin-bottom:1.6rem;" cols="70" rows="5" placeholder="<?php  echo $resultado['expertise']; ?>" readOnly="true"></textarea>
                    </div>
                    <div class="form-group mt-5">
                        <label for="diferencial">Qual o diferencial da sua metodologia ou do que você ensina?</label>
                        <textarea name="diferencial" class="form-control" style="display:block; margin-bottom:1.6rem;" cols="70" rows="5" placeholder="<?php  echo $resultado['diferencial']; ?>" readOnly="true"></textarea>
                    </div>
                    <div class="form-group mt-5">
                        <label for="conteudo">Você já gera conteúdo? Com que frequência? Qual o tamanho da sua audiência?</label>
                        <textarea name="conteudo" class="form-control" style="display:block; margin-bottom:1.6rem;" cols="70" rows="5" placeholder="<?php  echo $resultado['conteudo']; ?>" readOnly="true"></textarea>
                    </div>
                    <div class="form-group mt-5">
                        <label for="motivo_parceria">O que te levou a buscar uma parceria?</label>
                        <textarea name="motivo_parceria" class="form-control" style="display:block; margin-bottom:1.6rem;" cols="70" rows="5" placeholder="<?php  echo $resultado['motivo_parceria']; ?>" readOnly="true"></textarea>
                    </div>
                    <div class="form-group mt-5">
                        <label for="expectativas">Porque gostaria de ser selecionado? Quais as suas expectativas?</label>
                        <textarea name="expectativas" class="form-control" style="display:block; margin-bottom:1.6rem;" cols="70" rows="5" placeholder="<?php  echo $resultado['expectativas']; ?>" readOnly="true"></textarea>
                    </div>
                    <div class="form-group mt-5">
                        <label for="contato">Escreva seus contatos para que em caso de interesse possam entrar em contato com você.</label>
                        <textarea name="contato" class="form-control" style="display:block; margin-bottom:1.6rem;" cols="70" rows="5" placeholder="<?php  echo $resultado['contatos']; ?>" readOnly="true"></textarea>
                    </div>
                    <div class="button-aplicacao-container">
                        <a href="profile-exp.php?id=<?php  echo $resultado['id_usuario']; ?>" class="btn-aplicacao btn-default mt-4"> Visualizar Perfil </a>
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