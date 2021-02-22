<?php
namespace  App\Models;
use Illuminate\Database\Eloquent\Model;

class VilleEntry extends Model
{
 protected $table = "sp_ville";
 
 protected $fillable  = [
     "idVille",
     "nomVille",
     "codePostal",
     "idPays"
 ];

 public function adressePartenaire(){
    return $this->belongsTo(AdressePartenaireEntry::class, 'idVille', 'idVille');
 }

 public function pays(){
     return $this->belongsTo(PaysEntry::class,'idPays','idPays');
 }

}