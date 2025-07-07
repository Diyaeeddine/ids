<?php

use App\Http\Controllers\BudgetTableController;
use App\Http\Controllers\ContratController;
use App\Http\Controllers\DemandeController;
use App\Http\Controllers\FactureController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PlaisanceController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TresorierController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect('/login');
})->name('admin.login');

Route::get('/register', function () {
    return view('auth/register');
});

// Route::get('/user/login', [UserController::class, 'create'])->name('user.login');
// Route::post('/user/login', [UserController::class, 'store'])->name('user.login.submit');

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/notifications/mark-as-read/{id}', [NotificationController::class, 'markAsRead'])
        ->name('notifications.read');
});

/*
|--------------------------------------------------------------------------
| User Dashboard Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified', 'role:user'])->group(function () {
    Route::get('user/dashboard', [UserController::class, 'userDashboard'])->name('user.dashboard');
    
    // User Demandes
    Route::get('/user/demandes', [UserController::class, 'userDemandes'])->name('user.demandes');
    Route::get('/user/alerts', [UserController::class, 'getAlerts'])->name('user.alerts');
    Route::get('user/demande/afficher/{id}', [DemandeController::class, 'show'])->name('user.demandes.voir');
    Route::get('user/demande/remplir/{id}', [DemandeController::class, 'showRemplir'])->name('user.demandes.showRemplir');
    Route::post('user/demande/remplir/{id}', [DemandeController::class, 'remplir'])->name('user.demandes.remplir');
    
    // File Downloads
    Route::get('/telecharger/{filename}', function ($filename) {
        $path = storage_path('app/public/demandes/' . $filename);
        
        if (!file_exists($path)) {
            abort(404);
        }
        
        return response()->download($path);
    })->name('telecharger.fichier');
    
    // User Contrats
    Route::get('user/contrats', [ContratController::class, 'index'])->name('user.contrats');
    Route::get('user/contrats/create', [ContratController::class, 'create'])->name('contrats.create');
    Route::post('user/contrats', [ContratController::class, 'store'])->name('contrat.store');
    Route::view('user/contrats/contrat-radonnee', 'user.contrats.randonnee')->name('user.contrats.contrat_radonnee');
    Route::view('user/contrats/contrat-accostage', 'user.contrats.accostage')->name('user.contrats.contrat_accostage');
    Route::get('/contrats/generer/{id}/{type}', [ContratController::class, 'genererPDF'])->name('contrats.genererPDF');
    
    // User Factures
    Route::get('/factures', [FactureController::class, 'index'])->name('factures.index');
    Route::get('/factures/view/{facture}', [FactureController::class, 'showPublic'])->name('factures.show');
    Route::get('/contrats/{contrat}/facture/create', [FactureController::class, 'create'])->name('factures.create');
    Route::post('/contrats/{contrat}/facture', [FactureController::class, 'store'])->name('factures.store');
    Route::delete('/factures/{facture}', [FactureController::class, 'destroy'])->name('factures.destroy');
});

Route::middleware(['auth', 'verified', 'role:plaisance'])->group(function () {

    Route::get('plaisance/dashboard', [PlaisanceController::class, 'plaisanceDashboard'])->name('plaisance.dashboard');
    Route::get('plaisance/demandes', [PlaisanceController::class, 'userDemandes'])->name('plaisance.demandes');

    Route::get('/plaisance/alerts', [PlaisanceController::class, 'getAlerts'])->name('plaisance.alerts');
    Route::get('plaisance/demande/afficher/{id}', [PlaisanceController::class, 'show'])->name('plaisance.demandes.voir');
    Route::get('plaisance/demande/remplir/{id}', [PlaisanceController::class, 'showRemplir'])->name('plaisance.demandes.showRemplir');
    Route::post('plaisance/demande/remplir/{id}', [PlaisanceController::class, 'remplir'])->name('plaisance.demandes.remplir');
    
    // File Downloads
    Route::get('/telecharger/{filename}', function ($filename) {
        $path = storage_path('app/public/demandes/' . $filename);
        
        if (!file_exists($path)) {
            abort(404);
        }
        
        return response()->download($path);
    })->name('telecharger.fichier');
    
    // User Contrats
    Route::get('plaisance/contrats', [ContratController::class, 'index'])->name('plaisance.contrats');
    Route::get('plaisance/contrats/create', [ContratController::class, 'create'])->name('contrats.create');
    Route::post('plaisance/contrats', [ContratController::class, 'store'])->name('contrat.store');
    Route::view('plaisance/contrats/contrat-radonnee', 'plaisance.contrats.randonnee')->name('plaisance.contrats.contrat_radonnee');
    Route::view('plaisance/contrats/contrat-accostage', 'plaisance.contrats.accostage')->name('plaisance.contrats.contrat_accostage');
    Route::get('/contrats/generer/{id}/{type}', [ContratController::class, 'genererPDF'])->name('contrats.genererPDF');
    
    // User Factures
    Route::get('plaisance/factures', [FactureController::class, 'index'])->name('plaisance.factures.index');
    Route::get('plaisance/factures/view/{facture}', [FactureController::class, 'showPublic'])->name('plaisance.factures.show');
    Route::get('plaisance/contrats/{contrat}/facture/create', [FactureController::class, 'create'])->name('plaisance.factures.create');
    Route::post('plaisance/contrats/{contrat}/facture', [FactureController::class, 'store'])->name('plaisance.factures.store');
    Route::delete('plaisance/factures/{facture}', [FactureController::class, 'destroy'])->name('plaisance.factures.destroy');


});
Route::middleware(['auth', 'verified', 'role:plaisance'])->group(function () {

    Route::get('plaisance/dashboard', [PlaisanceController::class, 'plaisanceDashboard'])->name('plaisance.dashboard');
    Route::get('plaisance/demandes', [PlaisanceController::class, 'userDemandes'])->name('plaisance.demandes');
    Route::get('/plaisance/alerts', [PlaisanceController::class, 'getAlerts'])->name('plaisance.alerts');
    Route::get('plaisance/demande/afficher/{id}', [DemandeController::class, 'show'])->name('plaisance.demandes.voir');
    Route::get('plaisance/demande/remplir/{id}', [DemandeController::class, 'showRemplir'])->name('plaisance.demandes.showRemplir');
    Route::post('plaisance/demande/remplir/{id}', [DemandeController::class, 'remplir'])->name('plaisance.demandes.remplir');
    
    // File Downloads
    Route::get('/telecharger/{filename}', function ($filename) {
        $path = storage_path('app/public/demandes/' . $filename);
        
        if (!file_exists($path)) {
            abort(404);
        }
        
        return response()->download($path);
    })->name('telecharger.fichier');
    
    // User Contrats
    Route::get('plaisance/contrats', [ContratController::class, 'index'])->name('plaisance.contrats');
    Route::get('plaisance/contrats/create', [ContratController::class, 'create'])->name('contrats.create');
    Route::post('plaisance/contrats', [ContratController::class, 'store'])->name('contrat.store');
    Route::view('plaisance/contrats/contrat-radonnee', 'plaisance.contrats.randonnee')->name('plaisance.contrats.contrat_radonnee');
    Route::view('plaisance/contrats/contrat-accostage', 'plaisance.contrats.accostage')->name('plaisance.contrats.contrat_accostage');
    Route::get('/contrats/generer/{id}/{type}', [ContratController::class, 'genererPDF'])->name('contrats.genererPDF');
    
    // User Factures
    Route::get('/factures', [FactureController::class, 'index'])->name('factures.index');
    Route::get('/factures/view/{facture}', [FactureController::class, 'showPublic'])->name('factures.show');
    Route::get('/contrats/{contrat}/facture/create', [FactureController::class, 'create'])->name('factures.create');
    Route::post('/contrats/{contrat}/facture', [FactureController::class, 'store'])->name('factures.store');
    Route::delete('/factures/{facture}', [FactureController::class, 'destroy'])->name('factures.destroy');



});

Route::middleware(['auth', 'verified', 'role:tresorier'])->group(function () {

    Route::get('tresorier/dashboard', [TresorierController::class, 'tresorierDashboard'])->name('tresorier.dashboard');
    Route::get('tresorier/demandes', [TresorierController::class, 'userDemandes'])->name('tresorier.demandes');
    Route::get('tresorier/OP', [TresorierController::class, 'OP'])->name('tresorier.op');
    Route::get('tresorier/create-OP', [TresorierController::class, 'createOP'])->name('tresorier.create-OP');
    Route::get('tresorier/create-OV', [TresorierController::class, 'createOV'])->name('tresorier.create-OV');
    Route::get('tresorier/OV', [TresorierController::class, 'OV'])->name('tresorier.ov');


});
/*
|--------------------------------------------------------------------------
| Admin Dashboard Routes
|--------------------------------------------------------------------------
*/

