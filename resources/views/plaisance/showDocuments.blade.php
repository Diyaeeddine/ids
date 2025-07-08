<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Documents reçus pour la demande : ') }} {{ $demande->titre }}
        </h2>
        <a href="{{route('plaisance.demandes')}}" class="inline-flex items-center px-4 py-2.5 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl font-medium text-sm text-gray-700 dark:text-gray-300 shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-all duration-200 group">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 group-hover:-translate-x-1 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Retour
        </a>
    </div>
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

        @if($demande->type_economique == 'produit' && $demandeUser && $demandeUser->etape == 'acceptee')
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                            🏷 Documents liés au produit
                        </h3>
                        <span class="bg-purple-100 text-purple-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-purple-900 dark:text-purple-300">
                            Générés automatiquement
                        </span>
                    </div>

                    <div class="grid gap-3">
                        <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div class="flex items-center">
                                <span class="text-2xl mr-3">📋</span>
                                <div>
                                    <div class="text-sm font-medium text-gray-900 dark:text-gray-200">Contrat</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">Document contractuel</div>
                                </div>
                            </div>
                            <div class="flex space-x-2">
                                <a href="{{ route('voir.fichier', ['filename' => $demande->id . '-contrat.pdf']) }}"
                                   target="_blank"
                                   class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-purple-700 bg-purple-100 hover:bg-purple-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                                    Voir
                                </a>
                                <a href="{{ route('plaisance.imprimer.fichier', ['filename' => $demande->id . '-contrat.pdf']) }}"
                                   target="_blank"
                                   class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-purple-700 bg-purple-50 hover:bg-purple-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                                    Imprimer
                                </a>
                            </div>
                        </div>

                        <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div class="flex items-center">
                                <span class="text-2xl mr-3">🧾</span>
                                <div>
                                    <div class="text-sm font-medium text-gray-900 dark:text-gray-200">Facture</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">Document de facturation</div>
                                </div>
                            </div>
                            <div class="flex space-x-2">
                                <a href="{{ route('voir.fichier', ['filename' => $demande->id . '-facture.pdf']) }}"
                                   target="_blank"
                                   class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-purple-700 bg-purple-100 hover:bg-purple-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                                    Voir
                                </a>
                                <a href="{{ route('plaisance.imprimer.fichier', ['filename' => $demande->id . '-facture.pdf']) }}"
                                   target="_blank"
                                   class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-purple-700 bg-purple-50 hover:bg-purple-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                                    Imprimer
                                </a>
                            </div>
                        </div>

                        <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div class="flex items-center">
                                <span class="text-2xl mr-3">🧾</span>
                                <div>
                                    <div class="text-sm font-medium text-gray-900 dark:text-gray-200">Reçu de Paiement</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">Justificatif de paiement</div>
                                </div>
                            </div>
                            <div class="flex space-x-2">
                                <a href="{{ route('voir.fichier', ['filename' => $demande->id . '-recu.pdf']) }}"
                                   target="_blank"
                                   class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-purple-700 bg-purple-100 hover:bg-purple-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                                    Voir
                                </a>
                                <a href="{{ route('plaisance.imprimer.fichier', ['filename' => $demande->id . '-recu.pdf']) }}"
                                   target="_blank"
                                   class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-purple-700 bg-purple-50 hover:bg-purple-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                                    Imprimer
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if($demande->type_economique == 'charge' && $demandeUser && $demandeUser->etape == 'acceptee')
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                            💼 Documents liés à la charge
                        </h3>
                        <span class="bg-orange-100 text-orange-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-orange-900 dark:text-orange-300">
                            Générés automatiquement
                        </span>
                    </div>

                    <div class="grid gap-3">
                        <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div class="flex items-center">
                                <span class="text-2xl mr-3">📋</span>
                                <div>
                                    <div class="text-sm font-medium text-gray-900 dark:text-gray-200">Bon de Commande</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">Document de commande</div>
                                </div>
                            </div>
                            <div class="flex space-x-2">
                                <a href="{{ route('voir.fichier', ['filename' => $demande->id . '-bon-de-commande.pdf']) }}"
                                   target="_blank"
                                   class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-orange-700 bg-orange-100 hover:bg-orange-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                                    Voir
                                </a>
                                <a href="{{ route('plaisance.imprimer.fichier', ['filename' => $demande->id . '-bon-de-commande.pdf']) }}"
                                   target="_blank"
                                   class="inline-flex items-c   enter px-3 py-1 border border-transparent text-sm font-medium rounded-md text-orange-700 bg-orange-50 hover:bg-orange-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                                    Imprimer
                                </a>
                            </div>
                        </div>

                        <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div class="flex items-center">
                                <span class="text-2xl mr-3">🏢</span>
                                <div>
                                    <div class="text-sm font-medium text-gray-900 dark:text-gray-200">Marché</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">Document de marché public</div>
                                </div>
                            </div>
                            <div class="flex space-x-2">
                                <a href="{{ route('voir.fichier', ['filename' => $demande->id . '-marche.pdf']) }}"
                                   target="_blank"
                                   class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-orange-700 bg-orange-100 hover:bg-orange-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                                    Voir
                                </a>
                                <a href="{{ route('plaisance.imprimer.fichier', ['filename' => $demande->id . '-marche.pdf']) }}"
                                   target="_blank"
                                   class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-orange-700 bg-orange-50 hover:bg-orange-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                                    Imprimer
                                </a>
                            </div>
                        </div>

                        <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div class="flex items-center">
                                <span class="text-2xl mr-3">📝</span>
                                <div>
                                    <div class="text-sm font-medium text-gray-900 dark:text-gray-200">Contrat</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">Document contractuel</div>
                                </div>
                            </div>
                            <div class="flex space-x-2">
                                <a href="{{ route('voir.fichier', ['filename' => $demande->id . '-contrat-charge.pdf']) }}"
                                   target="_blank"
                                   class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-orange-700 bg-orange-100 hover:bg-orange-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                                    Voir
                                </a>
                                <a href="{{ route('plaisance.imprimer', ['demandeId' => $demande->id]) }}"
                                   target="_blank"
                                   class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-orange-700 bg-orange-50 hover:bg-orange-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                                    Imprimer
                                </a>
                            </div>
                        </div>

                        <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div class="flex items-center">
                                <span class="text-2xl mr-3">🔧</span>
                                <div>
                                    <div class="text-sm font-medium text-gray-900 dark:text-gray-200">Prestation de Services</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">Document de prestation</div>
                                </div>
                            </div>
                            <div class="flex space-x-2">
                                <a href="{{ route('voir.fichier', ['filename' => $demande->id . '-prestation-services.pdf']) }}"
                                   target="_blank"
                                   class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-orange-700 bg-orange-100 hover:bg-orange-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                                    Voir
                                </a>
                                <a href="{{ route('plaisance.imprimer.fichier', ['filename' => $demande->id . '-prestation-services.pdf']) }}"
                                   target="_blank"
                                   class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-orange-700 bg-orange-50 hover:bg-orange-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                                    Imprimer
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        </div>
    </div>
</x-app-layout>