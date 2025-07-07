<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\BudgetEntry;
use Carbon\Carbon;

class Demande extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'etape',
        'champs',
        'type_economique',
        
    ];

    protected $casts = [
        'champs' => 'array', // Pour que Laravel caste automatiquement en tableau associatif
    ];

    /**
     * Relation avec les utilisateurs via table pivot 'demande_user'.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'demande_user')
            ->withPivot('duree', 'created_at', 'updated_at');
    }
    public function demandeUsers()
    {
        return $this->hasMany(DemandeUser::class);
    }
    
    
    /**
     * Retourne les utilisateurs avec leur durée et timestamps.
     */
    public function usersWithDurations()
    {
        $users = $this->users()->orderByPivot('created_at')->get();

        $durations = [];

        foreach ($users as $user) {
            $assignedAt = Carbon::parse($user->pivot->created_at)->timezone(config('app.timezone'));
            $completedAt = Carbon::parse($user->pivot->updated_at)->timezone(config('app.timezone'));

            $durations[] = [
                'user' => $user,
                'duration' => $user->pivot->duree,
                'assigned_at' => $assignedAt,
                'completed_at' => $completedAt,
            ];
        }

        return $durations;
    }

    /**
     * Relation avec les entrées de budget.
     */
    public function budgetEntries()
    {
        return $this->belongsToMany(BudgetEntry::class, 'budget_entry_demande');
    }
}
