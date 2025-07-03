<?php

namespace App\Http\Controllers;

use App\Models\Demande;
use App\Models\DemandeUser;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Models\ChampPersonnalise;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\BudgetTable;
use App\Models\BudgetEntry;
use App\Models\Notification;
class DemandeController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $demands = Demande::with('users')->latest()->get();
        return view('admin.demandes.show-demande', compact('demands'));
    }


    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        $users = User::all();
        return view('admin.demandes.add-demande', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */

     public function store(Request $request)
     {
         $request->validate([
             'titre' => 'required|string|max:255',
             'fields' => 'nullable|array',
             'fields.*.key' => 'required|string|max:255',
         ]);
         $champs = [];
         foreach ($request->input('fields', []) as $field) {
             $champs[$field['key']] = null;
         }
     
         $demande = Demande::create([
             'titre' => $request->input('titre'),
             'champs' => $champs,
         ]);
     
         Notification::create([
             'user_id' => null,
             'demande_id' => $demande->id,
             'titre' => $demande->titre ?? 'Nouvelle demande',
             'is_read' => false,
             'read_at' => null,
         ]);
     
         if (session()->has('selected_imputation')) {
             $imputation = session('selected_imputation');
             $entry = BudgetEntry::where('imputation_comptable', $imputation['imputation'])->first();
     
             if ($entry) {
                 $demande->budgetEntries()->attach($entry->id);
             } else {
                 logger("BudgetEntry not found for imputation: " . $imputation['imputation']);
             }
         }
     
         return redirect()->back()->with('success', 'Demande créée avec succès');
     }
     

     public function show($id)
     {
         $user = Auth::user();
         $demande = Demande::findOrFail($id);
        //  $champs = $demande->champs ?? [];
         $champs = collect($demande->champs ?? [])
        ->filter(function ($champData) use ($user) {
            return is_array($champData)
                && isset($champData['user_id'])
                && $champData['user_id'] == $user->id;
        });
         $fichiers = DB::table('demande_files')
             ->where('demande_id', $id)
             ->where('user_id', $user->id)
             ->orderBy('created_at', 'desc')
             ->get();
         return view('user.voirDemande', compact('user', 'demande', 'champs', 'fichiers'));
    }

    public function edit(Demande $demande)
    {
        //
    }


    public function update(Request $request, Demande $demande)
    {
        //
    }

    public function destroy(Demande $demande)
    {
        //
    }

    public function affecterPage($id = null)
    {
        $demandes = Demande::latest()->get();
        $selectedDemande = $id ? Demande::findOrFail($id) : null;
        $users = User::role('user')->get();
    
        return view('admin.demandes.affecter-demande', compact('demandes', 'users', 'selectedDemande'));
    }
    


public function demandePage($id = null)
{
    $demandes = Demande::with('users')->latest()->get();

    if ($demandes->isEmpty()) {
        abort(404, 'Aucune demande en base');
    }

    $selectedDemande = $id
        ? Demande::with('users')->find($id)
        : $demandes->first();

    if (!$selectedDemande) {
        return redirect()->route('demande', $demandes->first()->id);
    }

    return view('admin.demandes.show-demande', [
        'demandes' => $demandes,
        'selectedDemande' => $selectedDemande,
    ]);
}


public function affecterChamps(Request $request, $demandeId)
{
    $request->validate([
        'user_id' => 'required|exists:users,id',
        'champs_selected' => 'required|array|min:1',
        'champs_selected.*' => 'string'
    ]);

    $userId = $request->input('user_id');
    $selectedChampKeys = $request->input('champs_selected', []);
    $demande = Demande::findOrFail($demandeId);

    $existing = DB::table('demande_user')
        ->where('demande_id', $demandeId)
        ->where('user_id', $userId)
        ->first();

    if ($existing) {
        return redirect()->back()->with('error', 'Cet utilisateur est déjà affecté à cette demande.');
    }

    $lastSort = DB::table('demande_user')
        ->where('demande_id', $demandeId)
        ->max('sort');
    $nextSort = $lastSort ? $lastSort + 1 : 1;

    $demande->users()->attach($userId, [
        'sort' => $nextSort,
        'isyourturn' => ($nextSort === 1),
        'etape'=>'en_cours_remplissage',
        'is_filled' => false,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $champs = $demande->champs ?? [];

    foreach ($selectedChampKeys as $key) {
        if (!array_key_exists($key, $champs)) {
            return redirect()->back()->with('error', "Le champ « $key » n'existe pas dans cette demande.");
        }

        $champs[$key] = [
            'value' => $champs[$key]['value'] ?? null,
            'user_id' => $userId,
        ];
    }

    $demande->champs = $champs;
    $demande->updated_at = now();
    $demande->save();

    if ($nextSort === 1) {
        Notification::create([
            'user_id' => $userId,
            'demande_id' => $demandeId,
            'titre' => 'Nouvelle demande à remplir',
            'is_read' => false,
        ]);
    }

    $nombreChamps = count($selectedChampKeys);
    $userName = DB::table('users')->find($userId)->name;
    $message = $nombreChamps === 1
        ? "1 champ affecté à {$userName}"
        : "{$nombreChamps} champs affectés à {$userName}";

    return redirect()->route('demandes.affecter', $demandeId)->with('success', $message);
}

// public function updateUserDemandeStatus($demandeId, $userId)
// {
//     $demande = Demande::findOrFail($demandeId);
//     $user = User::findOrFail($userId);

//     $demande->users()->updateExistingPivot($userId, [
//         'is_filled' => true,   
//         'isyourturn' => 0,    
//     ]);

//     $nextUser = DB::table('demande_user')
//         ->where('demande_id', $demandeId)
//         ->where('sort', '>', DB::table('demande_user')->where('user_id', $userId)->value('sort'))
//         ->orderBy('sort')
//         ->first();

//     if ($nextUser) {
//         DB::table('demande_user')
//             ->where('demande_id', $demandeId)
//             ->where('user_id', $nextUser->user_id)
//             ->update(['isyourturn' => 1]);

//         Notification::create([
//             'user_id' => $nextUser->user_id,  
//             'demande_id' => $demandeId,
//             'titre' => 'Nouvelle demande à remplir',
//             'is_read' => false, 
//         ]);
//     }

//     $notification = Notification::where('demande_id', $demandeId)
//         ->where('user_id', $userId) 
//         ->first();

//     if ($notification) {
//         $notification->update([
//             'is_read' => true,
//             'read_at' => now(), 
//         ]);
//     }

//     return response()->json(['success' => true]);
// }

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

    return view('user.remplirDemande', [
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

    return redirect()->route('user.demandes')->with('success', 'Formulaire soumis avec succès.');
}


public function selectBudgetTable()
{
    $tables = BudgetTable::with('entries')->get();
    return view('admin.demandes.select-budget-table', compact('tables'));
}
public function addImputationToForm(Request $request)
{
    $request->validate([
        'imputation' => 'required|string',
        'intitule' => 'nullable|string',
    ]);

    session()->put('selected_imputation', [
    'imputation' => $request->imputation,
    'intitule' => $request->intitule,
    ]);


    return redirect()->route('demande.add-demande');
}
public function chooseBudgetTableForEntry()
{
    $tables = BudgetTable::all();
    return view('admin.demandes.choose-table-for-entry', compact('tables'));
}

public function showAddEntryForm($tableId)
{
    $budgetTable = BudgetTable::findOrFail($tableId);

    return view('admin.demandes.add-entry-to-table', [
        'budgetTable' => $budgetTable,
    ]);
}

public function saveEntryAndReturn(Request $request)
{
    $request->validate([
        'budget_table_id' => 'required|exists:budget_tables,id',
        'imputation_comptable' => 'required|string',
        'intitule' => 'required|string',
        'prevision' => 'nullable|numeric',
        'atterrissage' => 'nullable|numeric',
    ]);

    $budgetTable = BudgetTable::findOrFail($request->budget_table_id);

    $lastPosition = BudgetEntry::where('budget_table_id', $budgetTable->id)->max('position') ?? 0;

    $newEntry = BudgetEntry::create([
        'budget_table_id' => $budgetTable->id,
        'imputation_comptable' => $request->imputation_comptable,
        'intitule' => $request->intitule,
        'budget_previsionnel' => $request->prevision,
        'atterrissage' => $request->atterrissage,
        'position' => $lastPosition + 1,
    ]);

    session()->flash('selected_imputation', [
        'imputation' => $newEntry->imputation_comptable,
        'intitule' => $newEntry->intitule,
    ]);

    return redirect()->route('demande.add-demande')->with('success', 'Ligne ajoutée et sélectionnée.');
}

public function showDecision()
{
    $demandes = DemandeUser::with(['demande', 'user'])
        ->where('is_filled', true)
        ->where('isyourturn', true)
        ->where('etape', 'en_attente_validation')
        ->orderByDesc('updated_at')
        ->get();

    return view('admin.demandes.boite-decision', compact('demandes'));
}

public function showChamps(Request $request)
{
    $query = DemandeUser::with(['demande', 'user'])
        ->where('is_filled', true);

    if ($request->filled('search_user')) {
        $query->whereHas('user', function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->search_user . '%');
        });
    }

    if ($request->filled('filter_etape')) {
        $query->where('etape', $request->filter_etape);
    }

    if ($request->filled('date_soumission')) {
        $query->whereDate('updated_at', $request->date_soumission);
    }

    $demandes = $query->orderByDesc('updated_at')->paginate(10);
    $totalDemandes = DemandeUser::where('is_filled', true)->count();

    return view('admin.demandes.showChamps', compact('demandes', 'totalDemandes'));
}


public function afficher($demande_id, $user_id)
{
    $demandeUser = DemandeUser::with(['demande', 'user'])
        ->where('demande_id', $demande_id)
        ->where('user_id', $user_id)
        ->firstOrFail();   
    $userChamps = collect($demandeUser->demande->champs ?? [])
        ->filter(fn($champ) => isset($champ['user_id']) && $champ['user_id'] == $user_id);

    return view('admin.demandes.afficher-demande', [
        'demandeUser' => $demandeUser,
        'userChamps' => $userChamps,
    ]);
}

public function accepter($demande_id, $user_id)
{
    $demande_user = DemandeUser::where('demande_id', $demande_id)
        ->where('user_id', $user_id)
        ->first();

    if ($demande_user) {
        $demande_user->update([
            'etape' => 'acceptee',
            'IsYourTurn' => false,
        ]);

        $currentSort = $demande_user->sort;

        $nextUser = DemandeUser::where('demande_id', $demande_id)
            ->where('sort', '>', $currentSort)
            ->orderBy('sort')
            ->first();

        if ($nextUser) {
            $nextUser->update(['IsYourTurn' => true]);

            Notification::create([
                'user_id' => $nextUser->user_id,
                'demande_id' => $demande_id,
                'titre' => 'Nouvelle demande à remplir',
                'is_read' => false,
            ]);
        }
        return redirect()->route('admin.demandes.decision')->with('success', 'Demande acceptée avec succès.');
    }

    return redirect()->back()->with('error', 'Affectation introuvable.');
}

public function refuser(Request $request, $demande_id, $user_id)
{
    $request->validate([
        'motif_refus' => 'required|string|max:1000',
    ]);

    $commentaire = $request->input('motif_refus');

    $demande_user = DemandeUser::where('demande_id', $demande_id)
        ->where('user_id', $user_id)
        ->first();

    if (!$demande_user) {
        return redirect()->back()->with('error', 'Affectation introuvable.');
    }
    $demande_user->update(['etape' => 'modifications_requises']);

    $demande_titre = $demande_user->demande->titre ?? 'demande';

    Notification::create([
        'user_id' => $user_id,
        'original_user_id' => $user_id,
        'demande_id' => $demande_id,
        'titre' => "Votre demande {$demande_titre} a été refusée",
        'commentaire' => $commentaire,
        'is_read' => false,
    ]);

    return redirect()->route('admin.demandes.decision')
        ->with('success', 'Demande refusée avec un message envoyé à l\'utilisateur.');
}

}