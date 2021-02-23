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

    public function listAll(Response $response, Request $request, $id)
    {

        $utilisateurList = $this->utilisateurEntry->SELECT('*')
                            ->where('id_utilisateur', '!=', $id)
                            ->get()
                            ->toArray();

        return $this->customResponse->is200Response($response,$utilisateurList);

    }

    public function hashPassword($password)
    {
        return password_hash($password,PASSWORD_DEFAULT);
    }

}