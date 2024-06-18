<?php
namespace Tables\Builder\Router\Controllers;

use Tables\Builder\Router\DTO\SignInDTO;
use Tables\Builder\Router\Services\Session;

class SessionController 
{
    private $service;
    public function __construct(Session $service)
    {
        $this->service = $service;
    }
    public function signIn(SignInDTO $data) 
    {   
        $username = $data->username;
        $password = $data->password;
        //continuacao da logica para realizar login
    }
}