<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DemandeUser extends Model
{
    use HasFactory;

    protected $table = 'demande_user';

    protected $fillable = [
        'demande_id',
        'user_id',
        'is_filled',
        'duree',
        'etape',
        'sort',
        'IsYourTurn',
    ];

    public function demande()
    {
        return $this->belongsTo(Demande::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
