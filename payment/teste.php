  <?
  include_once("vendor/autoload.php");


// Configura credenciais
  MercadoPago\SDK::setAccessToken('APP_USR-1306213234705543-092906-0cd634c058fff5b76bbee79e0cb41ced-652592122');

// Cria um objeto de preferência
$preference = new MercadoPago\Preference();


$external_reference = 'TESTE012';


// Cria um item na preferência
$item = new MercadoPago\Item();
$item->id = '123';
$item->title = 'Publicação Geets';
$item->quantity = 1;
$item->unit_price = 97.00;

/*$payer = new MercadoPago\Payer();
$payer->name = "Joao";
  $payer->surname = "Silva";
  $payer->email = "user@email.com";
  $payer->date_created = "2018-06-02T12:58:41.425-04:00";
  $payer->phone = array(
    "area_code" => "11",
    "number" => "4444-4444"
  );
    
  $payer->identification = array(
    "type" => "CPF",
    "number" => "19119119100"
  );
    
  $payer->address = array(
    "street_name" => "Street",
    "street_number" => 123,
    "zip_code" => "06233200"
  );
*/

$preference->items = array($item);
//$preference->payer = $payer;
$preference->external_reference = $external_reference;
$preference->save();

  ?>


  <form action="/processar_pagamento" method="POST">
  <script
   src="https://www.mercadopago.com.br/integrations/v1/web-payment-checkout.js"
   data-preference-id="<?php echo $preference->id; ?>">
  </script>
</form>