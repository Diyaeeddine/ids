<title>Tableau de bord - Bouregreg Marina</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
<link href="https://fonts.googleapis.com/css2?family=Figtree&display=swap" rel="stylesheet" />
<script src="https://cdn.tailwindcss.com"></script>

<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                <i class="fas fa-tachometer-alt mr-2"></i>
                {{ __('Tableau de bord') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6 px-4 sm:px-6 lg:px-8" id="tresorier-dashboard">
        <!-- Metrics Section -->
        <div class="mb-8">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4 flex items-center">
                <i class="fas fa-chart-bar text-indigo-600 mr-2"></i>
                Vue d'ensemble
            </h3>

            @php
    $colorClasses = [
        'blue' => 'from-blue-500 to-blue-600',
        'emerald' => 'from-emerald-500 to-emerald-600',
        'purple' => 'from-purple-500 to-purple-600'
    ];
@endphp

<div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
    @foreach($metrics as $metric)
        @php 
            $gradientClass = $colorClasses[$metric['color']] ?? 'from-gray-500 to-gray-600';
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
            box-shadow: 0 10px 25px -3px rgba(0, 0, 0, 0.1),
                        0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        @media (max-width: 640px) {
            .metric-card {
                padding: 1rem;
            }
        }
    </style>
</x-app-layout>
