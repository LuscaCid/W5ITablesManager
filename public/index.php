<?php
include_once "../vendor/autoload.php";


use Builder\Tables\Router\Services\Session;
use TablesBuilder\Router\Controllers\SessionController;
use TablesBuilder\Router\Core\BrowseRouter;
use TablesBuilder\Router\Core\Request;

include_once "../src/Router/DTO/SignIn.php";
include_once "../src/Router/DTO/SignUp.php.php";
include_once "../src/Router/DTO/TestDTO.php.php";

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

$router->get("/test", [SessionController::class, "test"]);
$router->resolveRequest();