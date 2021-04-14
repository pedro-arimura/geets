<?php

session_start();

$mysqli = new mysqli('localhost','root','','id15265491_geets');
// DEFINE O FUSO HORARIO COMO O HORARIO DE BRASILIA
date_default_timezone_set('America/Sao_Paulo');

// A sessão precisa ser iniciada em cada página diferente
if (!isset($_SESSION)) session_start();

$nivel_necessario = array('2','1');

if (!isset($_SESSION['usuarioNiveisAcessoId'])) {
    // Destrói a sessão por segurança
    session_destroy();

    echo "Nível não definido";

    // Redireciona o visitante de volta pro login
    header("Location: index.php"); exit;
}
elseif ( ! in_array( $_SESSION['usuarioNiveisAcessoId'], $nivel_necessario ) )
{
    session_destroy();
    echo "Sem permissão"; exit;
}

if ($_SESSION['usuarioNiveisAcessoId'] == 2) {
    $retorno = "profissional";
}elseif ($_SESSION['usuarioNiveisAcessoId'] == 1) {
    $retorno = "empresa";
}


/*
if (isset($_GET['realizar_filtro'])) {


    $sql1 = "SELECT * FROM usuarios WHERE niveis_acesso_id = 2 AND id IN (SELECT id_usuarios FROM habilidades_usuarios WHERE habilidade IN('".implode("','", $_GET['habilidades'])."') )";
    $query1 = mysqli_query($mysqli, $sql1);



    
}else{
    $sql1 = "SELECT * FROM usuarios WHERE niveis_acesso_id = 2 ";
    $query1 = mysqli_query($mysqli, $sql1);
}

$sql4 = "SELECT * FROM habilidades ORDER BY nome ASC";
$query4 = mysqli_query($mysqli, $sql4);
*/


?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<meta name="application-name" content="">
	<meta name="description" content="">
	<title>Chat</title>

	<link rel="stylesheet" href="dist/css/vendor/bootstrap.min.css">

	<link rel="stylesheet" href="dist/css/vendor/font-awesome/css/font-awesome.min.css">

    <link rel="stylesheet" href="dist/css/main.css">
    
    <link rel="stylesheet" href="dist/css/responsive.css">
