<?php

namespace  App\Controllers;

use App\Models\UtilisateurEntry;
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

    protected $utilisateurEntry;
    protected $customResponse;
    protected $validator;

    public function __construct()
    {
        $this->utilisateurEntry = new UtilisateurEntry();
        $this->customResponse = new CustomResponse();
        $this->validator = new Validator();
    }


    public function Register(Request $request, Response $response)
    {
       $this->validator->validate($request,[
            "nom"=>v::notEmpty(),
            "prenom"=>v::notEmpty(),
            "addMail"=>v::notEmpty()->email(),
            "mdp"=>v::notEmpty()
       ]);

       if($this->validator->failed())
       {
           $responseMessage = $this->validator->errors;
           return $this->customResponse->is400Response($response,$responseMessage);
       }

       if($this->addMailExist(CustomRequestHandler::getParam($request,"addMail")))
       {
           $responseMessage = "Le mail existe déjà";
           return $this->customResponse->is400Response($response,$responseMessage);
       }

       $passwordHash = $this->hashPassword(CustomRequestHandler::getParam($request,'mdp'));

       $userInfos = $this->utilisateurEntry->create([
            "nom"=>CustomRequestHandler::getParam($request,"nom"),
            "prenom"=>CustomRequestHandler::getParam($request,"prenom"),
            "addMail"=>CustomRequestHandler::getParam($request,"addMail"),
            "mdp"=>$passwordHash
       ]);

       $data = array(
        'id'=>$userInfos->id,
        'addMail'=>$userInfos->addMail
       );

       $responseMessage =  GenerateTokenController::generateToken($data);

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
            $responseMessage = "Adresse mail ou mdp invalide";
            return $this->customResponse->is400Response($response,$responseMessage);
        }

        $data = array(
            'id'=>$verifyAccount->id_utilisateur,
            'addMail'=>$verifyAccount->addMail
           );
    
        $responseMessage =  GenerateTokenController::generateToken($data);

        return $this->customResponse->is200Response($response,$responseMessage);
    }

    public function verifyAccount($password,$addMail)
    {
        $count = $this->utilisateurEntry->where(["addMail"=>$addMail])->count();
        if($count==0)
        {
            return false;
        }

        $utilisateurEntry = $this->utilisateurEntry->where(["addMail"=>$addMail])->first();

        $hashedPassword = $utilisateurEntry->mdp;

        $verify = password_verify($password,$hashedPassword);
        
        if(!$verify)
        {
            return false;
        }

        return $utilisateurEntry;
    }

    public function hashPassword($password)
    {
        return password_hash($password,PASSWORD_BCRYPT);
    }

    public function addMailExist($addMail)
    {
        $count = $this->utilisateurEntry->where(['addMail'=>$addMail])->count();
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