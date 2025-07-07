<link href="https://fonts.googleapis.com/css2?family=Unbounded:wght@700&display=swap" rel="stylesheet">
@php
    use App\Enums\UserRole;
@endphp

<style>
@keyframes ring {
  0% { transform: rotate(0deg); }
  1% { transform: rotate(30deg); }
  3% { transform: rotate(-28deg); }
  5% { transform: rotate(34deg); }
  7% { transform: rotate(-32deg); }
  9% { transform: rotate(30deg); }
  11% { transform: rotate(-28deg); }
  13% { transform: rotate(26deg); }
  15% { transform: rotate(-24deg); }
  17% { transform: rotate(22deg); }
  19% { transform: rotate(-20deg); }
  21% { transform: rotate(18deg); }
  23% { transform: rotate(-16deg); }
  25% { transform: rotate(14deg); }
  27% { transform: rotate(-12deg); }
  29% { transform: rotate(10deg); }
  31% { transform: rotate(-8deg); }
  33% { transform: rotate(6deg); }
  35% { transform: rotate(-4deg); }
  37% { transform: rotate(2deg); }
  39% { transform: rotate(-1deg); }
  41% { transform: rotate(1deg); }
  43% { transform: rotate(0deg); }
  100% { transform: rotate(0deg); }
}

.animate-ring {
  transform-origin: top center;
  animation: ring 1.5s ease-in-out infinite;
}

.benbar-logo {
  font-family: 'Unbounded', 'Segoe UI', sans-serif;
  font-weight: 700;
  font-size: 1.5rem;
  transition: color 0.3s ease-in-out;
  color: #111111;
}

.marina-logo {
  max-width: 150px;
  max-height: 50px;
  vertical-align: middle;
}