</head>
<body>
    <?php
        include("header.php");
    ?>

	<section id="chatting-page" style="padding-top: 85px;">
        <div class="container-fluid pr-4 pl-4">
            <div class="chatting-page">
               	<div class="row">
                    <div class="col-sm-12 col-md-4 col-lg-4 order-sm-1 order-2" style="max-height: 72vh;">
                        <div class="chat-freelancers" style="height: 100%;">
                            <div class="search">
                                <input type="text" placeholder="&#xf002;  Search..">
                            </div>
                            <div class="menu">
                                <ul class="nav nav-tabs">
                                    <li>
                                    <a data-toggle="tab" href="#inbox" role="tablist">Inbox</a>
                                    </li>
                                    <li>
                                    <a data-toggle="tab" href="#unread" role="tablist">Unread</a>
                                    </li>
                                    <li>
                                    <a data-toggle="tab" href="#archived" role="tablist">Archived</a>
                                    </li>
                                    <li>
                                    <a data-toggle="tab" href="#all" role="tablist">All</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-content"  style="overflow: auto; height: 100%;" >
                                <div class="tab-pane fade show active" id="inbox">
                                    <div class="users">
                                        <ul>
                                            <li class="active">
                                                <div class="user-img">
                                                    <a href="#"><img src="img/chatting/user1.jpg" alt=""></a>
                                                    <span class="online-icon"></span>
                                                </div>
                                                <div class="user-details">
                                                    <a href="#" class="user-name">Amazingsoftware</a>
                                                    <a href="#" class="user-description">Multi Vendor Website</a>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="user-img">
                                                    <a href="#"><img src="img/chatting/user2.jpg" alt=""></a>
                                                    <span class="online-icon"></span>
                                                </div>
                                                <div class="user-details">
                                                    <a href="#" class="user-name">John</a>
                                                    <a href="#" class="user-description">Write Some Software</a>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="user-img">
                                                    <a href="#"><img src="img/chatting/user3.jpg" alt=""></a>
                                                    <span class="online-icon"></span>
                                                    <span class="msg-alert">04</span>
                                                </div>
                                                <div class="user-details">
                                                    <a href="#" class="user-name">BabyGirl</a>
                                                    <a href="#" class="user-description">Create Powerpoint Temp-</a>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="user-img">
                                                    <a href="#"><img src="img/chatting/user4.jpg" alt=""></a>
                                                    <span class="online-icon"></span>
                                                    <span class="msg-alert">01</span>
                                                </div>
                                                <div class="user-details">
                                                    <a href="#" class="user-name">Tinno87</a>
                                                    <a href="#" class="user-description">Simple CSS for Wordpress</a>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="user-img">
                                                    <a href="#"><img src="img/chatting/user5.jpg" alt=""></a>
                                                    <span class="online-icon"></span>
                                                </div>
                                                <div class="user-details">
                                                    <a href="#" class="user-name">MarketingWizard</a>
                                                    <a href="#" class="user-description">Write code get google drive</a>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="user-img">
                                                    <a href="#"><img src="img/chatting/user6.jpg" alt=""></a>
                                                    <span class="online-icon"></span>
                                                </div>
                                                <div class="user-details">
                                                    <a href="#" class="user-name">Janelia</a>
                                                    <a href="#" class="user-description">Google Write Code</a>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="user-img">
                                                    <a href="#"><img src="img/chatting/user7.jpg" alt=""></a>
                                                    <span class="online-icon"></span>
                                                </div>
                                                <div class="user-details">
                                                    <a href="#" class="user-name">Fawad</a>
                                                    <a href="#" class="user-description">HTML Builder</a>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="user-img">
                                                    <a href="#"><img src="img/chatting/user8.jpg" alt=""></a>
                                                    <span class="online-icon"></span>
                                                </div>
                                                <div class="user-details">
                                                    <a href="#" class="user-name">CreativeMan</a>
                                                    <a href="#" class="user-description">CSS expert need</a>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="user-img">
                                                    <a href="#"><img src="img/chatting/user9.jpg" alt=""></a>
                                                    <span class="online-icon"></span>
                                                </div>
                                                <div class="user-details">
                                                    <a href="#" class="user-name">DevineDesign</a>
                                                    <a href="#" class="user-description">Woo Commerce</a>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="user-img">
                                                    <a href="#"><img src="img/chatting/user10.jpg" alt=""></a>
                                                    <span class="online-icon"></span>
                                                </div>
                                                <div class="user-details">
                                                    <a href="#" class="user-name">Kallen08</a>
                                                    <a href="#" class="user-description">Web Development</a>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="user-img">
                                                    <a href="#"><img src="img/chatting/user11.jpg" alt=""></a>
                                                    <span class="online-icon"></span>
                                                </div>
                                                <div class="user-details">
                                                    <a href="#" class="user-name">JannetLewis</a>
                                                    <a href="#" class="user-description">Design a logo</a>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="user-img">
                                                    <a href="#"><img src="img/chatting/user12.jpg" alt=""></a>
                                                    <span class="online-icon"></span>
                                                </div>
                                                <div class="user-details">
                                                    <a href="#" class="user-name">MasterHacker</a>
                                                    <a href="#" class="user-description">Build a Professional Website</a>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="user-img">
                                                    <a href="#"><img src="img/chatting/user13.jpg" alt=""></a>
                                                    <span class="online-icon"></span>
                                                </div>
                                                <div class="user-details">
                                                    <a href="#" class="user-name">James89</a>
                                                    <a href="#" class="user-description">Design a Logo</a>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="user-img">
                                                    <a href="#"><img src="img/chatting/user14.jpg" alt=""></a>
                                                    <span class="online-icon"></span>
                                                </div>
                                                <div class="user-details">
                                                    <a href="#" class="user-name">CreativeMan</a>
                                                    <a href="#" class="user-description">CSS expert need</a>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="unread">
                                    <div class="users">
                                        <ul>
                                        <li class="active">
                                            <div class="user-img">
                                                <a href="#"><img src="img/chatting/user1.jpg" alt=""></a>
                                                <span class="online-icon"></span>
                                            </div>
                                            <div class="user-details">
                                                <a href="#" class="user-name">Amazingsoftware</a>
                                                <a href="#" class="user-description">Multi Vendor Website</a>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="user-img">
                                                <a href="#"><img src="img/chatting/user4.jpg" alt=""></a>
                                                <span class="online-icon"></span>
                                                <span class="msg-alert">01</span>
                                            </div>
                                            <div class="user-details">
                                                <a href="#" class="user-name">Tinno87</a>
                                                <a href="#" class="user-description">Simple CSS for Wordpress</a>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="user-img">
                                                <a href="#"><img src="img/chatting/user9.jpg" alt=""></a>
                                                <span class="online-icon"></span>
                                            </div>
                                            <div class="user-details">
                                                <a href="#" class="user-name">DevineDesign</a>
                                                <a href="#" class="user-description">Woo Commerce</a>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="user-img">
                                                <a href="#"><img src="img/chatting/user11.jpg" alt=""></a>
                                                <span class="online-icon"></span>
                                            </div>
                                            <div class="user-details">
                                                <a href="#" class="user-name">JannetLewis</a>
                                                <a href="#" class="user-description">Design a logo</a>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="user-img">
                                                <a href="#"><img src="img/chatting/user8.jpg" alt=""></a>
                                                <span class="online-icon"></span>
                                            </div>
                                            <div class="user-details">
                                                <a href="#" class="user-name">CreativeMan</a>
                                                <a href="#" class="user-description">CSS expert need</a>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="user-img">
                                                <a href="#"><img src="img/chatting/user14.jpg" alt=""></a>
                                                <span class="online-icon"></span>
                                            </div>
                                            <div class="user-details">
                                                <a href="#" class="user-name">CreativeMan</a>
                                                <a href="#" class="user-description">CSS expert need</a>
                                            </div>
                                        </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="archived">
                                    <div class="users">
                                        <ul>
                                        <li class="active">
                                            <div class="user-img">
                                                <a href="#"><img src="img/chatting/user3.jpg" alt=""></a>
                                                <span class="online-icon"></span>
                                                <span class="msg-alert">04</span>
                                            </div>
                                            <div class="user-details">
                                                <a href="#" class="user-name">BabyGirl</a>
                                                <a href="#" class="user-description">Create Powerpoint Temp-</a>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="user-img">
                                                <a href="#"><img src="img/chatting/user14.jpg" alt=""></a>
                                                <span class="online-icon"></span>
                                            </div>
                                            <div class="user-details">
                                                <a href="#" class="user-name">CreativeMan</a>
                                                <a href="#" class="user-description">CSS expert need</a>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="user-img">
                                                <a href="#"><img src="img/chatting/user13.jpg" alt=""></a>
                                                <span class="online-icon"></span>
                                            </div>
                                            <div class="user-details">
                                                <a href="#" class="user-name">James89</a>
                                                <a href="#" class="user-description">Design a Logo</a>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="user-img">
                                                <a href="#"><img src="img/chatting/user12.jpg" alt=""></a>
                                                <span class="online-icon"></span>
                                            </div>
                                            <div class="user-details">
                                                <a href="#" class="user-name">MasterHacker</a>
                                                <a href="#" class="user-description">Build a Professional Website</a>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="user-img">
                                                <a href="#"><img src="img/chatting/user9.jpg" alt=""></a>
                                                <span class="online-icon"></span>
                                            </div>
                                            <div class="user-details">
                                                <a href="#" class="user-name">DevineDesign</a>
                                                <a href="#" class="user-description">Woo Commerce</a>
                                            </div>
                                        </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="all">
                                    <div class="users">
                                        <ul>
                                        <li class="active">
                                            <div class="user-img">
                                                <a href="#"><img src="img/chatting/user4.jpg" alt=""></a>
                                                <span class="online-icon"></span>
                                                <span class="msg-alert">01</span>
                                            </div>
                                            <div class="user-details">
                                                <a href="#" class="user-name">Tinno87</a>
                                                <a href="#" class="user-description">Simple CSS for Wordpress</a>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="user-img">
                                                <a href="#"><img src="img/chatting/user3.jpg" alt=""></a>
                                                <span class="online-icon"></span>
                                                <span class="msg-alert">04</span>
                                            </div>
                                            <div class="user-details">
                                                <a href="#" class="user-name">BabyGirl</a>
                                                <a href="#" class="user-description">Create Powerpoint Temp-</a>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="user-img">
                                                <a href="#"><img src="img/chatting/user12.jpg" alt=""></a>
                                                <span class="online-icon"></span>
                                            </div>
                                            <div class="user-details">
                                                <a href="#" class="user-name">MasterHacker</a>
                                                <a href="#" class="user-description">Build a Professional Website</a>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="user-img">
                                                <a href="#"><img src="img/chatting/user14.jpg" alt=""></a>
                                                <span class="online-icon"></span>
                                            </div>
                                            <div class="user-details">
                                                <a href="#" class="user-name">CreativeMan</a>
                                                <a href="#" class="user-description">CSS expert need</a>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="user-img">
                                                <a href="#"><img src="img/chatting/user13.jpg" alt=""></a>
                                                <span class="online-icon"></span>
                                            </div>
                                            <div class="user-details">
                                                <a href="#" class="user-name">James89</a>
                                                <a href="#" class="user-description">Design a Logo</a>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="user-img">
                                                <a href="#"><img src="img/chatting/user9.jpg" alt=""></a>
                                                <span class="online-icon"></span>
                                            </div>
                                            <div class="user-details">
                                                <a href="#" class="user-name">DevineDesign</a>
                                                <a href="#" class="user-description">Woo Commerce</a>
                                            </div>
                                        </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-8 col-lg-8 order-sm-2 order-1">
                        <div class="chat-panel" style="max-height: 77vh; overflow: auto;" id="chat">
                            <div class="chat-header">
                            <p class="loading">Loading earlier messages..</p>
                            <p class="time">2:14pm | 5 April 2019</p>
                            </div>
                            <div class="chat">
                            <div class="chat-avatar">
                                <a href="#" data-toggle="tooltip" data-placement="right" data-original-title="Amazingsoftware"><img src="img/chatting/user15.jpg" alt=""></a>
                            </div>
                            <div class="chat-body">
                                <div class="chat-content">
                                    <p>Hello. What can i do for you?</p>
                                    <time class="chat-time">12:00</time>
                                </div>
                            </div>
                            </div>
                            <div class="chat chat-left">
                            <div class="chat-avatar">
                                <a href="#" data-toggle="tooltip" data-placement="left" data-original-title="James89"><img src="img/chatting/user1.jpg" alt=""></a>
                            </div>
                            <div class="chat-body">
                                <div class="chat-content">
                                    <p>I am just looking around. Will you tell me something about yourself? I am just looking around.</p>
                                    <time class="chat-time">12:05</time>
                                </div>
                                <div class="chat-content">
                                    <p>Are you there? That time?</p>
                                    <time class="chat-time">12:10</time>
                                </div>
                            </div>
                            </div>
                            <div class="chat">
                            <div class="chat-avatar">
                                <a href="#" data-toggle="tooltip" data-placement="right" data-original-title="Amazingsoftware"><img src="img/chatting/user15.jpg" alt=""></a>
                            </div>
                            <div class="chat-body">
                                <div class="chat-content">
                                    <p>Where?</p>
                                    <time class="chat-time">12:15</time>
                                </div>
                                <div class="chat-content">
                                    <p>OK, my name is Sasha Stain. I like singing, playing basketball and so on Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dignissimos quae cupiditate accusantium rerum fugiat quam deleniti beatae sapiente doloremque nam!</p>
                                    <time class="chat-time">12:17</time>
                                </div>
                            </div>
                            </div>
                            <div class="chat chat-left">
                            <div class="chat-avatar">
                                <a href="#" data-toggle="tooltip" data-placement="left" data-original-title="James89"><img src="img/chatting/user1.jpg" alt=""></a>
                            </div>
                            <div class="chat-body">
                                <div class="chat-content">
                                    <p>You wait for notice.</p>
                                    <time class="chat-time">12:20</time>
                                </div>
                                <div class="chat-content">
                                    <p>Do you want to join the concert?</p>
                                    <time class="chat-time">12:22</time>
                                </div>
                                <div class="chat-content">
                                    <p>Ok?</p>
                                    <time class="chat-time">12:24</time>
                                </div>
                            </div>
                            </div>
                            <div class="chat">
                            <div class="chat-avatar">
                                <a href="#" data-toggle="tooltip" data-placement="right" data-original-title="Amazingsoftware"><img src="img/chatting/user15.jpg" alt=""></a>
                            </div>
                            <div class="chat-body">
                                <div class="chat-content">
                                    <p>Ok!</p>
                                    <time class="chat-time">12:30</time>
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="chat-panel-footer">
                            <form action="#">
                                <div class="input-group form-material">
                                    <input type="text" class="form-control" placeholder="Enter your message">
                                    <div class="input-group-btn">
                                    <label for="input-file">
                                        <span class="btn btn-pure btn-default icon md-file-send waves-effect waves-light waves-round"></span>
                                        <input type="file" id="input-file">
                                    </label>
                                    <button type="button" class="btn btn-pure btn-default icon message-send waves-effect waves-light waves-round"></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
               </div>
            </div>
        </div>
    </section>

	<script src="js/vendor/font-awesome.js"></script>
	<script src="js/vendor/popper.min.js"></script>
    <script src="js/vendor/jquery-3.3.1.slim.min.js"></script>
	<script src="js/vendor/bootstrap.min.js"></script>
	<script src="js/vendor/jquery.min.js"></script>
    <script src="js/index.js"></script>
    <script>
        var chat = document.getElementById("chat");
        chat.scrollTop = chat.scrollHeight;
    </script>
</body>
</html>