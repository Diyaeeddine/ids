<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;  
use Illuminate\Validation\Rules\Password; 
use App\Models\OrderP;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Response;
use PDF;  

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();
        
        $query->role('user');
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        $users = $query->latest()->get();

        return view('admin.profiles.profiles', compact('users'));
    }


  
    public function create()
    {
        return view('admin.profiles.add-profile');
    }
    public function create_demande(){
        return view('admin.demandes.add-demande');
    }

 
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));
        return redirect()->route('acce.index')->with('success', 'Profil créé avec succès');

    }

    
    public function show(string $id)
    {
       
    }

   
    public function edit(string $id)
    {
        $user=User::find($id);
        return view('admin.profiles.edit', compact('user'));
    }

  
    public function update(Request $request, string $id)
{   
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:admin_users,email,' . $id,
    ]);

    $user = User::findOrFail($id);
    $user->update([
        'name' => $request->name,
        'email' => $request->email,
    ]);

    return redirect()->route('acce.index')->with('success', 'Utilisateur mis à jour avec succès.');
}


 
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('acce.index')->with('success', 'Utilisateur supprimé avec succès.');

    }
    public function userCreate(){
        return view('admin.profiles.add-profile');

    }
    public function storeUserProfile(Request $request){
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        event(new Registered($user));
        return redirect()->route('acce.index')->with('success', 'Profil créé avec succès');

    }


    public function traiterOP(){

        $op_attente_traiter = OrderP::where('is_accepted', false)->get();
        return view('admin.demandes.verifier-op',compact('op_attente_traiter'));
    
    }

    public function telechargerPDFOP($id)
    {
        $op = OrderP::findOrFail($id);
    
        $pdf = PDF::loadView('admin.pdf.ordre-paiement', [
            'op' => $op,
            'date_generation' => now()->format('d/m/Y H:i:s'),
        ]);
    
        return $pdf->download('OP_' . $op->id . '_' . $op->reference . '.pdf');
    }
    
    public function detailsOP($id)
{
    $op = OrderP::findOrFail($id);
    return view('admin.partials.details-op', compact('op'));
}

public function accepterOP(Request $request, $id)
{
    $op = OrderP::findOrFail($id);

    if ($op->is_accepted || $op->is_rejected) {
        return redirect()->back()->with('error', 'Cet ordre de paiement a déjà été traité.');
    }

    $op->update([
        'is_accepted' => true,
        'updated_at' => now(),
    ]);

    return redirect()->back()->with('success', 'Ordre de paiement accepté avec succès.');
}

public function refuserOP(Request $request, $id)
{
    $op = OrderP::findOrFail($id);

    if ($op->is_accepted || $op->is_rejected) {
        return redirect()->back()->with('error', 'Cet ordre de paiement a déjà été traité.');
    }

    $op->update([
        'is_accepted' => false,
        'updated_at' => now(),
        // 'motif_refus' => $request->input('motif_refus', 'Aucun motif spécifié'),
    ]);

    return redirect()->back()->with('success', 'Ordre de paiement refusé avec succès.');
}

}


