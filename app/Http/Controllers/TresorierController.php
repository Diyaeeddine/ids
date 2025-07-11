<?php

namespace App\Http\Controllers;

use App\Models\OrderP;
use App\Models\OrderV;
use Illuminate\Http\Request;
use App\Models\Demande;
use App\Models\DemandeUser;
use App\Models\Facture;
use App\Models\User;
use App\Models\FactureItem;
use App\Models\Contrat;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;


class TresorierController extends Controller
{
    public function tresorierDashboard()
    {
        $demandesRemplies = Demande::whereHas('demandeUsers', function ($query) {
            $query->where('etape', 'acceptee');
        })->count();

        $demandesEnAttente = DemandeUser::where('etape', 'en_attente_validation')->count();

        $ordresPaiementCount = OrderP::count();

        $metrics = [
            [
                'label' => 'Demandes Remplies',
                'count' => $demandesRemplies,
                'color' => 'blue',
                'icon'  => 'fa-file-circle-check'
            ],
            [
                'label' => 'Ordres de Paiment',
                'count' => $ordresPaiementCount,
                'color' => 'emerald',
                'icon'  => 'fa-building-columns'
            ],
            [
                'label' => 'Ordres de Virement',
                'count' => $demandesEnAttente,
                'color' => 'purple',
                'icon'  => 'fa-money-bill-transfer'
            ],
        ];

        return view('tresorier.dashboard', compact('metrics'));
    }

    public function userDemandes()
    {
        $demandes_acc = DemandeUser::with(['demande', 'user'])
        ->where('etape', 'acceptee')
        ->get();
    
        $totalDemandes = DemandeUser::where('etape', 'acceptee')->count();
        
        return view('tresorier.demandes', compact('demandes_acc', 'totalDemandes'));

    }

     public function OP(Request $request)
    {
        $query = OrderP::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('reference', 'like', "%{$search}%")
                  ->orWhere('description_operation', 'like', "%{$search}%")
                  ->orWhere('fournisseur', 'like', "%{$search}%");
            });
        }

        if ($paymentMethod = $request->input('payment_method')) {
            if (in_array($paymentMethod, ['check', 'cash', 'bank_transfer'])) {
                $query->where('mode_paiement', $paymentMethod);
            }
        }

        $orders = $query->orderBy('date_mise_paiement', 'desc')
                        ->paginate(10)
                        ->withQueryString();

        return view('tresorier.op', compact('orders'));
    }


    public function createOP()
    {
    
        $factureIdsUtilisees = OrderP::pluck('id_facture')->toArray();
    
        $factures = Facture::whereNotIn('factures.id', $factureIdsUtilisees)
        ->join('contrats', 'factures.contrat_id', '=', 'contrats.id')
        ->join('demandes', 'demandes.contrat_id', '=', 'contrats.id')
        ->join('demande_user', function($join) {
            $join->on('demande_user.demande_id', '=', 'demandes.id')
                 ->where('demande_user.etape', '=', 'acceptee'); 
        })
        ->select('factures.*') 
        ->get();
        $factureData = [];
    
        foreach ($factures as $facture) {
            $items = FactureItem::where('facture_id', $facture->id)->get();
    
            $contrat = Contrat::find($facture->contrat_id);
            $demandeNom = $contrat && $contrat->demandeur ? $contrat->demandeur->nom : 'N/A';
    
            $factureData[] = [
                'id' => $facture->id,
                'numero' => $facture->numero_facture ?? 'Facture #' . $facture->id,
                'demande_nom' => $demandeNom,
                'montant_paye' => $facture->montant_paye,
                'items' => $items->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'description' => $item->description,
                        'montant_ht' => $item->montant_ht,
                    ];
                }),
            ];
        }
    
        return view('tresorier.create-OP', compact('factureData'));
    }

