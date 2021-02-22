<?php

namespace  App\Response;

class CustomResponse
{

    public function is200Response($response,$responseMessage)
    {
        $responseMessage = json_encode(["success"=>true,"status"=>200,"response"=>$responseMessage]);
        $response->getBody()->write($responseMessage);
        return $response->withHeader("Content-Type","application/json")
            ->withStatus(200);
    }


    public function is400Response($response,$responseMessage)
    {
        $responseMessage = json_encode(["success"=>false,"status"=>400,"response"=>$responseMessage]);
        $response->getBody()->write($responseMessage);
        return $response->withHeader("Content-Type","application/json")
            ->withStatus(400);
    }

    public function is422Response($response,$responseMessage)
    {
        $responseMessage = json_encode(["success"=>true,"status"=>422,"response"=>$responseMessage]);
        $response->getBody()->write($responseMessage);
        return $response->withHeader("Content-Type","application/json")
            ->withStatus(422);
    }
}