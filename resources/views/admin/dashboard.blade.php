<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
<title>Accueil - Marina Bouregreg</title>
<script src="https://cdn.tailwindcss.com"></script>

<link href="https://fonts.googleapis.com/css2?family=Figtree&display=swap" rel="stylesheet" />



<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Accueil') }}
            </h2>
            <a href="{{route('admin.demandes.accueil-decision')}}" 
            class="inline-flex items-center px-4 py-2 bg-amber-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-amber-700 active:bg-amber-900 focus:outline-none focus:border-amber-900 focus:ring focus:ring-amber-300 disabled:opacity-25 transition ease-in-out duration-150">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            Boîte de décision
            </a>

        </div>
    </x-slot>

    <div class="py-6 px-4 sm:px-6 lg:px-8" id="dsq">
        <!-- Metrics Section -->
        <div class="mb-8">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4 flex items-center">
                <i class="fas fa-chart-bar text-indigo-600 mr-2"></i>
                Vue d'ensemble
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                @php
                    $metrics = [
                        [
                            'label' => 'Total Demandes',
                            'count' => \App\Models\Demande::count(),
                            'color' => 'blue',
                            'icon' => 'fa-file-alt'
                        ],
                        [
                            'label' => 'Tables Budget',
                            'count' => \App\Models\BudgetTable::count(),
                            'color' => 'emerald',
                            'icon' => 'fa-table'
                        ],
                        [
                            'label' => 'Utilisateurs',
                            'count' => \App\Models\User::count(),
                            'color' => 'purple',
                            'icon' => 'fa-users'
                        ],
                    ];
                @endphp

                @foreach($metrics as $metric)
                    @php 
                        $colorClasses = [
                            'blue' => 'from-blue-500 to-blue-600',
                            'emerald' => 'from-emerald-500 to-emerald-600', 
                            'purple' => 'from-purple-500 to-purple-600'
                        ];
                        $gradientClass = $colorClasses[$metric['color']];
                    @endphp
                    <div class="metric-card bg-gradient-to-br {{ $gradientClass }} rounded-xl p-4 sm:p-5 text-white relative overflow-hidden transform transition-all duration-300 hover:scale-105 hover:shadow-lg">
                        <div class="absolute top-0 right-0 w-16 h-16 bg-white bg-opacity-10 rounded-full -mr-8 -mt-8"></div>
                        <div class="relative z-10">
                            <div class="flex items-center justify-between mb-2">
                                <i class="fas {{ $metric['icon'] }} text-xl sm:text-2xl opacity-80"></i>
                                <span class="text-xl sm:text-2xl lg:text-3xl font-bold">{{ $metric['count'] }}</span>
                            </div>
                            <p class="text-xs sm:text-sm font-medium opacity-90">{{ $metric['label'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Quick Access Section -->
        <div class="mt-8">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4 flex items-center">
                <i class="fas fa-bolt text-indigo-600 mr-2"></i>
                Accès Rapide
            </h3>
            <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 sm:gap-5">
                <a href="{{ route('demande.add-demande') }}"
                   class="quick-access-card group bg-white dark:bg-gray-800 p-5 sm:p-6 rounded-xl shadow-sm hover:shadow-md border border-gray-200 dark:border-gray-700 text-center transition-all duration-200 hover:scale-105">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform">
                        <i class="fas fa-plus text-green-600 dark:text-green-400 text-xl sm:text-2xl"></i>
                    </div>
                    <h4 class="font-semibold text-gray-900 dark:text-white text-sm sm:text-base mb-1">Ajouter Demande</h4>
                    <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 hidden sm:block">Créer une nouvelle demande</p>
                </a>

                <a href="{{ route('budget-tables.create') }}"
                   class="quick-access-card group bg-white dark:bg-gray-800 p-5 sm:p-6 rounded-xl shadow-sm hover:shadow-md border border-gray-200 dark:border-gray-700 text-center transition-all duration-200 hover:scale-105">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform">
                        <i class="fas fa-square-plus text-blue-600 dark:text-blue-400 text-xl sm:text-2xl"></i>
                    </div>
                    <h4 class="font-semibold text-gray-900 dark:text-white text-sm sm:text-base mb-1">Créer Budget</h4>
                    <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 hidden sm:block">Nouvelle table budget</p>
                </a>

                <a href="{{ route('budget-tables.index') }}"
                   class="quick-access-card group bg-white dark:bg-gray-800 p-5 sm:p-6 rounded-xl shadow-sm hover:shadow-md border border-gray-200 dark:border-gray-700 text-center transition-all duration-200 hover:scale-105">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 bg-yellow-100 dark:bg-yellow-900 rounded-lg flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform">
                        <i class="fas fa-table text-yellow-600 dark:text-yellow-400 text-xl sm:text-2xl"></i>
                    </div>
                    <h4 class="font-semibold text-gray-900 dark:text-white text-sm sm:text-base mb-1">Voir Budgets</h4>
                    <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 hidden sm:block">Parcourir toutes les tables</p>
                </a>

                <a href="{{ route('admin.demandes') }}"
                   class="quick-access-card group bg-white dark:bg-gray-800 p-5 sm:p-6 rounded-xl shadow-sm hover:shadow-md border border-gray-200 dark:border-gray-700 text-center transition-all duration-200 hover:scale-105">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 bg-red-100 dark:bg-red-900 rounded-lg flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform">
                        <i class="fas fa-list-check text-red-600 dark:text-red-400 text-xl sm:text-2xl"></i>
                    </div>
                    <h4 class="font-semibold text-gray-900 dark:text-white text-sm sm:text-base mb-1">Gérer Demandes</h4>
                    <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 hidden sm:block">Examiner et traiter</p>
                </a>

                <a href="{{ route('acce.index') }}"
                   class="quick-access-card group bg-white dark:bg-gray-800 p-5 sm:p-6 rounded-xl shadow-sm hover:shadow-md border border-gray-200 dark:border-gray-700 text-center transition-all duration-200 hover:scale-105">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 bg-purple-100 dark:bg-purple-900 rounded-lg flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform">
                        <i class="fas fa-users text-purple-600 dark:text-purple-400 text-xl sm:text-2xl"></i>
                    </div>
                    <h4 class="font-semibold text-gray-900 dark:text-white text-sm sm:text-base mb-1">Gérer Utilisateurs</h4>
                    <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 hidden sm:block">Administration des utilisateurs</p>
                </a>
            </div>
        </div>
    </div>

    <style>
        * {
        font-family: 'Figtree', sans-serif;
    }
        .metric-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .metric-card:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 10px 25px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        
        .quick-access-card {
            transition: all 0.2s ease;
        }
        
        .quick-access-card:hover {
            transform: translateY(-2px);
        }
        
        /* Mobile optimizations */
        @media (max-width: 640px) {
            .metric-card {
                padding: 1rem;
            }
            
            .quick-access-card {
                padding: 1rem;
            }
            
            .quick-access-card h4 {
                font-size: 0.875rem;
            }
        }
    </style>
</x-app-layout>