<?php
//
//$server = "https://homologacao.focusnfe.com.br";
////// Substituir pela sua identificação interna da nota
//$ref = "112408062022";
//$login = "R8KyuKBpKBC4HG9ONmEs9yfOnXSZm5Ea";
//$password = "";
//$email = array (
//    "emails" => array(
//        "gabrielgomessdasilva13@gmail.com"
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
    $ref = "165108062022";
    $login = "59jOIZxVUSjC1eqkwrt4SXeWIyjgzCtF";
    $password = "";
    // Para ambiente de produção use a variável abaixo:
    // $server = "https://api.focusnfe.com.br";
    $server = "https://api.focusnfe.com.br"; // Servidor de homologação
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
//$server = "https://api.focusnfe.com.br";
//// Substituir pela sua identificação interna da nota
////3503901
//$ref = "165108062022";
//$login = "59jOIZxVUSjC1eqkwrt4SXeWIyjgzCtF";
//$password = "";
//$nfse = array(
//    "data_emissao" => "2022-06-08T17:43:14-3:00",
//    "incentivador_cultural" => "false",
//    "natureza_operacao" => "1",
//    "optante_simples_nacional" => "false",
//    "prestador" => array(
//        "cnpj" => "36705357000112",
//        "inscricao_municipal" => "15954",
//        "codigo_municipio" => "3546801"
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


//Cancelamento

//// Você deve definir isso globalmente para sua aplicação
//$ch = curl_init();
//// Substituir pela sua identificação interna da nota
//$ref   = "165108062022";
//// Para ambiente de produção use a variável abaixo:
//// $server = "https://api.focusnfe.com.br";
//$server = "https://api.focusnfe.com.br";
//$justificativa = array ("justificativa" => "Erro nas informações passadas");
//$login = "59jOIZxVUSjC1eqkwrt4SXeWIyjgzCtF";
//$password = "";
//curl_setopt($ch, CURLOPT_URL, $server . "/v2/nfse/" . $ref);
//curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
//curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($justificativa));
//curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
//curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
//$body = curl_exec($ch);
//$result = curl_getinfo($ch, CURLINFO_HTTP_CODE);
////as três linhas abaixo imprimem as informações retornadas pela API, aqui o seu sistema deverá
////interpretar e lidar com o retorno
//print($result."\n");
//print($body."\n\n");
//print("");
//curl_close($ch);