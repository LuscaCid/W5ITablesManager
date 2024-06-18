<?php 

namespace Builder\Tables\Router\Core;

use ReflectionMethod;

class BrowseRouter
{
    private array $dependecies;
    private Request $request;
    private array $routes = [];
    public function __construct (Request $request, array $dependecies) 
    {
        $this->request = $request;
        $this->dependecies = $dependecies;
    }   
    /**
     * @summary : vai acoplar no roteador o caminho que foi chamado para justamente mapear a rota e o metodo a ser chamado
     */
    public function get(string $path, array $controller) 
    {
        $this->routes["get"][$path] = $controller;
    }
    public function post(string $path, array $controller) 
    {
        $this->routes['post'][$path] = $controller;
    }
    public function delete(string $path, array $controller)
    {
        $_SERVER["POST"] = array_merge($_SERVER, ["METHOD" => "DELETE"]);
        $this->routes['delete'][$path] = $controller;
    }
    public function put(string $path, array $controller) 
    {
        $_SERVER["POST"] = array_merge($_SERVER, ["METHOD" => "PUT"]);
        $this->routes['delete'][$path] = $controller;
    }
    public function patch(string $path, array $controller) 
    {
        $_SERVER["POST"] = array_merge($_SERVER, ["METHOD" => "PATCH"]);
        $this->routes['patch'][$path] = $controller;
    }
    /**
     * summary : no metodo resolveRequest que ira injetar no controller 
     */
    public function resolveRequest() 
    {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();
        $controller = $this->routes[$method][$path] ?? NULL;
        
        list($class, $method) = $controller;

        $serviceToInject = $this->dependecies[$class] ?? NULL;
        if (class_exists($class) && method_exists($class, $method)) 
        {
            if(class_exists($serviceToInject))
            {
                $controller = new $class(new $serviceToInject);
 
                //obter o metodo para conseguir ter acesso aos seus possicveis parameteos
                $reflected = new ReflectionMethod($class, $method);

                $parameters = $reflected->getParameters();
                $args = [];
                foreach ($parameters as $parameter) 
                {
                    $type = $parameter->getType();
                    $classes = $this->getArrClasses();

                    $index = array_search($type->getName(), $classes);
                    $typeName = $classes[$index] ?? NULL;

                    if ($type && !$type->isBuiltin() && $typeName) 
                    {
                        $instance = new $typeName;

                        //para obter as (propriedades) do objeto é necessário passar uma instancia da classe
                        $toArr = get_object_vars($instance);

                        $keys = array_keys($toArr);
                        
                        foreach ($keys as $key) 
                        {
                            $instance->$key = $_POST[$key];
                        }
                        $args[] = $instance;
                    }
                }
                $controller->$method(...$args);
            }
        } else
        {
            throw new \Exception("Classe ou método nao encontrados.");
        }
       
        return $controller;
    }

    private function getArrClasses() 
    {
        $root = __DIR__;
        $directory = str_replace( "Core","DTO", $root);;
        $classes = [];
        
        if(is_dir($directory)) 
        {
            $arquivos = scandir($directory);
            
            foreach ($arquivos as $arquivo) 
            {
                if($arquivo == "." || $arquivo == "..")continue; 
                $completeDir = $directory . DIRECTORY_SEPARATOR . $arquivo;
                $data = file_get_contents($completeDir);

                $pattern = "/class\s+([a-zA-Z_\x80-\xff][a-zA-Z0-9_\x80-\xff]*)\s*/";

                preg_match_all($pattern, $data, $classes, 0, 1);
            }    
        };
        return $classes;
    }
}