<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Demande;
use App\Models\DemandeUser;
use App\Models\Notification;
use Illuminate\Support\Facades\DB;

class PlaisanceController extends Controller
{
    /**
     * Display the dashboard for the "Plaisance" role with filtered stats.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function plaisancedashboard(Request $request)
    {
        $user = $request->user();

        // Fetch contracts and invoices created ONLY by this user
        $contrats = $user->contrats()->latest()->get();
        $factures = $user->factures()->latest()->get();

        // Calculate statistics based on the filtered data
        $data = [
            'contractCount'       => $contrats->count(),
            'invoiceCount'        => $factures->count(),
            'unpaidInvoicesCount' => $factures->where('statut', 'non payée')->count(),
            'totalOwed'           => $factures->where('statut', 'non payée')->sum('total_ttc'),
            'recentContrats'      => $contrats->take(5),
            'title'               => 'Tableau de bord Plaisance'
        ];

        return view('plaisance.dashboard', $data);
    }

    /**
     * Display a list of "demandes" assigned to the authenticated user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function userDemandes(Request $request)
    {
        $user = $request->user();
        
        // Fetch all relevant "demandes" for this user in one query
        $mesdemandes = DemandeUser::with('demande')
            ->where('user_id', $user->id)
            ->where(fn($q) => $q->where('isyourturn', true)->orWhere('is_filled', true))
            ->latest('updated_at')
            ->paginate(10);

        // Process each "demande" to calculate elapsed time
        $mesdemandes->each(function ($demande) {
            $demande->temps_ecoule = $demande->updated_at->diffForHumans(now(), [
                'syntax' => \Carbon\CarbonInterface::DIFF_ABSOLUTE,
                'parts' => 2,
            ]);
        });

        // Filter the collection to get new and late "demandes" without extra database queries
        $actionableDemandes = $mesdemandes->where('is_filled', false)->where('isyourturn', true);
        $nouvellesDemandes = $actionableDemandes->where('updated_at', '>', now()->subHour());
        $demandesEnRetard = $actionableDemandes->where('updated_at', '<=', now()->subHour());

        return view('plaisance.demandes', compact('mesdemandes', 'nouvellesDemandes', 'demandesEnRetard'));
    }

    /**
     * Show the form for the user to fill their assigned fields for a "demande".
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id The ID of the Demande.
     * @return \Illuminate\View\View
     */
    public function showRemplir(Request $request, $id)
    {
        $user = $request->user();
        $demande = Demande::findOrFail($id);

        // Filter the "champs" array to get only the fields assigned to the current user.
        $champsAffectes = collect($demande->champs ?? [])
            ->filter(fn($champData) => is_array($champData) && isset($champData['user_id']) && $champData['user_id'] == $user->id);

        return view('plaisance.remplirDemande', [
            'demande' => $demande,
            'champs' => $champsAffectes,
            'title' => "Remplir la Demande #{$demande->id}"
        ]);
    }

    /**
     * Handle the form submission for filling a "demande".
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id The ID of the Demande.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remplir(Request $request, $id)
    {
        $user = $request->user();
        $demande = Demande::findOrFail($id);
        
        // Security check: Ensure this user is actually assigned to this demande
        if (!$demande->users()->where('user_id', $user->id)->exists()) {
            return redirect()->route('plaisance.demandes')->with('error', 'Vous n\'êtes pas autorisé à modifier cette demande.');
        }

        $champs = $demande->champs ?? [];
        $values = $request->input('values', []);

        // Update values for assigned fields
        foreach ($values as $key => $value) {
            if (isset($champs[$key]) && is_array($champs[$key]) && ((string)($champs[$key]['user_id'] ?? '') === (string)$user->id)) {
                $champs[$key]['value'] = $value;
            }
        }
        
        // Handle file uploads
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $key => $file) {
                if (isset($champs[$key]) && is_array($champs[$key]) && ((string)($champs[$key]['user_id'] ?? '') === (string)$user->id)) {
                    $fileName = time() . '_' . $user->id . '_' . $file->getClientOriginalName();
                    $filePath = $file->storeAs('demandes', $fileName, 'public');
                    $champs[$key]['value'] = $filePath; // Save the file path as the value
                }
            }
        }

        $demande->champs = $champs;
        $demande->save();
        
        // Check if all fields assigned to THIS user are now filled
        $userChamps = array_filter($champs, fn($champ) => is_array($champ) && ($champ['user_id'] ?? null) === $user->id);
        $allFilled = collect($userChamps)->every(fn($champ) => !empty(trim($champ['value'] ?? '')));

        // Update the pivot table with the new status
        $demande->users()->updateExistingPivot($user->id, [
            'is_filled' => $allFilled,
            'etape' => $allFilled ? 'en_attente_validation' : 'en_cours',
            'duree' => $request->input('temps_ecoule'),
        ]);

        // Notify the Admin that a user has submitted their part of the form
        Notification::create([
            'user_id' => 1, // Assumes Admin user_id is 1
            'demande_id' => $id,
            'titre' => "L'utilisateur {$user->name} a rempli sa partie de la demande #{$id}.",
            'is_read' => false,
        ]);

        return redirect()->route('plaisance.demandes')->with('success', 'Formulaire soumis avec succès pour validation.');
    }
}