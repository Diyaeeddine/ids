<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Enums\UserRole;
use App\Models\Notification;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('*', function ($view) {
            $user = Auth::user();

            if (!$user) {
                return;
            }

            if ($user->hasRole('user') || $user->hasRole('plaisance')) {
                $notifications = Notification::select(
                        'notifications.id',
                        'notifications.titre',
                        'notifications.commentaire',
                        'notifications.is_read',
                        'notifications.created_at',
                        'notifications.demande_id',
                        'notifications.contrat_id',
                        'notifications.user_id',
                        'notifications.original_user_id',
                        'demande_user.user_id as user_affecte_id'
                    )
                    ->leftJoin('demande_user', 'notifications.demande_id', '=', 'demande_user.demande_id')
                    ->where('notifications.user_id', $user->id)
                    ->where('notifications.is_read', false)
                    ->orderBy('notifications.created_at', 'desc')
                    ->get()
                    ->map(function ($notif) {
                        return [
                            'id' => $notif->id,
                            'titre' => $notif->titre,
                            'commentaire' => $notif->commentaire ?? 'Aucun commentaire disponible.',
                            'temps' => $notif->created_at->diffForHumans(),
                            'demande_id' => $notif->demande_id,
                            'contrat_id' => $notif->contrat_id,
                            'user_id' => $notif->user_id,
                            'user_affecte_id' => $notif->user_affecte_id,
                            'original_user_id' => $notif->original_user_id ?? $notif->user_id,
                            'is_read' => $notif->is_read,
                            'showCommentaire' => false
                        ];
                    });

                $view->with('demandes', $notifications);
            }
            
            if ($user->hasRole('admin')) {
                $adminNotifications = Notification::select(
                        'notifications.id',
                        'notifications.titre',
                        'notifications.commentaire',
                        'notifications.is_read',
                        'notifications.created_at',
                        'notifications.demande_id',
                        'notifications.contrat_id',
                        'notifications.user_id',
                        'notifications.original_user_id',
                        'demande_user.user_id as user_affecte_id'
                    )
                    ->leftJoin('demande_user', 'notifications.demande_id', '=', 'demande_user.demande_id')
                    ->where('notifications.user_id', $user->id)
                    ->where('notifications.is_read', false)
                    ->orderBy('notifications.created_at', 'desc')
                    ->get()
                    ->map(function ($notif) {
                        return [
                            'id' => $notif->id,
                            'titre' => $notif->titre,
                            'commentaire' => $notif->commentaire ?? 'Aucun commentaire disponible.',
                            'temps' => $notif->created_at->diffForHumans(),
                            'demande_id' => $notif->demande_id,
                            'contrat_id' => $notif->contrat_id,
                            'user_id' => $notif->user_id,
                            'user_affecte_id' => $notif->user_affecte_id, 
                            'original_user_id' => $notif->original_user_id ?? $notif->user_id,
                            'is_read' => $notif->is_read,
                            'showCommentaire' => false
                        ];
                    });

                $view->with('adminNotifications', $adminNotifications);
            }
        });
    }
}