@media (prefers-color-scheme: dark) {
  .benbar-logo { color: #f2f2f2; }
}

.dark { color-scheme: dark; }

.comment-box {
  background: #f8fafc;
  border-left: 2px solid #3b82f6;
}

.comment-content {
  position: relative;
}

.comment-content::before {
  content: '"';
  font-size: 2rem;
  color: #94a3b8;
  position: absolute;
  top: -8px;
  left: -4px;
  font-family: serif;
}

.comment-button-pulse {
  animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

@keyframes pulse {
  0%, 100% { opacity: 1; }
  50% { opacity: .7; }
}
</style>

<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between h-16">
      <div class="flex">
        <div class="shrink-0 logo-wrapper flex items-center">
          <a href="{{ route('dashboard') }}">
            <img src="{{ asset('build/assets/images/marina-logo-white.png') }}" class="marina-logo hidden dark:block" alt="Logo Light" />
            <img src="{{ asset('build/assets/images/marina-logo-black.png') }}" class="marina-logo block dark:hidden" alt="Logo Dark" />
          </a>
        </div>

        <!-- Navigation Admin et User -->
        @role('admin')
          <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('admin.dashboard')">{{ __('Accueil') }}</x-nav-link>
            <x-nav-link :href="route('demande.add-demande')" :active="request()->routeIs('demande.add-demande')">{{ __('Création') }}</x-nav-link>
            <x-nav-link :href="route('demandes.affecter')" :active="request()->routeIs('demandes.affecter')">{{ __('Afféctation') }}</x-nav-link>
            <x-nav-link :href="route('admin.demandes')" :active="request()->routeIs('demande.add-demand') || request()->routeIs('admin.demandes') || request()->routeIs('demande') || request()->routeIs('admin.demande.user.uploads') || request()->routeIs('admin.demandes.decision') || request()->routeIs('demandes.afficher-demande')">{{ __('Demandes') }}</x-nav-link>
            <x-nav-link :href="route('admin.contrats.index')" :active="request()->routeIs('admin.contrats.index')">{{ __('Contrats') }}</x-nav-link>
            <x-nav-link :href="route('budget-tables.create')" :active="request()->routeIs('budget-tables.create')">{{ __('Création Table Budgétaire') }}</x-nav-link>
            <x-nav-link href="{{ route('budget-tables.index') }}" :active="request()->routeIs('budget-tables.index') || request()->routeIs('budget-tables.show')">{{ __('Tables Budgétaires') }}</x-nav-link>
            <x-nav-link :href="route('acce.index')" :active="request()->routeIs('acce.index') || request()->routeIs('acce.edit') || request()->routeIs('acce.update') || request()->routeIs('profile.add-profile')">{{ __('Accés') }}</x-nav-link>
          </div>
        @endrole

        @role('plaisance')
          <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
            <x-nav-link :href="route('plaisance.dashboard')" :active="request()->routeIs('plaisance.dashboard')">
              {{ __('Accueil') }}
            </x-nav-link>
          </div>
          <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
            <x-nav-link :href="route('plaisance.demandes')" :active="request()->routeIs('plaisance.demandes') || request()->routeIs('plaisance.demandes.showRemplir') || request()->routeIs('plaisance.demandes.voir')">
              {{ __('Mes demandes') }}
            </x-nav-link>
          </div>
          <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
            <x-nav-link
            :href="route('plaisance.contrats')"
            :active="request()->routeIs('plaisance.contrats') || request()->routeIs('contrats.create')"
          >
            {{ __('Contrats') }}
          </x-nav-link>
          <x-nav-link
          :href="route('plaisance.factures.index')"
          :active="request()->routeIs('plaisance.factures') || request()->routeIs('plaisance.factures.index') || request()->routeIs('plaisance.factures.create') || request()->routeIs('plaisance.factures.show')"
          >
            {{ __('Factures') }}
          </x-nav-link>
          </div>
        @endrole
        @role('user')
          <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">{{ __('Accueil') }}</x-nav-link>
            <x-nav-link :href="route('user.demandes')" :active="request()->routeIs('user.demandes') || request()->routeIs('user.demandes.showRemplir') || request()->routeIs('user.demandes.voir')">{{ __('Mes demandes') }}</x-nav-link>
            <x-nav-link :href="route('user.contrats')" :active="request()->routeIs('user.contrats') || request()->routeIs('contrats.create')">{{ __('Contrats') }}</x-nav-link>
            <x-nav-link :href="route('factures.index')" :active="request()->routeIs('user.factures') || request()->routeIs('factures.index') || request()->routeIs('factures.create') || request()->routeIs('factures.show')">{{ __('Factures') }}</x-nav-link>
          </div>
        @endrole
        @role('tresorier')
        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
          <x-nav-link :href="route('tresorier.dashboard')" :active="request()->routeIs('tresorier.dashboard')">
            {{ __('Accueil') }}
          </x-nav-link>
          <x-nav-link :href="route('tresorier.demandes')" :active="request()->routeIs('tresorier.demandes')">
            {{ __('Demandes') }}
          </x-nav-link>
          <x-nav-link :href="route('tresorier.op')" :active="request()->routeIs('op.demandes')">
            {{ __('Ordre de paiment') }}
          </x-nav-link>
          <x-nav-link :href="route('tresorier.ov')" :active="request()->routeIs('ov.demandes')">
            {{ __('Ordre de virement') }}
          </x-nav-link>
        </div>
        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
          {{-- <x-nav-link
          :href="route('user.contrats')"
          :active="request()->routeIs('user.contrats') || request()->routeIs('contrats.create')"
        >
          {{ __('Contrats') }}
        </x-nav-link>
         <x-nav-link
        :href="route('factures.index')"
        :active="request()->routeIs('user.factures') || request()->routeIs('factures.index') || request()->routeIs('factures.create') || request()->routeIs('factures.show')"
        >
          {{ __('Factures') }}
        </x-nav-link> --}}
        </div>
      @endrole

      </div>
<!-- Partie droite -->
<div class="hidden sm:flex sm:items-center sm:ms-6 space-x-4 relative"
     x-data='notificationBell(@json(auth()->user()->hasRole("admin") ? ($adminNotifications ?? []) : ($demandes ?? [])))'
     @click.away="closeDropdown()">


  @if((auth()->user()->hasRole('user') && isset($demandes)) || (auth()->user()->hasRole('plaisance') && isset($demandes)) ||
     (auth()->user()->hasRole('admin') && isset($adminNotifications)))

          <button @click="toggleDropdown()" type="button" class="relative inline-flex items-center p-1.5 text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white focus:outline-none rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition" :class="unreadCount > 0 ? 'animate-ring' : ''">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
              <path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0 1 18 14.158V11a6.002 6.002 0 0 0-4-5.659V5a2 2 0 1 0-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 1 1-6 0v-1m6 0H9"/>
            </svg>
            <template x-if="unreadCount > 0">
              <span class="absolute top-0 right-0 block w-4 h-4 bg-red-600 border-2 border-white rounded-full dark:border-gray-800 text-white text-xs flex items-center justify-center" x-text="unreadCount"></span>
            </template>
          </button>

          <div x-show="dropdownOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-1" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-1" x-transition:leave-end="opacity-0 -translate-y-4" class="absolute right-0 top-full mt-2 w-80 max-h-96 overflow-auto rounded-md shadow-lg bg-white dark:bg-gray-800 ring-1 ring-black ring-opacity-5 focus:outline-none z-50">
            <div class="block px-4 py-2 font-semibold text-center text-gray-700 bg-gray-50 dark:bg-gray-900 dark:text-white">Notifications</div>

            <template x-if="notifications.length === 0">
              <div class="text-center text-gray-500 p-4 dark:text-gray-400">Aucune notification</div>
            </template>

            <template x-for="(notif, index) in visibleNotifications" :key="notif.id">
              <div class="border-b border-gray-100 last:border-b-0">
                <div class="flex items-center justify-between px-4 py-3 hover:bg-gradient-to-r hover:from-gray-50 hover:to-blue-50 transition-all duration-200" :class="{ 'opacity-0 max-h-0 overflow-hidden p-0': notif.read, 'cursor-pointer': hasCommentaire(notif), 'bg-blue-25': notif.showCommentaire }" x-bind.style="notif.read ? 'height:0;padding:0;margin:0;' : ''" @click="hasCommentaire(notif) ? toggleCommentaire(index) : navigateToDetail(notif)">
                  <div class="flex-1 pr-3">
                    <div class="flex items-center">
                      <p class="text-sm font-medium text-gray-800 leading-relaxed">
                        <span x-text="notif.titre ?? 'Sans objet'"></span>
                      </p>
                      <template x-if="hasCommentaire(notif)">
                        <div class="flex items-center ml-2">
                          <svg class="w-4 h-4 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 13V5a2 2 0 00-2-2H4a2 2 0 00-2 2v8a2 2 0 002 2h3l3 3 3-3h3a2 2 0 002-2zM5 7a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1zm1 3a1 1 0 100 2h3a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                          </svg>
                          <span class="ml-1 text-xs text-blue-600 font-medium">Détails</span>
                        </div>
                      </template>
                    </div>
                    <p class="text-xs text-blue-600 mt-1 font-medium" x-text="notif.temps"></p>
                  </div>
                  <button @click.stop="markAsRead(index)" class="ml-3 px-3 py-1 text-xs font-semibold text-white bg-gradient-to-r from-green-500 to-green-600 rounded-full hover:from-green-600 hover:to-green-700 shadow-md hover:shadow-lg transition-all duration-200 transform hover:scale-105">✓ Lu</button>
                </div>

                <template x-if="hasCommentaire(notif)">
                  <div x-show="notif.showCommentaire" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform -translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 transform translate-y-0" x-transition:leave-end="opacity-0 transform -translate-y-2" class="comment-box mx-4 mb-4 rounded-lg shadow-sm">
                    <div class="p-4">
                      <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center">
                          <svg class="w-5 h-5 text-blue-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                          </svg>
                          <p class="text-sm font-semibold text-blue-800">Commentaire administrateur</p>
                        </div>
                        <span class="px-1 py-0.5 text-[10px] font-medium bg-orange-100 text-orange-800 rounded-full whitespace-nowrap">Action requise</span>
                      </div>
                      <div class="comment-content bg-white rounded-md p-3 border border-blue-100">
                        <p class="text-sm text-gray-700 leading-relaxed pl-4">
                          <span x-text="notif.commentaire"></span>
                        </p>
                      </div>
                      <div class="flex justify-end mt-4 space-x-2">
                        <button @click="toggleCommentaire(index)" class="px-2 py-1 text-xs font-medium text-gray-600 bg-gray-100 rounded-md hover:bg-gray-200 transition-colors duration-200">Fermer</button>
                        <button @click="window.location.href = '/user/demande/remplir/' + notif.demande_id" class="comment-button-pulse px-3 py-1 text-xs font-bold text-white bg-gradient-to-r from-blue-600 to-indigo-600 rounded-md hover:from-blue-700 hover:to-indigo-700 shadow-md hover:shadow-lg transition-all duration-200 transform hover:scale-105 flex items-center">
                          <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                          </svg>
                          Modifier ma demande
                        </button>
                      </div>
                    </div>
                  </div>
                </template>
              </div>
            </template>

            <template x-if="notifications.length > 5">
              <button @click="showAll = true" class="block w-full text-center py-2 text-sm font-medium text-gray-900 bg-gray-50 hover:bg-gray-100 dark:bg-gray-900 dark:hover:bg-gray-700 dark:text-white">Voir toutes</button>
            </template>
          </div>
        @endif


        <!-- Settings Dropdown -->
        <div class="hidden sm:flex sm:items-center sm:ms-6">
          <x-dropdown align="right" width="48">
            <x-slot name="trigger">
              <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                <div>{{ Auth::user()->name }}</div>
                <div class="ms-1">
                  <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                  </svg>
                </div>
              </button>
            </x-slot>
            <x-slot name="content">
              @if(Auth::User()->role === UserRole::Admin)
                <x-dropdown-link :href="route('profile.edit')">{{ __('Profile') }}</x-dropdown-link>
              @endif
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">{{ __('Déconnexion') }}</x-dropdown-link>
              </form>
            </x-slot>
          </x-dropdown>
        </div>

        <!-- Hamburger -->
        <div class="-me-2 flex items-center sm:hidden">
          <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
              <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
              <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
      </div>
    </div>
  </div>
</nav>

<script>
  function notificationBell(initialNotifications = []) {
    return {
      dropdownOpen: false,
      notifications: Array.isArray(initialNotifications)
        ? initialNotifications.map(n => ({
            ...n,
            read: false,
            showCommentaire: false,
            commentaire: n.commentaire || null,
            original_user_id: n.original_user_id || n.user_id || null
        }))
        : [],
      unreadCount: initialNotifications.length || 0,
      showAll: false,

      get visibleNotifications() {
        return this.showAll ? this.notifications : this.notifications.slice(0, 5);
      },

      toggleDropdown() {
        this.dropdownOpen = !this.dropdownOpen;
        if (!this.dropdownOpen) this.showAll = false;
      },

      closeDropdown() {
        this.dropdownOpen = false;
        this.showAll = false;
      },

      markAsRead(index) {
        const notification = this.notifications[index];
        if (!notification) return;

        const notificationId = notification.id;

        // Mise à jour locale
        this.notifications[index].read = true;
        this.unreadCount = this.notifications.filter(n => !n.read).length;

        setTimeout(() => {
          this.notifications.splice(index, 1);  // Supprime la notification après l'avoir lue
        }, 500);

        // Envoi AJAX
        fetch(`/notifications/mark-as-read/${notificationId}`, {
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
            'Accept': 'application/json'
          }
        })
        .then(response => {
          if (!response.ok) throw new Error("La requête a échoué");
          return response.json();
        })
        .then(data => {
          if (!data.success) {
            console.error('Réponse API invalide:', data.message || data);
          }
        })
        .catch(error => {
          console.error("Erreur lors du marquage:", error);
        });
      },

      toggleCommentaire(index) {
        const notification = this.notifications[index];
        if (notification && this.hasCommentaire(notification)) {
          notification.showCommentaire = !notification.showCommentaire;
        }
      },

      hasCommentaire(notification) {
        return notification.commentaire && notification.commentaire.trim() !== '' && notification.commentaire !== 'Aucun commentaire disponible.';
      },

      navigateToDetail(notification) {
        if (!notification.demande_id) {
          console.error('demande_id manquant dans la notification');
          return;
        }
        const userId = notification.user_affecte_id || notification.original_user_id || notification.user_id;
        if (!userId) {
          console.error('Aucun user_id disponible pour la navigation');
          return;
        }

        const currentUrl = window.location.href;
        const isAdmin = currentUrl.includes('/admin/') || currentUrl.includes('admin');

        if (isAdmin) {
          // Redirection vers la vue admin
          const adminUrl = `/admin/demandes/afficher/${notification.demande_id}/${userId}`;
          console.log('Navigating to admin URL:', adminUrl);
          window.location.href = adminUrl;
        } else {
          // Redirection vers la vue utilisateur
          const userUrl = `/user/demande/remplir/${notification.demande_id}`;
          console.log('Navigating to user URL:', userUrl);
          window.location.href = userUrl;
        }
      }
    };
  }
</script>