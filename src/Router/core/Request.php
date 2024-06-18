<?php 
namespace Builder\Tables\Router\Core;

class Request 
{
    public function getMethod () 
    {
        return strtolower($_SERVER["REQUEST_METHOD"]);
    }
    private function getPostData() 
    {
        return $_POST ?? NULL;
    }
    private function getGetData()
    {
        return $_GET ?? NULL;
    }
    public function getData()
    {
        return $this->getGetData() ? $this->getGetData() : $this->getPostData();
    }
    /**
     * @summary : Retorna o caminho executado para enviar tanto uma view quanto dados acessados de dentro do banco de dados
     * @author : Lucas Cid <lucasfelipaaa@gmail.com>
     */
    public function getPath () 
    {
        $path =  $_SERVER["REQUEST_URI"];
        $afterBase = strpos($path, "//" );
        
        $path = strtolower(substr($path, $afterBase));
        //futuramente irei adicionar a capacidade de ter o agrupamento de rotas
        $exploded = explode("/", $path);

        return $path;
    }
}