<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contrat;
use App\Models\Demandeur;
use App\Models\Gardien;
use App\Models\Navire;
use App\Models\Notification;
use App\Models\Proprietaire;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
// We will use the Snappy facade for high-quality PDFs
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;

class ContratController extends Controller
{
    /**
     * Display a list of contracts.
     * Shows all contracts to an admin, but only personal contracts to a plaisance user.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        // Check the user's role to determine which contracts to show
        if ($user->hasRole('admin')) {
            $contrats = Contrat::with(['user', 'demandeur', 'navire'])->latest()->paginate(15);
            // Admin gets a different view with all contracts
            return view('admin.contrats.index', [
                'contrats' => $contrats,
                'title' => 'Tous les Contrats'
            ]);
        }

        // For 'plaisance' or other users, only show their own contracts
        $contrats = $user->contrats()->with('navire', 'demandeur')->latest()->get();
        
        return view('plaisance.contrats.contrats', [
            'contrats' => $contrats,
            'title' => 'Mes Contrats'
        ]);
    }

    /**
     * Show the form for creating a new contract.
     */
    public function create(Request $request)
    {
        // Return the correct view based on the user's role
        $view = $request->user()->hasRole('admin') ? 'admin.contrats.create' : 'plaisance.contrats.create';
        
        return view($view, ['title' => 'Créer un Contrat']);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type_contrat' => 'required|in:randonnee,accostage',
            'nom_demandeur' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $contrat = DB::transaction(function () use ($request) {
            $currentUser = $request->user();

            $demandeur = Demandeur::create([
                'nom' => $request->nom_demandeur,
                'cin' => $request->cin_pass_demandeur,
                'tel' => $request->tel_demandeur,
                'adresse' => $request->adresse_demandeur,
                'email' => $request->email_demandeur,
            ]);

            $proprietaire = null;
            if ($request->filled('nom_proprietaire') || $request->filled('nom_societe')) {
                $proprietaire = Proprietaire::create([
                    'type' => $request->filled('nom_societe') ? 'morale' : 'physique',
                    'nom' => $request->nom_proprietaire ?? $request->nom_societe,
                    'tel' => $request->tel_proprietaire,
                    'nom_societe' => $request->nom_societe,
                    'ice' => $request->ice,
                    'nationalite' => $request->nationalite_proprietaire,
                    'cin_pass_phy' => $request->cin_pass_proprietaire_phy,
                    'cin_pass_mor' => $request->cin_pass_proprietaire_mor,
                    'validite_cin' => $request->validite_cin,
                    'caution_solidaire' => $request->caution_solidaire,
                ]);
            }

            $navire = Navire::create([
                'nom' => $request->nom_navire, 'type' => $request->type_navire, 'port' => $request->port,
                'numero_immatriculation' => $request->numero_immatriculation, 'pavillon' => $request->pavillon,
                'longueur' => $request->longueur, 'largeur' => $request->largeur, 'tirant_eau' => $request->tirant_eau,
                'tirant_air' => $request->tirant_air, 'jauge_brute' => $request->jauge_brute,
                'annee_construction' => $request->annee_construction, 'marque_moteur' => $request->marque_moteur,
                'type_moteur' => $request->type_moteur, 'numero_serie_moteur' => $request->numero_serie_moteur,
                'puissance_moteur' => $request->puissance_moteur,
            ]);

            $gardien = null;
            if ($request->filled('nom_gardien')) {
                $gardien = Gardien::create([
                    'nom' => $request->nom_gardien, 'cin' => $request->cin_pass_gardien, 'tel' => $request->num_tele_gardien,
                ]);
            }

            $mouvements = [];
            if ($request->type_contrat === 'randonnee') {
                $mouvements = ['num_titre_com' => $request->num_titre_com, 'equipage' => $request->equipage, 'passagers' => $request->passagers, 'total_personnes' => $request->total_personnes, 'majoration_stationnement' => $request->majoration_stationnement];
            } elseif ($request->type_contrat === 'accostage') {
                $mouvements = ['num_abonn' => $request->num_abonn, 'ponton' => $request->ponton, 'num_poste' => $request->num_poste, 'autres_prestations' => $request->autres_prestations ?? [], 'com_assurance' => $request->com_assurance, 'num_police' => $request->num_police, 'echeance' => $request->echeance];
            }

            $newContrat = Contrat::create([
                'user_id' => $currentUser->id, 'demandeur_id' => $demandeur->id, 'proprietaire_id' => $proprietaire?->id,
                'navire_id' => $navire->id, 'gardien_id' => $gardien?->id, 'type' => $request->type_contrat,
                'mouvements' => json_encode($mouvements), 'date_debut' => $request->date_debut, 'date_fin' => $request->date_fin,
                'signe_par' => $request->signe_par, 'accepte_le' => $request->accepte_le,
                'lieu_signature' => $request->lieu_signature, 'date_signature' => $request->date_signature,
            ]);

            // Notify Admins
            $admins = User::role('admin')->get();
            foreach ($admins as $admin) {
                Notification::create([
                    'user_id' => $admin->id, 'contrat_id' => $newContrat->id,
                    'titre' => 'Nouveau contrat créé par ' . $currentUser->name, 'is_read' => false,
                ]);
            }
            return $newContrat;
        });

        // Redirect to the correct route based on the user's role
        $routeName = $request->user()->hasRole('admin') ? 'admin.factures.create' : 'plaisance.factures.create';
        
        return redirect()->route($routeName, ['contrat' => $contrat->id])
                         ->with('status', 'Contrat créé avec succès !');
    }

    /**
     * Generate and download a PDF for a specific, existing contract.
     */
    public function downloadPDF(Request $request, Contrat $contrat)
    {
        // Security Check: Allow admin to see any contract, but plaisance can only see their own.
        if (!$request->user()->hasRole('admin') && $contrat->user_id !== $request->user()->id) {
            abort(403, 'Action non autorisée.');
        }

        $contrat->load(['user', 'demandeur', 'proprietaire', 'navire', 'gardien']);
        $contrat->mouvements = json_decode($contrat->mouvements, true);
        
        // Use the same template for all roles for consistency
        $view = 'plaisance.contrats' . $contrat->type; 

        if (!view()->exists($view)) {
             abort(404, "Le template de contrat pour '{$contrat->type}' n'a pas été trouvé.");
        }

        $pdf = PDF::loadView($view, ['contrat' => $contrat]);
        $filename = "contrat_{$contrat->type}_{$contrat->id}.pdf";
        
        return $pdf->download($filename);
    }
}