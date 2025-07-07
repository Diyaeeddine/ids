<title>Tableau de bord - Bouregreg Marina</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />

<x-app-layout>
    <x-slot name="header">

        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            <i class="fas fa-tachometer-alt mr-2"></i>
            {{ __('Tableau de bord') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium">Bonjour, {{ Auth::user()->name }} !</h3>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Bienvenue sur votre tableau de bord.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg p-6 flex items-center">
                    <div class="bg-blue-100 dark:bg-blue-900/50 p-4 rounded-full">
                        <i class="fas fa-file-contract fa-2x text-blue-500"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Contrats Totals</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $contractCount ?? '------' }}</p>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg p-6 flex items-center">
                    <div class="bg-green-100  p-4 rounded-full">
                        <i class="fas fa-file-invoice-dollar fa-2x text-green-500"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Factures Totales</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $invoiceCount ?? '------' }}</p>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg p-6 flex items-center">
                    <div class="bg-red-100 dark:bg-red-900/50 p-4 rounded-full">
                        <i class="fas fa-exclamation-triangle fa-2x text-red-500"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Factures Impayées</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $unpaidInvoicesCount ?? '------------' }}</p>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg p-6 flex items-center">
                    <div class="bg-yellow-100 dark:bg-yellow-900/50 p-4 rounded-full">
                        <i class="fas fa-wallet fa-2x text-yellow-500"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Montant Dû</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ number_format($totalOwed, 2, ',', ' ') }} DH</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-1 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Actions Rapides</h3>
                    <div class="space-y-3">
                        <a href="{{ route('contrats.create') }}" class="w-full flex items-center justify-center px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-sm transition">
                            <i class="fas fa-plus mr-2"></i> Créer un Contrat
                        </a>
                        <a href="{{ route('plaisance.contrats') }}" class="w-full flex items-center justify-center px-4 py-3 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-lg shadow-sm transition">
                            <i class="fas fa-list-ul mr-2"></i> Voir les Contrats
                        </a>
                        <a href="{{ route('plaisance.factures.index') }}" class="w-full flex items-center justify-center px-4 py-3 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-lg shadow-sm transition">
                            <i class="fas fa-list-ul mr-2"></i> Voir les Factures
                        </a>
                    </div>
                </div>

                <div class="lg:col-span-2 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Contrats Récents</h3>
                    <div class="space-y-4">
                        @forelse($recentContrats as $contrat)
                            <div class="flex justify-between items-center border-b dark:border-gray-700 pb-2">
                                <div>
                                    <p class="font-semibold text-gray-800 dark:text-gray-200">Contrat #{{ $contrat->id }} - {{ $contrat->navire?->nom ?? 'N/A' }}</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        Du {{ \Carbon\Carbon::parse($contrat->date_debut)->format('d/m/y') }} au {{ \Carbon\Carbon::parse($contrat->date_fin)->format('d/m/y') }}
                                    </p>
                                </div>
                                <div>
                                    @if($contrat->type === 'accostage')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Accostage</span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-white-800">Randonnée</span>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-gray-500 dark:text-gray-400 py-4">Aucun contrat récent à afficher.</p>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>