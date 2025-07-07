<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Demande;
use App\Models\DemandeUser;

class TresorierController extends Controller
{
    public function tresorierDashboard()
    {
        $demandesRemplies = Demande::whereHas('demandeUsers', function ($query) {
            $query->where('etape', 'acceptee');
        })->count();

        $demandesEnAttente = DemandeUser::where('etape', 'en_attente_validation')->count();

        $metrics = [
            [
                'label' => 'Demandes Remplies',
                'count' => $demandesRemplies,
                'color' => 'blue',
                'icon'  => 'fa-file-circle-check'
            ],
            [
                'label' => 'Ordres de Virement',
                'count' => 0,
                'color' => 'emerald',
                'icon'  => 'fa-building-columns'
            ],
            [
                'label' => 'Demandes en attente',
                'count' => $demandesEnAttente,
                'color' => 'purple',
                'icon'  => 'fa-hourglass-half'
            ],
        ];

        return view('tresorier.dashboard', compact('metrics'));
    }

    public function userDemandes()
    {
        $demandes_acc = \App\Models\DemandeUser::with(['demande', 'user'])
        ->where('etape', 'acceptee')
        ->get();
    
        $totalDemandes = \App\Models\DemandeUser::where('etape', 'acceptee')->count();
        
        return view('tresorier.demandes', compact('demandes_acc', 'totalDemandes'));
    //     return response()->json([
    //     'demandes_acc' => $demandes,
    //     'totalDemandes' => $totalDemandes,
    // ]);
    }
   public function userDemandesSearch(Request $request)
{
    // Get all filter parameters
    $searchUser = $request->get('search_user');
    $dateSubmission = $request->get('date_soumission');
    $typeEconomique = $request->get('filter_etape');
    
    $query = DemandeUser::with(['demande', 'user'])
        ->where('etape', 'acceptee');

    // Apply filters
    if ($searchUser) {
        $query->whereHas('user', function($q) use ($searchUser) {
            $q->where('name', 'LIKE', '%' . $searchUser . '%')
              ->orWhere('email', 'LIKE', '%' . $searchUser . '%');
        });
    }

    if ($dateSubmission) {
        $query->whereDate('updated_at', $dateSubmission);
    }

    if ($typeEconomique && $typeEconomique !== 'all') {
        $query->whereHas('demande', function($q) use ($typeEconomique) {
            $q->where('type_economique', $typeEconomique);
        });
    }

    $query->orderBy('updated_at', 'desc');
    $demandes_acc = $query->get();
    $totalDemandes = $demandes_acc->count();

    // If AJAX request, return only the results partial
    if ($request->ajax()) {
        return response()->json([
            'success' => true,
            'html' => view('tresorier.partials.demandes-results', compact(
                'demandes_acc', 
                'totalDemandes',
                'searchUser',
                'dateSubmission', 
                'typeEconomique'
            ))->render()
        ]);
    }

    // Normal page load
    return view('tresorier.demandes', compact(
        'demandes_acc', 
        'totalDemandes',
        'searchUser',
        'dateSubmission', 
        'typeEconomique'
    ));
}


    public function OP()
    {
        return view('tresorier.op');
    }

    public function OV()
    {
        return view('tresorier.ov');
    }
}