<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Demandeur;
use App\Models\Proprietaire;
use App\Models\Navire;
use App\Models\Gardien;
use App\Models\User;

class Contrat extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'demandeur_id',
        'proprietaire_id',
        'navire_id',
        'gardien_id',
        'type',
        'mouvements',
        'majoration_stationnement',
        'equipage',
        'passagers',
        'total_personnes',
        'date_debut',
        'date_fin',
        'signe_par',
        'date_signature',
        'accepte_le',
    ];
    public function demandeur()
    {
        return $this->belongsTo(Demandeur::class);
    }

    public function proprietaire()
    {
        return $this->belongsTo(Proprietaire::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function navire()
    {
        return $this->belongsTo(Navire::class);
    }

    public function gardien()
    {
        return $this->belongsTo(Gardien::class);
    }
    public function contratSigne()
{
    return $this->hasOne(ContratSigne::class);
}

protected $casts = [
    'est_imprime' => 'boolean',
];



}
