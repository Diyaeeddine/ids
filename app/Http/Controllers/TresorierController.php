<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Demande;
use App\Models\DemandeUser;
use App\Models\OrderP;
use App\Models\OrderV;
use App\Models\Facture;
use Laravel\Pail\ValueObjects\Origin\Console;

use function Laravel\Prompts\error;

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
                'label' => 'Ordres de Paiement',
                'count' => 0,
                'color' => 'emerald',
                'icon'  => 'fa-building-columns'
            ],
            [
                'label' => 'Ordres de Virement',
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

    public function OV(Request $request)
{
    // ========================================
    // COMMON DATA SETUP
    // ========================================

    // try {
    //     // Fetch all entries from OrderP and map id => entite_ordonnatrice
    //     $op_ids = OrderP::pluck('entite_ordonnatrice', 'id')->toArray();

    // } catch (\Exception $e) {
    //     return response()->json([
    //         'success' => false,
    //         'message' => 'Erreur lors de la récupération des données: ' . $e->getMessage()
    //     ], 500);
    // }

    $op_ids = [
                100 => 'Youssef',
                101 => 'Amine',
                102 => 'Sara',
                103 => 'Karim',
                104 => 'Nora',
                105 => 'Leila',
                106 => 'Omar',
                107 => 'Mona',
                108 => 'Rachid',
                109 => 'Samira',
            ];

    // ========================================
    // GET SEARCH PARAMETERS - FIXED
    // ========================================

    $beneficiaireRib = $request->get('beneficiaire_rib');
    $factureNumber = $request->get('facture_number');
    $dateSubmission = $request->get('date');

    $beneficiaireRib = !empty($beneficiaireRib) ? $beneficiaireRib : null;
    $factureNumber = !empty($factureNumber) ? $factureNumber : null;
    $dateSubmission = !empty($dateSubmission) ? $dateSubmission : null;

    $hasSearchParams = $beneficiaireRib || $factureNumber || $dateSubmission;

    // ========================================
    // BUILD QUERY
    // ========================================

    $query = OrderV::query();

    if ($hasSearchParams) {
        if ($beneficiaireRib) {
            if (is_numeric($beneficiaireRib)) {
                $query->where('beneficiaire_rib', $beneficiaireRib);
            } else {
                $query->where('beneficiaire_nom', 'LIKE', '%' . $beneficiaireRib . '%');
            }
        }

        if ($factureNumber) {
            $orderPIds = OrderP::whereNotNull('id_facture')
                ->pluck('id_facture')
                ->toArray();

            $factureIds = Facture::whereIn('id', $orderPIds)
                ->where('numero_facture', 'LIKE', '%' . $factureNumber . '%')
                ->pluck('id')
                ->toArray();

            if (!empty($factureIds)) {
                $query->whereHas('orderP', function ($q) use ($factureIds) {
                    $q->whereIn('id_facture', $factureIds);
                });
            } else {
                $query->whereRaw('1 = 0');
            }
        }

        if ($dateSubmission) {
            try {
                $date = \Carbon\Carbon::createFromFormat('Y-m-d', $dateSubmission);
                $query->whereDate('date_virement', $date->format('Y-m-d'));
            } catch (\Exception $e) {
                error_log('Invalid date format provided: ' . $dateSubmission);
            }
        }
    }

    $query->orderBy('created_at', 'desc');

    // ========================================
    // PAGINATION vs SEARCH RESULTS
    // ========================================

    if ($hasSearchParams) {
        $ordres = $query->get();
        $isSearch = true;
    } else {
        $ordres = $query->paginate(10);
        $isSearch = false;
    }

    $totalOvs = $hasSearchParams ? $ordres->count() : OrderV::count();

    // ========================================
    // FINAL RESPONSE (choose one: JSON or view)
    // ========================================

    // return response()->json([
    //     'success' => true,
    //     'dyn_op_ids' => $dyn_op_ids,
    //     'total' => $totalOvs,
    //     'orders' => $ordres,
    //     'hasResults' => $totalOvs > 0
    // ]);

    // Or return a Blade view instead (uncomment below if needed):
    
    return view('tresorier.ov', compact(
        'op_ids',
        'ordres',
        'totalOvs',
        'isSearch',
        'beneficiaireRib',
        'factureNumber',
        'dateSubmission'
    ));
    
}

    
        
        
        
    public function ovStore(Request $request){
        // Simple validation - only essential rules
        $validatedData = $request->validate([
            // 'id_op' => 'required|integer',
            'id_op' => 'integer',
            'date_virement' => 'required|date',
            'montant' => 'required|numeric|min:0.01',
            'compte_debiteur' => 'required|string|min:5',
            'beneficiaire_nom' => 'required|string|min:2',
            'beneficiaire_rib' => 'required|string|min:10',
            'beneficiaire_banque' => 'required|string|min:2',
            'beneficiaire_agence' => 'required|string|min:2',
            'objet' => 'required|string|min:5'
        ]);

        try {
            $virement = \App\Models\OrderV::create([
                'id_op' => $validatedData['id_op'],
                'date_virement' => $validatedData['date_virement'],
                'compte_debiteur' => $validatedData['compte_debiteur'],
                'montant' => $validatedData['montant'],
                'beneficiaire_nom' => $validatedData['beneficiaire_nom'],
                'beneficiaire_rib' => $validatedData['beneficiaire_rib'],
                'beneficiaire_banque' => $validatedData['beneficiaire_banque'],
                'beneficiaire_agence' => $validatedData['beneficiaire_agence'],
                'objet' => $validatedData['objet']
            ]);

            return redirect()->back()->with('success', 'Demande créée avec succès');

        } catch (ValidationException $e) {
           
            return redirect()->back()->with('error', 'Erreurs de validation.');

        } catch (\Exception $e) {
           
            return redirect()->back()->with('error', 'Une erreur est survenue lors de l\'enregistrement.');
        }
    }


    public function ovShow($id)
        {
            try {
                // Assuming you have a model called OrderV
                $operation = OrderV::findOrFail($id); // Will throw ModelNotFoundException if not found

                return response()->json([
                    'success' => true,
                    'data' => $operation
                ]);

            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Aucune opération trouvée avec cet ID.'
                ], 404);

            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur lors de la récupération des données: ' . $e->getMessage()
                ], 500);
            }
        }

    public function ovUpdate(Request $request, $id)
        {
            try {
                // Validate the request
                $validatedData = $request->validate([
                    'date_virement' => 'required|date',
                    'montant' => 'required|numeric|min:0',
                    'compte_debiteur' => 'required|string|max:255',
                    'beneficiaire_nom' => 'required|string|max:255',
                    'beneficiaire_rib' => 'required|string|max:255',
                    'beneficiaire_banque' => 'required|string|max:255',
                    'beneficiaire_agence' => 'required|string|max:255',
                    'objet' => 'required|string',
                ]);

                // Find and update the record
                $ordre = OrderV::findOrFail($id); // Adjust model name as needed
                $ordre->update($validatedData);

                // Return JSON response for AJAX requests
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Ordre de virement mis à jour avec succès',
                        'data' => $ordre
                    ]);
                }

                // Redirect for regular form submissions
                return redirect()->route('tresorier.ov')->with('success', 'Ordre de virement mis à jour avec succès');

            } catch (\Illuminate\Validation\ValidationException $e) {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Erreur de validation',
                        'errors' => $e->errors()
                    ], 422);
                }
                return back()->withErrors($e->errors())->withInput();

            } catch (\Exception $e) {
                \Log::error('Error updating ordre virement: ' . $e->getMessage());
                
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Erreur lors de la mise à jour: ' . $e->getMessage()
                    ], 500);
                }
                return back()->with('error', 'Erreur lors de la mise à jour')->withInput();
            }
        }

    public function ovDelete(Request $request, $id)
{
    try {
        // Debug: Log the incoming request
       

        // Check if record exists first
        $ordre = \App\Models\OrderV::find($id);
        
        if (!$ordre) {
            \Log::error('OrderV not found for deletion', ['id' => $id]);
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => "Ordre de virement avec l'ID {$id} introuvable"
                ], 404);
            }
            
            return back()->with('error', 'Ordre de virement introuvable');
        }
        $ordre->delete();
        
        \Log::info('OrderV deleted successfully');

        // Return JSON response for AJAX requests
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Ordre de virement supprimé avec succès',
                'deleted_id' => $id
            ]);
        }

        return redirect()->route('tresorier.ov')->with('success', 'Ordre de virement supprimé avec succès');

    } catch (\Exception $e) {
        \Log::error('Error deleting OrderV', [
            'id' => $id,
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression: ' . $e->getMessage()
            ], 500);
        }
        
        return back()->with('error', 'Erreur lors de la suppression');
    }
}



    }

