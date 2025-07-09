<?php

namespace App\Http\Controllers;

use App\Models\OrderP;
use Illuminate\Http\Request;
use App\Models\Demande;
use App\Models\DemandeUser;
use App\Models\Facture;
use App\Models\FactureItem;
use App\Models\Contrat;

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
        return view('tresorier.demandes');
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
    public function OV()
    {
        return view('tresorier.ov');
    }

public function createOP()
{

    $factureIdsUtilisees = OrderP::pluck('id_facture')->toArray();

    $factures = Facture::whereNotIn('id', $factureIdsUtilisees)->get();

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


public function store(Request $request)
{
    $validated = $request->validate([
        'invoice_id' => 'required|integer|exists:factures,id',
        'description' => 'required|string|max:255',
        'amount' => 'required|numeric|min:0.01',
        'payment_method' => 'required|string',
        'due_date' => 'required|date',
        'notes' => 'nullable|string',
    ]);

$facture = Facture::with('contrat.demandeur')->find($validated['invoice_id']);

\DB::table('order_p')->insert([
    'id_facture' => $validated['invoice_id'],
    'reference' => $facture->numero_facture ?? null,
    'entite_ordonnatrice' => optional($facture->contrat->demandeur)->nom,
    'description_operation' => $validated['description'],
    'montant_chiffres' => $validated['amount'],
    'mode_paiement' => $validated['payment_method'],
    'date_paiment' => $validated['due_date'],
    'observations' => $validated['notes'] ?? null,
    'created_at' => now(),
    'updated_at' => now(),
]);


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
    ]);

    $order = OrderP::findOrFail($id);
    $order->update([
        'description_operation' => $validated['description'],
        'montant_chiffres' => $validated['amount'],
        'mode_paiement' => $validated['payment_method'],
        'date_paiment' => $validated['due_date'],
        'observations' => $validated['notes'],
        'updated_at' => now(),
    ]);

    return redirect()->route('tresorier.op')->with('success', 'Ordre de paiement mis à jour avec succès.');
}

}
