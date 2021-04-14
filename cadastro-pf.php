<?php 
    $mysqli = new mysqli('localhost','id15265491_root','Genérica1234','id15265491_geets');
    // DEFINE O FUSO HORARIO COMO O HORARIO DE BRASILIA
    date_default_timezone_set('America/Sao_Paulo');
    $verify = $mysqli->query("SELECT * FROM usuarios WHERE email ='".$mysqli->real_escape_string($_POST['email'])."'");
    $verify = $verify->num_rows;
    if($verify < 1){
        if(isset($_POST['cadastrar'])){
            // Insere o usuário na tabela "usuarios", aqui você vai mudar o primeiro "1" por 2 e o segundo por 3
            $insertUsuario = $mysqli->query("INSERT INTO usuarios VALUES (DEFAULT,'".$mysqli->real_escape_string($_POST[nome])."','".$mysqli->real_escape_string($_POST[email])."','".$mysqli->real_escape_string($_POST[senha])."','2', '3','".date('Y-m-d')."','".date('H:i:s')."', '', '".$mysqli->real_escape_string($_POST['perfil'])."')");
            // Pega o id recém inserido
            $getId = $mysqli->query("SELECT * FROM usuarios WHERE email ='". $mysqli->real_escape_string($_POST['email'])."'");
            $getId = $getId->fetch_assoc();
            //Seta o diretório "thumb" para receber as imagens
            $diretorio = "thumb/";

            $capa = isset($_FILES['imgPerfil']) ? $_FILES['imgPerfil'] : FALSE;
            $m = md5($getId['id']);
            $destino1 = $diretorio."/"."1".$m.$capa['name'];
            move_uploaded_file($capa['tmp_name'], $destino1);

            if($_FILES['imgPerfil']['name'] != ""){
                $capa = isset($_FILES['imgPerfil']) ? $_FILES['imgPerfil'] : FALSE;
                $m = md5($getId['id']);
                $destino1 = $diretorio."/"."1".$m.$capa['name'];
                move_uploaded_file($capa['tmp_name'], $destino1);

                $capa = "1".$m.$capa['name'];
                // Insere os dados na tabela de perfil adequada
                $insertPerfil = $mysqli->query("INSERT INTO perfil_profissional VALUES(DEFAULT, '$getId[id]', '".$mysqli->real_escape_string($_POST[nome])."', '".$mysqli->real_escape_string($_POST[perfil])."', '$capa', '".$mysqli->real_escape_string($_POST[desc])."', '".$mysqli->real_escape_string($_POST[experiencia])."', '".$mysqli->real_escape_string($_POST[caracteristicas])."', '".$mysqli->real_escape_string($_POST[treinamentos])."', '".$mysqli->real_escape_string($_POST[comunidadeDigital])."', '".$mysqli->real_escape_string($_POST[facebook])."', '".$mysqli->real_escape_string($_POST[instagram])."', '".$mysqli->real_escape_string($_POST[youtube])."')");
                $updateImagem = $mysqli->query("UPDATE usuarios SET thumb = '$capa' WHERE id = ".$getId['id']."");
            }
            else{
                $insertPerfil = $mysqli->query("INSERT INTO perfil_profissional VALUES(DEFAULT, '$getId[id]', '".$mysqli->real_escape_string($_POST[nome])."', '".$mysqli->real_escape_string($_POST[perfil])."', '', '".$mysqli->real_escape_string($_POST[desc])."', '".$mysqli->real_escape_string($_POST[experiencia])."', '".$mysqli->real_escape_string($_POST[caracteristicas])."', '".$mysqli->real_escape_string($_POST[treinamentos])."', '".$mysqli->real_escape_string($_POST[comunidadeDigital])."', '".$mysqli->real_escape_string($_POST[facebook])."', '".$mysqli->real_escape_string($_POST[instagram])."', '".$mysqli->real_escape_string($_POST[youtube])."')");
            }

            // Criando sessão
            session_start();
            $_SESSION['usuarioId'] = $getId['id'];
            $_SESSION['usuarioNome'] = $getId['nome'];
            $_SESSION['usuarioSenha'] = $getId['senha'];
            $_SESSION['usuarioNiveisAcessoId'] = $getId['niveis_acesso_id'];
            $_SESSION['usuarioEmail'] = $getId['email'];
            $_SESSION['tipo_perfil'] = $getId['id_tipo_perfil'];

            if ($_SESSION['usuarioNiveisAcessoId'] == 2) {
          header("Location: profile-pf.php?id=".$getId['id']."");
            }elseif($_SESSION['usuarioNiveisAcessoId'] == 1){
              header("Location: home.php");
            }elseif($_SESSION['usuarioNiveisAcessoId'] == 3){
              header("Location: master.php");
            }else{
              session_destroy();
              header("Location: cadastro-pf.php?error");
            }
        }
    }
    else{
        header("Location: cadastro.html?erro=email_ja_cadastrado");
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="/fontawesome-free-5.14.0-web/css/fontawesome.css" rel="stylesheet">
        <link href="/fontawesome-free-5.14.0-web/css/brands.css" rel="stylesheet">
        <link href="/fontawesome-free-5.14.0-web/css/solid.css" rel="stylesheet">
        <!-- Google Fonts -->

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.1/css/bootstrap.min.css">
        <!-- Animation CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
        <!-- Title & Favicon -->
        <title>Geets</title>
        <!-- CSS Link -->
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/responsive.css">
        <link rel="stylesheet" href="css/style_register.css">
        <script src="https://kit.fontawesome.com/7cc69e0e3a.js" crossorigin="anonymous"></script>
        <style type="text/css">
            .error-alert{
                font-size: 1.2rem;
                color: red;
                text-align: center;
                margin-top: 1rem;
                display: none;
            }
            .erro{
                border: 1px solid red;
            }
            .correto{
                border: 1px solid greenyellow;
            }
        </style>

          <!-- Facebook Pixel Code -->
        <script>
            !function(f,b,e,v,n,t,s)
            {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};
            if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
            n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t,s)}(window, document,'script',
            'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '648834475963415');
            fbq('track', 'PageView');
            </script>
            <noscript><img height="1" width="1" style="display:none"
            src="https://www.facebook.com/tr?id=648834475963415&ev=PageView&noscript=1"
            /></noscript>
            <!-- End Facebook Pixel Code -->
            
            <!-- Global site tag (gtag.js) - Google Analytics -->
            <script async
            src="https://www.googletagmanager.com/gtag/js?id=UA-173061804-1"></script>
            <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', 'UA-173061804-1');
            </script>
            
            <script type="text/javascript">
            (function(e,t,o,n,p,r,i){e.visitorGlobalObjectAlias=n;e[e.visitorGlobalObjectAlias]=e[e.visitorGlobalObjectAlias]||function(){(e[e.visitorGlobalObjectAlias].q=e[e.visitorGlobalObjectAlias].q||[]
            ).push(arguments)};e[e.visitorGlobalObjectAlias].l=(new
            Date).getTime();r=t.createElement("script");r.src=o;r.async=true;i=t.getElementsByTagName
            ("script")[0];i.parentNode.insertBefore(r,i)})(window,document,"https://diffuser-cdn.app-us1.com/diffuser/diffuser.js","vgo");
            vgo('setAccount', '26353360');
            vgo('setTrackByDefault', true);
            vgo('process');
        </script> 
    </head>

<body>

    <!-- Navbar Inicio -->
    <!-- Navbar For XXl Device -->
    <nav class="navbar navbar-expand-xl py-5 d-none d-xl-block">
        <div class="container">
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav mr-auto">
                  <li class="nav-item active-page">
                    <a class="nav-link" href="index.html">Home<span class="sr-only">(current)</span></a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#">Como Funciona</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#">Fale Conosco</a>
                  </li>
                </ul>
              </div>
            <a class="navbar-brand" href="index.html"><img width="100" src="Geets_Logo_contorno1.png" class="" alt="logo"></a>
            <div class="collapse navbar-collapse">
              <div class="ml-auto">
                <form class="form-inline my-2 my-lg-0">
                  <div class="navbar-btn">
                    <a href="login.php" class="btn-1 my-2 my-sm-0 ml-5">Entrar</a>
                    <a href="cadastro.html" class="btn-2 my-2 my-sm-0 ml-3">Cadastre-se</a>
                  </div>
                </form>
              </div>
            </div>
        </div>
    </nav>
    <!-- Navbar For XXl Device FIM -->

    <!-- Navbar For Mobile Device -->
    <nav class="navbar navbar-expand-xl py-5 d-xl-none">
        <div class="container">
          <a class="navbar-brand" href="index.html"><img width="100" src="Geets_Logo_contorno1.png" alt="logo"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse">
          <span style="font-size:25px;cursor:pointer" class="openNav">&#9776;</i></span>
        </button>
        <div id="myNav" class="overlay">
          <a href="javascript:void(0)" class="closebtn closeNav">&times;</a>
          <div class="overlay-content">
            <ul class="navbar-nav mr-auto">
              <li class="nav-item active-page">
                <a class="nav-link" href="index.html">Home<span class="sr-only">(current)</span></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Como Funciona</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Fale Conosco</a>
              </li>
            </ul>
            <form class="form-block my-2 my-lg-0">
              <div class="navbar-btn mt-3">
                <a href="login.php" class="btn-1 my-2 my-sm-0 mt-3">Entrar</a>
                <a href="cadastro.html" class="btn-2 my-2 my-sm-0 mt-3">Cadastre-se</a>
              </div>
            </form>
          </div>
        </div>

        </div>
    </nav>
    <!-- Navbar For Mobile Device FIM -->

    <!-- Form Register -->
    <form id="regForm" class="pf" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="nome" id="nome" value="<?php echo($_POST['nome']) ?>">
    <input type="hidden" name="email" id="email" value="<?php echo($_POST['email']) ?>">
    <input type="hidden" name="senha" value="<?php echo($_POST['senha']) ?>">
    <div class="mt-10">
        <section class="mx-auto mt-5 tab"> <!-- First Section -->
            <div class="form-register mx-auto position-relative">
                <div class="content-register mx-auto text-center w-75 pt-3"> <!-- Div for content-center -->
                    <p class="h1 tsize-2 pt-5 mb-5"> Complete seu Perfil</p>
                    <p class="form-text text-muted mb-5">Seu perfil ficará visível somente para as agências e coprodutores que você aplicar e demonstrar interesse em fazer parceria.</p>
                    <button type="button" class="btn w-100 mt-3 mb-5" onclick="nextPrev(1);">Começar</button>
                </div>
            </div>
        </section>


        <section class="mx-auto mt-5 tab"> <!-- First Section -->
            <div class="form-register mx-auto position-relative"> <!-- Div for box -->
                <div class="content-register mx-auto text-center"> <!-- Div for content-center -->
                    <p class="h1 tsize-2 pt-5"> Qual o seu perfil? </p>
                    <small id="help" class="form-text text-muted mb-5"> Ex: Gestor de tráfego. </small>
                        <div class="form-group w-75 mx-auto"> <!-- Div input -->
                            <input type="text" class="form-control input-small" id="perfil" name="perfil">
                            <span class="error-alert" id="erro-1">* Preencha o campo acima!</span>
                        </div>
                        <button type="button" class="btn w-75 mt-2" onclick="nextPrev(1);"> Prosseguir </button>
                </div>
            </div>
        </section>

        <section class="mx-auto mt-5 tab">
            <div class="form-register mx-auto position-relative mb-5">
                <div class="content-register mx-auto text-center">
                    <p class="h1 tsize-2 pt-5"> Escolha uma foto de perfil! </p>
                    <small id="help" class="form-text text-muted mb-5"> Clique no ícone para adicionar sua imagem. </small>
                    <div class="form-group mx-auto">
                        <label for="imgPerfil" class="user-file" style="cursor: pointer;">
                            <img src="img/user-solid.svg" id="imgPreview" width="200px" height="200px" style="border-radius: 100%;">
                        </label>
                            <input type="file" name="imgPerfil" id="imgPerfil" accept="image/png, image/jpeg, image/jpg">
                    </div>
                    <button type="button" class="btn w-75 mt-5" onclick="nextPrev(1);"> Prosseguir </button>
                    <button type="button" class="btn-back w-75 mt-3 mb-5" onclick="nextPrev(1)">  Pular <i class="fas fa-arrow-right"></i></button>
                </div>
            </div>
        </section>

        <section class="mx-auto mt-5 tab">
            <div class="form-register mx-auto position-relative">
                <div class="content-register mx-auto text-center w-75">
                    <p class="h1 mb-5 tsize-2 pt-5"> Escreva uma pequena descrição sobre você! </p>
                        <div class="form-group w-100 mx-auto">
                            <textarea class="form-control input-big" id="desc" name="desc"> </textarea>
                        </div>
                        <button type="button" class="btn w-100 mt-2" onclick="nextPrev(1);"> Prosseguir </button>
                        <button type="button" class="btn-back w-100 mt-3 mb-5" onclick="nextPrev(1)">  Pular <i class="fas fa-arrow-right"></i></button>

                </div>
            </div>
        </section>

        <section class="mx-auto mt-5 tab">
            <div class="form-register mx-auto position-relative">
                <div class="content-register mx-auto text-center w-75">
                    <p class="h1 mb-5 tsize-2 pt-5"> Qual a sua experiência nessa área e quais resultados já gerou? </p>
                        <div class="form-group w-100 mx-auto">
                            <textarea class="form-control input-big" id="experiencia" name="experiencia"> </textarea>
                        </div>
                        <button type="button" class="btn w-100 mt-2" onclick="nextPrev(1);"> Prosseguir </button>
                        <button type="button" class="btn-back w-100 mt-3 mb-5" onclick="nextPrev(1)">  Pular <i class="fas fa-arrow-right"></i></button>

                </div>
            </div>
        </section>

        <section class="mx-auto mt-5 tab">
            <div class="form-register mx-auto position-relative">
                <div class="content-register mx-auto text-center w-75">
                    <p class="h1 mb-5 tsize-2 pt-5"> Quais as suas principais características como profissional? </p>
                        <div class="form-group w-100 mx-auto">
                            <textarea class="form-control input-big" id="caracteristicas" name="caracteristicas"> </textarea>
                        </div>
                        <button type="button" class="btn w-100 mt-2" onclick="nextPrev(1);"> Prosseguir </button>
                        <button type="button" class="btn-back w-100 mt-3 mb-5" onclick="nextPrev(1)">  Pular <i class="fas fa-arrow-right"></i></button>

                </div>
            </div>
        </section>

        <section class="mx-auto mt-5 tab">
            <div class="form-register mx-auto position-relative">
                <div class="content-register mx-auto text-center w-75">
                    <p class="h1 mb-4 tsize-2 pt-5"> Quais treinamentos você já fez que foram relevantes para o seu crescimento pessoal e profissional? </p>
                        <div class="form-group w-100 mx-auto">
                            <textarea class="form-control input-big" id="treinamentos" name="treinamentos"> </textarea>
                        </div>
                        <button type="button" class="btn w-100 mt-2" onclick="nextPrev(1);"> Prosseguir </button>
                        <button type="button" class="btn-back w-100 mt-3 mb-5" onclick="nextPrev(1)">  Pular <i class="fas fa-arrow-right"></i></button>

                </div>
            </div>
        </section>

        <section class="mx-auto mt-5 tab">
            <div class="form-register mx-auto position-relative">
                <div class="content-register mx-auto text-center w-75">
                    <p class="h1 mb-5 tsize-2 pt-5"> Participa de alguma comunidade digital? Qual? </p>
                        <div class="form-group w-100 mx-auto">
                            <input type="text" class="form-control input-small" id="comunidadeDigital" name="comunidadeDigital">
                        </div>
                        <button type="button" class="btn w-100 mt-4" onclick="nextPrev(1);"> Prosseguir </button>
                        <button type="button" class="btn-back w-100 mt-3 mb-5" onclick="nextPrev(1)">  Pular <i class="fas fa-arrow-right"></i></button>

                </div>
            </div>
        </section>

        <section class="mx-auto mt-5 tab">
            <div class="form-register mx-auto position-relative">
                <div class="content-register mx-auto text-center w-75">
                    <p class="h1 mb-4 tsize-2 pt-5"> Coloque os links das suas redes sociais: </p>
                        <div class="form-group w-100 mx-auto">
                            <input type="text" class="form-control input-small mb-3" id="facebook" placeholder="Facebook" name="facebook">
                            <input type="text" class="form-control input-small mb-3" id="instagram" placeholder="Instagram" name="instagram">
                            <input type="text" class="form-control input-small" id="youtube" placeholder="Youtube" name="youtube">
                        </div>
                        <button type="button" class="btn w-100 mt-2" onclick="nextPrev(1);"> Prosseguir </button>
                        <button type="button" class="btn-back w-100 mt-3 mb-5" onclick="nextPrev(1)">  Pular <i class="fas fa-arrow-right"></i></button>

                </div>
            </div>
        </section>

        <section class="mx-auto mt-5 tab">
            <div class="form-register mx-auto position-relative mb-5">
                <div class="content-register mx-auto text-center w-75">
                    <p class="h1 mb-5 tsize-2 pt-5"> Perfil criado com sucesso! </p>
                        <div class="form-group w-100 mx-auto">
                            <i class="fas fa-check-circle success-icon"></i>
                        </div>
                        <button type="submit" class="btn w-100 mt-5 mb-5" name="cadastrar"> Finalizar </button>
                </div>
            </div>
        </section>

    </div>
    </form>
    <!-- Form Register END -->

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.1/js/bootstrap.min.js"></script>
    <!-- Main JS -->
    <script src="js/main.js"></script>
    <!-- WoW JS -->
    <script src="js/wow.min.js"></script>
    <script>
    new WOW().init();
    </script>
    <script src="js/functions.js"></script>
</body>
</html>
<script src="js/vendor/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        $("#regForm").submit(function(){
            var email = $("#email").val();
            var nome = $("#nome").val();
            $.ajax({
                url:"activecampaign.php",
                type: 'POST',
                data: {
                    email:email,
                    nome:nome,
                    tipo:"pf"
                },
                success: function(response){
                    console.log(response);
                }
            });
        });
    });
</script>