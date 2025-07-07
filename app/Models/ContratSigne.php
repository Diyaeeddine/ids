<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContratSigne extends Model
{
    protected $fillable = ['contrat_id', 'fichier_path', 'imported_at'];

    protected $table = 'contrats_signes'; // ✅ Très important
        public $timestamps = true;

    public function contrat()
    {
        return $this->belongsTo(Contrat::class);
    }
}