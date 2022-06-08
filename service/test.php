<?php
//
//$server = "https://homologacao.focusnfe.com.br";
//// Substituir pela sua identificação interna da nota
//$ref = "MjAyMi0wNi0wMSAwOTo0NzoyNQ==";
//$login = "QAWTWpN0SQgSxkbbU7iaa8AiFv6MNSgW";
//$password = "";
//$email = array (
//    "emails" => array(
//        "gabrielgomess@hotmail.com"
//    )
//);
//// Inicia o processo de envio das informações usando o cURL
//$ch = curl_init();
//curl_setopt($ch, CURLOPT_URL, $server."/v2/nfse/" . $ref . "/email");
//curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//curl_setopt($ch, CURLOPT_POST, 1);
//curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($email));
//curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
//curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
//$body = curl_exec($ch);
//$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
////as três linhas abaixo imprimem as informações retornadas pela API, aqui o seu sistema deverá
////interpretar e lidar com o retorno
//print($http_code."\n");
//print($body."\n\n");
//print("");
//curl_close($ch);

    //Buscar por NFSE
    //Você deve definir isso globalmente para sua aplicação
    //Substituir pela sua identificação interna da nota
    $ref = "210507062022";
    $login = "R8KyuKBpKBC4HG9ONmEs9yfOnXSZm5Ea";
    $password = "";
    // Para ambiente de produção use a variável abaixo:
    // $server = "https://api.focusnfe.com.br";
    $server = "https://homologacao.focusnfe.com.br"; // Servidor de homologação
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $server . "/v2/nfse/" . $ref);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array());
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
    $body = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    //as três linhas abaixo imprimem as informações retornadas pela API, aqui o seu sistema deverá
    //interpretar e lidar com o retorno
    print($http_code . "\n");
    print($body . "\n\n");
    print("");
    curl_close($ch);

//Enviar uma NFSE

//// Você deve definir isso globalmente para sua aplicação
//// Para ambiente de produção use a variável abaixo:
// $server = "https://api.focusnfe.com.br";
//$server = "https://homologacao.focusnfe.com.br";
//// Substituir pela sua identificação interna da nota
//$ref = "210507062022";
//$login = "R8KyuKBpKBC4HG9ONmEs9yfOnXSZm5Ea";
//$password = "";
//$nfse = array(
//    "data_emissao" => "2012-06-07T17:43:14-3:00",
//    "incentivador_cultural" => "false",
//    "natureza_operacao" => "1",
//    "optante_simples_nacional" => "false",
//    "prestador" => array(
//        "cnpj" => "36705357000112",
//        "inscricao_municipal" => "15953",
//        "codigo_municipio" => "3503901"
//    ),
//    "tomador" => array(
//        "cnpj" => "07504505000132",
//        "razao_social" => "Acras Tecnologia da Informação LTDA",
//        "email" => "contato@acras.com.br",
//        "endereco" => array(
//            "bairro" => "Jardim America",
//            "cep" => "81530900",
//            "codigo_municipio" => "4119905",
//            "logradouro" => "Rua ABC",
//            "numero" => "16",
//            "uf" => "PR"
//        )
//    ),
//    "servico" => array(
//        "discriminacao" => "Exemplo Servi\u00e7o",
//        "iss_retido" => "false",
//        "aliquota" => "4",
//        "item_lista_servico" => "106",
//        "codigo_cnae" => "6319400",
//        "valor_servicos" => "1.00"
//    ),
//);
//// Inicia o processo de envio das informações usando o cURL
//$ch = curl_init();
//curl_setopt($ch, CURLOPT_URL, $server . "/v2/nfse?ref=" . $ref);
//curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//curl_setopt($ch, CURLOPT_POST, 1);
//curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($nfse));
//curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
//curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
//$body = curl_exec($ch);
//$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
////as três linhas abaixo imprimem as informações retornadas pela API, aqui o seu sistema deverá
////interpretar e lidar com o retorno
//print($http_code . "\n");
//print($body . "\n\n");
//print("");
//curl_close($ch);