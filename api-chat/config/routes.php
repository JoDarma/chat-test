<?php
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;
use App\Controllers\GuestEntryController;
use App\Controllers\ActiviteEntryController;


return function (App $app)
{
    $app->group("/api", function($app){
        $app->group("/auth",function($app)
        {
            $app->post("/register",[\App\Controllers\AuthController::class,"register"]);
            $app->post('/login', [\App\Controllers\AuthController::class,'login']);
        });
    
        $app->group("/conv",function($app){
            $app->post("/creer",[\App\Controllers\ConversationEntryController::class,"creerConv"]);
            $app->get("/{id}",[\App\Controllers\ConversationEntryController::class,"getConvId"]);
        });
    
        $app->group("/participation",function($app){
            $app->get("/{id}/list",[\App\Controllers\ParticipationEntryController::class,"listPartUserId"]);
            
        });

        $app->group("/mess",function($app){
            $app->post("/creer",[\App\Controllers\MessageEntryController::class,"creerMessage"]);

        });

        $app->get("/utilisateur/{id}/listAll",[\App\Controllers\UtilisateurEntryController::class,"listAll"]);

        
      
        $app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function($req, $res) {
            $handler = $this->notFoundHandler; // handle using the default Slim page not found handler
            return $handler($req, $res);
        });
       
    }); 

  

   
   
};