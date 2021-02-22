<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeUtilisateurEntry extends Model
{
    protected $table = 'sp_typeutilisateur';

    protected $fillable = [
        "idTypeUsr",
        "libelleType",
        "codeTypeUsr"
    ];

    public function utilisateur(){
        return $this->belongsTo(UtilisateurEntry::class,'idTypeUsr','idTypeUsr');
    }

}