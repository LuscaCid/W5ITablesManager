<?php
namespace Builder\Tables\Router\Controllers;

use Builder\Tables\Router\DTO\SignInDTO;
use Builder\Tables\Router\Services\Session;

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
}