Route::view('admin/dashboard', 'admin.dashboard')
    ->middleware(['auth', 'verified', 'role:admin'])
    ->name('admin.dashboard');

Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    
    // Admin Contrats
    Route::get('/admin/contrats', [ContratController::class, 'indexAdmin'])->name('admin.contrats.index');
    Route::post('/admin/contrats/{id}/importer', [ContratController::class, 'importerContrat'])->name('admin.contrats.importer');
    Route::get('/admin/contrats/{id}/{type}/imprimer', [ContratController::class, 'genererPDF'])->name('admin.contrats.imprimer');
    Route::get('admin/contrats/signes/{contrat}', [ContratController::class, 'voirContratSigne'])->name('admin.contrats.signe.voir');
    Route::post('/admin/contrats/{id}/marquer-imprime', [ContratController::class, 'marquerImprime'])->name('admin.contrats.marquerImprime');
    
    // Admin Demandes
    Route::get('admin/demandes', [DemandeController::class, 'index'])->name('admin.demandes');
    Route::get('admin/demandes/add-demande', [DemandeController::class, 'create'])->name('demande.add-demande');
    Route::post('admin/demandes/add-demande', [DemandeController::class, 'store'])->name('demande.store-demande');
    Route::get('/admin/demandes/boite-decision', [DemandeController::class, 'showDecision'])->name('admin.demandes.decision');
    Route::get('/admin/demandes/afficher-champs', [DemandeController::class, 'showChamps'])->name('admin.demandes.showChamps');
    Route::post('/admin/demandes/{id}/{user}/accepter', [DemandeController::class, 'accepter'])->name('admin.demandes.accepter');
    Route::post('/admin/demandes/{id}/{user}/refuser', [DemandeController::class, 'refuser'])->name('admin.demandes.refuser');
    // Route::post('/admin/demandes/{id}/refuser', [DemandeController::class, 'refuser'])->name('admin.demandes.refuser');
    Route::get('/admin/demandes/afficher/{demande}/{user}', [DemandeController::class, 'afficher'])->name('demandes.afficher-demande');
    Route::get('/admin/demandes/affecter/{id?}', [DemandeController::class, 'affecterPage'])->name('demandes.affecter');
    Route::post('/admin/demandes/affecter/{id}', [DemandeController::class, 'affecterUsers'])->name('demandes.affecterUsers');
    Route::post('/admin/demandes/affecter/{id}', [DemandeController::class, 'affecterChamps'])->name('demande.affecterChamps');
    Route::get('/admin/demandes/{id?}', [DemandeController::class, 'demandePage'])->name('demande');
    
    // Demande Budget Operations
    Route::get('/demande/select-budget-table', [DemandeController::class, 'selectBudgetTable'])->name('demande.select-budget-table');
    Route::post('/demande/add-imputation', [DemandeController::class, 'addImputationToForm'])->name('demande.add-imputation-to-form');
    Route::get('/demande/choose-table-for-entry', [DemandeController::class, 'chooseBudgetTableForEntry'])->name('demande.choose-table-for-entry');
    Route::get('/demande/add-entry-to-table/{id}', [DemandeController::class, 'showAddEntryForm'])->name('demande.add-entry-to-table');
    Route::post('/demande/save-entry-and-return', [DemandeController::class, 'saveEntryAndReturn'])->name('demande.save-entry-and-return');
    Route::post('/admin/demandes/save-entry-and-return', [DemandeController::class, 'saveEntryAndReturn'])->name('demande.save-entry-and-return');
    Route::get('/admin/demandes/budget-table/{tableId}/add-entry', [DemandeController::class, 'showAddEntryForm'])->name('demande.add-entry-form');
    
    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // User Management
    Route::get('admin/profiles', [UserController::class, 'index'])->name('acce.index');
    Route::get('admin/profile/add-profile', [UserController::class, 'createProfile'])->name('profile.add-profile');
    Route::post('admin/profile/add-profile', [UserController::class, 'store'])->name('storeProfile');
    Route::get('admin/profiles/edit/{id}', [UserController::class, 'edit'])->name('acce.edit');
    Route::put('profiles/update/{id}', [UserController::class, 'update'])->name('acce.update');
    Route::delete('profiles/delete/{id}', [UserController::class, 'destroy'])->name('acce.delete');
    
    // PDF and File Management
    Route::get('demande/{id}/pdf', [PDFController::class, 'generatePDF'])->name('demande.pdf');
    Route::get('demandes/{demande}/users/{user}/uploads', [PDFController::class, 'downloadPdf'])->name('admin.uploads.download');
    Route::get('/admin/demandes/{demande}/user/{user}/uploads', [PDFController::class, 'showUserUploads'])->name('admin.demande.user.uploads');
    Route::get('demandes/{demande}/user/{user}/fichiers/{fichier}/download', [PDFController::class, 'download'])->name('admin.download.file');
    
    // Budget Tables Management
    Route::prefix('admin')->group(function () {
        Route::get('/budgetaires/create', [BudgetTableController::class, 'create'])->name('budget-tables.create');
        Route::post('/budgetaires', [BudgetTableController::class, 'store'])->name('budget-tables.store');
        Route::post('/admin/budget-tables', [BudgetTableController::class, 'store'])->name('budget-tables.store');
        Route::get('/tables-budgetaires', [BudgetTableController::class, 'index'])->name('budget-tables.index');
        Route::get('/tables-budgetaires/{id}', [BudgetTableController::class, 'show'])->name('budget-tables.show');
        Route::get('/admin/budget-tables/export/{id}', [BudgetTableController::class, 'exportPdf'])->name('budget-tables.export');
        Route::get('/admin/budgetaire/tables-budgetaires', [BudgetTableController::class, 'index'])->name('budget-tables.index');
        Route::get('/admin/budgetaire/tables-budgetaires/{id}/edit', [BudgetTableController::class, 'edit'])->name('budget-tables.edit');
        Route::post('/admin/budgetaire/tables-budgetaires/{id}/update', [BudgetTableController::class, 'updateEntries'])->name('budget-tables.update.entries');
    });
});

/*
|--------------------------------------------------------------------------
| Standalone Routes
|--------------------------------------------------------------------------
*/

Route::get('/demandes', [DemandeController::class, 'create'])
    ->middleware(['auth', 'verified', 'role:admin'])
    ->name('demandes');

Route::get('/demande/{id}/remplir', [DemandeController::class, 'remplir'])
    ->middleware(['auth', 'verified', 'role:plaisance'])
    ->name('demande.remplir');



    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/dashboard', function () {
            $user = auth()->user();
    
            if ($user->hasRole('admin')) {
                return redirect()->route('admin.dashboard');
            } elseif ($user->hasRole('plaisance')) {
                return redirect()->route('plaisance.dashboard');
            } elseif ($user->hasRole('tresorier')) {
                return redirect()->route('tresorier.dashboard');
            } elseif ($user->hasRole('user')) {
                return redirect()->route('user.dashboard');
            }
    
            // Fallback - you can customize this
            return redirect()->route('user.dashboard');
        })->name('dashboard');
    });
    
/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/


require __DIR__.'/auth.php';