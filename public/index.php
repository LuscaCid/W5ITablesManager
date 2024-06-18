<?php

use Tables\Builder\Router\Controllers\SessionController;
use Tables\Builder\Router\core\Request;
use Tables\Builder\Router\core\Router;
use Tables\Builder\Router\DTO\SignInDTO;
use Tables\Builder\Router\Services\Session;

require_once "../vendor/autoload.php";

header("Allow-Control-Access-Origin: *");
header("Content-type: Apliccation/json");

date_default_timezone_set("America/Sao_Paulo");

/**
 * lista de dependencias de acordo com o nome do controller para qual service que será injetado dentro dele.
 */
$dependenciesList = [
    SessionController::class => Session::class
];
$DTOs = [
    SignInDTO::class
];
$router = new Router(new Request, $dependenciesList, $DTOs);

$router->get('/', [SessionController::class, "signin"]);

//anotacao tipo laravel para obtencao da classe e do metodo correspondente na rota passada como primeiro parametro
$router->get("/", [SessionController::class, "signIn"]);

$requestMethod = $_SERVER["REQUEST_METHOD"];
$post = $_POST;
$auth = $_SERVER["HTTP_AUTHORIZATION"];