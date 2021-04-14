<?php
session_start();
$mysqli = new mysqli('localhost','id15265491_root','Genérica1234','id15265491_geets');
if(isset($_POST['aplicar'])){
    $mysqli->query("INSERT INTO aplicacao_expert 
    VALUES (DEFAULT, '$_SESSION[usuarioId]', '$_POST[id_nd]', '".$mysqli->real_escape_string($_POST['expertise'])."', '".$mysqli->real_escape_string($_POST['diferencial'])."', '".$mysqli->real_escape_string($_POST['conteudo'])."', '".$mysqli->real_escape_string($_POST['motivo_parceria'])."', '".$mysqli->real_escape_string($_POST['expectativas'])."', '".$mysqli->real_escape_string($_POST['contato'])."', '0')");

    $queryEmail = $mysqli->query("SELECT email FROM usuarios WHERE id = ".$_POST['id_nd']."");
    $emailND = $queryEmail->fetch_assoc();
    $queryND = $mysqli->query("SELECT * FROM perfil_negocio_digital WHERE id_usuario = ".$_POST['id_nd']."");
    $infoND = $queryND->fetch_assoc();
    $queryExp = $mysqli->query("SELECT * FROM perfil_expert WHERE id_usuario = ".$_SESSION['usuarioId']."");
    $infoExp = $queryExp->fetch_assoc();
    /*
    $to = $emailND['email'];
    $subject = "Você recebeu uma aplicação!";

    $message = '
    <div style="width: 100%; text-align: center;">
        <div style="padding: 15px 0 15px 0; margin-bottom: 0.4rem; width: 100%;">
            <a href="https://www.geets.com.br"> <img src="https://www.geets.com.br/Geets_Logo.jpg" width="20%"> </a>
        </div>
        <div id="header" style="text-align: center; width: 100%;">
            <h1>Olá, '.$infoND['razao_social'].'! Você recebeu uma aplicação de um expert!</h1>
        </div>
        <div id="body" style="width: 80%; text-align: center; margin: 0 auto;">
            <p style="margin-bottom: 2.6rem; font-size: 1.3rem;">
                Seus esforços estão recompensando, pois você acabou de receber uma aplicação! Acesse nossa plataforma 
                para conferir o que lhe foi enviado e entrar em contato com o(a) expert '.$infoExp['nome'].' que se interessou pelo seu negócio digital!
            </p>
            <a href="https://www.geets.com.br/login.php" style="text-decoration: none;
            color: #fff;
            background: linear-gradient(239deg, #9279FA 0%, #00D1D5 100%);
            border-radius: 20px;
            padding: 10px 40px 10px 40px;
            margin: 0 auto;
            margin-bottom: 3rem;"> Clique Aqui </a>
        </div>
    </div>
    ';

    // Always set content-type when sending HTML email
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    // More headers
    $headers .= 'From: <geetsdigital@gmail.com.br>' . "\r\n";

    mail($to,$subject,$message,$headers);
    */
    header("Location: home.php?sucesso");
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
                <h2 class="text-center mt-4 mb-4"> Fazer Aplicação </h2>
                <form method="POST">
                    <input type="hidden" name="id_nd" value="<?php echo($_POST['id_nd']); ?>">
                    <div class="form-group">
                        <label for="expertise">Fale sobre a sua expertise e seu nicho de atuação.</label>
                        <textarea name="expertise" class="form-control" style="display:block; margin-bottom:1.6rem;" cols="70" rows="5"></textarea>
                    </div>
                    <div class="form-group mt-5">
                        <label for="diferencial">Qual o diferencial da sua metodologia ou do que você ensina?</label>
                        <textarea name="diferencial" class="form-control" style="display:block; margin-bottom:1.6rem;" cols="70" rows="5"></textarea>
                    </div>
                    <div class="form-group mt-5">
                        <label for="conteudo">Você já gera conteúdo? Com que frequência? Qual o tamanho da sua audiência?</label>
                        <textarea name="conteudo" class="form-control" style="display:block; margin-bottom:1.6rem;" cols="70" rows="5"></textarea>
                    </div>
                    <div class="form-group mt-5">
                        <label for="motivo_parceria">O que te levou a buscar uma parceria?</label>
                        <textarea name="motivo_parceria" class="form-control" style="display:block; margin-bottom:1.6rem;" cols="70" rows="5"></textarea>
                    </div>
                    <div class="form-group mt-5">
                        <label for="expectativas">Porque gostaria de ser selecionado? Quais as suas expectativas?</label>
                        <textarea name="expectativas" class="form-control" style="display:block; margin-bottom:1.6rem;" cols="70" rows="5"></textarea>
                    </div>
                    <div class="form-group mt-5">
                        <label for="contato">Escreva seus contatos para que em caso de interesse possam entrar em contato com você.</label>
                        <textarea name="contato" class="form-control" style="display:block; margin-bottom:1.6rem;" cols="70" rows="5"></textarea>
                    </div>
                    <div class="button-aplicacao-container">
                        <input type="submit" class="btn-aplicacao btn-default mt-4" name="aplicar" value="Fazer aplicação!">
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