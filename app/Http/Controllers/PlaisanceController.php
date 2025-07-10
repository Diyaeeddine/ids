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
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

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
        'type'=>'verifier_demande',
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
public function showDocuments($id)
    {
        $demande = Demande::findOrFail($id);

        $documents = DB::table('demande_files')
            ->where('demande_id', $id)
            ->get();

        $fichiersEnvoyes = DB::table('demande_files')
            ->where('demande_id', $id)
            ->get();

        $demandeUser = DemandeUser::where('demande_id', $id)
                                  ->where('etape', 'acceptee')
                                  ->first();

        return view('plaisance.showDocuments', compact('demande', 'documents', 'demandeUser', 'fichiersEnvoyes'));
    }
public function imprimerContrat($demandeId)
{
    $demande = Demande::findOrFail($demandeId);

    $user = Auth::user();
    $demandeUser = DemandeUser::where('demande_id', $demandeId)
                              ->where('user_id', $user->id)
                              ->first();

    if (!$demandeUser) {
        abort(403, 'Accès non autorisé à cette demande');
    }

    $champsContrat = $this->getChampsByType($demande, 'contrat');

    $contratChamps = $this->formatChampsForContrat($champsContrat);

    $metadata = [
        'date_generation' => now()->format('d/m/Y H:i'),
        'generated_by' => $user->name ?? 'Système',
        'version' => '1.0',
        'type_document' => 'Contrat',
        'numero_contrat' => $this->generateContratNumber($demande)
    ];

    $pdf = Pdf::loadView('plaisance.documents.contrat', compact('demande', 'contratChamps', 'metadata'))
              ->setPaper('A4', 'portrait')
              ->setOptions([
                  'isHtml5ParserEnabled' => true,
                  'isPhpEnabled' => true,
                  'defaultFont' => 'DejaVu Sans'
              ]);

    return $pdf->stream("contrat-{$demande->id}.pdf");
}
public function telechargerContrat($demandeId)
{
    $demande = Demande::findOrFail($demandeId);

    $user = Auth::user();
    $demandeUser = DemandeUser::where('demande_id', $demandeId)
                              ->where('user_id', $user->id)
                              ->first();

    if (!$demandeUser) {
        abort(403, 'Accès non autorisé à cette demande');
    }

    $champsContrat = $this->getChampsByType($demande, 'contrat');

    $contratChamps = $this->formatChampsForContrat($champsContrat);

    $metadata = [
        'date_generation' => now()->format('d/m/Y H:i'),
        'generated_by' => $user->name ?? 'Système',
        'version' => '1.0',
        'type_document' => 'Contrat',
        'numero_contrat' => $this->generateContratNumber($demande)
    ];

    $pdf = Pdf::loadView('plaisance.documents.contrat', compact('demande', 'contratChamps', 'metadata'))
              ->setPaper('A4', 'portrait')
              ->setOptions([
                  'isHtml5ParserEnabled' => true,
                  'isPhpEnabled' => true,
                  'defaultFont' => 'DejaVu Sans'
              ]);

    return $pdf->download("contrat-{$demande->id}.pdf");
}
public function showContrat($demandeId)
{
    $demande = Demande::findOrFail($demandeId);

    if (is_string($demande->champs)) {
        $champs = json_decode($demande->champs, true) ?? [];
    } else {
        $champs = $demande->champs ?? [];
    }

    $champsContrat = collect($champs)->filter(function ($champ) {
        return isset($champ['type_form']) && $champ['type_form'] === 'contrat';
    });

    $contratChamps = $this->formatChampsForContrat($champsContrat->toArray());

    $metadata = [
        'date_generation' => now()->format('d/m/Y H:i'),
        'generated_by' => Auth::user()->name ?? 'Système',
        'version' => '1.0',
        'type_document' => 'Contrat',
        'numero_contrat' => $this->generateContratNumber($demande)
    ];

    return view('plaisance.documents.contrat', compact('demande', 'contratChamps', 'metadata'));
}
private function getChampsByType($demande, $typeForm)
{
    if (is_string($demande->champs)) {
        $champs = json_decode($demande->champs, true) ?? [];
    } else {
        $champs = $demande->champs ?? [];
    }

    return array_filter($champs, function($champ) use ($typeForm) {
        return isset($champ['type_form']) && $champ['type_form'] === $typeForm;
    });
}
private function formatChampsForContrat($champs)
{
    $formatted = [];

    foreach ($champs as $key => $champ) {
        if (isset($champ['value']) && !empty($champ['value'])) {
            $formatted[$key] = [
                'label' => $champ['label'] ?? $this->formatFieldName($key),
                'value' => $champ['value'],
                'type' => $champ['type'] ?? 'text'
            ];
        }
    }

    return $formatted;
}
private function generateContratNumber($demande)
{
    $year = now()->format('Y');
    $month = now()->format('m');

    return "CONT-{$year}-{$month}-{$demande->id}";
}
private function formatFieldName($fieldName)
{
    return ucfirst(str_replace('_', ' ', $fieldName));
}
public function imprimerFacture($demandeId)
{
    $demande = Demande::findOrFail($demandeId);

    $user = Auth::user();
    $demandeUser = DemandeUser::where('demande_id', $demandeId)
                              ->where('user_id', $user->id)
                              ->first();

    if (!$demandeUser) {
        abort(403, 'Accès non autorisé à cette demande');
    }

    $champsFacture = $this->getChampsByType($demande, 'facture');

    $factureChamps = $this->formatChampsForfacture($champsFacture);

    $metadata = [
        'date_generation' => now()->format('d/m/Y H:i'),
        'generated_by' => $user->name ?? 'Système',
        'version' => '1.0',
        'type_document' => 'Facture',
        'numero_facture' => $this->generatefactureNumber($demande)
    ];

    $pdf = Pdf::loadView('plaisance.documents.facture', compact('demande', 'factureChamps', 'metadata'))
              ->setPaper('A4', 'portrait')
              ->setOptions([
                  'isHtml5ParserEnabled' => true,
                  'isPhpEnabled' => true,
                  'defaultFont' => 'DejaVu Sans'
              ]);

    return $pdf->stream("facture-{$demande->id}.pdf");
}
public function telechargerFacture($demandeId)
{
    $demande = Demande::findOrFail($demandeId);

    $user = Auth::user();
    $demandeUser = DemandeUser::where('demande_id', $demandeId)
                              ->where('user_id', $user->id)
                              ->first();

    if (!$demandeUser) {
        abort(403, 'Accès non autorisé à cette demande');
    }

    $champsFacture = $this->getChampsByType($demande, 'facture');

    $factureChamps = $this->formatChampsForfacture($champsFacture);

    $metadata = [
        'date_generation' => now()->format('d/m/Y H:i'),
        'generated_by' => $user->name ?? 'Système',
        'version' => '1.0',
        'type_document' => 'Facture',
        'numero_facture' => $this->generatefactureNumber($demande)
    ];

    $pdf = Pdf::loadView('plaisance.documents.facture', compact('demande', 'factureChamps', 'metadata'))
              ->setPaper('A4', 'portrait')
              ->setOptions([
                  'isHtml5ParserEnabled' => true,
                  'isPhpEnabled' => true,
                  'defaultFont' => 'DejaVu Sans'
              ]);

    return $pdf->download("facture-{$demande->id}.pdf");
}
private function formatChampsForfacture($champs)
{
    $formatted = [];

    foreach ($champs as $key => $champ) {
        if (isset($champ['value']) && !empty($champ['value'])) {
            $formatted[$key] = [
                'label' => $champ['label'] ?? $this->formatFieldName($key),
                'value' => $champ['value'],
                'type' => $champ['type'] ?? 'text'
            ];
        }
    }
    return $formatted;
}
private function generatefactureNumber($demande)
{
    $year = now()->format('Y');
    $month = now()->format('m');

    return "FACT-{$year}-{$month}-{$demande->id}";
}
public function showFacture($demandeId)
{
    $demande = Demande::findOrFail($demandeId);

    $champs = json_decode($demande->champs, true);

    $champsFacture = collect($champs)->filter(function ($champ) {
        return isset($champ['type_form']) && $champ['type_form'] === 'facture';
    });

    $factureChamps = $this->formatChampsForfacture($champsFacture->toArray());

    $metadata = [
        'date_generation' => now()->format('d/m/Y H:i'),
        'generated_by' => Auth::user()->name ?? 'Système',
        'version' => '1.0',
        'type_document' => 'Facture',
        'numero_facture' => $this->generatefactureNumber($demande)
    ];

    return view('plaisance.documents.facture', compact('demande', 'factureChamps', 'metadata'));
}
public function imprimerRecuPaiement($demandeId)
{
    $demande = Demande::findOrFail($demandeId);

    $user = Auth::user();
    $demandeUser = DemandeUser::where('demande_id', $demandeId)
                              ->where('user_id', $user->id)
                              ->first();

    if (!$demandeUser) {
        abort(403, 'Accès non autorisé à cette demande');
    }

    $champsRecuPaiement = $this->getChampsByType($demande, 'recu_p');

    $recuPaiementChamps = $this->formatChampsForRecuPaiement($champsRecuPaiement);

    $metadata = [
        'date_generation' => now()->format('d/m/Y H:i'),
        'generated_by' => $user->name ?? 'Système',
        'version' => '1.0',
        'type_document' => 'Reçu de Paiement',
        'numero_recu' => $this->generateRecuPaiementNumber($demande)
    ];

    $pdf = Pdf::loadView('plaisance.documents.recudepaiement', compact('demande', 'recuPaiementChamps', 'metadata'))
              ->setPaper('A4', 'portrait')
              ->setOptions([
                  'isHtml5ParserEnabled' => true,
                  'isPhpEnabled' => true,
                  'defaultFont' => 'DejaVu Sans'
              ]);

    return $pdf->stream("recu-paiement-{$demande->id}.pdf");
}
public function telechargerRecuPaiement($demandeId)
{
    $demande = Demande::findOrFail($demandeId);

    $user = Auth::user();
    $demandeUser = DemandeUser::where('demande_id', $demandeId)
                              ->where('user_id', $user->id)
                              ->first();

    if (!$demandeUser) {
        abort(403, 'Accès non autorisé à cette demande');
    }

    $champsRecuPaiement = $this->getChampsByType($demande, 'recu_p');

    $recuPaiementChamps = $this->formatChampsForRecuPaiement($champsRecuPaiement);

    $metadata = [
        'date_generation' => now()->format('d/m/Y H:i'),
        'generated_by' => $user->name ?? 'Système',
        'version' => '1.0',
        'type_document' => 'Reçu de Paiement',
        'numero_recu' => $this->generateRecuPaiementNumber($demande)
    ];

    $pdf = Pdf::loadView('plaisance.documents.recudepaiement', compact('demande', 'recuPaiementChamps', 'metadata'))
              ->setPaper('A4', 'portrait')
              ->setOptions([
                  'isHtml5ParserEnabled' => true,
                  'isPhpEnabled' => true,
                  'defaultFont' => 'DejaVu Sans'
              ]);

    return $pdf->download("recu-paiement-{$demande->id}.pdf");
}
public function showRecuPaiement($demandeId)
{
    $demande = Demande::findOrFail($demandeId);

    $champs = json_decode($demande->champs, true);

    $champsRecuPaiement = collect($champs)->filter(function ($champ) {
        return isset($champ['type_form']) && $champ['type_form'] === 'recu_p';
    });

    $recuPaiementChamps = $this->formatChampsForRecuPaiement($champsRecuPaiement->toArray());

    $metadata = [
        'date_generation' => now()->format('d/m/Y H:i'),
        'generated_by' => Auth::user()->name ?? 'Système',
        'version' => '1.0',
        'type_document' => 'Reçu de Paiement',
        'numero_recu' => $this->generateRecuPaiementNumber($demande)
    ];

    return view('plaisance.documents.recudepaiement', compact('demande', 'recuPaiementChamps', 'metadata'));
}
private function formatChampsForRecuPaiement($champs)
{
    $formatted = [];

    foreach ($champs as $key => $champ) {
        if (isset($champ['value']) && !empty($champ['value'])) {
            $formatted[$key] = [
                'label' => $champ['label'] ?? $this->formatFieldName($key),
                'value' => $champ['value'],
                'type' => $champ['type'] ?? 'text'
            ];
        }
    }

    return $formatted;
}
private function generateRecuPaiementNumber($demande)
{
    $year = now()->format('Y');
    $month = now()->format('m');

    return "RECU-{$year}-{$month}-{$demande->id}";
}
public function imprimerBonCommande($demandeId)
{
    $demande = Demande::findOrFail($demandeId);

    $user = Auth::user();
    $demandeUser = DemandeUser::where('demande_id', $demandeId)
                              ->where('user_id', $user->id)
                              ->first();

    if (!$demandeUser) {
        abort(403, 'Accès non autorisé à cette demande');
    }

    $champsBonCommande = $this->getChampsByType($demande, 'bon_commande');

    $bonCommandeChamps = $this->formatChampsForBonCommande($champsBonCommande);

    $metadata = [
        'date_generation' => now()->format('d/m/Y H:i'),
        'generated_by' => $user->name ?? 'Système',
        'version' => '1.0',
        'type_document' => 'Bon de Commande',
        'numero_bon' => $this->generateBonCommandeNumber($demande)
    ];

    $pdf = Pdf::loadView('plaisance.documents.boncommande', compact('demande', 'bonCommandeChamps', 'metadata'))
              ->setPaper('A4', 'portrait')
              ->setOptions([
                  'isHtml5ParserEnabled' => true,
                  'isPhpEnabled' => true,
                  'defaultFont' => 'DejaVu Sans'
              ]);

    return $pdf->stream("bon-commande-{$demande->id}.pdf");
}
public function telechargerBonCommande($demandeId)
{
    $demande = Demande::findOrFail($demandeId);

    $user = Auth::user();
    $demandeUser = DemandeUser::where('demande_id', $demandeId)
                              ->where('user_id', $user->id)
                              ->first();

    if (!$demandeUser) {
        abort(403, 'Accès non autorisé à cette demande');
    }

    $champsBonCommande = $this->getChampsByType($demande, 'bon_commande');

    $bonCommandeChamps = $this->formatChampsForBonCommande($champsBonCommande);

    $metadata = [
        'date_generation' => now()->format('d/m/Y H:i'),
        'generated_by' => $user->name ?? 'Système',
        'version' => '1.0',
        'type_document' => 'Bon de Commande',
        'numero_bon' => $this->generateBonCommandeNumber($demande)
    ];

    $pdf = Pdf::loadView('plaisance.documents.boncommande', compact('demande', 'bonCommandeChamps', 'metadata'))
              ->setPaper('A4', 'portrait')
              ->setOptions([
                  'isHtml5ParserEnabled' => true,
                  'isPhpEnabled' => true,
                  'defaultFont' => 'DejaVu Sans'
              ]);

    return $pdf->download("bon-commande-{$demande->id}.pdf");
}
public function showBonCommande($demandeId)
{
    $demande = Demande::findOrFail($demandeId);

    $champs = json_decode($demande->champs, true);

    $champsBonCommande = collect($champs)->filter(function ($champ) {
        return isset($champ['type_form']) && $champ['type_form'] === 'bon_commande';
    });

    $bonCommandeChamps = $this->formatChampsForBonCommande($champsBonCommande->toArray());

    $metadata = [
        'date_generation' => now()->format('d/m/Y H:i'),
        'generated_by' => Auth::user()->name ?? 'Système',
        'version' => '1.0',
        'type_document' => 'Bon de Commande',
        'numero_bon' => $this->generateBonCommandeNumber($demande)
    ];

    return view('plaisance.documents.boncommande', compact('demande', 'bonCommandeChamps', 'metadata'));
}
private function formatChampsForBonCommande($champs)
{
    $formatted = [];

    foreach ($champs as $key => $champ) {
        if (isset($champ['value']) && !empty($champ['value'])) {
            $formatted[$key] = [
                'label' => $champ['label'] ?? $this->formatFieldName($key),
                'value' => $champ['value'],
                'type' => $champ['type'] ?? 'text'
            ];
        }
    }

    return $formatted;
}
private function generateBonCommandeNumber($demande)
{
    $year = now()->format('Y');
    $month = now()->format('m');

    return "BC-{$year}-{$month}-{$demande->id}";
}
public function imprimerMarche($demandeId)
{
    $demande = Demande::findOrFail($demandeId);

    $user = Auth::user();
    $demandeUser = DemandeUser::where('demande_id', $demandeId)
                              ->where('user_id', $user->id)
                              ->first();

    if (!$demandeUser) {
        abort(403, 'Accès non autorisé à cette demande');
    }

    $champsMarche = $this->getChampsByType($demande, 'marche');

    $marcheChamps = $this->formatChampsForMarche($champsMarche);

    $metadata = [
        'date_generation' => now()->format('d/m/Y H:i'),
        'generated_by' => $user->name ?? 'Système',
        'version' => '1.0',
        'type_document' => 'Marché Public',
        'numero_marche' => $this->generateMarcheNumber($demande)
    ];

    $pdf = Pdf::loadView('plaisance.documents.marche', compact('demande', 'marcheChamps', 'metadata'))
              ->setPaper('A4', 'portrait')
              ->setOptions([
                  'isHtml5ParserEnabled' => true,
                  'isPhpEnabled' => true,
                  'defaultFont' => 'DejaVu Sans'
              ]);

    return $pdf->stream("marche-{$demande->id}.pdf");
}
public function telechargerMarche($demandeId)
{
    $demande = Demande::findOrFail($demandeId);

    $user = Auth::user();
    $demandeUser = DemandeUser::where('demande_id', $demandeId)
                              ->where('user_id', $user->id)
                              ->first();

    if (!$demandeUser) {
        abort(403, 'Accès non autorisé à cette demande');
    }

    $champsMarche = $this->getChampsByType($demande, 'marche');

    $marcheChamps = $this->formatChampsForMarche($champsMarche);

    $metadata = [
        'date_generation' => now()->format('d/m/Y H:i'),
        'generated_by' => $user->name ?? 'Système',
        'version' => '1.0',
        'type_document' => 'Marché Public',
        'numero_marche' => $this->generateMarcheNumber($demande)
    ];

    $pdf = Pdf::loadView('plaisance.documents.marche', compact('demande', 'marcheChamps', 'metadata'))
              ->setPaper('A4', 'portrait')
              ->setOptions([
                  'isHtml5ParserEnabled' => true,
                  'isPhpEnabled' => true,
                  'defaultFont' => 'DejaVu Sans'
              ]);

    return $pdf->download("marche-{$demande->id}.pdf");
}
public function showMarche($demandeId)
{
    $demande = Demande::findOrFail($demandeId);

    $champs = json_decode($demande->champs, true);

    $champsMarche = collect($champs)->filter(function ($champ) {
        return isset($champ['type_form']) && $champ['type_form'] === 'marche';
    });

    $marcheChamps = $this->formatChampsForMarche($champsMarche->toArray());

    $metadata = [
        'date_generation' => now()->format('d/m/Y H:i'),
        'generated_by' => Auth::user()->name ?? 'Système',
        'version' => '1.0',
        'type_document' => 'Marché Public',
        'numero_marche' => $this->generateMarcheNumber($demande)
    ];

    return view('plaisance.documents.marche', compact('demande', 'marcheChamps', 'metadata'));
}
private function formatChampsForMarche($champs)
{
    $formatted = [];

    foreach ($champs as $key => $champ) {
        if (isset($champ['value']) && !empty($champ['value'])) {
            $formatted[$key] = [
                'label' => $champ['label'] ?? $this->formatFieldName($key),
                'value' => $champ['value'],
                'type' => $champ['type'] ?? 'text'
            ];
        }
    }
    return $formatted;
}
private function generateMarcheNumber($demande)
{
    $year = now()->format('Y');
    $month = now()->format('m');

    return "M-{$year}-{$month}-{$demande->id}";
}
public function imprimerPrestation($demandeId)
{
    $demande = Demande::findOrFail($demandeId);
    $user = Auth::user();
    $demandeUser = DemandeUser::where('demande_id', $demandeId)
                              ->where('user_id', $user->id)
                              ->first();
    if (!$demandeUser) {
        abort(403, 'Accès non autorisé à cette demande');
    }
    $champsPrestation = $this->getChampsByType($demande, 'prestation');
    $prestationChamps = $this->formatChampsForPrestation($champsPrestation);
    $metadata = [
        'date_generation' => now()->format('d/m/Y H:i'),
        'generated_by' => $user->name ?? 'Système',
        'version' => '1.0',
        'type_document' => 'Prestation de Service',
        'numero_prestation' => $this->generatePrestationNumber($demande)
    ];
    $pdf = Pdf::loadView('plaisance.documents.prestation', compact('demande', 'prestationChamps', 'metadata'))
              ->setPaper('A4', 'portrait')
              ->setOptions([
                  'isHtml5ParserEnabled' => true,
                  'isPhpEnabled' => true,
                  'defaultFont' => 'DejaVu Sans'
              ]);
    return $pdf->stream("prestation-{$demande->id}.pdf");
}
public function telechargerPrestation($demandeId)
{
    $demande = Demande::findOrFail($demandeId);
    $user = Auth::user();
    $demandeUser = DemandeUser::where('demande_id', $demandeId)
                              ->where('user_id', $user->id)
                              ->first();

    if (!$demandeUser) {
        abort(403, 'Accès non autorisé à cette demande');
    }

    $champsPrestation = $this->getChampsByType($demande, 'prestation');
    $prestationChamps = $this->formatChampsForPrestation($champsPrestation);
    $metadata = [
        'date_generation' => now()->format('d/m/Y H:i'),
        'generated_by' => $user->name ?? 'Système',
        'version' => '1.0',
        'type_document' => 'Prestation de Service',
        'numero_prestation' => $this->generatePrestationNumber($demande)
    ];

    $pdf = Pdf::loadView('plaisance.documents.prestation', compact('demande', 'prestationChamps', 'metadata'))
              ->setPaper('A4', 'portrait')
              ->setOptions([
                  'isHtml5ParserEnabled' => true,
                  'isPhpEnabled' => true,
                  'defaultFont' => 'DejaVu Sans'
              ]);

    return $pdf->download("prestation-{$demande->id}.pdf");
}
public function showPrestation($demandeId)
{
    $demande = Demande::findOrFail($demandeId);

    $champs = json_decode($demande->champs, true);

    $champsPrestation = collect($champs)->filter(function ($champ) {
        return isset($champ['type_form']) && $champ['type_form'] === 'prestation';
    });

    $prestationChamps = $this->formatChampsForPrestation($champsPrestation->toArray());

    $metadata = [
        'date_generation' => now()->format('d/m/Y H:i'),
        'generated_by' => Auth::user()->name ?? 'Système',
        'version' => '1.0',
        'type_document' => 'Prestation de Service',
        'numero_prestation' => $this->generatePrestationNumber($demande)
    ];

    return view('plaisance.documents.prestation', compact('demande', 'prestationChamps', 'metadata'));
}
private function formatChampsForPrestation($champs)
{
    $formatted = [];

    foreach ($champs as $key => $champ) {
        if (isset($champ['value']) && !empty($champ['value'])) {
            $formatted[$key] = [
                'label' => $champ['label'] ?? $this->formatFieldName($key),
                'value' => $champ['value'],
                'type' => $champ['type'] ?? 'text'
            ];
        }
    }

    return $formatted;
}
private function generatePrestationNumber($demande)
{
    $year = now()->format('Y');
    $month = now()->format('m');

    return "P-{$year}-{$month}-{$demande->id}";
}
}
