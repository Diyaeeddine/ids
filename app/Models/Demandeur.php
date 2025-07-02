<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Demandeur extends Model
{
        protected $fillable = [
            'nom',
            'cin_pass',
            'tel',
            'passeport',
            'adresse',
            'email',
        ];
    //
    public function contrats()
{
    return $this->hasMany(Contrat::class);
}

}