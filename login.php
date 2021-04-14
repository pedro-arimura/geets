<?php 
session_start();

    $mysqli = new mysqli('localhost','root','','id15265491_geets');
  // DEFINE O FUSO HORARIO COMO O HORARIO DE BRASILIA
    date_default_timezone_set('America/Sao_Paulo');

if (isset($_POST['acessar'])) {
  
  $sql1 = "SELECT * FROM usuarios WHERE email = '".$_POST['email']."' AND senha = '".$_POST['senha']."'";
  $query1 = mysqli_query($mysqli, $sql1);
  $dados1 = mysqli_fetch_assoc($query1);

  if (isset($dados1)) {
    $_SESSION['usuarioId'] = $dados1['id'];
    $_SESSION['usuarioNome'] = $dados1['nome'];
    $_SESSION['usuarioSenha'] = $dados1['senha'];
    $_SESSION['usuarioNiveisAcessoId'] = $dados1['niveis_acesso_id'];
    $_SESSION['usuarioEmail'] = $dados1['email'];
    $_SESSION['tipo_perfil'] = $dados1['id_tipo_perfil'];
    if ($_SESSION['usuarioNiveisAcessoId'] == 2) {
      header("Location: home.php");
    }elseif($_SESSION['usuarioNiveisAcessoId'] == 1){
      header("Location: home.php");
    }elseif($_SESSION['usuarioNiveisAcessoId'] == 3){
      header("Location: master.php");
    }else{
      session_destroy();
      header("Location: login.php?error");
    }


  }else{
    $erro = true;
  }
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
            <noscript>
            <img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=648834475963415&ev=PageView&noscript=1"/>
            </noscript>
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

  <form method="POST">
    <div class="mt-5">
        <section class="mx-auto mt-5" style="padding-bottom: 9rem;">
            <h2 class="heading wow animate__animated animate__fadeInUp animate__slow text-light">Acesse sua conta</h2>
            <div class="form-register-login mx-auto position-relative">
              <div class="content-register mx-auto pt-5">
                                <?php if(isset($erro)){
                echo('<div class="alert alert-danger w-75 mx-auto" role="alert" style="font-size:1.4rem;">
                  Login e/ou senha incorretos!
                </div>');
              }
              ?>
                        <div class="form-group w-75 mx-auto mt-2">
                            <label class="input-label" for="email"> E-mail: </label><input type="text" name="email" class="form-control input-small" id="email">
                            <label class="input-label mt-4" for="senha"> Senha: </label><input type="password" name="senha" class="form-control input-small mb-4" id="senha">
                            <a href="#" class="" style="font-size: 1.3rem;"> Esqueci a senha </a>
                        </div>
                        <div class="text-center mt-4">
                            <button type="submit" name="acessar" class="btn w-75  mb-5"> Entrar </button>
                        </div>
              </div>
            </div>
        </section>
      </div>
    </form>

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