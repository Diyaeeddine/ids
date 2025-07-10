<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Boîte de décisions') }} - {{ __('Demandes à valider') }}
            </h2>
            <a href="{{ route('admin.demandes.decision') }}" class="inline-flex items-center px-4 py-2.5 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl font-medium text-sm text-gray-700 dark:text-gray-300 shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-all duration-200 group">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 group-hover:-translate-x-1 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                {{ __('Retour') }}
            </a>
        </div>
    </x-slot>
<div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-4">
    <form method="GET" action="{{ route('admin.demandes.showChamps') }}" class="flex flex-wrap gap-4 items-end">
        <input 
            type="text" 
            name="search_user" 
            value="{{ request('search_user') }}" 
            placeholder="Nom de l'utilisateur"
            class="px-4 py-2 border rounded-md text-sm w-60 dark:bg-gray-700 dark:text-white dark:border-gray-600"
        >
    
        <select name="filter_etape" class="px-4 py-2 border rounded-md text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600">
            <option value="">Toutes les étapes</option>
            @foreach(['en_cours_remplissage', 'en_attente_validation', 'modifications_requises', 'acceptee', 'refusee'] as $etape)
                <option value="{{ $etape }}" {{ request('filter_etape') == $etape ? 'selected' : '' }}>
                    {{ __(ucwords(str_replace('_', ' ', $etape))) }}
                </option>
            @endforeach
        </select>
    
        <input 
            type="date" 
            name="date_soumission" 
            value="{{ request('date_soumission') }}" 
            class="px-4 py-2 border rounded-md text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600"
        >
    
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm hover:bg-blue-700">
            Rechercher
        </button>
    </form>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if($demandes->isEmpty())
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-12 text-center">
                        <div class="flex flex-col items-center">
                            <svg class="w-16 h-16 text-gray-400 dark:text-gray-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <p class="text-gray-600 dark:text-gray-400 text-lg font-medium">
                                {{ $totalDemandes > 0 
                                    ? __('Aucune demande ne correspond à votre recherche') 
                                    : __('Aucune demande remplie pour l’instant') }}
                            </p>
                            <p class="text-gray-500 dark:text-gray-500 text-sm mt-1">
                                {{ $totalDemandes > 0 
                                    ? __('Essayez d\'ajuster les filtres de recherche') 
                                    : __('Aucun formulaire n’a encore été rempli par les utilisateurs') }}
                            </p>
                        </div>
                    </div>
                </div>
            @else
            <div class="space-y-6">
                @foreach($demandes as $demandeUser)
                    @php
                        $etape = $demandeUser->etape ?? 'en_cours_remplissage';
                        $statusConfig = [
                            'en_cours_remplissage' => [
                                'label' => __('En cours de remplissage'),
                                'bgClass' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
                                'borderClass' => 'border-blue-400',
                                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>'
                            ],
                            'en_attente_validation' => [
                                'label' => __('En attente de validation'),
                                'bgClass' => 'bg-amber-100 text-amber-800 dark:bg-amber-900 dark:text-amber-200',
                                'borderClass' => 'border-amber-400',
                                'icon' => '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>'
                            ],
                            'modifications_requises' => [
                                'label' => __('Modifications requises'),
                                'bgClass' => 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200',
                                'borderClass' => 'border-orange-400',
                                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z"></path>'
                            ],
                            'acceptee' => [
                                'label' => __('Acceptée'),
                                'bgClass' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                                'borderClass' => 'border-green-400',
                                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>'
                            ],
                            'refusee' => [
                                'label' => __('Refusée'),
                                'bgClass' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                                'borderClass' => 'border-red-400',
                                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>'
                            ]
                        ];
                        $currentStatus = $statusConfig[$etape] ?? $statusConfig['en_cours_remplissage'];
                    @endphp
                    
                    <div class="bg-white dark:bg-gray-800 overflow-hidden hover:bg-slate-200 animation shadow-sm sm:rounded-lg border-l-4 {{ $currentStatus['borderClass'] }}">
                        <div class="p-6 ">
                            <div class="flex items-start justify-between">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <div class="w-12 h-12 bg-amber-100 dark:bg-amber-900 rounded-full flex items-center justify-center">
                                            <svg class="w-6 h-6 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                        </div>
                                    </div>  
                                    <div class="flex-1">
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">
                                            {{ $demandeUser->demande->titre ?? __('Demande sans titre') }}
                                        </h3>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                                    <span class="font-medium">{{ __('Demandeur:') }}</span>
                                                    {{ $demandeUser->user->name ?? __('N/A') }}
                                                </p>
                                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                                    <span class="font-medium">{{ __('Email:') }}</span>
                                                    {{ $demandeUser->user->email ?? __('N/A') }}
                                                </p>
                                            </div>
                                            <div>
                                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                                    <span class="font-medium">{{ __('Date de soumission:') }}</span>
                                                    {{ $demandeUser->updated_at ? $demandeUser->updated_at->format('d/m/Y H:i') : __('N/A') }}
                                                </p>
                                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                                    <span class="font-medium">{{ __('ID Demande:') }}</span>
                                                    #{{ $demandeUser->demande_id }}
                                                </p>
                                            </div>
                                        </div>
                                        @if($demandeUser->demande->description)
                                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-3 line-clamp-2">
                                                {{ Str::limit($demandeUser->demande->description, 150) }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex-shrink-0 ml-4">
                                    <div class="flex flex-col items-end space-y-2">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $currentStatus['bgClass'] }}">
                                            <svg class="w-3 h-3 mr-1.5" fill="{{ $etape === 'en_attente_validation' ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                                                {!! $currentStatus['icon'] !!}
                                            </svg>
                                            {{ $currentStatus['label'] }}
                                        </span>
                                        <div class="flex items-center text-xs text-gray-500 dark:text-gray-400">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ __('Cliquer pour voir les détails') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    {{ __('Total: :count demande(s) en attente de validation', ['count' => $demandes->count()]) }}
                </p>
            </div>

            @endif
        </div>
    </div>
</x-app-layout>