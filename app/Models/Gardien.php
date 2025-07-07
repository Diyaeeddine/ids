<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gardien extends Model
{
    protected $table = 'gardiens'; 

    protected $fillable = [
        'nom',
        'cin_pass',
        'tel',
    ];

    
    public function contrats()
    {
        return $this->hasMany(Contrat::class);
    }
}
