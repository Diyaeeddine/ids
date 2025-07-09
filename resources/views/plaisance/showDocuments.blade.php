<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Documents reçus pour la demande : ') }} {{ $demande->titre }}
        </h2>
    </x-slot>

<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                        📎 Fichiers envoyés avec le formulaire
                    </h3>
                    <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">
                        {{ $fichiersEnvoyes->count() }} fichier(s)
                    </span>
                </div>

                @if($fichiersEnvoyes->isEmpty())
                    <div class="text-center py-8">
                        <div class="text-gray-400 dark:text-gray-600 text-4xl mb-4">📎</div>
                        <p class="text-gray-500 dark:text-gray-400">Aucun fichier envoyé avec le formulaire.</p>
                    </div>
                @else
                    <div class="grid gap-3">
                        @foreach($fichiersEnvoyes as $fichier)
                            <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div class="flex items-center">
                                    <span class="text-2xl mr-3">📎</span>
                                    <span class="text-sm font-medium text-gray-900 dark:text-gray-200">
                                        {{ $fichier->file_name }}
                                    </span>
                                </div>

                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('telecharger.fichier', ['filename' => $fichier->file_name]) }}"
                                       class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-sky-700 bg-sky-100 hover:bg-sky-200 dark:bg-sky-800 dark:text-sky-200 dark:hover:bg-sky-700 rounded-md transition-colors duration-200">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        Télécharger
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        @php
            $typesFormulaires = [];
            if (isset($demande->champs) && is_array($demande->champs)) {
                foreach ($demande->champs as $champ) {
                    if (isset($champ['type_form']) && !empty($champ['type_form'])) {
                        $typesFormulaires[] = $champ['type_form'];
                    }
                }
            }
            $typesFormulaires = array_unique($typesFormulaires);

            $documentsConfig = [
                'contrat' => [
                    'icon' => '📋',
                    'title' => 'Contrat',
                    'description' => 'Document contractuel',
                    'filename' => $demande->id . '-contrat.pdf',
                    'color' => 'purple'
                ],
                'facture' => [
                    'icon' => '🧾',
                    'title' => 'Facture',
                    'description' => 'Document de facturation',
                    'filename' => $demande->id . '-facture.pdf',
                    'color' => 'green'
                ],
                'op' => [
                    'icon' => '💳',
                    'title' => 'Ordre de Paiement',
                    'description' => 'Document de paiement',
                    'filename' => $demande->id . '-op.pdf',
                    'color' => 'blue'
                ],
                'ov' => [
                    'icon' => '🔄',
                    'title' => 'Ordre de Virement',
                    'description' => 'Document de virement',
                    'filename' => $demande->id . '-ov.pdf',
                    'color' => 'indigo'
                ],
                'bon_commande' => [
                    'icon' => '📋',
                    'title' => 'Bon de Commande',
                    'description' => 'Document de commande',
                    'filename' => $demande->id . '-bon-de-commande.pdf',
                    'color' => 'orange'
                ],
                'recu_p' => [
                    'icon' => '🧾',
                    'title' => 'Reçu de Paiement',
                    'description' => 'Justificatif de paiement',
                    'filename' => $demande->id . '-recu.pdf',
                    'color' => 'purple'
                ],
                'prestation' => [
                    'icon' => '🔧',
                    'title' => 'Prestation de Services',
                    'description' => 'Document de prestation',
                    'filename' => $demande->id . '-prestation-services.pdf',
                    'color' => 'orange'
                ],
                'marche' => [
                    'icon' => '🏢',
                    'title' => 'Marché',
                    'description' => 'Document de marché public',
                    'filename' => $demande->id . '-marche.pdf',
                    'color' => 'orange'
                ]
            ];
        @endphp

        @if(!empty($typesFormulaires) && $demandeUser && $demandeUser->etape == 'acceptee')
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                            📄 Documents générés
                        </h3>
                        <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">
                            {{ count($typesFormulaires) }} document(s) disponible(s)
                        </span>
                    </div>

                    <div class="grid gap-3">
                        @foreach($typesFormulaires as $typeForm)
                            @if(isset($documentsConfig[$typeForm]))
                                @php
                                    $config = $documentsConfig[$typeForm];
                                @endphp
                                <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <div class="flex items-center">
                                        <span class="text-2xl mr-3">{{ $config['icon'] }}</span>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900 dark:text-gray-200">
                                                {{ $config['title'] }}
                                            </div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ $config['description'] }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex space-x-2">
                                        <a href="{{ route('voir.fichier', ['filename' => $config['filename']]) }}"
                                           target="_blank"
                                           class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-{{ $config['color'] }}-700 bg-{{ $config['color'] }}-100 hover:bg-{{ $config['color'] }}-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-{{ $config['color'] }}-500">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            Voir
                                        </a>
                                        <a href="{{ route('plaisance.imprimer.fichier', ['filename' => $config['filename']]) }}"
                                           target="_blank"
                                           class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-{{ $config['color'] }}-700 bg-{{ $config['color'] }}-50 hover:bg-{{ $config['color'] }}-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-{{ $config['color'] }}-500">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H9.5a2 2 0 01-2-2V5a2 2 0 012-2h5.5a2 2 0 002 2v2a2 2 0 002 2h2a2 2 0 002 2v4a2 2 0 01-2 2h-2m-6-4h6m-6 4h6"></path>
                                            </svg>
                                            Imprimer
                                        </a>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        @if(empty($typesFormulaires) && $demandeUser && $demandeUser->etape == 'acceptee')
            @if($demande->type_economique == 'produit')
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                                🏷 Documents liés au produit
                            </h3>
                            <span class="bg-purple-100 text-purple-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-purple-900 dark:text-purple-300">
                                Type économique : Produit
                            </span>
                        </div>

                        <div class="grid gap-3">
                            @foreach(['contrat', 'facture', 'recu_p'] as $typeDoc)
                                @if(isset($documentsConfig[$typeDoc]))
                                    @php $config = $documentsConfig[$typeDoc]; @endphp
                                    <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                        <div class="flex items-center">
                                            <span class="text-2xl mr-3">{{ $config['icon'] }}</span>
                                            <div>
                                                <div class="text-sm font-medium text-gray-900 dark:text-gray-200">{{ $config['title'] }}</div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400">{{ $config['description'] }}</div>
                                            </div>
                                        </div>
                                        <div class="flex space-x-2">
                                            <a href="{{ route('voir.fichier', ['filename' => $config['filename']]) }}" target="_blank"
                                               class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-purple-700 bg-purple-100 hover:bg-purple-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                                                Voir
                                            </a>
                                            <a href="{{ route('imprimer.fichier', ['filename' => $config['filename']]) }}" target="_blank"
                                               class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-purple-700 bg-purple-50 hover:bg-purple-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                                                Imprimer
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            @if($demande->type_economique == 'charge')
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                                💼 Documents liés à la charge
                            </h3>
                            <span class="bg-orange-100 text-orange-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-orange-900 dark:text-orange-300">
                                Type économique : Charge
                            </span>
                        </div>

                        <div class="grid gap-3">
                            @foreach(['bon_commande', 'marche'] as $typeDoc)
                                @if(isset($documentsConfig[$typeDoc]))
                                    @php $config = $documentsConfig[$typeDoc]; @endphp
                                    <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                        <div class="flex items-center">
                                            <span class="text-2xl mr-3">{{ $config['icon'] }}</span>
                                            <div>
                                                <div class="text-sm font-medium text-gray-900 dark:text-gray-200">{{ $config['title'] }}</div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400">{{ $config['description'] }}</div>
                                            </div>
                                        </div>
                                        <div class="flex space-x-2">
                                            <a href="{{ route('voir.fichier', ['filename' => $config['filename']]) }}" target="_blank"
                                               class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-orange-700 bg-orange-100 hover:bg-orange-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                                                Voir
                                            </a>
                                            <a href="{{ route('imprimer.fichier', ['filename' => $config['filename']]) }}" target="_blank"
                                               class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-orange-700 bg-orange-50 hover:bg-orange-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                                                Imprimer
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        @endif

        @if((!$demandeUser || $demandeUser->etape != 'acceptee') && empty($typesFormulaires))
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="text-center py-8">
                        <div class="text-gray-400 dark:text-gray-600 text-4xl mb-4">📄</div>
                        <p class="text-gray-500 dark:text-gray-400">
                            Les documents générés seront disponibles une fois que votre demande sera acceptée.
                        </p>
                    </div>
                </div>  
            </div>
        @endif

    </div>
</div>
</x-app-layout>