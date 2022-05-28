<?php
ob_start();

require __DIR__ . "/vendor/autoload.php";
/**
 * BOOTSTRAP
 */

use CoffeeCode\Router\Router;
use Source\Core\Session;

$session = new Session();
$route = new Router(url(), ":");
$route->namespace("Source\App");
$route->get("/beta", "Beta:home");


$route->namespace("Source\App\Admin");
$route->group(null);
$route->get("/", "Login:root");
$route->get("/login", "Login:login");
$route->post("/login", "Login:login");


/* ==================================================================================== */
/**
 * ADMIN ROUTES
 */
$route->namespace("Source\App\Admin");
$route->group("/admin");
//login
$route->get("/", "Login:root");
$route->get("/login", "Login:login");
$route->post("/login", "Login:login");

//dash
$route->get("/dash", "Dash:dash");
$route->get("/dash/home", "Dash:home");
$route->post("/dash/home", "Dash:home");
$route->get("/logoff", "Dash:logoff");
$route->get("/dash/home/{search}/{page}", "Dash:home");



//Admin -> Admins
$route->get("/admins/home", "Admins:home");
$route->post("/admins/home", "Admins:home");


$route->get("/admins/areaAdmin", "Admins:areaAdmin");
$route->post("/admins/areaAdmin", "Admins:areaAdmin");

//Admin -> Clients
$route->get("/clients/home", "Clients:home");
$route->get("/clients/home/{search}/{page}", "Clients:home");

//Admin Update -> admin
$route->get("/admins/areaAdmin/{admin_id}", "Admins:areaAdmin");
$route->post("/admins/areaAdmin/{admin_id}", "Admins:areaAdmin");
$route->get("/admins/home/{search}/{page}", "Admins:home");

//Admin Update -> client
$route->get("/clients/areaClient", "Clients:areaClient");
$route->post("/clients/areaClient", "Clients:areaClient");

$route->get("/clients/areaClient/{client_id}", "Clients:areaClient");
$route->post("/clients/areaClient/{client_id}", "Clients:areaClient");
$route->get("/clients/home/{search}/{page}", "Clients:home");

$route->get("/clients/status/{client_id}/{status}", "Clients:settingStatusCompany");
$route->post("/clients/status/{client_id}/{status}", "Clients:settingStatusCompany");

// Setting-> admin photo
$route->get("/settings/photo", "Settings:photo");
$route->post("/settings/updatePhoto/{admin_id}", "Settings:updatePhoto");
$route->post("/settings/deletePhoto/{admin_id}", "Settings:deletePhoto");

//Settings-> Admin
$route->get("/settings/home", "Settings:home");
$route->post("/settings/updateAccount/{admin_id}", "Settings:updateAccount");

// Admin -> Admin Invoice
$route->get("/nfse/{client_id}", "Nfse:createNfse");
$route->post("/nfse/{client_id}", "Nfse:createNfse");

$route->get("/nfse/cancelamento", "Nfse:deleteNfse");
$route->post("/nfse/cancelamento", "Nfse:deleteNfse");


/**
 * ERROR ROUTES
 */
$route->namespace("Source\App\Error");
$route->group("/ops");
$route->get("/{errcode}", "Error:errors");
/**
 * ROUTE
 */
$route->dispatch();

/**
 * ERROR REDIRECT
 */
if ($route->error()) {
    $route->redirect("/ops/{$route->error()}");
}

ob_end_flush();
