<?php
    /*
    // Registra com a Tag de "expert"
    if($_POST['tipo'] == "exp"){
        // Registra o usuário no ActiveCampaign
        $info = array(
            "contact" => array("email"=>$_POST['email'], "firstname"=>$_POST['nome'])
        );
        $json = json_encode($info, JSON_UNESCAPED_UNICODE);
        $url = "https://geets.api-us1.com/api/3/contacts";
        $ch = curl_init($url);
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $json );
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json', "Api-Token: 59dbd75dcaba387e25b8a85a33498ebc3891da936bf8b7a20bb8cb11da8bfaed74625017"));
        # Envia o requerimento.
        curl_exec($ch);
        curl_close($ch);
        

        // Pega o id recém cadastrado para adicionar as tags e na lista para receber o email.
        $url2 = "https://geets.api-us1.com/api/3/contacts?email_like=".$_POST['email']."";
        $ch2 = curl_init($url2);
        curl_setopt($ch2, CURLOPT_HTTPHEADER, array('Content-Type:application/json', "Api-Token: 59dbd75dcaba387e25b8a85a33498ebc3891da936bf8b7a20bb8cb11da8bfaed74625017", "Accept: json"));
        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch2);
        $resultado = json_decode($result, true);
        $ContactId = $resultado['contacts'][0]['id'];
        curl_close($ch2);

        // Adiciona a tag no ActiveCampaign. 2 é ND, 3 é expert e 4 é profissional
        $info = array(
            "contactTag"=>array("contact"=>$ContactId, "tag"=>'3')
        );
        $json = json_encode($info);
        $url3 = "https://geets.api-us1.com/api/3/contactTags";
        $ch3 = curl_init($url3);
        curl_setopt( $ch3, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch3, CURLOPT_HEADER, true);
        curl_setopt( $ch3, CURLOPT_HTTPHEADER, array('Content-Type:application/json', "Api-Token: 59dbd75dcaba387e25b8a85a33498ebc3891da936bf8b7a20bb8cb11da8bfaed74625017"));
        # Envia o requerimento.
        curl_exec($ch3);
        curl_close($ch3);

        // Adiciona na lista de usuários cadastrados
        $info = array(
            "contactList"=>array("list"=>2, "contact"=>$ContactId, "status"=>1)
        );
        $json = json_encode($info);
        $url4 = "https://geets.api-us1.com/api/3/contactLists";
        $ch4 = curl_init($url4);
        curl_setopt( $ch4, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch4, CURLOPT_HEADER, true);
        curl_setopt( $ch4, CURLOPT_HTTPHEADER, array('Content-Type:application/json', "Api-Token: 59dbd75dcaba387e25b8a85a33498ebc3891da936bf8b7a20bb8cb11da8bfaed74625017"));
        # Envia o requerimento.
        curl_exec($ch4);
        curl_close($ch4);
    }
    // Registra com a tag "profissional"
    elseif($_POST['tipo'] == "pf"){
        // Registra o usuário no ActiveCampaign
        $info = array(
            "contact" => array("email"=>$_POST['email'], "firstname"=>$_POST['nome'])
        );
        $json = json_encode($info, JSON_UNESCAPED_UNICODE);
        $url = "https://geets.api-us1.com/api/3/contacts";
        $ch = curl_init($url);
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $json );
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json', "Api-Token: 59dbd75dcaba387e25b8a85a33498ebc3891da936bf8b7a20bb8cb11da8bfaed74625017"));
        # Envia o requerimento.
        curl_exec($ch);
        curl_close($ch);
        

        // Pega o id recém cadastrado para adicionar as tags e na lista para receber o email.
        $url2 = "https://geets.api-us1.com/api/3/contacts?email_like=".$_POST['email']."";
        $ch2 = curl_init($url2);
        curl_setopt( $ch2, CURLOPT_HTTPHEADER, array('Content-Type:application/json', "Api-Token: 59dbd75dcaba387e25b8a85a33498ebc3891da936bf8b7a20bb8cb11da8bfaed74625017", "Accept: json"));
        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch2);
        $resultado = json_decode($result, true);
        $ContactId = $resultado['contacts'][0]['id'];
        curl_close($ch2);

        // Adiciona a tag no ActiveCampaign. 2 é ND, 3 é expert e 4 é profissional
        $info = array(
            "contactTag"=>array("contact"=>$ContactId, "tag"=>'4')
        );
        $json = json_encode($info);
        $url3 = "https://geets.api-us1.com/api/3/contactTags";
        $ch3 = curl_init($url3);
        curl_setopt( $ch3, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch3, CURLOPT_HEADER, true);
        curl_setopt( $ch3, CURLOPT_HTTPHEADER, array('Content-Type:application/json', "Api-Token: 59dbd75dcaba387e25b8a85a33498ebc3891da936bf8b7a20bb8cb11da8bfaed74625017"));
        # Envia o requerimento.
        curl_exec($ch3);
        curl_close($ch3);

        // Adiciona na lista de usuários cadastrados
        $info = array(
            "contactList"=>array("list"=>2, "contact"=>$ContactId, "status"=>1)
        );
        $json = json_encode($info);
        $url4 = "https://geets.api-us1.com/api/3/contactLists";
        $ch4 = curl_init($url4);
        curl_setopt( $ch4, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch4, CURLOPT_HEADER, true);
        curl_setopt( $ch4, CURLOPT_HTTPHEADER, array('Content-Type:application/json', "Api-Token: 59dbd75dcaba387e25b8a85a33498ebc3891da936bf8b7a20bb8cb11da8bfaed74625017"));
        # Envia o requerimento.
        curl_exec($ch4);
        curl_close($ch4);
    }
    // Registra com a tag "negócio digital"
    else{
        // Registra o usuário no ActiveCampaign
        $info = array(
            "contact" => array("email"=>$_POST['email'], "firstname"=>$_POST['nome'])
        );
        $json = json_encode($info, JSON_UNESCAPED_UNICODE);
        $url = "https://geets.api-us1.com/api/3/contacts";
        $ch = curl_init($url);
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $json );
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json', "Api-Token: 59dbd75dcaba387e25b8a85a33498ebc3891da936bf8b7a20bb8cb11da8bfaed74625017"));
        # Envia o requerimento.
        curl_exec($ch);
        curl_close($ch);
        

        // Pega o id recém cadastrado para adicionar as tags e na lista para receber o email.
        $url2 = "https://geets.api-us1.com/api/3/contacts?email_like=".$_POST['email']."";
        $ch2 = curl_init($url2);
        curl_setopt( $ch2, CURLOPT_HTTPHEADER, array('Content-Type:application/json', "Api-Token: 59dbd75dcaba387e25b8a85a33498ebc3891da936bf8b7a20bb8cb11da8bfaed74625017", "Accept: json"));
        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch2);
        $resultado = json_decode($result, true);
        $ContactId = $resultado['contacts'][0]['id'];
        curl_close($ch2);

        // Adiciona a tag no ActiveCampaign. 2 é ND, 3 é expert e 4 é profissional
        $info = array(
            "contactTag"=>array("contact"=>$ContactId, "tag"=>'2')
        );
        $json = json_encode($info);
        $url3 = "https://geets.api-us1.com/api/3/contactTags";
        $ch3 = curl_init($url3);
        curl_setopt( $ch3, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch3, CURLOPT_HEADER, true);
        curl_setopt( $ch3, CURLOPT_HTTPHEADER, array('Content-Type:application/json', "Api-Token: 59dbd75dcaba387e25b8a85a33498ebc3891da936bf8b7a20bb8cb11da8bfaed74625017"));
        # Envia o requerimento.
        curl_exec($ch3);
        curl_close($ch3);

        // Adiciona na lista de usuários cadastrados
        $info = array(
            "contactList"=>array("list"=>2, "contact"=>$ContactId, "status"=>1)
        );
        $json = json_encode($info);
        $url4 = "https://geets.api-us1.com/api/3/contactLists";
        $ch4 = curl_init($url4);
        curl_setopt( $ch4, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch4, CURLOPT_HEADER, true);
        curl_setopt( $ch4, CURLOPT_HTTPHEADER, array('Content-Type:application/json', "Api-Token: 59dbd75dcaba387e25b8a85a33498ebc3891da936bf8b7a20bb8cb11da8bfaed74625017"));
        # Envia o requerimento.
        curl_exec($ch4);
        curl_close($ch4);
    }
    */
?>