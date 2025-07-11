{{-- Results Section --}}

@php
    $searchUser = $searchUser ?? null;
    $dateSubmission = $dateSubmission ?? null;
    $typeEconomique = $typeEconomique ?? null;
@endphp

@if($demandes_acc->isEmpty())
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-12 text-center">
            <div class="flex flex-col items-center">
                <svg class="w-16 h-16 text-gray-400 dark:text-gray-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <p class="text-gray-600 dark:text-gray-400 text-lg font-medium">
                    {{ ($searchUser || $dateSubmission || ($typeEconomique && $typeEconomique !== 'all'))
                        ? __('Aucune demande ne correspond à votre recherche')
                        : __('Aucune demande acceptée pour l\'instant') }}
                </p>
                <p class="text-gray-500 dark:text-gray-500 text-sm mt-1">
                    {{ ($searchUser || $dateSubmission || ($typeEconomique && $typeEconomique !== 'all'))
                        ? __('Essayez d\'ajuster les filtres de recherche')
                        : __('Aucune demande n\'a encore été acceptée') }}
                </p>
            </div>
        </div>
    </div>
@else
    <div class="space-y-6">
        @foreach($demandes_acc as $demandeUser)
            @php
                $typeEconomique = $demandeUser->demande->type_economique ?? 'produit';
                $statusConfig = [
                    'produit' => [
                        'label' => __('Produit'),
                        'bgClass' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                        'borderClass' => 'border-green-400',
                        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"></path>'
                    ],
                    'charge' => [
                        'label' => __('Charge'),
                        'bgClass' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                        'borderClass' => 'border-red-400',
                        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>'
                    ]
                ];
                $currentStatus = $statusConfig[$typeEconomique] ?? $statusConfig['produit'];
            @endphp
            
            <div class="bg-white dark:bg-gray-800 overflow-hidden hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150 shadow-sm sm:rounded-lg border-l-4 {{ $currentStatus['borderClass'] }}">
                <div class="p-6">
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
                                        @if($demandeUser->demande->type_economique)
                                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                                <span class="font-medium">{{ __('Type:') }}</span>
                                                <span class="capitalize">{{ $demandeUser->demande->type_economique }}</span>
                                            </p>
                                        @endif
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
                                    <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        {!! $currentStatus['icon'] !!}
                                    </svg>
                                    {{ $currentStatus['label'] }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    
    <div class="mt-6 text-center">
        <p class="text-sm text-gray-600 dark:text-gray-400">
            {{ __('Total: :count demande(s) trouvée(s)', ['count' => $demandes_acc->count()]) }}
        </p>
    </div>
@endif