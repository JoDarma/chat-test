<?php

namespace  App\Controllers;
use App\Models\ActiviteEntry;
use App\Models\CoursEntry;
use App\Requests\CustomRequestHandler;
use App\Response\CustomResponse;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\RequestInterface as Request;
use App\Validation\Validator;
use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Validator as v;



class ActiviteEntryController
{

    protected $customResponse;

    protected $activiteEntry;

    protected $coursEntry;

    protected $validator;

    public function __construct()
    {
        $this->customResponse = new CustomResponse();
        $this->activiteEntry = new ActiviteEntry();
        $this->coursEntry= new CoursEntry();
        $this->validator = new Validator();

    }

    public function listActivitePartenaire(Response $response, $id)
    {
        $activiteList = $this->activiteEntry::with('type.categorie')
                ->where(["idPartenaire"=>$id])
                ->get();

        return $this->customResponse->is200Response($response,$activiteList);
    }

    public function activiteId(Response $response, $id){

        $activite = $this->activiteEntry::with('type.categorie')
                ->where(["idActivite"=>$id])
                ->get();

        return $this->customResponse->is200Response($response,$activite);
    }

    public function activiteCours(Response $response, $id){
        $activite = $this->activiteEntry::with('cours')
                ->where(["idActivite"=>$id])
                ->get();

        return $this->customResponse->is200Response($response,$activite);
    }

    public function modifierActivite(Response $response, $id, Request $request){

    }

    public function stopperActivite(Response $response, $id, Request $request){
        
    }

}
