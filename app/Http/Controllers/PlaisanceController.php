<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\DemandeUser;
use App\Models\Demande;
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

public function showRemplir($id)
{
    $user = Auth::user();
    $demande = Demande::findOrFail($id);

    $champsAffectes = collect($demande->champs ?? [])
        ->filter(function ($champData) use ($user) {
            return is_array($champData)
                && isset($champData['user_id'])
                && $champData['user_id'] == $user->id;
        });

    return view('plaisance.remplirDemande', [
        'user' => $user,
        'demande' => $demande,
        'champs' => $champsAffectes,
    ]);
}


    public function remplir(Request $request, $id)
    {
    $user = Auth::user();
    $demande = Demande::findOrFail($id);
    $userId = $user->id;

    $values = $request->input('values', []);

    if ($request->hasFile('files')) {
        $request->validate([
            'files.*' => 'file|max:10240', 
        ]);
    }

    $champs = $demande->champs ?? [];

    foreach ($values as $key => $value) {
        if (isset($champs[$key]) && is_array($champs[$key]) && ((string)($champs[$key]['user_id'] ?? '') === (string)$userId)) {
            $champs[$key]['value'] = $value;
        }
        
    }
    $demande->champs = $champs;
    $demande->save();
    if ($request->hasFile('files')) {
        foreach ($request->file('files') as $file) {
            $originalName = $file->getClientOriginalName();
            $fileName = time() . '_' . $userId . '_' . $originalName;
            $filePath = $file->storeAs('demandes', $fileName, 'public');

            DB::table('demande_files')->insert([
                'demande_id' => $demande->id,
                'user_id' => $userId,
                'file_name' => $originalName,
                'file_path' => $filePath,
                'file_size' => $file->getSize(),
                'mime_type' => $file->getMimeType(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    $userChamps = array_filter($champs, function ($champ) use ($userId) {
        return is_array($champ) && isset($champ['user_id']) && $champ['user_id'] === $userId;
    });
    $allFilled = collect($userChamps)->every(fn($champ) => !is_null($champ['value']) && trim($champ['value']) !== '');

    if ($allFilled) {
        $user->demandes()->updateExistingPivot($demande->id, [
            'is_filled' => true,
            // 'isyourturn' => false,
            'duree' => $request->input('temps_ecoule'),
            'etape'=>'en_attente_validation',
        ]);

    } else {
        $user->demandes()->updateExistingPivot($demande->id, [
            'is_filled' => false,
        ]);
    }
    Notification::create([
        'user_id' => 1,
        'demande_id' => $id,
        'titre' => 'vous avez des champs a reviser',
        'is_read' => false,
    ]);

    return redirect()->route('plaisance.demandes')->with('success', 'Formulaire soumis avec succès.');
}

public function getAlerts()
{
    $userId = Auth::id();
    $now = now();
    $nouvellesDemandes = DemandeUser::where('user_id', $userId)
        ->where('is_filled', false)
        // ->where('IsYourTurn', true)
        ->where('updated_at', '>', $now->copy()->subMinutes(60))
        ->count();
    $demandesEnRetard = DemandeUser::where('user_id', $userId)
        ->where('is_filled', false)
        // ->where('IsYourTurn', true)
        ->where('updated_at', '<=', $now->copy()->subMinutes(60))
        ->count();
    return response()->json([
        'nouvelles' => $nouvellesDemandes,
        'retard' => $demandesEnRetard,
    ]);
}


}
