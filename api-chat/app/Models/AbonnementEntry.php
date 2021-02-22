<?php
namespace  App\Models;
use Illuminate\Database\Eloquent\Model;

class AbonnementEntry extends Model
{
 protected $table = "sp_abonnement";
 
 protected $fillable  = ["idAbonnement","prixEuro","nbCreditAbonnement",'descriptionAbonnement',"offreTmp","statut"];
}