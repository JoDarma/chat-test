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

    public function listParticipationUserId(Response $response, Request $request, $id)
    {
        $utilisateurList = $this->participationEntry::with('cours.activite',
                        'cours.activite.partenaire',
                        'cours.activite.type.categorie',
                        'cours.adresse')
                        ->where(['idUtilisateur'=>$id])
                        ->orderBy('dateCreation','desc')
                        ->get()
                        ->toArray();

        return $this->customResponse->is200Response($response,$utilisateurList);
    }

    public function infoParticipationId(Response $response, $id){
        $utilisateurId = $this->participationEntry::with('cours.activite.partenaire',
                            'cours.activite.type.categorie',
                            'cours.adresse')
                            ->where(["idParticipation"=>$id])
                            ->get()
                            ->toArray();

        return $this->customResponse->is200Response($response,$utilisateurId);
    }

    public function annulerParticipation(Response $response, $id)
    {
        $this->participationEntry
                        ->where(['idParticipation'=>$id])
                        ->update(['statusParticipation'=>'annuler']);

        $responseCorp = "Participation annulé";

        return $this->customResponse->is200Response($response,$responseCorp);
    }

    
}