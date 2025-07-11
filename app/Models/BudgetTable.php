<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BudgetTable extends Model
{
    protected $fillable = ['title', 'prevision_label'];

    public function entries()
    {
        return $this->hasMany(BudgetEntry::class)->orderBy('position');
    }
}
