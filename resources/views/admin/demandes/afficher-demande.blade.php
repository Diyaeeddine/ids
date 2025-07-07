<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Détails de la demande #:id', ['id' => $demandeUser->demande->id]) }}
            </h2>
            <a href="{{ route('admin.demandes.decision') }}"
                class="inline-flex items-center px-4 py-2.5 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl font-medium text-sm text-gray-700 dark:text-gray-300 shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-all duration-200 group">
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="h-4 w-4 mr-2 group-hover:-translate-x-1 transition-transform duration-200" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                {{ __('Retour') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    {{-- Header with User Icon and Dates --}}
                    <div class="mb-6 flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div
                                class="w-12 h-12 bg-amber-100 dark:bg-amber-900 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-amber-600 dark:text-amber-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <h1
                                    class="text-2xl font-bold text-gray-900 dark:text-gray-100 leading-tight">
                                    {{ __('Demande #:id', ['id' => $demandeUser->demande->id]) }}
                                </h1>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ __('Soumise le :date', ['date' => $demandeUser->demande->created_at?->format('d/m/Y H:i') ?? __('N/A')]) }}
                                </p>
                            </div>
                        </div>
                        <span
                            class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-amber-100 text-amber-800 dark:bg-amber-900 dark:text-amber-200">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            {{ __('En attente de validation') }}
                        </span>
                    </div>

                    {{-- Demandeur Info --}}
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                            {{ __('Informations du demandeur') }}
                        </h3>
                        <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-4">
                            <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                        {{ __('Nom') }}
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                        {{ $demandeUser->user->name ?? __('N/A') }}
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                        {{ __('ID Utilisateur') }}
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                        {{ $demandeUser->user->id ?? __('N/A') }}
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    {{-- Champs filtered for this user --}}
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                            {{ __('Champs remplis par l\'utilisateur') }}
                        </h3>
                        <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-4">
                            @php
                                $userChamps = collect($demandeUser->demande->champs ?? [])
                                    ->filter(fn($champ) => isset($champ['user_id']) && $champ['user_id'] == $demandeUser->user->id);
                            @endphp

                            @if($userChamps->isNotEmpty())
                                <dl class="space-y-4">
                                    @foreach ($userChamps as $key => $champ)
                                        @if(is_array($champ) && isset($champ['value']))
                                            <div
                                                class="border-b border-gray-200 dark:border-gray-700 pb-4 last:border-b-0 last:pb-0">
                                                <dt
                                                    class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">
                                                    {{ ucfirst(str_replace('_', ' ', $key)) }}
                                                </dt>
                                                <dd class="text-sm text-gray-900 dark:text-gray-100">
                                                    @if (empty($champ['value']))
                                                        <span
                                                            class="italic text-gray-500 dark:text-gray-400">{{ __('Non rempli') }}</span>
                                                    @else
                                                        {{ $champ['value'] }}
                                                    @endif
                                                </dd>
                                            </div>
                                        @endif
                                    @endforeach
                                </dl>
                            @else
                                <p
                                    class="text-gray-500 dark:text-gray-400 italic">{{ __('Aucun champ rempli par cet utilisateur.') }}</p>
                            @endif
                        </div>
                    </div>

                    {{-- Accept / Refuse Buttons --}}
                    <div
                        class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <form method="POST" action="{{ route('admin.demandes.refuser', [$demandeUser->demande->id, $demandeUser->user->id]) }}"
                            class="inline w-full"
                            onsubmit="return confirm('Êtes-vous sûr de vouloir refuser cette demande ?')">
                          @csrf
                      
                          <div class="mb-4 w-full"> <!-- Assurez-vous que ce parent utilise w-full -->
                              <label for="motif_refus
                              " class="block text-sm font-medium text-gray-700 mb-2">
                                  Motif du refus (obligatoire)
                              </label>
                              <textarea
                                  name="motif_refus"
                                  id="motif_refus"
                                  rows="4"
                                  class="mt-1 block w-full max-w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                  placeholder="Veuillez indiquer les modifications demandées ou le motif du refus..."
                                  required
                                  minlength="10"
                                  maxlength="1000">{{ old('motif_refus') }}</textarea>
                      
                              @error('motif_refus')
                                  <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                              @enderror
                          </div>
                      
                          <button type="submit"
                                  class="inline-flex items-center px-6 py-3 bg-red-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-900 focus:outline-none focus:border-red-900 focus:ring focus:ring-red-300 disabled:opacity-25 transition ease-in-out duration-150">
                              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                              </svg>
                              {{ __('Refuser la demande') }}
                          </button>
                      </form>
                        <form method="POST" action="{{ route('admin.demandes.accepter', [$demandeUser->demande->id, $demandeUser->user->id]) }}"
                            class="inline">
                            @csrf
                            <button type="submit"
                                onclick="return confirm('{{ __('Êtes-vous sûr de vouloir accepter cette demande ?') }}')"
                                class="inline-flex items-center px-6 py-3 bg-green-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring focus:ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                {{ __('Accepter la demande') }}
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
