<?php

namespace  App\Controllers;

use App\Models\ConversationEntry;
use App\Models\ParticipationEntry;
use App\Requests\CustomRequestHandler;
use App\Response\CustomResponse;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\RequestInterface as Request;
use App\Validation\Validator;
use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Validator as v;
use Illuminate\Pagination\Paginator;

class ConversationEntryController
{

    protected $customResponse;

    protected $conversationEntry;

    protected $validator;


    public function __construct()
    {
        $this->customResponse = new CustomResponse();
        $this->conversationEntry = new ConversationEntry();
        $this->participationEntry = new ParticipationEntry();
        $this->validator = new Validator();
      

    }

    public function getConvId(Response $response, Request $request, $id)
    {
        $conversationList = $this->conversationEntry::with('messages','participant.utilisateur')
                            ->where(["id_conversation"=>$id])
                            ->get()
                            ->toArray();

        return $this->customResponse->is200Response($response,$conversationList);

    }

    public function creerConv(Response $response, Request $request)
    {
        $conv = $this->conversationEntry->create([
            'libelle'=>CustomRequestHandler::getParam($request,'libelle'),
            'type_conversation'=>CustomRequestHandler::getParam($request,'type_conversation'),            
        ]);

        $lastInsertId = $conv->id;

        $participants = CustomRequestHandler::getParam($request,'participants');
        $nbParticipants = sizeof($participants);
       

        foreach($participants as $val){
            $part = $this->participationEntry->create([
                'id_utilisateur'=>$val,
                'id_conversation'=>$lastInsertId,
            ]);
        }

        $responseMessage = "créé";

        return $this->customResponse->is200Response($response,$responseMessage);
    }


}