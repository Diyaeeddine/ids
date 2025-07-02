<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\DemandeUser;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;  
use Illuminate\Validation\Rules\Password;  
use Illuminate\Auth\Events\Registered;  
class PlaisanceController extends Controller
{
    public function plaisanceDashboard(Request $request)
    {
        $user = $request->user();

        $contrats = $user->contrats()->latest()->get();
        $factures = $user->factures()->latest()->get();

        $contractCount = $contrats->count();
        $invoiceCount = $factures->count();
        $unpaidInvoicesCount = $factures->where('statut', 'non payée')->count();
        $totalOwed = $factures->where('statut', 'non payée')->sum('total_ttc');

        $recentContrats = $contrats->take(5);

        $data = [
            'contractCount' => $contractCount,
            'invoiceCount' => $invoiceCount,
            'unpaidInvoicesCount' => $unpaidInvoicesCount,
            'totalOwed' => $totalOwed,
            'recentContrats' => $recentContrats,
        ];

        return view('plaisance.dashboard', $data);
    }
    public function userDemandes()
{
    $user = Auth::user();
    
    $mesdemandes = DemandeUser::with(['demande', 'user'])
        ->where('user_id', $user->id)
        ->where(function ($q) {
            $q->where('isyourturn', true)
              ->orWhere('is_filled', true);
        })
        ->latest('updated_at')
        ->paginate(10);

        foreach ($mesdemandes as $demande) {
            $updated_at = $demande->updated_at;
            $now = now();
    
            $diffInMinutes = round($updated_at->diffInMinutes($now));
    
            if ($diffInMinutes < 60) {
                $demande->temps_ecoule = $diffInMinutes . ' min';
                $demande->temps_ecoule_minutes = $diffInMinutes;
            } elseif ($diffInMinutes < 1440) {
                $hours = floor($diffInMinutes / 60);
                $minutes = $diffInMinutes % 60;
                $demande->temps_ecoule = $hours . 'h ' . $minutes . 'min';
                $demande->temps_ecoule_minutes = $diffInMinutes;
            } else {
                $days = floor($diffInMinutes / 1440);
                $hours = floor(($diffInMinutes % 1440) / 60);
                $demande->temps_ecoule = $days . 'j ' . $hours . 'h';
                $demande->temps_ecoule_minutes = $diffInMinutes;
            }
        }
    $nouvellesDemandes = DemandeUser::with('demande')
        ->where('user_id', $user->id)
        ->where('is_filled', false)
        ->where('IsYourTurn', true)
        ->where('updated_at', '>', now()->subMinutes(60))
        ->get();

    $demandesEnRetard = DemandeUser::with('demande')
        ->where('user_id', $user->id)
        ->where('is_filled', false)
        ->where('IsYourTurn', true)
        ->where('updated_at', '<=', now()->subMinutes(60))
        ->get();

    return view('plaisance.demandes', compact('mesdemandes', 'nouvellesDemandes', 'demandesEnRetard'));
}



}
