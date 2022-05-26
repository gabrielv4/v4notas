<?php

/**
 * BASE
 */
define("CONF_HTTP_HOST", filter_var($_SERVER['HTTP_HOST'], FILTER_SANITIZE_STRIPPED));
define("CONF_HTTP_METHOD", filter_var($_SERVER['REQUEST_METHOD'], FILTER_SANITIZE_STRIPPED));
define("CONF_HTTP_USER_AGENT", filter_var($_SERVER['HTTP_USER_AGENT'], FILTER_SANITIZE_STRIPPED));

define("CONF_REQUEST_URI", filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_STRIPPED));
define("CONF_REMOTE_ADDR", filter_var($_SERVER['REMOTE_ADDR'], FILTER_SANITIZE_STRIPPED));


define("CONF_FORCE_WWW", 1);
/**
 * DATABASE
 */
define("CONF_DB_HOST", "localhost");
define("CONF_DB_USER", "root");
define("CONF_DB_PASS", "");
define("CONF_DB_NAME", "v4notas");

/**
 * PROJECT URLs
 */
define("CONF_URL_BASE", "https://www.fkb_valvulas.com.br");
define("CONF_URL_TEST", "https://www.localhost/TRABALHO/v4notas");

/**
 * SITE
 */
define("CONF_SITE_NAME", "V4 OR & ASSOCIADOS");
define("CONF_SITE_TITLE", "Gerenciamento de notas fiscais");
define("CONF_SITE_DESC",
    "Cadastro, listagem, atualização e notas fiscais");
define("CONF_SITE_LANG", "pt_BR");

/**
 * NFSe Focus API
 */

define("CONF_NFSE_HOST", 'https://homologacao.focusnfe.com.br');
define("CONF_NFSE_TOKEN", 'QAWTWpN0SQgSxkbbU7iaa8AiFv6MNSgW');
//define("CONF_NFSE_CALLBACK", CONF_URL_BASE . "/pay/nfse");
define("CONF_NFSE_CALLBACK", CONF_URL_TEST . "/pay/nfse");
define("CONF_NFSE_COMPANY", [
    "cnpj" => "40151836000101",
    "inscricao_municipal" => "15953",
    "codigo_municipio" => "3503901"
]);

/**
 * Information Address
 */

define("CONF_SITE_ADDR_STREET", "AV JOAO MANOEL");
define("CONF_SITE_CODE_CITY", "3503901");
define("CONF_SITE_ADDR_NUMBER", "600");
define("CONF_SITE_ADDR_COMPLEMENT", "Sala 904 A Conj B");
define("CONF_SITE_ADDR_CITY", "Arujá");
define("CONF_SITE_ADDR_STATE", "SP");
define("CONF_SITE_ADDR_ZIPCODE", "07400-605");

/**
 * DATES
 */
define("CONF_DATE_BR", "d/m/Y H:i:s");
define("CONF_DATE_APP", "Y-m-d H:i:s");
define("CONF_DATE_APP_BR", "d/m/Y");

setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

/**
 * PASSWORD
 */
define("CONF_PASSWD_MIN_LEN", 8);
define("CONF_PASSWD_MAX_LEN", 40);
define("CONF_PASSWD_ALGO", PASSWORD_DEFAULT);
define("CONF_PASSWD_OPTION", ["cost" => 10]);

/**
 * VIEW
 */
define("CONF_VIEW_PATH", __DIR__ . "/../../shared/views");
define("CONF_VIEW_EXT", "php");

define("CONF_VIEW_ADMIN", "admin");
define("CONF_VIEW_CLIENT", "fkbClient");
define("CONF_VIEW_FUNCTIONARY", "fkbFunctionary");

define("CONF_VIEW_ERROR","error");


/**
 * UPLOAD
 */
define("CONF_UPLOAD_DIR", "storage");
define("CONF_UPLOAD_IMAGE_DIR", "images");
define("CONF_UPLOAD_FILE_DIR", "files");
define("CONF_UPLOAD_MEDIA_DIR", "medias");

/**
 * IMAGES
 */
define("CONF_IMAGE_CACHE", CONF_UPLOAD_DIR . "/" . CONF_UPLOAD_IMAGE_DIR . "/cache");
define("CONF_IMAGE_SIZE", 2000);
define("CONF_IMAGE_QUALITY", ["jpg" => 75, "png" => 5]);

/**
 * MAIL
 */

define("CONF_MAIL_OPTION_LANG", "br");
define("CONF_MAIL_OPTION_HTML", true);
define("CONF_MAIL_OPTION_AUTH", true);
define("CONF_MAIL_OPTION_SECURE", "tls");
define("CONF_MAIL_OPTION_CHARSET", "utf-8");

define("CONF_MAIL_SUPPORT", "gabriel@digitalv8.com.br");



