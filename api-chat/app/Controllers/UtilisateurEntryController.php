<?php

namespace  App\Controllers;

use App\Models\UtilisateurEntry;
use App\Requests\CustomRequestHandler;
use App\Response\CustomResponse;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\RequestInterface as Request;
use App\Validation\Validator;
use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Validator as v;
use Illuminate\Pagination\Paginator;

class UtilisateurEntryController
{

    protected $customResponse;

    protected $utilisateurEntry;

    protected $validator;


    public function __construct()
    {
        $this->customResponse = new CustomResponse();
        $this->utilisateurEntry = new UtilisateurEntry();
        $this->validator = new Validator();
      

    }

    public function listAll(Response $response, Request $request)
    {

        $utilisateurList = $this->utilisateurEntry->SELECT('*')
                            ->get()
                            ->toArray();

        return $this->customResponse->is200Response($response,$utilisateurList);

    }

    public function updateUtilisateur(Response $response, $id, Request $request)
    {
        $this->validator->validate($request,[
            "nom"=>v::notEmpty(),
            "prenom"=>v::notEmpty(),
            "dateNaissance"=>v::notEmpty(),
            "addMail"=>v::notEmpty()->email(),
            "numeroTel"=>v::notEmpty(),
            "adressePostal"=>v::notEmpty(),
            "idVille"=>v::notEmpty()
         ]);

        if($this->validator->failed())
        {
            $responseMessage = $this->validator->errors;
            return $this->customResponse->is400Response($response,$responseMessage);
        }
  
        $this->utilisateurEntry->where(["idUtilisateur"=>$id])->update([
            'nom'=>CustomRequestHandler::getParam($request,'nom'),
            'prenom'=>CustomRequestHandler::getParam($request,'prenom'),
            'dateNaissance'=>date('Y-m-d',strtotime(CustomRequestHandler::getParam($request, 'dateNaissance'))),
            'addMail'=>CustomRequestHandler::getParam($request, 'addMail'),
            'numeroTel'=>CustomRequestHandler::getParam($request,'numeroTel'),
            'adressePostal'=>CustomRequestHandler::getParam($request,'adressePostal'),
            "idVille"=>CustomRequestHandler::getParam($request, 'idVille'),
            
        ]);

        $responseMessage = "Modification effectuée";

        return $this->customResponse->is200Response($response,$responseMessage);
    }

    public function updateMdp(Response $response, $id, Request $request)
    {
        $this->validator->validate($request,[
            "motDePasse"=>v::notEmpty()
         ]);

        if($this->validator->failed())
        {
            $responseMessage = $this->validator->errors;
            return $this->customResponse->is400Response($response,$responseMessage);
        }

        $passwordHash = $this->hashPassword(CustomRequestHandler::getParam($request,'motDePasse'));
        $this->utilisateurEntry->where(["idUtilisateur"=>$id])
                            ->update([
                                'motDePasse'=>$passwordHash,
                            ]);

        $responseMessage = "Mdp modifié";

        return $this->customResponse->is200Response($response,$responseMessage);
    }

    public function hashPassword($password)
    {
        return password_hash($password,PASSWORD_DEFAULT);
    }

}