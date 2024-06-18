<?php

use Builder\Tables\Router\Controllers\SessionController;
use Builder\Tables\Router\Core\BrowseRouter;
use Builder\Tables\Router\Core\Request;
use Builder\Tables\Router\Services\Session;

require_once "../vendor/autoload.php";

header("Allow-Control-Access-Origin: *");
date_default_timezone_set("America/Sao_Paulo");

/**
 * lista de dependencias de acordo com o nome do controller para qual service que será injetado dentro dele.
 */
$dependenciesList = [
    SessionController::class => Session::class
];

$router = new BrowseRouter(new Request, $dependenciesList);

$router->post('/', [SessionController::class, "signIn"]);

//anotacao tipo laravel para obtencao da classe e do metodo correspondente na rota passada como primeiro parametro
$router->get("/", [SessionController::class, "signIn"]);


$router->resolveRequest();