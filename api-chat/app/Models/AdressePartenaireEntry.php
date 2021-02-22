<?php
namespace  App\Models;
use Illuminate\Database\Eloquent\Model;

class AdressePartenaireEntry extends Model
{
    protected $table = "sp_adressepartenaire";
    
    protected $fillable  = [
        "idAdresse",
        "libelleAdresse",
        "adressePostal",
        "idPays",
        "idVille",
        "idPartenaire",
        "coordX",
        "coordY"
    ];


    public function ville()
    {
        return $this->hasOne(VilleEntry::class, 'idVille', 'idVille');
    }

    public function pays(){
        return $this->hasOne(PaysEntry::class, 'idPays', 'idPays');
    }

    public function partenaire(){
        return $this->belongsTo(PartenaireEntry::class, 'idPartenaire', 'idPartenaire');
    }

    public function cours(){
        return $this->hasMany(CoursEntry::class,'idAdresse','idAdresse');
    }

}