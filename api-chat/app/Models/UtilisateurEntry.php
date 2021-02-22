<?php
namespace  App\Models;
use Illuminate\Database\Eloquent\Model;

class UtilisateurEntry extends Model
{
 protected $table = "sp_utilisateur";
 
 protected $fillable  = [
     "idUtilisateur",
     "civilite",
     "nom",
     "prenom",
     "dateNaissance",
     "addMail",
     "numeroTel",
     "adressePostal",
     "nbCreditUtilisateur",
     "motDePasse",
     "dateInscription",
     "statusCompte",
     "idAbonnement",
     "dateRechargeCdt",
     "idPays",
     "idVille",
     "strp_id",
     "strp_subs_id",
     "dateDesinscription",
     "codeParrainage",
     "idTypeUsr",
     "codeParrain",
     "promoCodeInf",
     "promoCodeUse"
 ];

 public function ville()
 {
    return $this->hasOne(VilleEntry::class, 'idVille', 'idVille');
 }

 public function abonnement(){
    return $this->hasOne(AbonnementEntry::class, 'idAbonnement', 'idAbonnement');
 }

 public function participation(){
     return $this->hasMany(ParticipationEntry::class,'idUtilisateur','idUtilisateur');
 }

 public function type(){
     return $this->hasOne(TypeUtilisateurEntry::class, 'idTypeUsr','idTypeUsr');
 }

 public function filleul(){
     return $this->hasMany(UtilisateurEntry::class,'codeParrain','codeParrainage');
 }

 public function userWithInfCode(){
     return $this->hasMany(UtilisateurEntry::class, 'promoCodeUse', 'promoCodeInf');
 }
}