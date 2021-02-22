<?php
namespace  App\Models;
use Illuminate\Database\Eloquent\Model;

class MessageEntry extends Model
{
 protected $table = "messages";
 
 protected $fillable  = [
     "id_message",
     "contenu",
     "id_utilisateur",
     "id_conversation",
     "created_at"
 ];

 public function conversation(){
    return $this->belongsTo(ConversationEntry::class, 'id_conversation', 'id_conversation');
 }

 public function utilisateur(){
     return $this->belongsTo(UtilisateurEntry::class,'id_utilisateur','id_utilisateur');
 }

}