<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeEntry extends Model
{
    protected $table = 'sp_typeactivite';

    protected $fillable = [
        "idType",
        "libelleType",
        "idCategorie"
    ];

    public function categorie(){
        return $this->belongsTo(CategorieEntry::class,'idCategorie','idCategorie');
    }

    public function activite(){
        return $this->hasMany(ActiviteEntry::class,'idType','idType');
    }

}