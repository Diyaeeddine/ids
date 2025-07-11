<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proprietaire extends Model
{
    protected $table = 'proprietaires';

    protected $fillable = [
        'type',                
        'nom',                 
        'tel',
        'nom_societe',  
        'ice',      
        'cin_pass_phy',                 
        'cin_pass_mor',                 
        'nationalite',
        'validite_cin',
        'caution_solidaire',
    ];

    public function contrats()
    {
        return $this->hasMany(Contrat::class);
    }
}
