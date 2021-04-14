<?php
include_once("vendor/autoload.php");

MercadoPago\SDK::setAccessToken("APP_USR-8973314729985759-092919-bf4366ea70ea090cfc0195890550d6ca-440248070");


$payment = MercadoPago\Payment::find_by_id($_GET["id"]);

$fp=fopen('log.txt','a');
/*$html='';
foreach ($_GET as $key => $value){
    $html.=$key.'=>'.$value.' | ';
}*/
$html=$payment->{'status'}.' | '.$payment->{'status_detail'}.' | '.$payment->{'description'};
$write=fwrite($fp,$html);
fclose($fp);


$mysqli = new mysqli('mysql.hostinger.com.br','u614302657_geets','Dspm7356@','u614302657_geets');


if ($payment->{'status'} == 'pending') {
    $sql1 = "UPDATE fatura SET status = 'Aguardando Pagamento' WHERE id = '".$payment->{'external_reference'}."'";
    $query1 = mysqli_query($mysqli, $sql1);
}elseif($payment->{'status'} == 'approved'){
    $sql1 = "UPDATE fatura SET status = 'Aprovado' WHERE id = '".$payment->{'external_reference'}."'";
    $query1 = mysqli_query($mysqli, $sql1);

    $sql3 = "SELECT * FROM fatura WHERE id = '".$payment->{'external_reference'}."'";
    $query3 = mysqli_query($mysqli, $sql3);
    $dados3 = mysqli_fetch_assoc($query3);

    $sql2 = "UPDATE projetos SET status = 1 WHERE id = '".$dados3['id_projetos']."' ";
    $query2 = mysqli_query($mysqli, $sql2);

}elseif($payment->{'status'} == 'rejected'){
    $sql1 = "UPDATE fatura SET status = 'Reprovado' WHERE id = '".$payment->{'external_reference'}."'";
    $query1 = mysqli_query($mysqli, $sql1);
}



?>