<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'sp_admin';

    protected $fillable = [
            "nom",
            "prenom",
            "addMail",
            "mdp",
            "idRole"
        ];

}