<?php

session_start();
include "db.php";



$sql1 = "SELECT * FROM propostas WHERE id_projeto IN (SELECT id FROM projetos WHERE id_usuario = '".$_SESSION['usuarioId']."') AND lido = 0";
$query1 = mysqli_query($mysqli, $sql1);
$contar_query1 = mysqli_num_rows($query1);

$sql0 = "SELECT COUNT(id) AS total FROM propostas WHERE id_projeto IN (SELECT id FROM projetos WHERE id_usuario = '".$_SESSION['usuarioId']."') AND lido = 0";
$query0 = mysqli_query($mysqli, $sql0);
$dados0  = mysqli_fetch_assoc($query0);

?>

<input id="contagem" type="hidden" value="<?php  echo $dados0['total']; ?>">
<input id="countTotal" type="hidden" value="<?php  echo $contar_query1; ?>">


<?php  while($dados1 = mysqli_fetch_array($query1)){ 

	$sql2 = "SELECT * FROM usuarios WHERE id = '".$dados1['id_usuario']."'";
	$query2 = mysqli_query($mysqli, $sql2);
	$dados2 = mysqli_fetch_assoc($query2);

	$sql3 = "SELECT * FROM projetos WHERE id = '".$dados1['id_projeto']."'";
	$query3 = mysqli_query($mysqli, $sql3);
	$dados3 = mysqli_fetch_assoc($query3);

	$sql99 = "UPDATE propostas SET lido = 1 WHERE id = '".$dados1['id']."'";
	$query99 = mysqli_query($mysqli, $sql99);
	$dados99 = mysqli_fetch_assoc($query99);

?>


	<li>
		<a href="detalhe-projeto?id=<?php  echo $dados3['id']; ?>">
			<div class="notification-details">
				<p class="notification-text"><b>Você recebeu uma proposta de <?php  echo $dados2['nome']; ?></b> em <?php  echo $dados3['titulo']; ?> <b><?php  echo $dados3['habilidades']; ?></b></p>
				<p class="notification-time">Em <?php  echo date('d/m/Y', strtotime($dados1['data_cadastro'])); ?> às <?php  echo date('H:i', strtotime($dados1['hora_cadastro'])); ?></p>
			</div>
		</a>
	</li>
<?php }?>

<?php 

$mysqli = null;

?>



