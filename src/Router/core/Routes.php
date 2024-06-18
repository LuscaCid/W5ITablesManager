<?php 

namespace Tables\Builder\Router\core;
class Router 
{
    private Request $request;
    public function __construct (Request $request) 
    {
        $this->request = $request;
    }   
    public function getPath() 
    {
        
    }
}