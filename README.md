## Estrutura do Projeto
meu_projeto/
│
├── public/
│   └── index.php
│
├── app/
│   ├── Controllers/
│   │   ├── HomeController.php
│   │   ├── AboutController.php
│   │   └── ErrorController.php
│   ├── Models/
│   │   └── UserModel.php
│   └── Views/
│       ├── home.php
│       ├── about.php
│       └── error.php
└── core/
    ├── Router.php
    └── Request.php
    
### 1. Configurar o Arquivo index.php
O arquivo index.php será o ponto de entrada do nosso aplicativo. Ele irá inicializar o roteador e processar as solicitações.
````php
<?php
require_once '../core/Router.php';
require_once '../core/Request.php';

$router = new Router(new Request);

// Definir rotas
$router->get('/', 'HomeController@index');
$router->get('/about', 'AboutController@index');

// Processar a solicitação
$router->resolve();
````
### 2. Criar a Classe Request
A classe Request irá processar a solicitação HTTP e fornecer as informações necessárias ao roteador.

Arquivo Request.php
````php
<?php

class Request {
    public function getPath() {
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        $position = strpos($path, '?');
        if ($position === false) {
            return $path;
        }
        return substr($path, 0, $position);
    }

    public function getMethod() {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }
}
````
3. Criar a Classe Router
A classe Router será responsável por definir as rotas e direcionar as solicitações para os controladores apropriados.

Arquivo Router.php
````php
<?php

class Router {
    private $request;
    private $routes = [];

    public function __construct($request) {
        $this->request = $request;
    }

    public function get($path, $controller) {
        $this->routes['get'][$path] = $controller;
    }

    public function post($path, $controller) {
        $this->routes['post'][$path] = $controller;
    }

    public function resolve() {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();
        $controller = $this->routes[$method][$path] ?? null;

        if (!$controller) {
            header("HTTP/1.0 404 Not Found");
            echo "404 Not Found";
            return;
        }

        list($controllerName, $methodName) = explode('@', $controller);

        $controllerFile = "../app/Controllers/{$controllerName}.php";
        if (file_exists($controllerFile)) {
            require_once $controllerFile;
            $controllerInstance = new $controllerName();
            if (method_exists($controllerInstance, $methodName)) {
                echo call_user_func_array([$controllerInstance, $methodName], []);
                return;
            }
        }

        header("HTTP/1.0 404 Not Found");
        echo "404 Not Found";
    }
}
````
4. Criar os Modelos
Os modelos irão interagir com o banco de dados e fornecer dados para os controladores.

Arquivo UserModel.php
````php
<?php

class UserModel {
    public function getUsers() {
        // Simulação de dados vindos de um banco de dados
        return [
            ['name' => 'Lucas', 'email' => 'lucas@example.com'],
            ['name' => 'Maria', 'email' => 'maria@example.com'],
        ];
    }
}
````
5. Criar os Controladores
Os controladores irão processar as solicitações, interagir com os modelos e enviar dados para as views.

Arquivo HomeController.php
````php
<?php

class HomeController {
    public function index() {
        $userModel = new UserModel();
        $users = $userModel->getUsers();
        $this->render('home', ['users' => $users]);
    }

    private function render($view, $data = []) {
        extract($data);
        require_once "../app/Views/{$view}.php";
    }
}
````
### Arquivo AboutController.php

````php
<?php

class AboutController {
    public function index() {
        $this->render('about');
    }

    private function render($view, $data = []) {
        extract($data);
        require_once "../app/Views/{$view}.php";
    }
}
````
Arquivo ErrorController.php
````php
<?php

class ErrorController {
    public function index() {
        $this->render('error');
    }

    private function render($view, $data = []) {
        extract($data);
        require_once "../app/Views/{$view}.php";
    }
}
````