<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderP extends Model
{
    protected $table = 'order_p'; // ou le nom exact de ta table

    protected $fillable = [
        'entite_ordonnatrice',
        'marche_bc',
        'fournisseur',
        'periode_facturation',
        'date_paiement',
        'description_operation',
        'pieces_justificatives',
        'montant_chiffres',
        'montant_lettres'   ,
        'date_mise_paiement',
        'mode_paiement',
        'reference',
        'observations',
        'visa_controle',
        'imputation_comptable',
        'metier',
        'section_analytique',
        'produit',
        'extension_analytique',
    ];
}
