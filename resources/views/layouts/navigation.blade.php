<link href="https://fonts.googleapis.com/css2?family=Unbounded:wght@700&display=swap" rel="stylesheet">
{{-- @php
    use App\Enums\UserRole;
@endphp --}}

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
    }

    .benbar-logo {
        color: #111111;
    }
    .marina-logo{
      max-width: 150px;
      max-height: 50px;
      vertical-align: middle;
    }

    @media (prefers-color-scheme: dark) {
        .benbar-logo {
            color: #f2f2f2;
        }
    }
</style>

<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between h-16">
      <div class="flex">
        <!-- Logo -->
        <div class="shrink-0 logo-wrapper flex items-center">
          {{-- <a href="{{ route('dashboard') }}"> --}}

<img src="{{ asset('build/assets/images/logo-marina.png') }}" class="marina-logo hidden dark:block" alt="Logo Light" />

<img src="{{ asset('build/assets/images/logo-marina-dark1.png') }}" class="marina-logo block dark:hidden" alt="Logo Dark" />

          {{-- </a> --}}
        </div>

        <!-- Navigation Admin et User -->
        @role('admin')
          <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
              {{-- <x-nav-link :href="route('dashboard')" :active="request()->routeIs('admin.dashboard')"> --}}
                <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                  {{ __('Accueil') }}
              </x-nav-link>
          </div>
          <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
              <x-nav-link :href="route('demande.add-demande')" :active="request()->routeIs('demande.add-demande')">
                  {{ __('Création') }}
              </x-nav-link>
          </div>
          <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
              <x-nav-link :href="route('demandes.affecter')" :active="request()->routeIs('demandes.affecter')">
                  {{ __('Afféctation') }}
              </x-nav-link>
          </div>
          <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
              <x-nav-link
                  :href="route('admin.demandes')"
                  :active="request()->routeIs('demande.add-demand') || request()->routeIs('admin.demandes') || request()->routeIs('demande') || request()->routeIs('admin.demande.user.uploads') || request()->routeIs('admin.demandes.decision') || request()->routeIs('demandes.afficher-demande')"
              >
                  {{ __('Demandes') }}
              </x-nav-link>
          </div>
          <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
              <x-nav-link :href="route('admin.contrats.index')" :active="request()->routeIs('admin.contrats.index')">
                  {{ __('Contrats') }}
              </x-nav-link>
          </div>
          <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
              <x-nav-link :href="route('budget-tables.create')" :active="request()->routeIs('budget-tables.create')">
                  {{ __('Création Table Budgétaire') }}
              </x-nav-link>
          </div>
          <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
              <x-nav-link href="{{ route('budget-tables.index') }}" :active="request()->routeIs('budget-tables.index') || request()->routeIs('budget-tables.show')">
                  {{ __('Tables Budgétaires') }}
              </x-nav-link>
          </div>
          <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
              <x-nav-link :href="route('acce.index')" :active="request()->routeIs('acce.index') || request()->routeIs('acce.edit') || request()->routeIs('acce.update') || request()->routeIs('profile.add-profile')">
                  {{ __('Accés') }}
              </x-nav-link>
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
            <x-nav-link :href="route('user.dashboard')" :active="request()->routeIs('user.dashboard')">
              {{ __('Accueil') }}
            </x-nav-link>
            <x-nav-link :href="route('user.demandes')" :active="request()->routeIs('user.demandes') || request()->routeIs('user.demandes.showRemplir') || request()->routeIs('user.demandes.voir')">
              {{ __('Mes demandes') }}
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
        @role('tresorier')
        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
          <x-nav-link :href="route('user.dashboard')" :active="request()->routeIs('user.dashboard')">
            {{ __('Accueil') }}
          </x-nav-link>
          <x-nav-link :href="route('user.demandes')" :active="request()->routeIs('user.demandes') || request()->routeIs('user.demandes.showRemplir') || request()->routeIs('user.demandes.voir')">
            {{ __('Mes demandes') }}
          </x-nav-link>
        </div>
        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
          <x-nav-link
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
        </x-nav-link>
        </div>
      @endrole

      </div>
