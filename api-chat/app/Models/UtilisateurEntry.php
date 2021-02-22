<?php
namespace  App\Models;
use Illuminate\Database\Eloquent\Model;

class UtilisateurEntry extends Model
{
 protected $table = "utilisateur";
 
 protected $fillable  = [
    "id_utilisateur",
    "nom",
    "prenom",
    "addMail",
    "mdp"
 ];

 public function messages()
 {
    return $this->hasMany(MessageEntry::class, 'id_utilisateur', 'id_utilisateur');
 }

 public function participations(){
    return $this->hasMany(ParticipationEntry::class, 'id_utilisateur', 'id_utilisateur');
 }
}