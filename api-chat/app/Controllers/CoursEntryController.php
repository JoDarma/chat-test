<?php

namespace  App\Controllers;

use App\Models\CoursEntry;
use App\Requests\CustomRequestHandler;
use App\Response\CustomResponse;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\RequestInterface as Request;
use App\Validation\Validator;
use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Validator as v;



class CoursEntryController
{

    protected $customResponse;

    protected $coursEntry;

    protected $validator;

    public function __construct()
    {
        $this->customResponse = new CustomResponse();
        $this->coursEntry = new CoursEntry();
        $this->coursEntry= new CoursEntry();
        $this->validator = new Validator();

    }

    public function coursDetails(Response $response, $id)
    {
        $cours = $this->coursEntry::with('participation.utilisateur','activite')
                        ->where(["idCours"=>$id])
                        ->get()
                        ->toArray();

        return $this->customResponse->is200Response($response,$cours);
    }

    public function cours(Response $response, $id){

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