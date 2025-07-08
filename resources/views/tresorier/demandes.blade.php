<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Demandes Validées') }}
            </h2>
            <a href="{{ route('tresorier.dashboard') }}" class="inline-flex items-center px-4 py-2.5 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl font-medium text-sm text-gray-700 dark:text-gray-300 shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-all duration-200 group">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 group-hover:-translate-x-1 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                {{ __('Retour') }}
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Filter Form --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-4 mb-6">
                <form method="GET" action="{{ route('tresorier.demandes.search') }}" id="searchForm" class="flex flex-wrap gap-4 items-end">
                    <div class="flex flex-col">
                        <label for="searchUser" class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            {{ __('Nom de l\'utilisateur') }}
                        </label>
                        <input 
                            type="text"
                            name="search_user"
                            id="searchUser"
                            value="{{ $searchUser ?? request('search_user') }}"
                            placeholder="Nom de l'utilisateur"
                            class="px-4 py-2 border rounded-md text-sm w-60 dark:bg-gray-700 dark:text-white dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        >
                    </div>
                    
                    <div class="flex flex-col">
                        <label for="typeFilter" class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            {{ __('Type économique') }}
                        </label>
                        <select name="filter_etape" id="typeFilter" class="px-4 py-2 border rounded-md text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="all">{{ __('Tous les Types') }}</option>
                            <option value="produit" {{ ($typeEconomique ?? request('filter_etape')) == 'produit' ? 'selected' : '' }}>
                                {{ __('Produit') }}
                            </option>
                            <option value="charge" {{ ($typeEconomique ?? request('filter_etape')) == 'charge' ? 'selected' : '' }}>
                                {{ __('Charge') }}
                            </option>
                        </select>
                    </div>
                    
                    <div class="flex flex-col">
                        <label for="dateSubmission" class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            {{ __('Date de soumission') }}
                        </label>
                        <input 
                            type="date"
                            name="date_soumission"
                            id="dateSubmission"
                            value="{{ $dateSubmission ?? request('date_soumission') }}"
                            class="px-4 py-2 border rounded-md text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        >
                    </div>
                    
                    <div class="flex gap-2">
                        <button type="submit" id="searchBtn" class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            <span id="searchBtnText">{{ __('Rechercher') }}</span>
                        </button>
                        
                        <a href="{{ route('tresorier.demandes') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md text-sm hover:bg-gray-600 focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors duration-200">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            {{ __('Effacer') }}
                        </a>
                    </div>
                </form>
            </div>

            {{-- Results Section --}}
            <div id="results">
                @include('tresorier.partials.demandes-results')
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('searchForm');
        const searchBtn = document.getElementById('searchBtn');
        const searchBtnText = document.getElementById('searchBtnText');
        const resultsContainer = document.getElementById('results');

        // Function to show loading state
        function showLoading() {
            searchBtn.disabled = true;
            searchBtnText.textContent = '{{ __("Recherche...") }}';
            searchBtn.classList.add('opacity-75');
        }

        // Function to hide loading state
        function hideLoading() {
            searchBtn.disabled = false;
            searchBtnText.textContent = '{{ __("Rechercher") }}';
            searchBtn.classList.remove('opacity-75');
        }

        // Function to handle form submission
        function handleFormSubmit(e) {
            if (e) e.preventDefault();
            
            showLoading();
            
            const formData = new FormData(form);
            const params = new URLSearchParams(formData).toString();
            const url = form.action + (params ? '?' + params : '');

            fetch(url, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success && data.html) {
                    resultsContainer.innerHTML = data.html;
                } else {
                    throw new Error('Invalid response format');
                }
            })
            .catch(error => {
                console.error('AJAX request failed:', error);
                // Fallback to normal form submission
                form.submit();
            })
            .finally(() => {
                hideLoading();
            });
        }

        // Event listeners
        form.addEventListener('submit', handleFormSubmit);
        
        // Auto-submit on select and date change
        document.getElementById('typeFilter').addEventListener('change', handleFormSubmit);
        document.getElementById('dateSubmission').addEventListener('change', handleFormSubmit);
        
        // Optional: Auto-submit on text input with debounce
        // let searchTimeout;
        // document.getElementById('searchUser').addEventListener('input', function() {
        //     clearTimeout(searchTimeout);
        //     searchTimeout = setTimeout(handleFormSubmit, 500); // 500ms delay
        // });
    });
    </script>
</x-app-layout>
