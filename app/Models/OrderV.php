<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\OrderP;


class OrderV extends Model
{

    // Table name (optional if Laravel can't infer it from the model name)
    protected $table = 'order_v';

    // Mass assignable attributes
    protected $fillable = [
        'id_op',
        'date_virement',
        'compte_debiteur',
        'montant',
        'beneficiaire_nom',
        'beneficiaire_rib',
        'beneficiaire_banque',
        'beneficiaire_agence',
        'objet',
    ];

    // Optionally specify attribute casting
    protected $casts = [
        'date_virement' => 'date',
        'montant' => 'decimal:2',
    ];

    public function orderP()
{
    return $this->belongsTo(OrderP::class, 'id_op');
}
}