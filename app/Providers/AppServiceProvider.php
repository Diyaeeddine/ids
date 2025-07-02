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
                return; // pas connecté → rien à injecter
            }

            if ($user->hasRole('user') || $user->hasRole('plaisance')) {
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

                $view->with('demandes', $notifications);
            }

            if ($user->hasRole('admin')) {
                $adminNotifications = Notification::where('user_id', $user->id)
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

                $view->with('adminNotifications', $adminNotifications);
            }
        });
    }
}