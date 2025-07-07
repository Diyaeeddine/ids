<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\DemandeUser;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;  
use Illuminate\Validation\Rules\Password;  
use Illuminate\Auth\Events\Registered;  
use Illuminate\Support\Facades\Auth;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::query();
    
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
    
        $users = $query->latest()->get();
    
        return view('admin.profiles.profiles', compact('users'));
    }
    
    


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       //
    }
    public function createProfile()
    {
        return view('admin.profiles.add-profile');
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'password' => ['required', Password::defaults()],
            'role' => ['nullable', 'string', 'in:admin,plaisance,tresorier,comptable,admin_juridique,user'],
        ]);
    
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $role = $request->input('role', 'user');
        $user->assignRole($role);
    
        event(new Registered($user));
    
        return redirect()->route('acce.index')->with('success', 'Profil créé avec succès');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */

    public function edit(string $id)
    {
        $user=User::find($id);
        return view('admin.profiles.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, string $id)
{   
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $id,
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

    return view('user.demandes', compact('mesdemandes', 'nouvellesDemandes', 'demandesEnRetard'));
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

public function userDashboard(Request $request)
{
    // The normal user dashboard is simple and does not need to fetch contract or facture data.
    return view('user.dashboard', [
        'title' => 'Mon Tableau de bord'
    ]);
}


    
    public function notificationUser()
    {
        $userId = Auth::id();
    
        $demandes = DemandeUser::with('demande')
            ->where('user_id', $userId)
            ->orderByDesc('updated_at')
            ->take(5)
            ->get()
            ->map(function ($demandeUser) {
                $demandeUser->temps = $demandeUser->updated_at->diffForHumans();
                return $demandeUser;
            });
    
        return view('layouts.navigation', compact('demandes'));
    }
    
public function notificationAdmin()
{
$admin = Auth::user();
$adminNotifications = Notification::whereNull('read_at')
    ->orderByDesc('created_at')
    ->take(5)
    ->get()
    ->map(function ($notif) {
        $notif->temps = Carbon::parse($notif->created_at)->diffForHumans();
        return $notif;
    });

return view('layouts.navigation', compact('adminNotifications'));
}
}
    
   