public function destroy($id)
{
    $order = OrderP::findOrFail($id);
    $order->delete();

    return redirect()->route('tresorier.op')->with('success', 'Ordre de paiement supprimé avec succès.');
}
public function update(Request $request, $id)
{
    $validated = $request->validate([
        'description' => 'required|string|max:255',
        'amount' => 'required|numeric|min:0.01',
        'payment_method' => 'required|string',
        'due_date' => 'required|date',
        'notes' => 'nullable|string',
        'marche_bc' => 'nullable|string',
        'fournisseur' => 'nullable|string',
        'periode_facturation' => 'nullable|string',
        'pieces_justificatives' => 'nullable|string',
        'montant_lettres' => 'nullable|string',
        'date_mise_paiement' => 'nullable|date',
        'visa_controle' => 'nullable|string',
        'imputation_comptable' => 'nullable|string',
        'metier' => 'nullable|string',
        'section_analytique' => 'nullable|string',
        'produit' => 'nullable|string',
        'extension_analytique' => 'nullable|string',
    
    ]);

    $order = OrderP::findOrFail($id);
$order->update([
    'description_operation' => $validated['description'],
    'montant_chiffres' => $validated['amount'],
    'mode_paiement' => $validated['payment_method'],
    'date_paiment' => $validated['due_date'],
    'observations' => $validated['notes'],
    'marche_bc' => $validated['marche_bc'] ?? null,
    'fournisseur' => $validated['fournisseur'] ?? null,
    'periode_facturation' => $validated['periode_facturation'] ?? null,
    'pieces_justificatives' => $validated['pieces_justificatives'] ?? null,
    'montant_lettres' => $validated['montant_lettres'] ?? null,
    'date_mise_paiement' => $validated['date_mise_paiement'] ?? null,
    'visa_controle' => $validated['visa_controle'] ?? null,
    'imputation_comptable' => $validated['imputation_comptable'] ?? null,
    'metier' => $validated['metier'] ?? null,
    'section_analytique' => $validated['section_analytique'] ?? null,
    'produit' => $validated['produit'] ?? null,
    'extension_analytique' => $validated['extension_analytique'] ?? null,
    'updated_at' => now(),
]);


    return redirect()->route('tresorier.op')->with('success', 'Ordre de paiement mis à jour avec succès.');
}

public function show($id)
{
    $order = OrderP::with([
        'facture' => function($query) {
            $query->with([
                'contrat' => function($query) {
                    $query->with(['demandeur', 'demande']);
                }
            ]);
        }
    ])->findOrFail($id);

    return view('tresorier.show-op', compact('order'));
}


