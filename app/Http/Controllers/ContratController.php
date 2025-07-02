<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Demandeur;
use App\Models\Proprietaire;
use App\Models\Navire;
use App\Models\Gardien;
use App\Models\Contrat;
use App\Models\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\ContratSigne;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Storage;
use App\Models\User;


class ContratController extends Controller
{
    public function index(Request $request)
    {
        // Get the currently logged-in user from the Request object.
        $user = $request->user();

        // Fetch all contracts for this user, including related boat and requester info.
        $contrats = $user->contrats()->with('navire', 'demandeur')->latest()->get();

        // Pass the contracts data to the view.
        return view('user.contrats.contrats', ['contrats' => $contrats]);
    }
    public function create()
    {
        return view('user.contrats.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type_contrat' => 'required|in:randonnee,accostage',
            'nom_demandeur' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Erreur de validation');
        }

        $contrat = DB::transaction(function () use ($request) {
            $demandeur = Demandeur::create([
                'nom' => $request->nom_demandeur,
                'cin_pass' => $request->cin_pass_demandeur,
                'tel' => $request->tel_demandeur,
                'adresse' => $request->adresse_demandeur,
                'email' => $request->email_demandeur,
            ]);

            $proprietaire = Proprietaire::create([
                'type' => $request->filled('nom_societe') ? 'morale' : 'physique',
                'nom' => $request->nom_proprietaire ?? $request->nom_societe,
                'tel' => $request->tel_proprietaire,
                'nom_societe' => $request->nom_societe,
                'ice' => $request->ice,
                'nationalite' => $request->nationalite_proprietaire,
                'cin' => $request->cin_pass_proprietaire,
                'validite_cin' => $request->validite_cin,
                'caution_solidaire' => $request->caution_solidaire,
                'passeport' => $request->cin_pass_proprietaire,
            ]);

            $navire = Navire::create([
                'nom' => $request->nom_navire,
                'type' => $request->type_navire,
                'port' => $request->port,
                'numero_immatriculation' => $request->numero_immatriculation,
                'pavillon' => $request->pavillon,
                'longueur' => $request->longueur,
                'largeur' => $request->largeur,
                'tirant_eau' => $request->tirant_eau,
                'tirant_air' => $request->tirant_air,
                'jauge_brute' => $request->jauge_brute,
                'annee_construction' => $request->annee_construction,
                'marque_moteur' => $request->marque_moteur,
                'type_moteur' => $request->type_moteur,
                'numero_serie_moteur' => $request->numero_serie_moteur,
                'puissance_moteur' => $request->puissance_moteur,
            ]);

            $gardien = Gardien::create([
                'nom' => $request->nom_gardien,
                'cin_pass' => $request->cin_pass_gardien,
                'tel' => $request->num_tele_gardien,
            ]);

            $mouvements = [];

            if ($request->type_contrat === 'randonnee') {
                $mouvements = [
                    'num_titre_com' => $request->num_titre_com,
                    'equipage' => $request->equipage,
                    'passagers' => $request->passagers,
                    'total_personnes' => $request->total_personnes,
                    'majoration_stationnement' => $request->majoration_stationnement,
                ];
            } elseif ($request->type_contrat === 'accostage') {
                $mouvements = [
                    'num_abonn' => $request->num_abonn,
                    'ponton' => $request->ponton,
                    'num_poste' => $request->num_poste,
                    'autres_prestations' => $request->autres_prestations ?? [],
                    'com_assurance' => $request->com_assurance,
                    'num_police' => $request->num_police,
                    'echeance' => $request->echeance,
                ];
            }

            $contrat = Contrat::create([
                'user_id' => Auth::id(),
                'demandeur_id' => $demandeur->id,
                'proprietaire_id' => $proprietaire->id,
                'navire_id' => $navire->id,
                'gardien_id' => $gardien->id,
                'type' => $request->type_contrat,
                'mouvements' => json_encode($mouvements),
                'date_debut' => $request->date_debut,
                'date_fin' => $request->date_fin,
                'signe_par' => $request->signe_par,
                'accepte_le' => $request->accepte_le,
                'lieu_signature' => $request->lieu_signature,
                'date_signature' => $request->date_signature,
            ]);

            // Notifier les admins
            foreach (User::role('admin')->get() as $admin) {
                Notification::create([
                    'user_id' => $admin->id,
                    'contrat_id' => $contrat->id,
                    'titre' => 'Nouveau contrat créé par ' . Auth::user()->name,
                    'is_read' => false,
                ]);
            }

            return $contrat;
        });

            // return redirect()->route('contrats.genererPDF', [
            //     'id' => $contrat->id,
            //     'type' => $request->type_contrat
            // ]);
            return redirect()->route('factures.create', ['contrat' => $contrat->id])
            ->with('download_contract', [
                'id' => $contrat->id,
                'type' => $contrat->type
            ]);
    }

    public function genererPDF($id, $type)
    {
        $contrat = Contrat::with(['user', 'demandeur', 'proprietaire', 'navire', 'gardien'])->findOrFail($id);
        $contrat->mouvements = json_decode($contrat->mouvements, true);
        $view = $type === 'accostage' ? 'user.contrats.accostage' : 'user.contrats.randonnee';

        return view($view, compact('contrat', 'type'));
    }



public function indexAdmin()
{
    $contrats = Contrat::with(['demandeur', 'proprietaire', 'navire', 'contratSigne'])->latest()->paginate(10);
    return view('admin.contrats.index', compact('contrats'));
}


// public function imprimer($id)
// {
//     $contrat = Contrat::with(['navire', 'demandeur', 'proprietaire', 'gardien'])->findOrFail($id);
//     $mouvements = [];
//     if (!empty($contrat->mouvements)) {
//         try {
//             $decoded = json_decode($contrat->mouvements, true);
//             $mouvements = is_array($decoded) ? $decoded : [];
//         } catch (\Exception $e) {
//             $mouvements = [];
//         }
//     }

//     $type = $contrat->type === 'accostage' ? 'accostage' : 'randonnee';
//     $view = "user.contrats.{$type}";

//     return view($view, [
//         'contrat' => $contrat,
//         'type' => $type,
//         'mouvements' => $mouvements
//     ]);
// }

public function importerContrat(Request $request, $id)
{
    $request->validate([
        'contrat_signe' => 'required|mimes:pdf|max:10240'
    ]);

    $contrat = Contrat::findOrFail($id);

    $path = $request->file('contrat_signe')->store("contrats_signes/{$id}", 'public');

    // ✅ Mettre à jour le contrat
    $contrat->update([
        'est_signe_importe' => true,
        'contrat_signe_path' => $path
    ]);

    // ✅ Sauvegarder dans table contrat_signes
    ContratSigne::create([
        'contrat_id' => $contrat->id,
        'fichier_path' => $path,
        'imported_at' => now()
    ]);

    return back()->with('success', 'Contrat signé importé avec succès.');
}

public function voirContratSigne($contratId)
{
    $contrat = Contrat::findOrFail($contratId);

    $chemin = storage_path('app/public/' . $contrat->contrat_signe_path);

    if (!file_exists($chemin)) {
        abort(404, 'Fichier non trouvé.');
    }

    return response()->file($chemin);
}

public function marquerImprime($id)
{
    $contrat = \App\Models\Contrat::findOrFail($id);
    $contrat->est_imprime = true;
    $contrat->save();

    return response()->json(['status' => 'ok']);
}




}