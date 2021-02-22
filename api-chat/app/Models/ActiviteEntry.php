<?php
namespace  App\Models;
use Illuminate\Database\Eloquent\Model;

class ActiviteEntry extends Model
{
    protected $table = "sp_activite";

    protected $fillable  = [
        "idActivite",
        "nomActivite",
        "descriptionActivite"
    ];

    public function partenaire(){
        return $this->belongsTo(PartenaireEntry::class,'idPartenaire','idPartenaire');
    }

    public function type(){
        return $this->hasOne(TypeEntry::class,'idType','idType');
    }

    public function cours(){
        return $this->hasMany(CoursEntry::class,'idActivite','idActivite');
    }
}