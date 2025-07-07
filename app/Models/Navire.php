<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Navire extends Model
{
    protected $table = 'navires'; 

    protected $fillable = [
        'nom',
        'type',
        'port',
        'numero_immatriculation',
        'pavillon',
        'longueur',
        'largeur',
        'tirant_eau',
        'tirant_air',
        'jauge_brute',
        'annee_construction',
        'marque_moteur',
        'type_moteur',
        'numero_serie_moteur',
        'puissance_moteur',
    ];

    // Relations (exemple : un navire peut avoir plusieurs contrats)
    public function contrats()
    {
        return $this->hasMany(Contrat::class);
    }
}
