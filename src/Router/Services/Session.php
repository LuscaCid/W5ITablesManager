<?php
namespace Tables\Builder\Router\Services;
class Session
{
    public function __construct() 
    {
        session_start();
    }
    public function singIn(string $email, string $password) 
    {

    }

    public function singUp(string $email, string $password, $fullName) 
    {

    }
    public function signOut() 
    {

    }
}