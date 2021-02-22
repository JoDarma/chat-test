<?php
namespace  App\Models;
use Illuminate\Database\Eloquent\Model;

class CoursEntry extends Model
{
    protected $table = "sp_cours";

    protected $fillable  = [
        "idCours",
        "dateHeureDebut",
        "dateHeureFin",
        "nbParticipantMax",
        "idActivite",
        "statusCours",
        "idAdresse",
        "nomProf"
    ];

    public function activite(){
        return $this->belongsTo(ActiviteEntry::class,'idActivite','idActivite');
    }

    public function adresse(){
        return $this->belongsTo(AdressePartenaireEntry::class,'idAdresse', 'idAdresse');
    }

    public function participation(){
        return $this->hasMany(ParticipationEntry::class,'idCours','idCours');
    }

}