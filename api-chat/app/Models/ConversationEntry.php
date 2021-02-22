<?php
namespace  App\Models;
use Illuminate\Database\Eloquent\Model;

class ConversationEntry extends Model
{
 protected $table = "conversation";
 
 protected $fillable  = [
     "id_conversation",
     "libelle",
     "type_conversation",
 ];

 public function participant(){
    return $this->hasMany(ParticipationEntry::class, 'id_conversation', 'id_conversation');
 }

 public function messages(){
     return $this->hasMany(MessageEntry::class,'id_conversation','id_conversation');
 }

}