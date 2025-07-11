<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BudgetEntry extends Model
{
    protected $fillable = [
        'budget_table_id',
        'imputation_comptable',
        'intitule',
        'is_header',
        'budget_previsionnel',
        'atterrissage',
        'b_title',
        'position', 
    ];

    protected $casts = [
        'is_header' => 'boolean',
        'is_total' => 'boolean',
    ];

    public function budgetTable()
    {
        return $this->belongsTo(BudgetTable::class);
    }

public function demandes()
{
    return $this->belongsToMany(Demande::class, 'budget_entry_demande');
}




}

