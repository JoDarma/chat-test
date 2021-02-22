<?php
namespace  App\Models;
use Illuminate\Database\Eloquent\Model;

class ParticipationEntry extends Model
{
 protected $table = "participation";
 
 protected $fillable  = [
    "id_utilisateur",
    "id_conversation",
    "created_at"
 ];

 public function utilisateur()
 {
    return $this->belongsTo(UtilisateurEntry::class, 'id_utilisateur', 'id_utilisateur');
 }

 public function conversation(){
    return $this->belongsTo(ConversationEntry::class, 'id_conversation', 'id_conversation');
 }

 
}