public function store(Request $request)
{
    $validated = $request->validate([
        'invoice_id' => 'required|integer|exists:factures,id',
        'description' => 'required|string|max:255',
        'amount' => 'required|numeric',
        'payment_method' => 'required|string',
        'due_date' => 'required|date',
        'notes' => 'nullable|string',
        'marche_bc' => 'nullable|string',
        'fournisseur' => 'nullable|string',
        'periode_facturation' => 'nullable|string',
        'pieces_justificatives' => 'nullable|string',
        'montant_lettres' => 'nullable|string',
        'date_mise_paiement' => 'nullable|date',
        'visa_controle' => 'nullable|string',
        'imputation_comptable' => 'nullable|string',
        'metier' => 'nullable|string',
        'section_analytique' => 'nullable|string',
        'produit' => 'nullable|string',
        'extension_analytique' => 'nullable|string',
    
    ]);

    $facture = Facture::with('contrat.demandeur', 'contrat.demande')->find($validated['invoice_id']);

    if (!$facture || !$facture->contrat || !$facture->contrat->demande) {
        return back()->withErrors(['error' => 'Impossible de trouver la demande liée à la facture.']);
    }
    
    DB::table('order_p')->insert([
            'id_facture' => $validated['invoice_id'],
            'reference' => $facture->numero_facture,
            'entite_ordonnatrice' => $facture->contrat->demandeur->nom,
            'description_operation' => $validated['description'],
            'montant_chiffres' => $validated['amount'],
            'mode_paiement' => $validated['payment_method'],
            'date_paiment' => $validated['due_date'],
            'observations' => $validated['notes'] ?? null,
            'marche_bc' => $validated['marche_bc'] ?? null,
            'fournisseur' => $validated['fournisseur'] ?? null,
            'periode_facturation' => $validated['periode_facturation'] ?? null,
            'pieces_justificatives' => $validated['pieces_justificatives'] ?? null,
            'montant_lettres' => $validated['montant_lettres'] ?? null,
            'date_mise_paiement' => $validated['date_mise_paiement'] ?? null,
            'visa_controle' => $validated['visa_controle'] ?? null,
            'imputation_comptable' => $validated['imputation_comptable'] ?? null,
            'metier' => $validated['metier'] ?? null,
            'section_analytique' => $validated['section_analytique'] ?? null,
            'produit' => $validated['produit'] ?? null,
            'extension_analytique' => $validated['extension_analytique'] ?? null,
            'created_at' => now(),
            'updated_at' => now(),

    ]);
    
    foreach (User::role('admin')->get() as $admin) {
        DB::table('notifications')->insert([
            'user_id' => $admin->id,
            'demande_id' => $facture->contrat->demande->id,
            'contrat_id' => $facture->contrat->id,
            'type' => 'verifier_op',
            'titre' => 'Nouveau OP à vérifier',
            'source_user_id' => Auth()->id(),
            'is_read' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
    

    return redirect()->route('tresorier.op')->with('success', 'Ordre de paiement créé avec succès.');
}






    public function createOV()
    {
        return view('tresorier.create-OV');
    }

    

    public function reset($id)
    {
        $order = OrderP::findOrFail($id);

        $order->status = null; 
        $order->save();

        return redirect()->route('tresorier.op')->with('success', 'Le statut de l\'ordre de paiement a été réinitialisé.');
    }

    public function userDemandesSearch(Request $request)
{
    $searchUser = $request->get('search_user');
    $dateSubmission = $request->get('date_soumission');
    $typeEconomique = $request->get('filter_etape');
    
    $query = DemandeUser::with(['demande', 'user'])
        ->where('etape', 'acceptee');

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

    return view('tresorier.demandes', compact(
        'demandes_acc', 
        'totalDemandes',
        'searchUser',
        'dateSubmission', 
        'typeEconomique'
    ));
}


public function OV(Request $request)
{


    $num_op = OrderP::select('id')->where('is_accepted',true)->get();


    $beneficiaireRib = $request->get('beneficiaire_rib');
    $factureNumber = $request->get('facture_number');
    $dateSubmission = $request->get('date');

    $beneficiaireRib = !empty($beneficiaireRib) ? $beneficiaireRib : null;
    $factureNumber = !empty($factureNumber) ? $factureNumber : null;
    $dateSubmission = !empty($dateSubmission) ? $dateSubmission : null;

    $hasSearchParams = $beneficiaireRib || $factureNumber || $dateSubmission;

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

    if ($hasSearchParams) {
        $ordres = $query->get();
        $isSearch = true;
    } else {
        $ordres = $query->paginate(10);
        $isSearch = false;
    }

    $totalOvs = $hasSearchParams ? $ordres->count() : OrderV::count();
    return view('tresorier.ov', compact(
        'num_op',
        'ordres',
        'totalOvs',
        'isSearch',
        'beneficiaireRib',
        'factureNumber',
        'dateSubmission'
    ));
    
}

    public function ovStore(Request $request){
        $validatedData = $request->validate([
            // 'id_op' => 'required|integer',
            'id_op' => 'integer',
            'date_virement' => 'required|date',
            'montant' => 'required|numeric',
            'compte_debiteur' => 'required|string|min:5',
            'beneficiaire_nom' => 'required|string|min:2',
            'beneficiaire_rib' => 'required|string|min:10',
            'beneficiaire_banque' => 'required|string|min:2',
            'beneficiaire_agence' => 'required|string|min:2',
            'objet' => 'required|string|min:5'
        ]);

        try {
            $virement = OrderV::create([
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
                $operation = OrderV::findOrFail($id); 

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
            $validatedData = $request->validate([
                'date_virement' => 'required|date',
                'compte_debiteur' => 'required|string|max:255',
                'montant' => 'required|numeric|min:0',
                'beneficiaire_nom' => 'required|string|max:255',
                'beneficiaire_rib' => 'required|string|max:255',
                'beneficiaire_banque' => 'required|string|max:255',
                'beneficiaire_agence' => 'required|string|max:255',
                'objet' => 'required|string|max:500'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Opération mise à jour avec succès',
                'data' => array_merge(['id_op' => $id], $validatedData)
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour: ' . $e->getMessage()
            ], 500);
        }
    }

            public function downloadPdf($id)
        {
            $ordre = OrderV::findOrFail($id);

            $pdf = Pdf::loadView('tresorier.ov_pdf', compact('ordre'));

            return $pdf->download("ordre-virement-{$ordre->id}.pdf");
        }

}
