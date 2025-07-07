<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contrat;
use App\Models\Facture;
use App\Models\FactureItem;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Auth;

use Barryvdh\Snappy\Facades\SnappyPdf as PDF;

class FactureController extends Controller
{
    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
{
    $user = $request->user();
    $factures = $user->factures()->with('contrat.navire')->latest()->get();

    return view('plaisance.factures.index', [
        'factures' => $factures,
        'title' => 'Mes Factures' 
    ]);
}

    /**
     * @param  \App\Models\Contrat  $contrat
     * @return \Illuminate\View\View
     */
    public function create(Contrat $contrat)
    {
        $contrat->load('demandeur', 'navire');
        $latestInvoice = Facture::whereYear('created_at', date('Y'))->whereMonth('created_at', date('m'))->latest('id')->first();
        $nextInvoiceNumber = $latestInvoice ? (int)substr($latestInvoice->numero_facture, -4) + 1 : 1;
        $invoiceNumber = 'FAC/' . date('Y/m') . '/' . str_pad($nextInvoiceNumber, 4, '0', STR_PAD_LEFT);
        return view('plaisance.factures.create', ['contrat' => $contrat, 'invoiceNumber' => $invoiceNumber]);
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contrat  $contrat
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Contrat $contrat)
    {
        $validated = $request->validate([
            'numero_facture' => 'required|string|unique:factures,numero_facture',
            'date_facture' => 'required|date', 'date_echeance' => 'required|date', 'items' => 'required|array|min:1',
            'items.*.description' => 'required|string|max:255', 'items.*.quantite' => 'required|numeric|min:0.01',
            'items.*.prix_unitaire' => 'required|numeric|min:0', 'total_ht' => 'required|numeric',
            'taxe_regionale' => 'required|numeric', 'total_tva' => 'required|numeric', 'total_ttc' => 'required|numeric',
        ]);

        $facture = DB::transaction(function() use ($validated, $contrat) {
            $facture = Facture::create([
                'contrat_id' => $contrat->id, 'numero_facture' => $validated['numero_facture'],
                'date_facture' => $validated['date_facture'], 'date_echeance' => $validated['date_echeance'],
                'total_ht' => $validated['total_ht'], 'taxe_regionale' => $validated['taxe_regionale'],
                'total_tva' => $validated['total_tva'], 'total_ttc' => $validated['total_ttc'],
            ]);
            foreach ($validated['items'] as $item) {
                FactureItem::create([
                    'facture_id' => $facture->id, 'description' => $item['description'], 'quantite' => $item['quantite'],
                    'prix_unitaire' => $item['prix_unitaire'], 'montant_ht' => $item['quantite'] * $item['prix_unitaire'],
                ]);
            }
            return $facture;
        });

        return redirect()->route('plaisance.factures.show', $facture)
                         ->with('status', 'Facture créée avec succès !');
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Facture  $facture
     * @return \Illuminate\View\View
     */
    public function show(Request $request, Facture $facture)
{
    if ($facture->contrat->user_id !== $request->user()->id) {
        abort(403, 'Unauthorized action.');
    }

    $facture->load('items', 'contrat.navire', 'contrat.demandeur');
    
    $url = route('factures.showPublic', $facture);
    $qrCode = QrCode::size(80)->generate($url);

    return view('user.factures.facture-detail', [
        'facture' => $facture,
        'qrCode' => $qrCode,
        'title' => 'Facture ' . $facture->numero_facture 
    ]);
}

    /**
    
     */
    public function showPublic(Facture $facture)
    {
        return $this->generateInvoiceView($facture);
    }


    



  
    /**
    
     * @param  \App\Models\Facture  $facture
     * @return \Illuminate\View\View
     */
    private function generateInvoiceView(Facture $facture)
    {
        $facture->load('items', 'contrat.navire', 'contrat.demandeur');
        
        $url = route('factures.show', $facture);
        $qrCode = QrCode::size(80)->generate($url);

        return view('user.factures.facture-detail', [
            'facture' => $facture,
            'qrCode' => $qrCode
        ]);
    }

    /**
     * NEW: Remove the specified invoice from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Facture  $facture
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, Facture $facture)
    {
        if ($facture->contrat->user_id !== $request->user()->id) {
            abort(403, 'Unauthorized action.');
        }

        $facture->delete();

        return redirect()->route('factures.index')
                         ->with('status', 'Facture ' . $facture->numero_facture . ' a été supprimée avec succès.');
    }

}