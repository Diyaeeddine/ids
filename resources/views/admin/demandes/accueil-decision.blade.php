<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white tracking-tight">
                {{ __('Boîte de Décision') }}
            </h2>
            <a href="{{ route('admin.dashboard') }}"
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

    <div class="py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-4">
                <div class="group bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-blue-200 dark:border-blue-800 overflow-hidden hover:shadow-2xl transition-all duration-300 transform">
                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
                        <div class="flex items-center justify-between">
                            <h3 class="text-xl font-bold text-white flex items-center">
                                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Demandes
                            </h3>
                            <span class="bg-white/20 text-white rounded-full px-3 py-1 text-gray-500 dark:text-gray-400">
                                Total généré: {{$demandes_total ?? 'N/A'}}
                            </span>
                        </div>
                    </div>      
                    <div class="text-center py-12 bg-blue-50 dark:bg-blue-900/20">
                        <div class="w-full h-12 mx-auto flex flex-col items-center justify-center">
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">En attente de traitement</p>
                            <p class="text-3xl font-bold text-blue-600 dark:text-blue-400 mb-3">{{$demandes_attente_traiter ?? 'N/A'}}</p>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                            Demandes à traiter
                        </h4>
                        <div class="text-xs  mb-4">        
                            <span class="text-gray-500 dark:text-gray-400">Total traité: {{$demandes_traiter ?? 'N/A'}} </span>
                        </div>
                        <a href="{{route('admin.demandes.decision')}}">
                            <button class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                           Traiter les demandes
                         </button>
                        </a>
                    </div>
                </div>
                <div class="group bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-green-200 dark:border-green-800 overflow-hidden hover:shadow-2xl transition-all duration-300 transform">
                    <div class="bg-gradient-to-r from-green-500 to-green-600 px-6 py-4">
                        <div class="flex items-center justify-between">
                            <h3 class="text-xl font-bold text-white flex items-center">
                                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Ordres de Paiement (OP)
                            </h3>                            
                            <span class="bg-white/20 text-white rounded-full px-3 py-1 text-gray-500 dark:text-gray-400">
                                Total généré: {{$op_total ?? 'N/A'}}
                            </span>
                        </div>
                    </div>
                    <div class="text-center py-12 bg-green-50 dark:bg-green-900/20">
                        <div class="w-full h-12 mx-auto flex flex-col items-center justify-center">
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">En attente de traitement</p>
                            <p class="text-3xl font-bold text-green-600 dark:text-green-400 mb-3">{{$op_attente_traiter ?? 'N/A'}}</p>
                        </div>
                        
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                            OP à traiter
                        </h4>
                        <div class="text-xs text-gray-500 dark:text-gray-400 mb-4">
                            <span>Total traité: {{$op_traiter ?? 'N/A'}}</span>
                        </div>
                        <a href="{{route('admin.demandes.traiterOP')}}"><button class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Traiter les OP
                         </button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>