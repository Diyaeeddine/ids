<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facture extends Model
{
    use HasFactory;

    protected $fillable = [
        'contrat_id',
        'numero_facture',
        'date_facture',
        'date_echeance',
        'total_ht',
        'total_tva',
        'taxe_regionale',
        'total_ttc',
        'montant_paye',
        'statut',
    ];

    public function contrat()
    {
        return $this->belongsTo(Contrat::class);
    }

    public function items()
    {
        return $this->hasMany(FactureItem::class);
    }
}