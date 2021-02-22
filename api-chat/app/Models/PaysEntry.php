<?php
namespace  App\Models;
use Illuminate\Database\Eloquent\Model;

class PaysEntry extends Model
{
   protected $table = "sp_pays";

   protected $fillable  = [
      "idPays",
      "nomPays",
      "codePays"
   ];

   public function ville(){
      return $this->hasMany(VilleEntry::class,'idPays','idPays');
   }


}