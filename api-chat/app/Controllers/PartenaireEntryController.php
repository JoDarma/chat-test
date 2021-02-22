<?php

namespace  App\Controllers;
use App\Models\PartenaireEntry;
use App\Requests\CustomRequestHandler;
use App\Response\CustomResponse;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\RequestInterface as Request;
use App\Validation\Validator;
use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Validator as v;



class PartenaireEntryController
{

    protected $customResponse;

    protected $partenaireEntry;


    protected $validator;

    public function __construct()
    {
        $this->customResponse = new CustomResponse();
        $this->partenaireEntry = new PartenaireEntry();
        $this->validator = new Validator();

    }

    public function hashPassword($password)
    {
        return password_hash($password,PASSWORD_DEFAULT);
    }

    public function listAll(Response $response)
    {
        $partenaireList = $this->partenaireEntry
                            ->select("*")
                            ->get();
        
        return $this->customResponse->is200Response($response,$partenaireList);

    }

    public function infoPartenaireId(Response $response, $id){
      
        $partenaireId = $this->partenaireEntry::with('adresse.ville.pays')
                            ->where(["idPartenaire"=>$id])
                            ->get()
                            ->toArray();
                          
        
        return $this->customResponse->is200Response($response,$partenaireId);
    }

    public function updatePartenaire(Response $response, $id, Request $request)
    {
        $this->partenaireEntry->where(["idPartenaire"=>$id])->update([
            'nomEntreprise'=>CustomRequestHandler::getParam($request,'nomEntreprise'),
            'addMail'=>CustomRequestHandler::getParam($request,'addMail'),
            'numeroTel'=>CustomRequestHandler::getParam($request,'numeroTel'),
            'civilite'=>CustomRequestHandler::getParam($request, 'civilite'),
            'nomDirigeant'=>CustomRequestHandler::getParam($request, 'nomDirigeant'),
            "siteWeb"=>CustomRequestHandler::getParam($request, 'siteWeb'),
            "RIB"=>CustomRequestHandler::getParam($request, 'RIB'),
            "descriptionPartenaire"=>CustomRequestHandler::getParam($request, 'descriptionPartenaire'),
            "instagram_link"=>CustomRequestHandler::getParam($request, 'instagram_link'),
            "facebook_link"=>CustomRequestHandler::getParam($request, 'facebook_link')
        ]);

        $responseMessage = "Modification effectuée";

        return $this->customResponse->is200Response($response,$responseMessage);
    }

    public function updateMdp(Response $response, $id, Request $request)
    {
        $passwordHash = $this->hashPassword(CustomRequestHandler::getParam($request,'motDePasse'));
        $this->partenaireEntry->where(["idPartenaire"=>$id])
                            ->update([
                                'motDePasse'=>$passwordHash,
                            ]);

        $responseMessage = "Mdp modifié";

        return $this->customResponse->is200Response($response,$responseMessage);
    }

    public function updateAvatar(Response $response, $id, Request $request)
    {
        
    }

}