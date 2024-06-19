<?php
namespace TablesBuilder\Router\Controllers;

use Builder\Tables\Router\Services\Session;
use TablesBuilder\Router\DTO\SignInDTO;
use TablesBuilder\Router\DTO\TestDTO;

class SessionController 
{
    private $service;
    public function __construct(Session $service)
    {
        $this->service = $service;
    }
    public function signIn(SignInDTO $data) 
    {   
        $username = $data->email;
        $password = $data->password;

        var_dump($username);
        //continuacao da logica para realizar login
    }
    public function render() 
    {
        
    }
    public function test(TestDTO $test) 
    {
        echo json_encode($test);
    }
}