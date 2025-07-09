<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderP extends Model
{
    protected $table = 'order_p'; 

    protected $fillable = [
        'entite_ordonnatrice',
        'marche_bc',
        'id_facture',
        'fournisseur',
        'periode_facturation',
        'date_paiment',
        'description_operation',
        'pieces_justificatives',
        'montant_chiffres',
        'montant_lettres',
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
        'is_accepted',
    ];
}