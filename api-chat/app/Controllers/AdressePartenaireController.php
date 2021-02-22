<?php

namespace  App\Controllers;
 
use App\Models\AdressePartenaireEntry;
use App\Requests\CustomRequestHandler;
use App\Response\CustomResponse;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\RequestInterface as Request;
use App\Validation\Validator;
use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Validator as v;
use Illuminate\Pagination\Paginator;

class AdressePartenaireController
{

    protected $customResponse;

    protected $adresseEntry;

    protected $validator;


    public function __construct()
    {
        $this->customResponse = new CustomResponse();
        $this->adresseEntry = new AdressePartenaireEntry();
        $this->validator = new Validator();
    }

    public function listCoursAdresse(Response $response, Request $request, $idAdresse,$id)
    {
        $coursList = $this->adresseEntry::with('cours')
                        ->where(['idAdresse'=>$idAdresse])
                        ->get()
                        ->toArray();

        return $this->customResponse->is200Response($response,$coursList);
    }

   
    
}