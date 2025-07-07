<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FactureItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'facture_id',
        'description',
        'quantite',
        'prix_unitaire',
        'montant_ht',
    ];

    public function facture()
    {
        return $this->belongsTo(Facture::class);
    }
}