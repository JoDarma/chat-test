<?php
namespace App\Controllers;
use App\Interfaces\SecretKeyInterface;
use Firebase\JWT\JWT;


class GenerateTokenController implements SecretKeyInterface
{

    
    public static function generateToken($email)
    {
        $now = time();
        $future = strtotime('+1 month',$now);
        $secretKey = self::JWT_SECRET_KEY;
        $payload = array(
            "iss" => "https://smartpass97.com", 
            "jti"=>$email,
            "iat"=>$now,
            "exp"=>$future
        );

        return JWT::encode($payload,$secretKey,"HS256");
    }

    public static function decodedToken($token)
    {
        $secretKey = self::JWT_SECRET_KEY;
        return JWT::decode($token,$secretKey,array('HS256'));
    }

  
}