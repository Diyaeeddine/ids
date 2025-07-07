<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
use App\Models\Demande;

class NotificationController extends Controller
{
    public function getUnreadNotifications()
    {
        $user = Auth::user();

        $notifications = Notification::where('user_id', $user->id)
            ->where('is_read', false)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($notif) {
                return [
                    'id' => $notif->id,
                    'titre' => $notif->titre,
                    'temps' => $notif->created_at->diffForHumans(),
                    'demande_id' => $notif->demande_id,
                    'contrat_id' => $notif->contrat_id, 
                ];
            });

        return response()->json([
            'success' => true,
            'notifications' => $notifications,
            'count' => $notifications->count(),
        ]);
    }

public function markAsRead($id)
{
    if (!auth()->check()) {
        return response()->json(['success' => false, 'message' => 'Non authentifié'], 401);
    }

    $notification = Notification::find($id);

    if (!$notification) {
        return response()->json(['success' => false, 'message' => 'Notification non trouvée'], 404);
    }

    $notification->update([
        'is_read' => true,
        'read_at' => now(),
    ]);

    return response()->json(['success' => true]);
}


public function generateNotifications()
{
    $user = Auth::user();

    $demandes = Demande::whereNotIn('id', function($query) use ($user) {
        $query->select('demande_id')
              ->from('notifications')
              ->where('user_id', $user->id)
              ->whereNotNull('demande_id');
    })->get();

    foreach ($demandes as $demande) {
        $users = $demande->users()->orderByPivot('sort')->get();

        foreach ($users as $currentUser) {
            $userPivot = $demande->users()->where('user_id', $currentUser->id)->first();

            if ($userPivot && $userPivot->pivot->isyourturn == 1) {
                Notification::create([
                    'user_id' => $currentUser->id,
                    'demande_id' => $demande->id,
                    'titre' => 'Nouvelle demande à remplir',
                    'is_read' => false,
                ]);
            }
        }
    }

    return response()->json(['success' => true]);
}




    public function sendContractNotificationToAdmin($contratId)
    {
        // Récupérer tous les admins
        $admins = \App\Models\User::where('role', \App\Enums\UserRole::Admin)->get();

        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'titre' => 'Nouveau contrat soumis',
                'contrat_id' => $contratId,
                'is_read' => false,
            ]);
        }

        return response()->json(['success' => true]);
    }
}