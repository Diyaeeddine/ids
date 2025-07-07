<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gardien extends Model
{
    protected $table = 'gardiens'; // Nom de la table

    protected $fillable = [
        'nom',
        'cin_pass',
        'tel',
    ];

    // Relations (exemple : un gardien peut avoir plusieurs contrats)
    public function contrats()
    {
        return $this->hasMany(Contrat::class);
    }
}
