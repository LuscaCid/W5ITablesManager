<?php 

namespace Tables\Builder\Router\Auth;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
class AuthJwtService
{
    private $object;
    public static $secret = "428347892347982347289"; // only for development
    public function __construct($object)
    {
        $this->object = $object;
    }
    public static function encodeToken($payload) 
    {
        try 
        { // payload contains data that i want to put inside token
        $token =  JWT::encode($payload, self::$secret, 'HS256');
        return $token;
        } catch (Exception $e) 
        {
        echo json_encode(["error" => $e->getMessage()]);
        }
    }
    public function verify() 
    {
        if ($this->object->authToken)
        {
        $authToken = explode(" ", $this->object->authToken)[1];
        }  else 
        {
        echo json_encode(["error" => "JWT nao passado."]);
        exit;
        }

        try
        { 
        $decodedToken = JWT::decode($authToken, new Key(self::$secret, "HS256"));
        return $decodedToken;

        }catch (Exception $e)
        {
        echo json_encode([ "error"=> $e->getMessage()]);
        exit;
        }
    }
}