<!-- Partie droite -->
<div class="hidden sm:flex sm:items-center sm:ms-6 space-x-4 relative"
     x-data='notificationBell(@json(auth()->user()->hasRole("admin") ? ($adminNotifications ?? []) : ($demandes ?? [])))'
     @click.away="closeDropdown()">


  @if((auth()->user()->hasRole('user') && isset($demandes)) || (auth()->user()->hasRole('plaisance') && isset($demandes)) || 
     (auth()->user()->hasRole('admin') && isset($adminNotifications)))
 
    <button
      @click="toggleDropdown()"
      type="button"
      aria-haspopup="true"
      aria-expanded="false"
      aria-label="Notifications"
      class="relative inline-flex items-center p-1.5 text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white focus:outline-none rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition"
      title="Notifications"
      :class="unreadCount > 0 ? 'animate-ring' : ''"
    >
      <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"
           viewBox="0 0 24 24">
        <path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0 1 18 14.158V11a6.002 6.002 0 0 0-4-5.659V5a2 2 0 1 0-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 1 1-6 0v-1m6 0H9"/>
      </svg>
      <template x-if="unreadCount > 0">
        <span class="absolute top-0 right-0 block w-4 h-4 bg-red-600 border-2 border-white rounded-full dark:border-gray-800 text-white text-xs flex items-center justify-center"
              x-text="unreadCount">
        </span>
      </template>
    </button>

    <!-- Dropdown notifications -->
    <div
      x-show="dropdownOpen"
      x-transition:enter="transition ease-out duration-300"
      x-transition:enter-start="opacity-0 -translate-y-4"
      x-transition:enter-end="opacity-100 translate-y-1"
      x-transition:leave="transition ease-in duration-200"
      x-transition:leave-start="opacity-100 translate-y-1"
      x-transition:leave-end="opacity-0 -translate-y-4"
      class="origin-top-right absolute right-0 mt-40 w-80 max-h-96 overflow-auto rounded-md shadow-lg bg-white dark:bg-gray-800 ring-1 ring-black ring-opacity-5 focus:outline-none z-50"
      style="display: none;"
    >
      <div class="block px-4 py-2 font-semibold text-center text-gray-700 bg-gray-50 dark:bg-gray-900 dark:text-white">
        Notifications
      </div>

      <template x-if="notifications.length === 0">
        <div class="text-center text-gray-500 p-4 dark:text-gray-400">
          Aucune notification
        </div>
      </template>

      <template x-for="(notif, index) in visibleNotifications" :key="notif.id">
        <div
          class="flex items-center justify-between px-4 py-3 border-b border-gray-200 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700 transition-all"
          :class="{ 'opacity-0 max-h-0 overflow-hidden p-0': notif.read }"
          x-bind.style="notif.read ? 'height:0;padding:0;margin:0;' : ''"
        >
          <div class="flex-1 pr-3">
            <p class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed" x-text="notif.titre ?? 'Sans objet'"></p>
            <p class="text-xs text-blue-600 dark:text-blue-500 mt-1" x-text="notif.temps"></p>
          </div>
          <button
            @click.prevent="markAsRead(index)"
            class="ml-3 px-2 py-0.5 text-xs font-semibold text-gray-600 dark:text-gray-400 bg-gray-200 dark:bg-gray-700 rounded-full hover:bg-gray-300 dark:hover:bg-gray-600 shadow-sm transition"
          >
            ✓ Lu
          </button>
        </div>
      </template>

      <template x-if="notifications.length > 5">
        <button
          @click="showAll = true"
          class="block w-full text-center py-2 text-sm font-medium text-gray-900 bg-gray-50 hover:bg-gray-100 dark:bg-gray-900 dark:hover:bg-gray-700 dark:text-white"
        >
          Voir toutes
        </button>
      </template>
    </div>
  @endif


        <!-- Settings Dropdown -->
        <div class="hidden sm:flex sm:items-center sm:ms-6">
          <x-dropdown align="right" width="48">
            <x-slot name="trigger">
              <button
                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150"
                aria-haspopup="true"
              >
                <div>{{ Auth::user()->name }}</div>
                <div class="ms-1">
                  <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                          d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                          clip-rule="evenodd"
                    />
                  </svg>
                </div>
              </button>
            </x-slot>

            <x-slot name="content">
              @if(auth()->user()->hasRole('admin'))
                <x-dropdown-link :href="route('profile.edit')">
                  {{ __('Profile') }}
                </x-dropdown-link>
              @endif
          
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                  {{ __('Déconnexion') }}
                </x-dropdown-link>
              </form>
            </x-slot>
          </x-dropdown>
        </div>

        <!-- Hamburger -->
        <div class="-me-2 flex items-center sm:hidden">
          <button
            @click="open = !open"
            class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out"
          >
            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24" aria-hidden="true">
              <path
                :class="{ 'hidden': open, 'inline-flex': !open }"
                class="inline-flex"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M4 6h16M4 12h16M4 18h16"
              />
              <path
                :class="{ 'hidden': !open, 'inline-flex': open }"
                class="hidden"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M6 18L18 6M6 6l12 12"
              />
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
              ? initialNotifications.map(n => ({ ...n, read: false }))
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
          this.notifications.splice(index, 1);
      }, 500);
  
      // Envoi AJAX
      fetch(`/notifications/mark-as-read/${notificationId}`, {
  method: 'POST',
  headers: {
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    'Content-Type': 'application/json',
    'Accept': 'application/json'  // ✅ Important
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
  }
  
      };
  }
  </script>