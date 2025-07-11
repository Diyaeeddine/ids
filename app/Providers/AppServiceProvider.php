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

            // Pour tous les rôles (user, plaisance, tresorier)
            if ($user->hasRole('user') || $user->hasRole('plaisance') || $user->hasRole('tresorier')) {
                $notifications = Notification::select(
                        'notifications.id',
                        'notifications.titre',
                        'notifications.commentaire',
                        'notifications.is_read',
                        'notifications.created_at',
                        'notifications.demande_id',
                        'notifications.type',
                        'notifications.contrat_id',
                        'notifications.user_id',
                        'notifications.source_user_id',
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
                            'type' => $notif->type,
                            'commentaire' => $notif->commentaire ?? 'Aucun commentaire disponible.',
                            'temps' => $notif->created_at->diffForHumans(),
                            'demande_id' => $notif->demande_id,
                            'contrat_id' => $notif->contrat_id,
                            'user_id' => $notif->user_id,
                            'user_affecte_id' => $notif->user_affecte_id,
                            'source_user_id' => $notif->source_user_id ?? $notif->user_id,
                            'is_read' => $notif->is_read,
                            'showCommentaire' => false
                        ];
                    });

                $view->with('demandes', $notifications);
            }

            // Pour les admins
            if ($user->hasRole('admin')) {
                $adminNotifications = Notification::select(
                        'notifications.id',
                        'notifications.titre',
                        'notifications.type',
                        'notifications.commentaire',
                        'notifications.is_read',
                        'notifications.created_at',
                        'notifications.demande_id',
                        'notifications.contrat_id',
                        'notifications.user_id',
                        'notifications.source_user_id',
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
                            'type' => $notif->type,
                            'commentaire' => $notif->commentaire ?? 'Aucun commentaire disponible.',
                            'temps' => $notif->created_at ? $notif->created_at->diffForHumans() : 'Date inconnue',
                            'demande_id' => $notif->demande_id,
                            'contrat_id' => $notif->contrat_id,
                            'user_id' => $notif->user_id,
                            'user_affecte_id' => $notif->user_affecte_id,
                            'source_user_id' => $notif->source_user_id ?? $notif->user_id,
                            'is_read' => $notif->is_read,
                            'showCommentaire' => false
                        ];
                    });

                $view->with('adminNotifications', $adminNotifications);
            }
        });
    }
}