<?php

namespace  App\Controllers;

use App\Models\Admin;
use App\Requests\CustomRequestHandler;
use App\Response\CustomResponse;
use App\Validation\Validator;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface AS Response;
use Respect\Validation\Validator as v;
use App\Interfaces\SecretKeyInterface;
use Firebase\JWT\JWT;

class AuthController
{

    protected $adminEntry;
    protected $customResponse;
    protected $validator;

    public function __construct()
    {
        $this->adminEntry = new Admin();
        $this->customResponse = new CustomResponse();
        $this->validator = new Validator();
    }


    public function Register(Request $request, Response $response)
    {
       $this->validator->validate($request,[
          "name"=>v::notEmpty(),
           "addMail"=>v::notEmpty()->addMail(),
           "password"=>v::notEmpty()
       ]);

       if($this->validator->failed())
       {
           $responseMessage = $this->validator->errors;
           return $this->customResponse->is400Response($response,$responseMessage);
       }

       if($this->addMailExist(CustomRequestHandler::getParam($request,"addMail")))
       {
           $responseMessage = "addMail already exist";
           return $this->customResponse->is400Response($response,$responseMessage);
       }

       $passwordHash = $this->hashPassword(CustomRequestHandler::getParam($request,'password'));

       $this->adminEntry->create([
          "name"=>CustomRequestHandler::getParam($request,"name"),
           "addMail"=>CustomRequestHandler::getParam($request,"addMail"),
           "password"=>$passwordHash
       ]);

       $responseMessage = "new adminEntry created successfully";

       return $this->customResponse->is200Response($response,$responseMessage);
    }

    public function login(Request $request,Response $response)
    {
        $this->validator->validate($request,[
            "addMail"=>v::notEmpty()->email(),
            "mdp"=>v::notEmpty()
        ]);

        if($this->validator->failed())
        {
            $responseMessage = $this->validator->errors;
            return $this->customResponse->is400Response($response,$responseMessage);
        }
        
        $verifyAccount = $this->verifyAccount(
            CustomRequestHandler::getParam($request,"mdp"),
            CustomRequestHandler::getParam($request,"addMail")
        );

        if($verifyAccount==false)
        {
            $responseMessage = "invalid Email or password";
            return $this->customResponse->is400Response($response,$responseMessage);
        }

        $token = GenerateTokenController::generateToken(
            CustomRequestHandler::getParam($request,"addMail")
        );

        $responseMessage = array("admin"=>$verifyAccount,"token"=>$token);
    
        
        
      
        return $this->customResponse->is200Response($response,$responseMessage);
    }

    public function verifyAccount($password,$addMail)
    {
        $count = $this->adminEntry->where(["addMail"=>$addMail])->count();
        if($count==0)
        {
            return false;
        }

        $adminEntry = $this->adminEntry->where(["addMail"=>$addMail])->first();

        $hashedPassword = $adminEntry->mdp;
        $verify = password_verify($password,$hashedPassword);

        if($verify==false)
        {
            return false;
        }
        return $adminEntry;
    }

    public function hashPassword($password)
    {
        return password_hash($password,PASSWORD_DEFAULT);
    }

    public function addMailExist($addMail)
    {
        $count = $this->adminEntry->where(['addMail'=>$addMail])->count();
        if($count==0)
        {
            return false;
        }
        return true;
    }

    public function verifyToken(Request $request,Response $response)
    {

        $decodedToken = GenerateTokenController::decodedToken(
                CustomRequestHandler::getParam($request,"token")
            );

        $addMail = $decodedToken->jti;

        $verifyToken = $this->addMailExist($addMail);

        if($verifyToken==false){
            $responseMessage = "Invalid token";
            return $this->customResponse->is400Response($response,$responseMessage);
        }
        else{

        }

        return $this->customResponse->is200Response($response,$decodedToken);
    }

}