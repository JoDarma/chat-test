<?php

namespace  App\Controllers;

use App\Models\ParticipationEntry;
use App\Requests\CustomRequestHandler;
use App\Response\CustomResponse;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\RequestInterface as Request;
use App\Validation\Validator;
use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Validator as v;
use Illuminate\Pagination\Paginator;

class ParticipationEntryController
{

    protected $customResponse;

    protected $participationEntry;

    protected $validator;


    public function __construct()
    {
        $this->customResponse = new CustomResponse();
        $this->participationEntry = new ParticipationEntry();
        $this->validator = new Validator();
    }

    public function listPartUserId(Response $response, Request $request, $id)
    {
        $participationList = $this->participationEntry::with('conversation.participant.utilisateur')
                        ->where(['id_utilisateur'=>$id])
                        // ->orderBy('dateCreation','desc')
                        ->get()
                        ->toArray();

        return $this->customResponse->is200Response($response,$participationList);
    }

    public function creerParticipation(Response $response, Request $request){
       
    }
    
}