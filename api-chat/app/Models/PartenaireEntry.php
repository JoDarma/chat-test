<?php
namespace  App\Models;
use Illuminate\Database\Eloquent\Model;

class PartenaireEntry extends Model
{
 protected $table = "sp_partenaire";
 
 protected $fillable  = [
     "idPartenaire",
     "nomEntreprise",
     "addMail",
     "numeroTel",
     "civilite",
     "nomDirigeant",
     "siteWeb",
     "motDePasse",
     "dateInscription",
     "statusCompte",
     "RIB",
     "avatarPartenaireSmall",
     "avatarPartenaire",
     "descriptionPartenaire",
     "instagram_link",
     "facebook_link"
 ];

 public function adresse()
 {
     return $this->hasMany(AdressePartenaireEntry::class,'idPartenaire','idPartenaire');
 }

 public function activite()
 {
     return $this->hasMany(ActiviteEntry::class,'idPartenaire','idPartenaire');
 }

}