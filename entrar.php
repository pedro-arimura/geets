<?
session_start();

  $mysqli = new mysqli('localhost','root','','new-bd-geets');
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
    print_r($dados1);
    if ($_SESSION['usuarioNiveisAcessoId'] == 2) {
      header("Location: profissional.php");
    }elseif($_SESSION['usuarioNiveisAcessoId'] == 1){
      echo("eeeeeee");
      header("Location: empresa.php");
    }elseif($_SESSION['usuarioNiveisAcessoId'] == 3){
      header("Location: master.php");
    }else{
      session_destroy();
      header("Location: entrar.php?error");
    }


  }else{
    header("Location: entrar.php?failed");
  }

}

?>
<!doctype html>
<html lang="pt-BR">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
  </head>
  <body> 
    <!-- ============================= Start header Section Here ============================= -->
    <header id="header-section">
      <!-- Navbar For XXl Device -->
      <nav class="navbar navbar-expand-xl py-5 d-none d-xl-block">
        <div class="container">
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav mr-auto">
                  <li class="nav-item active-page">
                    <a class="nav-link" href="index.html">Home<span class="sr-only">(current)</span></a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="/#como_funciona">Como Funciona</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="/#fale_conosco">Fale Conosco</a>
                  </li>
                </ul>
              </div>
            <a class="navbar-brand" href="#header-section"><img width="100" src="Geets_Logo_contorno1.png" class="" alt="logo"></a>
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
      <!-- Navbar For Mobile Device -->
      <nav class="navbar navbar-expand-xl py-5 d-xl-none">
        <div class="container">
          <a class="navbar-brand" href="#"><img width="100" src="Geets_Logo_contorno1.png" alt="logo"></a>
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
                <a href="#" class="btn-1 my-2 my-sm-0 mt-3">Entrar</a>
                <a href="#" class="btn-2 my-2 my-sm-0 mt-3">Cadastre-se</a>
              </div>
            </form>
          </div>
        </div>

        </div>
      </nav>
      <div class="header-content" style="padding-top: 25px !important;">
        <div class="container">
          <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
              <h2 class="heading  wow animate__animated animate__fadeInUp animate__slow">Vamos começar?</h2>

              <div class="row" style="padding-top: 40px;">
               


                  <div class="col-sm-6 col-lg-6 mb-6 form-group">
                    <a href="register/index.php">
                      <div class="custom-card img-fluid">
                        <div class="card-body">
                          <div class="card-img text-center"><img src="img/p-card-2.png" alt="image" class="img-fluid"></div>
                          <p class="card-text mt-5">NÃO TENHO CADASTRO</p>
                        </div>
                      </div>
                    </a>
                  </div>

                  <div class="col-sm-6 col-lg-6 mb-6" onclick="abrir2();">
                    <div class="custom-card img-fluid">
                      <div class="card-body">
                        <div class="card-img text-center"><img width="117" src="img/p-card-1.png" alt="image" class="img-fluid"></div>
                        <p class="card-text mt-5">JÁ TENHO UMA CONTA</p>

                        <div id="cad2" style="display: none;">
                                <form method="POST" action="">
                                    <label class="col-md-12" style="color: #4F66E8; font-size: 17px;">
                                        E-mail
                                        <input style="font-size: 17px;" type="email" name="email" class="form-control" required="">
                                    </label>

                                    <label class="col-md-12" style="color: #4F66E8; font-size: 17px;">
                                        Senha
                                        <input style="font-size: 17px;" required="" type="password" name="senha" class="form-control">
                                        <small>*Não informe sua senha para ninguém!</small>
                                    </label>

                                    <label class="col-md-12">
                                        <input style="font-size: 17px; border-style: none;" required="" type="submit" name="acessar" value="Entrar" class="primary-btn text-center col-md-12 btn-sm">
                                    </label>
                                </form>
                          </div>

                      </div>



                    </div>
                  </div>

                  <script type="text/javascript">
                      
                      function abrir2(){
                          document.getElementById('cad2').style.display="block";
                          document.getElementById('cad').style.display="none";
                      }

                  </script>

              </div>

            </div>
            <div class="col-md-1"></div>
          </div>

        </div>
      </div>
    </header>



    <!-- ============================= End Footer Section Here ============================= -->
    <!-- Back To Top -->
    <button id="myBtn" title="Go to top"><i class="fa fa-arrow-up" aria-hidden="true"></i></button>

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