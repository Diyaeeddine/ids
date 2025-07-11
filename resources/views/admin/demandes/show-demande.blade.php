<x-app-layout>
  <x-slot name="header">
    <div class="flex justify-between items-center">
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Détails de la demande') }}
      </h2>
      <a href="{{ route('demandes.affecter') }}" class="inline-flex items-center px-4 py-2.5 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl font-medium text-sm text-gray-700 dark:text-gray-300 shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-all duration-200 group">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 group-hover:-translate-x-1 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
      </svg>
        {{ __('Retour') }}
      </a>
    </div>
    {{-- {{dd(date_Today())}} --}}
    {{-- {{ dd(date('Y-m-d')) }} --}}
    {{-- {{ dd(date('H:i:s')) }} --}}

  </x-slot>

  <div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="flex flex-col md:flex-row">

          <aside class="w-full md:w-1/4 bg-gray-50 dark:bg-gray-900 border-r dark:border-gray-700 p-4 md:min-h-[600px]">
            <div class="flex items-center justify-between mb-4">
              <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                {{ __('Liste des demandes') }}
              </h2>

              @if(count($demandes ?? []) > 8)
                <div class="relative">
                  <input type="text" id="search-demandes"
                      class="px-3 py-1 text-sm rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 focus:ring-indigo-500 focus:border-indigo-500"
                      placeholder="Rechercher...">
                </div>
              @endif
            </div>

            <nav class="space-y-1 overflow-y-auto max-h-[500px] pr-1" id="demandes-list">
              @php
                $demandesList = $demandes ?? \App\Models\Demande::with('users')->latest()->get();

                if (!isset($selectedDemande)) {
                    $id = request()->route('id') ?? ($demandesList->first()->id ?? null);
                    $selectedDemande = $id ? \App\Models\Demande::with('users')->find($id) : null;
                }
              @endphp

              @forelse($demandesList as $d)
                <a href="{{ route('demande', $d->id) }}"
                   class="flex justify-between items-center px-3 py-2 rounded-md text-sm transition-colors
                     {{ $selectedDemande && $selectedDemande->id === $d->id
                        ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900 dark:text-indigo-200 border-l-4 border-indigo-500'
                        : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
                  <div class="truncate">
                    <span class="font-medium">{{$d->titre}}</span>
                    <span class="block text-xs text-gray-500 dark:text-gray-400 truncate">Créé le {{ $d->created_at->format('d/m/Y') }}</span>

                  </div>
                  @if($d->created_at->isToday())
                    <span class="text-xs px-2 py-1 rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">Aujourd'hui</span>
                  @endif
                </a>
              @empty
                <div class="text-sm text-gray-500 dark:text-gray-400 italic text-center py-4">
                  {{ __('Aucune demande disponible') }}
                </div>
              @endforelse
            </nav>
          </aside>

          {{-- Contenu principal optimisé --}}
          <main class="w-full md:w-3/4 p-6">
            @if($selectedDemande)
              {{-- Titre, ID, date et bouton Générer PDF --}}
              <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-2 sm:mb-0">
                  {{ $selectedDemande->titre }}
                </h2>

                <div class="flex items-center space-x-2">
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                    ID: {{ $selectedDemande->id }}
                  </span>
                  @if($selectedDemande->created_at)
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200">
                      {{ $selectedDemande->created_at->format('d/m/Y') }}
                    </span>
                  @endif

                  <a href="{{ route('demande.pdf', $selectedDemande->id) }}"
                     class="inline-flex items-center px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-md shadow-sm transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0l3-3m-3 3l-3-3M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2" />
                    </svg>
                    Générer le PDF
                  </a>
                </div>
              </div>

              {{-- Carte d'informations principale --}}
              <div class="bg-white dark:bg-gray-700 shadow-sm rounded-lg border border-gray-200 dark:border-gray-600 overflow-hidden mb-6">
                <div class="border-b border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-800 px-4 py-3">
                  <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200">
                    {{ __('Informations générales') }}
                  </h3>
                </div>

                <div class="p-4">
                  <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-6">
                    <div>
                      <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                        {{ __('Titre') }}
                      </dt>
                      <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                        {{ $selectedDemande->titre }}
                      </dd>
                    </div>
                    <div>
                      <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                        {{ __('Date de création') }}
                      </dt>
                      <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                        @if($selectedDemande->created_at)
                          {{ $selectedDemande->created_at->format('d/m/Y à H:i') }}
                        @else
                          <span class="text-gray-500 dark:text-gray-400 italic">{{ __('Non disponible') }}</span>
                        @endif
                      </dd>
                    </div>
                    <div>
                      <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                        {{ __('Responsable(s)') }}
                      </dt>
                      <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200 flex flex-col space-y-2">
                        @forelse($selectedDemande->users as $user)
                          <div class="flex items-center">
                            <span class="inline-block h-8 w-8 rounded-full bg-gray-200 dark:bg-gray-600 text-center leading-8 mr-2 text-gray-700 dark:text-gray-300">
                              {{ strtoupper(substr($user->name, 0, 1)) }}
                            </span>
                            <span>{{ $user->name }} {{ $user->prenom ?? '' }}</span>
                          </div>
                        @empty
                          <span class="text-gray-500 dark:text-gray-400 italic">{{ __('Non assigné') }}</span>
                        @endforelse
                      </dd>
                    </div>

                    {{-- Ajoutez ici d'autres champs pertinents de votre modèle Demande --}}
                  </dl>
                </div>
              </div>

              {{-- Section pour afficher les demandes associées si nécessaire --}}
              @if(isset($selectedDemande->demandes) && count($selectedDemande->demandes) > 0)
                <div class="bg-white dark:bg-gray-700 shadow-sm rounded-lg border border-gray-200 dark:border-gray-600 overflow-hidden">
                  <div class="border-b border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-800 px-4 py-3">
                    <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200">
                      {{ __('Demandes associées') }} ({{ count($selectedDemande->demandes) }})
                    </h3>
                  </div>

                  <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                      <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr>
                          <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('ID') }}
                          </th>
                          <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('Titre') }}
                          </th>
                          <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('Responsable') }}
                          </th>
                          <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('Date') }}
                          </th>
                          <th scope="col" class="relative px-4 py-3">
                            <span class="sr-only">{{ __('Actions') }}</span>
                          </th>
                        </tr>
                      </thead>
                      <tbody class="bg-white dark:bg-gray-700 divide-y divide-gray-200 dark:divide-gray-600">
                        @foreach($selectedDemande->demandes as $sousdemande)
                          <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">
                              {{ $sousdemande->id }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-200">
                              {{ $sousdemande->titre }}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">
                              @if($sousdemande->user)
                                {{ $sousdemande->user->name }} {{ $sousdemande->user->prenom ?? '' }}
                              @else
                                <span class="text-gray-500 dark:text-gray-400 italic">{{ __('Non assigné') }}</span>
                              @endif
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                              @if($sousdemande->created_at)
                                {{ $sousdemande->created_at->format('d/m/Y') }}
                              @else
                                -
                              @endif
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-right text-sm font-medium">
                              <a href="{{ route('demande', $sousdemande->id) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                                {{ __('Voir') }}
                              </a>
                            </td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
              @endif

            @else
              <div class="bg-yellow-50 dark:bg-yellow-900/30 border-l-4 border-yellow-400 p-4 rounded-md">
                <div class="flex">
                  <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                      <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                  </div>
                  <div class="ml-3">
                    <p class="text-sm text-yellow-700 dark:text-yellow-200">
                      {{ __('Aucune demande sélectionnée ou la demande n\'existe pas.') }}
                    </p>
                    <div class="mt-4">
                      <a href="{{ route('demande.add-demande') }}" class="inline-flex items-center px-4 py-2 bg-yellow-100 dark:bg-yellow-800 border border-transparent rounded-md font-semibold text-xs text-yellow-700 dark:text-yellow-200 uppercase tracking-widest hover:bg-yellow-200 dark:hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 dark:focus:ring-offset-gray-800 transition">
                        {{ __('Créer une nouvelle demande') }}
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            @endif
          </main>
        </div>
      </div>
    </div>
  </div>

  {{-- Script pour filtrer les demandes dans la barre latérale --}}
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const searchInput = document.getElementById('search-demandes');
      if (searchInput) {
        searchInput.addEventListener('input', function(e) {
          const searchValue = e.target.value.toLowerCase();
          const demandesList = document.querySelectorAll('#demandes-list a');

          demandesList.forEach(function(item) {
            const text = item.textContent.toLowerCase();
            if (text.includes(searchValue)) {
              item.style.display = '';
            } else {
              item.style.display = 'none';
            }
          });
        });
      }
    });
  </script>
</x-app-layout>
