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
            $app->post("/login",[\App\Controllers\AuthController::class,"login"]);
            $app->post('/verifyToken', [\App\Controllers\AuthController::class,'verifyToken']);
        });
    
        $app->group("/partenaire",function($app){
            $app->get("/listAll",[\App\Controllers\PartenaireEntryController::class,"listAll"]);
            $app->get("/{id}",[\App\Controllers\PartenaireEntryController::class,"infoPartenaireId"]);
            $app->patch("/{id}/update",[\App\Controllers\PartenaireEntryController::class,"updatePartenaire"]);
            $app->patch("/{id}/updateMdp",[\App\Controllers\PartenaireEntryController::class,"updateMdp"]);
            $app->get("/{id}/activite",[\App\Controllers\ActiviteEntryController::class,"listActivitePartenaire"]);
        });
    
        $app->group("/activite",function($app){
            $app->get("/{id}",[\App\Controllers\ActiviteEntryController::class,"activiteId"]);
            $app->get("/{id}/cours",[\App\Controllers\ActiviteEntryController::class,"activiteCours"]);
            $app->patch("/{id}/update",[\App\Controllers\ActiviteEntryController::class,"modifierActivite"]);
            $app->patch("/{id}/stop",[\App\Controllers\ActiviteEntryController::class,"stopperActivite"]);
        });

        $app->group("/cours",function($app){
            $app->get("/{id}",[\App\Controllers\CoursEntryController::class,"coursDetails"]);
            $app->patch("/{id}/annuler",[\App\Controllers\CoursEntryController::class,"annulerCours"]);
        });

        $app->group("/utilisateur",function ($app){
            $app->get("/listAll",[\App\Controllers\UtilisateurEntryController::class,"listAll"]);
            $app->get("/{id}",[\App\Controllers\UtilisateurEntryController::class,"infoUtilisateurId"]);
            $app->get("/{codeParrainage}/filleul",[\App\Controllers\UtilisateurEntryController::class,"listFilleul"]);
            $app->patch("/{id}/update",[\App\Controllers\UtilisateurEntryController::class,"updateUtilisateur"]);
            $app->patch("/{id}/updateMdp",[\App\Controllers\UtilisateurEntryController::class,"updateMdp"]);
            $app->patch("/{id}/updateStatus",[\App\Controllers\UtilisateurEntryController::class,"updateStatus"]);
            $app->get("/{id}/participation",[\App\Controllers\ParticipationEntryController::class,"listParticipationUserId"]);
        });

        $app->group("/participation",function($app){
            $app->get("/listAll",[\App\Controllers\ParticipationEntryController::class,"listAll"]);
            $app->get("/{id}",[\App\Controllers\ParticipationEntryController::class,"infoParticipationId"]);
            $app->patch("/{id}/annuler",[\App\Controllers\ParticipationEntryController::class,"annulerParticipation"]);
        });
      
        $app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function($req, $res) {
            $handler = $this->notFoundHandler; // handle using the default Slim page not found handler
            return $handler($req, $res);
        });
       
    }); 

  

   
   
};