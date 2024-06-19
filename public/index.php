<?php

require_once "../vendor/autoload.php";

function autoloader($className) {
    
    $root = __DIR__;
    $directory = str_replace( "public","src", $root);

    $path =  $directory . DIRECTORY_SEPARATOR ."Router". DIRECTORY_SEPARATOR ."DTO" . DIRECTORY_SEPARATOR. $className . ".php";
    if (file_exists($path)) {
        require_once $path;
    } else {
        echo "Arquivo para a classe $className não encontrado em $path.\n";
    }
}

$exists = class_exists("SignInDTO");    

use Builder\Tables\Router\Services\Session;
use TablesBuilder\Router\Controllers\SessionController;
use TablesBuilder\Router\Core\BrowseRouter;
use TablesBuilder\Router\Core\Request;

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