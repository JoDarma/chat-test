<?php
use Slim\App;
use Tuupola\Middleware\CorsMiddleware;


return function (App $app)
{
  $app->getContainer()->get('settings');
  $app->addRoutingMiddleware();
  $app->add(new Tuupola\Middleware\CorsMiddleware([
    "origin" => ["*"],
    "methods" => ["GET", "POST", "PUT", "PATCH", "DELETE"],
    "headers.allow" => ["Authorization", "If-Match", "If-Unmodified-Since"],
    "headers.expose" => ["Etag"],
    "credentials" => true,
    "cache" => 86400
  ]));
  
  $app->add(
    new \Tuupola\Middleware\JwtAuthentication([
      "ignore"=>[
        "/api/auth/login",
        "/api/utilisateur/listAll",
        "/api/auth/verifyToken"
      ],

      "secret"=>\App\Interfaces\SecretKeyInterface::JWT_SECRET_KEY,
      "error"=>function($response,$arguments)
      {
          $data["success"] = false;
          $data["response"]=$arguments["message"];
          $data["status_code"]= "401";

          return $response->withHeader("Content-type","application/json")
              ->getBody()->write(json_encode($data,JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT ));
      }
    ])
  );

  $app->addErrorMiddleware(true,true,true);
};