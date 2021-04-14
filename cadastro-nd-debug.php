<?php 
    $mysqli = new mysqli('localhost','root','','new-bd-geets');
	// DEFINE O FUSO HORARIO COMO O HORARIO DE BRASILIA
    date_default_timezone_set('America/Sao_Paulo');
    
    $verify = $mysqli->query("SELECT * FROM usuarios WHERE email ='".$_POST['email']."'");
    $verify = $verify->num_rows;
    if($verify < 1){
        if(isset($_POST['cadastrar'])){
            $insertUsuario = $mysqli->query("INSERT INTO usuarios VALUES (DEFAULT,'$_POST[nome]','$_POST[email]','$_POST[senha]','1', '1','".date('Y-m-d')."','".date('H:i:s')."')");
            $getId = $mysqli->query("SELECT * FROM usuarios WHERE email ='". $_POST['email']."'");
            $getId = $getId->fetch_assoc();
            $diretorio = "thumb/";

            $capa = isset($_FILES['imgPerfil']) ? $_FILES['imgPerfil'] : FALSE;
            $m = md5($getId['id']);
            $destino1 = $diretorio."/"."1".$m.$capa['name'];
            move_uploaded_file($capa['tmp_name'], $destino1);

            $capa = "1".$m.$capa['name'];
            $insertPerfil = $mysqli->query("INSERT INTO perfil_negocio_digital VALUES(DEFAULT, '$getId[id]', '$_POST[nome]', '$_POST[modelo]', '$capa', '$_POST[sede]', '$_POST[desc]', '$_POST[atuacao]', '$_POST[pilaresnegocio]', '$_POST[diferenciais]', '$_POST[idade]', '$_POST[movimentacao]', '$_POST[facebook]', '$_POST[instagram]', '$_POST[youtube]')");

            // Criando sessão
            session_start();
            $_SESSION['usuarioId'] = $getId['id'];
            $_SESSION['usuarioNome'] = $getId['nome'];
            $_SESSION['usuarioSenha'] = $getId['senha'];
            $_SESSION['usuarioNiveisAcessoId'] = $getId['niveis_acesso_id'];
            $_SESSION['usuarioEmail'] = $getId['email'];
            /*
            if ($_SESSION['usuarioNiveisAcessoId'] == 2) {
              header("Location: home.php");
            }elseif($_SESSION['usuarioNiveisAcessoId'] == 1){
              header("Location: home.php");
            }elseif($_SESSION['usuarioNiveisAcessoId'] == 3){
              header("Location: master.php");
            }else{
              session_destroy();
              header("Location: cadastro-nd.php?error");
            }
            */
        }
    }
    /*

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
                    <a href="entrar" class="btn-1 my-2 my-sm-0 ml-5">Entrar</a>
                    <a href="entrar" class="btn-2 my-2 my-sm-0 ml-3">Cadastre-se</a>
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
                <a href="entrar" class="btn-1 my-2 my-sm-0 mt-3">Entrar</a>
                <a href="entrar" class="btn-2 my-2 my-sm-0 mt-3">Cadastre-se</a>
              </div>
            </form>
          </div>
        </div>

        </div>
    </nav>
    <!-- Navbar For Mobile Device FIM -->

    <!-- Form Register -->
    <form id="regForm" class="nd" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="nome" value="<?php echo($_POST['nome']) ?>">
    <input type="hidden" name="email" value="<?php echo($_POST['email']) ?>">
    <input type="hidden" name="senha" value="<?php echo($_POST['senha']) ?>">
    <input type="hidden" name="cadastro" value="cadastro">
    <div class="mt-10">

        <section class="mx-auto mt-5 tab"> <!-- First Section -->
            <div class="form-register mx-auto position-relative">
                <div class="content-register mx-auto text-center w-75 pt-3"> <!-- Div for content-center -->
                    <p class="h1 tsize-2 pt-5 mb-5"> Complete seu Perfil</p>
                    <p class="form-text text-muted mb-5">O perfil do seu negócio ficará visível e poderá receber aplicações de experts e profissionais interessados em fazer parceria.</p>
                    <button type="button" class="btn w-100 mt-3 mb-5" onclick="nextPrev(1);">Começar</button>
                </div>
            </div>
        </section>

        <section class="mx-auto mt-5 tab">
            <div class="form-register mx-auto position-relative"> <!-- Div for box -->
                <div class="content-register mx-auto text-center"> <!-- Div for content-center -->
                    <p class="h1 tsize-2 pt-5"> Qual o modelo do seu negócio? </p>
                    <small id="help" class="form-text text-muted mb-5"> Ex: Agência de lançamentos, coprodutor, etc. </small>
                        <div class="form-group w-75 mx-auto"> <!-- Div input -->
                            <input type="text" class="form-control input-small" id="modelo" name="modelo" onblur="validaBlur();" maxlength="255">
                            <span class="error-alert" id="erro-1">* Preencha o modelo do seu negócio!</span>
                        </div>
                        <button type="button" class="btn w-75 mt-2" id="nextBtn" onclick="nextPrev(1)"> Prosseguir </button>
                        <button type="button" class="btn-back w-75 mt-3 mb-5" id="prevBtn" onclick="nextPrev(-1)"> &lt;&nbsp; Voltar </button>
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
                                <input type="file" name="imgPerfil" id="imgPerfil" accept="image/png, image/jpeg, image/jpg" onblur="validaBlur();">
                                <span class="error-alert" id="erro-2">* Escolha uma foto de perfil!</span>
                        </div>
                        <button type="button" class="btn w-75 mt-5" onclick="nextPrev(1)"> Prosseguir </button>
                        <button type="button" class="btn-back w-75 mt-3 mb-5" id="prevBtn" onclick="nextPrev(-1)"> &lt;&nbsp; Voltar </button>
                </div>
            </div>
        </section>

        <section class="mx-auto mt-5 tab">
            <div class="form-register mx-auto position-relative">
                <div class="content-register mx-auto text-center w-75">
                    <p class="h1 mb-5 tsize-2 pt-5"> Onde fica a sede da empresa? </p>
                        <div class="form-group w-100 mx-auto mb-5">
                            <input class="form-control input-small" list="sedes" name="sede" id="sede" onblur="validaBlur();">
                            <span class="error-alert" id="erro-3">* Preencha a informação sobre sua sede!</span>
                            <datalist id="sedes">
                                <option value="Opção 1">
                                <option value="Opção 2">
                                <option value="Opção 3">
                                <option value="Opção 4">
                                <option value="Opção 5">
                              </datalist>
                        </div>
                        <button type="button" class="btn w-100 mt-2" id="nextBtn" onclick="nextPrev(1)"> Prosseguir </button>
                        <button type="button" class="btn-back w-100 mt-3 mb-5" onclick="nextPrev(-1)"> &lt;&nbsp; Voltar </button>
                </div>
            </div>
        </section>

        <section class="mx-auto mt-5 tab">
            <div class="form-register mx-auto position-relative">
                <div class="content-register mx-auto text-center w-75">
                    <p class="h1 mb-5 tsize-2 pt-5"> Escreva uma pequena descrição sobre o seu negócio. </p>
                        <div class="form-group w-100 mx-auto">
                            <textarea class="form-control input-big" id="desc" name="desc" onblur="validaBlur();" maxlength="1500"> </textarea>
                            <span class="error-alert" id="erro-4">* Preencha sua descrição!</span>
                        </div>
                        <button type="button" class="btn w-100 mt-2" id="nextBtn" onclick="nextPrev(1)"> Prosseguir </button>
                        <button type="button" class="btn-back w-100 mt-3 mb-5" onclick="nextPrev(-1)"> &lt;&nbsp; Voltar </button>
                </div>
            </div>
        </section>

        <section class="mx-auto mt-5 tab">
            <div class="form-register mx-auto position-relative">
                <div class="content-register mx-auto text-center w-75">
                    <p class="h1 mb-5 tsize-2 pt-5"> Fale sobre os projetos que atua e se tem preferência por algum nicho. </p>
                        <div class="form-group w-100 mx-auto">
                            <textarea class="form-control input-big" id="atuacao" name="atuacao" onblur="validaBlur();" maxlength="1500"> </textarea>
                            <span class="error-alert" id="erro-5">* Preencha o campo sobre sua atuação!</span>
                        </div>
                        <button type="button" class="btn w-100 mt-2" id="nextBtn" onclick="nextPrev(1)"> Prosseguir </button>
                        <button type="button" class="btn-back w-100 mt-3 mb-5" onclick="nextPrev(-1)"> &lt;&nbsp; Voltar </button>
                </div>
            </div>
        </section>

        <section class="mx-auto mt-5 tab">
            <div class="form-register mx-auto position-relative">
                <div class="content-register mx-auto text-center w-75">
                    <p class="h1 mb-4 tsize-2 pt-5"> Fale sobre os principais pilares que seu negócio atende. </p>
                    <small id="help" class="form-text text-muted mb-5"> Ex: Lançamento, produção de infoproduto, etc. </small>
                        <div class="form-group w-100 mx-auto">
                            <textarea class="form-control input-big" id="pilaresnegocio" name="pilaresnegocio" onblur="validaBlur();" maxlength="1500"> </textarea>
                            <span class="error-alert" id="erro-6">* Preencha as informações sobre seu negócio!</span>
                        </div>
                        <button type="button" class="btn w-100 mt-2" id="nextBtn" onclick="nextPrev(1)"> Prosseguir </button>
                        <button type="button" class="btn-back w-100 mt-3 mb-5" onclick="nextPrev(-1)"> &lt;&nbsp; Voltar </button>
                </div>
            </div>
        </section>

        <section class="mx-auto mt-5 tab">
            <div class="form-register mx-auto position-relative">
                <div class="content-register mx-auto text-center w-75">
                    <p class="h1 mb-4 tsize-2 pt-5"> Quais os diferenciais do seu negócio e os principais resultados gerados? </p>
                        <div class="form-group w-100 mx-auto">
                            <textarea class="form-control input-big" id="diferenciais" name="diferenciais" onblur="validaBlur();" maxlength="1500"> </textarea>
                            <span class="error-alert" id="erro-7">* Fale um pouco de seus diferenciais!</span>
                        </div>
                        <button type="button" class="btn w-100 mt-2" id="nextBtn" onclick="nextPrev(1)"> Prosseguir </button>
                        <button type="button" class="btn-back w-100 mt-3 mb-5" onclick="nextPrev(-1)"> &lt;&nbsp; Voltar </button>
                </div>
            </div>
        </section>

        <section class="mx-auto mt-5 tab">
            <div class="form-register mx-auto position-relative">
                <div class="content-register mx-auto text-center w-75">
                    <p class="h1 mb-5 tsize-2 pt-5"> Há quanto tempo está atuando no mercado? </p>
                        <div class="form-group w-100 mx-auto">
                            <input type="text" class="form-control input-small" id="idade" name="idade" onblur="validaBlur();" maxlength="255">
                            <span class="error-alert" id="erro-8">* Preencha o campo acima!</span>
                        </div>
                        <button type="button" class="btn w-100 mt-4" onclick="nextPrev(1)"> Prosseguir </button>
                        <button type="button" class="btn-back w-100 mt-3 mb-5" onclick="nextPrev(-1)"> &lt;&nbsp; Voltar </button>
                </div>
            </div>
        </section>

        <section class="mx-auto mt-5 tab">
            <div class="form-register mx-auto position-relative">
                <div class="content-register mx-auto text-center w-75">
                    <p class="h1 mb-5 tsize-2 pt-5"> Quanto a empresa já movimentou? </p>
                        <div class="form-group w-100 mx-auto">
                            <input type="text" class="form-control input-small" id="movimentacao" name="movimentacao" onblur="validaBlur();" maxlength="255">
                            <span class="error-alert" id="erro-9">* Preencha o campo acima!</span>
                        </div>
                        <button type="button" class="btn w-100 mt-4" onclick="nextPrev(1)"> Prosseguir </button>
                        <button type="button" class="btn-back w-100 mt-3 mb-5" onclick="nextPrev(-1)"> &lt;&nbsp; Voltar </button>
                </div>
            </div>
        </section>

        <section class="mx-auto mt-5 tab">
            <div class="form-register mx-auto position-relative">
                <div class="content-register mx-auto text-center w-75">
                    <p class="h1 mb-4 tsize-2 pt-5"> Coloque os links das suas redes sociais: </p>
                        <div class="form-group w-100 mx-auto">
                            <input type="text" class="form-control input-small mb-3" id="texto" placeholder="Facebook" name="facebook" maxlength="255">
                            <input type="text" class="form-control input-small mb-3" id="texto" placeholder="Instagram" name="instagram" maxlength="255">
                            <input type="text" class="form-control input-small" id="texto" placeholder="Youtube" name="youtube" maxlength="255">
                        </div>
                    <button type="button" class="btn w-100 mt-2" id="nextBtn" onclick="nextPrev(1)"> Prosseguir </button>
                    <button type="button" class="btn-back w-100 mt-3 mb-5" onclick="nextPrev(-1)"> &lt;&nbsp; Voltar </button>
                </div>
            </div>
        </section>

        <section class="mx-auto mt-5 tab">
            <div class="form-register mx-auto position-relative ">
                <div class="content-register mx-auto text-center w-75">
                    <p class="h1 mb-5 tsize-2 pt-5"> Perfil criado com sucesso! </p>
                        <div class="form-group w-100 mx-auto">
                            <i class="fas fa-check-circle success-icon"></i>
                        </div>
                        <button type="submit" class="btn w-100 mb-5 mt-5" name="cadastrar"> Finalizar </button>
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
    
</body>
</html>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Basic script, just for tests -->
<script type="text/javascript" src="js/functions.js"></script>
*/
?>