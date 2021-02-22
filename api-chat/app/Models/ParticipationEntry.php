<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParticipationEntry extends Model
{
    protected $table = 'sp_participation';

    protected $fillable = [
        "idParticipation",
        "idUtilisateur",
        "idCours",
        "statusParticiation",
        "dateCreation",
        "creditPaye"
    ];

    public function utilisateur(){
        return $this->belongsTo(UtilisateurEntry::class,'idUtilisateur','idUtilisateur');
    }

    public function cours(){
        return $this->belongsTo(CoursEntry::class, 'idCours','idCours');
    }

}