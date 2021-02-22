<?php

namespace  App\Controllers;

use App\Models\MessageEntry;
use App\Models\ParticipationEntry;
use App\Requests\CustomRequestHandler;
use App\Response\CustomResponse;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\RequestInterface as Request;
use App\Validation\Validator;
use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Validator as v;
use Illuminate\Pagination\Paginator;

class MessageEntryController
{

    protected $customResponse;

    protected $MessageEntry;

    protected $validator;


    public function __construct()
    {
        $this->customResponse = new CustomResponse();
        $this->messageEntry = new MessageEntry();
        $this->participationEntry = new ParticipationEntry();
        $this->validator = new Validator();
      

    }

    public function creerMessage(Response $response, Request $request)
    {
        $message = $this->messageEntry->create([
            'contenu'=>CustomRequestHandler::getParam($request,'contenu'),
            'id_utilisateur'=>CustomRequestHandler::getParam($request,'id_utilisateur'),
            'id_conversation'=>CustomRequestHandler::getParam($request,'id_conversation')        
        ]);

        $responseMessage = $message;
       
        return $this->customResponse->is200Response($response,$responseMessage);
    }


}