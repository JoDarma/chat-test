<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategorieEntry extends Model
{
    protected $table = 'sp_categorieactivite';

    protected $fillable = [
            "idCategorie",
            "libelleCategorie"
        ];

    public function type(){
        return $this->hasMany(TypeEntry::class, 'idCategorie', 'idCategorie');
    }

}