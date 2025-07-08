<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            {{-- Left: Page Title --}}
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Ordres de Virement') }}
            </h2>
                        
            {{-- Right: Create Button --}}
            <button onclick="openModal()" class="inline-flex items-center px-4 py-2.5 bg-blue-600 text-white rounded-xl font-medium text-sm shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200">
                {{ __('Créer un ordre de virement') }}
            </button>
        </div>
    </x-slot>

    <!-- Modal - Hidden by default -->
    <div id="createModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-2xl p-6 relative max-h-[90vh] overflow-y-auto">
            <button onclick="closeModal()" class="absolute top-4 right-4 text-gray-500 hover:text-red-500 text-2xl leading-none z-10">&times;</button>
                        
            <h2 class="text-xl font-bold mb-6 text-gray-800 dark:text-white">{{ __('Créer un Ordre de Virement') }}</h2>
                        
            <form action="{{ route('tresorier.ov.store') }}" method="POST" class="space-y-4">
                @csrf
                                
                <!-- N° Ordre Paiement (ID OP) -->
                <div>
                    <label for="id_op" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        N° Ordre Pai<span class="text-red-500">*</span>
                    </label>
                    <select name="id_op" id="id_op" required class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        @foreach($op_ids as $id => $label)
                            <option value="{{ $id }}">{{ $id }}-{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Date de Virement -->
                    <div>
                        <label for="date_virement" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Date de Virement <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="date_virement" id="date_virement" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                                        
                    <!-- Montant -->
                    <div>
                        <label for="montant" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Montant <span class="text-red-500">*</span>
                        </label>
                        <input type="number" step="0.01" name="montant" id="montant" required
                               placeholder="0.00"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                                        
                    <!-- Compte Débiteur -->
                    <div>
                        <label for="compte_debiteur" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Compte Débiteur <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="compte_debiteur" id="compte_debiteur" required
                               placeholder="Numéro de compte"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                                        
                    <!-- Nom du Bénéficiaire -->
                    <div>
                        <label for="beneficiaire_nom" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Nom du Bénéficiaire <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="beneficiaire_nom" id="beneficiaire_nom" required
                               placeholder="Nom complet du bénéficiaire"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                                        
                    <!-- RIB du Bénéficiaire -->
                    <div>
                        <label for="beneficiaire_rib" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            RIB du Bénéficiaire <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="beneficiaire_rib" id="beneficiaire_rib" required
                               placeholder="RIB du bénéficiaire"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                                        
                    <!-- Banque du Bénéficiaire -->
                    <div>
                        <label for="beneficiaire_banque" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Banque du Bénéficiaire <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="beneficiaire_banque" id="beneficiaire_banque" required
                               placeholder="Nom de la banque"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                                        
                    <!-- Agence du Bénéficiaire -->
                    <div>
                        <label for="beneficiaire_agence" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Agence du Bénéficiaire <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="beneficiaire_agence" id="beneficiaire_agence" required
                               placeholder="Nom de l'agence"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                </div>
                                
                <!-- Objet -->
                <div>
                    <label for="objet" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Objet <span class="text-red-500">*</span>
                    </label>
                    <textarea name="objet" id="objet" rows="3" required
                              placeholder="Motif du virement..."
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white resize-none"></textarea>
                </div>
                                
                <!-- Form Actions -->
                <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200 dark:border-gray-600">
                    <button type="button" onclick="closeModal()"
                            class="px-4 py-2 text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 dark:bg-gray-600 dark:text-gray-300 dark:hover:bg-gray-500 transition-colors duration-200">
                        {{ __('Annuler') }}
                    </button>
                    <button type="submit"
                            class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200">
                        {{ __('Enregistrer') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- VIEW MODAL - Add this missing modal -->
    <div id="viewModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-2xl p-6 relative max-h-[90vh] overflow-y-auto">
            <button onclick="closeViewModal()" class="absolute top-4 right-4 text-gray-500 hover:text-red-500 text-2xl leading-none z-10">&times;</button>
            
            <h2 class="text-xl font-bold mb-6 text-gray-800 dark:text-white">{{ __('Ordre de Virement') }}</h2>
            
            <form id="viewForm" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">N° Ordre Paiement</label>
                    <input type="text" id="view_id_op" readonly class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Date de Virement</label>
                        <input type="text" id="view_date_virement" readonly class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Montant</label>
                        <input type="text" id="view_montant" readonly class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Compte Débiteur</label>
                        <input type="text" id="view_compte_debiteur" readonly class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nom du Bénéficiaire</label>
                        <input type="text" id="view_beneficiaire_nom" readonly class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">RIB du Bénéficiaire</label>
                        <input type="text" id="view_beneficiaire_rib" readonly class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Banque du Bénéficiaire</label>
                        <input type="text" id="view_beneficiaire_banque" readonly class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Agence du Bénéficiaire</label>
                        <input type="text" id="view_beneficiaire_agence" readonly class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Objet</label>
                    <textarea id="view_objet" rows="3" readonly class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white resize-none"></textarea>
                </div>
                
                <div class="flex justify-end pt-4 border-t border-gray-200 dark:border-gray-600">
                    <button type="button" onclick="closeViewModal()" class="px-4 py-2 text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 dark:bg-gray-600 dark:text-gray-300 dark:hover:bg-gray-500 transition-colors duration-200">
                        {{ __('Fermer') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- EDIT MODAL - Add this missing modal -->
    <div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-2xl p-6 relative max-h-[90vh] overflow-y-auto">
            <button onclick="closeEditModal()" class="absolute top-4 right-4 text-gray-500 hover:text-red-500 text-2xl leading-none z-10">&times;</button>
            
            <h2 class="text-xl font-bold mb-6 text-gray-800 dark:text-white">{{ __('Modifier l\'Ordre de Virement') }}</h2>
            
            <form id="editForm" class="space-y-4">
                @csrf
                <input type="hidden" id="edit_id_op" name="id_op">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="edit_date_virement" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Date de Virement <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="date_virement" id="edit_date_virement" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                    
                    <div>
                        <label for="edit_montant" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Montant <span class="text-red-500">*</span>
                        </label>
                        <input type="number" step="0.01" name="montant" id="edit_montant" required placeholder="0.00" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                    
                    <div>
                        <label for="edit_compte_debiteur" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Compte Débiteur <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="compte_debiteur" id="edit_compte_debiteur" required placeholder="Numéro de compte" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                    
                    <div>
                        <label for="edit_beneficiaire_nom" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Nom du Bénéficiaire <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="beneficiaire_nom" id="edit_beneficiaire_nom" required placeholder="Nom complet du bénéficiaire" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                    
                    <div>
                        <label for="edit_beneficiaire_rib" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            RIB du Bénéficiaire <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="beneficiaire_rib" id="edit_beneficiaire_rib" required placeholder="RIB du bénéficiaire" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                    
                    <div>
                        <label for="edit_beneficiaire_banque" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Banque du Bénéficiaire <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="beneficiaire_banque" id="edit_beneficiaire_banque" required placeholder="Nom de la banque" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                    
                    <div>
                        <label for="edit_beneficiaire_agence" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Agence du Bénéficiaire <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="beneficiaire_agence" id="edit_beneficiaire_agence" required placeholder="Nom de l'agence" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                </div>
                
                <div>
                    <label for="edit_objet" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Objet <span class="text-red-500">*</span>
                    </label>
                    <textarea name="objet" id="edit_objet" rows="3" required placeholder="Motif du virement..." class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white resize-none"></textarea>
                </div>
                
                <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200 dark:border-gray-600">
                    <button type="button" onclick="closeEditModal()" class="px-4 py-2 text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 dark:bg-gray-600 dark:text-gray-300 dark:hover:bg-gray-500 transition-colors duration-200">
                        {{ __('Annuler') }}
                    </button>
                    <button type="button" id="saveBtn" onclick="saveOperation()" class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200">
                        <span>{{ __('Enregistrer') }}</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Search Form -->
            <form method="GET" action="{{ route('tresorier.ov') }}" id="searchForm" class="flex flex-wrap gap-4 items-end mb-4">
                <div class="flex flex-col">
                    <label for="search_beneficiaire_rib" class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Bénéficiaire/RIB
                    </label>
                    <input type="text"
                        name="beneficiaire_rib"
                        id="search_beneficiaire_rib"
                        value="{{ request('beneficiaire_rib') }}"
                        placeholder="Rechercher par Bénéf/RIB.."
                        class="px-4 py-2 border rounded-md text-sm w-60 dark:bg-gray-700 dark:text-white dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div class="flex flex-col">
                    <label for="search_date" class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Filtrer par Date
                    </label>
                    <input type="date"
                        name="date"
                        id="search_date"
                        value="{{ request('date') }}"
                        class="px-4 py-2 border rounded-md text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div class="flex flex-col">
                    <label for="search_facture_number" class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Numéro de facture
                    </label>
                    <input type="text"
                        name="facture_number"
                        id="search_facture_number"
                        value="{{ request('facture_number') }}"
                        placeholder="Rechercher par N° Fact.."
                        class="px-4 py-2 border rounded-md text-sm w-60 dark:bg-gray-700 dark:text-white dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div class="flex gap-2">
                    <button type="submit" id="searchBtn" class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <span id="searchBtnText">Rechercher</span>
                    </button>

                    <a href="{{ route('tresorier.ov') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md text-sm hover:bg-gray-600 focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors duration-200">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Effacer
                    </a>
                </div>
            </form>

            <!-- Table Container -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                <!-- Table Header -->
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Ordres de Virement</h3>
                </div>

                <!-- Scrollable Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-900/50 sticky top-0 z-10">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider whitespace-nowrap">N° Pai</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider whitespace-nowrap">Date Virement</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider whitespace-nowrap">Bénéficiaire</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider whitespace-nowrap">RIB</th>
                                <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider whitespace-nowrap">Montant</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider whitespace-nowrap">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($ordres ?? [] as $ordre)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="w-2 h-2 bg-blue-500 rounded-full mr-3"></div>
                                            <span class="text-sm font-medium text-gray-900 dark:text-white">
                                                #{{ $ordre->id_op }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 dark:text-white">
                                            {{ \Carbon\Carbon::parse($ordre->date_virement)->format('d/m/Y') }}
                                        </div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ \Carbon\Carbon::parse($ordre->date_virement)->format('H:i') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                            {{ $ordre->beneficiaire_nom }}
                                        </div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400 truncate">
                                            {{ $ordre->beneficiaire_banque }} - {{ $ordre->beneficiaire_agence }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-mono text-gray-600 dark:text-gray-300 bg-gray-50 dark:bg-gray-700 px-2 py-1 rounded text-xs">
                                            {{ $ordre->beneficiaire_rib }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <div class="text-sm font-semibold text-gray-900 dark:text-white">
                                            {{ number_format($ordre->montant, 2, ',', ' ') }} DH
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <div class="flex items-center justify-center space-x-2">
                                            <button onclick="viewOperation({{ $ordre->id }})" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300" title="Voir détails">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </button>
                                            <button onclick="editOperation({{ $ordre->id }})" class="text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300" title="Modifier">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </button>
                                            <button onclick="deleteOperation({{ $ordre->id }})" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300" title="Supprimer">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center space-y-3">
                                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            <div class="text-gray-500 dark:text-gray-400">
                                                <p class="text-lg font-medium">Aucun ordre de virement</p>
                                                <p class="text-sm">Créer votre ordre de virement</p>
                                            </div>
                                            <button onclick="openModal()" class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                </svg>
                                                Créer un ordre
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Results container for AJAX -->
                <div id="results-container">
                    <!-- AJAX search results will be loaded here -->
                </div>

                <!-- Pagination -->
                @if(!isset($isSearch) || !$isSearch)
                    @if(method_exists($ordres, 'hasPages') && $ordres->hasPages())
                        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
                            {{ $ordres->links() }}
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>

<script>
function openModal() {
  const modal = document.getElementById("createModal")
  if (modal) {
    modal.classList.remove("hidden")
    setTimeout(() => {
      const firstInput = document.getElementById("id_op")
      if (firstInput) firstInput.focus()
    }, 100)
  }
}

function closeModal() {
  const modal = document.getElementById("createModal")
  if (modal) {
    modal.classList.add("hidden")
    const form = modal.querySelector("form")
    if (form) form.reset()
  }
}

function openViewModal() {
  const modal = document.getElementById("viewModal")
  if (modal) {
    modal.classList.remove("hidden")
  }
}

function closeViewModal() {
  const modal = document.getElementById("viewModal")
  if (modal) {
    modal.classList.add("hidden")
  }
}

function openEditModal() {
  const modal = document.getElementById("editModal")
  if (modal) {
    modal.classList.remove("hidden")
    setTimeout(() => {
      const firstInput = document.getElementById("edit_date_virement")
      if (firstInput) firstInput.focus()
    }, 100)
  }
}

function closeEditModal() {
  const modal = document.getElementById("editModal")
  if (modal) {
    modal.classList.add("hidden")
    const form = document.getElementById("editForm")
    if (form) form.reset()
  }
}

function viewOperation(id) {
  console.log("Viewing operation:", id)
  // Show loading state
  const modal = document.getElementById("viewModal")
  if (modal) {
    openViewModal()
    // Show loading in form
    const form = document.getElementById("viewForm")
    if (form) {
      const inputs = form.querySelectorAll("input, textarea")
      inputs.forEach((input) => (input.value = "Chargement..."))
    }
  }

  // Fetch operation data
  fetch(`/tresorier/OV/${id}`, {
    method: "GET",
    headers: {
      "X-Requested-With": "XMLHttpRequest",
      Accept: "application/json",
    },
  })
    .then(async (response) => {
      const contentType = response.headers.get("content-type")
      const text = await response.text()
      console.log("Raw response text:", text)

      if (!response.ok) {
        throw new Error(`Error ${response.status}: ${text}`)
      }

      if (contentType && contentType.includes("application/json")) {
        return JSON.parse(text)
      } else {
        throw new Error("Expected JSON but got something else")
      }
    })
    .then((data) => {
      console.log("View response:", data)
      if (data.success && data.data) {
        populateViewForm(data.data)
      } else {
        throw new Error("Invalid response format")
      }
    })
    .catch((error) => {
      console.error("Failed to fetch operation:", error)
      alert("Erreur lors du chargement des données: " + error.message)
      closeViewModal()
    })
}

function editOperation(id) {
  console.log("Editing operation:", id)
  // First fetch the current data
  fetch(`/tresorier/OV/${id}`, {
    method: "GET",
    headers: {
      "X-Requested-With": "XMLHttpRequest",
      Accept: "application/json",
    },
  })
    .then(async (response) => {
      const contentType = response.headers.get("content-type")
      const text = await response.text()
      console.log("Raw response text:", text)

      if (!response.ok) {
        throw new Error(`Error ${response.status}: ${text}`)
      }

      if (contentType && contentType.includes("application/json")) {
        return JSON.parse(text)
      } else {
        throw new Error("Expected JSON but got something else")
      }
    })
    .then((data) => {
      console.log("Edit data response:", data)
      if (data.success && data.data) {
        populateEditForm(data.data)
        openEditModal()
      } else {
        throw new Error("Invalid response format")
      }
    })
    .catch((error) => {
      console.error("Failed to fetch operation for editing:", error)
      alert("Erreur lors du chargement des données: " + error.message)
    })
}

function deleteOperation(id) {
  if (confirm("Êtes-vous sûr de vouloir supprimer cette opération ?")) {
    console.log("Deleting operation:", id)
    // Implement delete functionality here
    alert("Fonction de suppression à implémenter")
  }
}

function saveOperation() {
  const form = document.getElementById("editForm")
  const saveBtn = document.getElementById("saveBtn")
  const id = document.getElementById("edit_id_op").value

  if (!form.checkValidity()) {
    form.reportValidity()
    return
  }

  // Show loading state
  saveBtn.disabled = true
  const span = saveBtn.querySelector("span")
  if (span) span.textContent = "Enregistrement..."

  const formData = new FormData(form)
  fetch(`/tresorier/OV/update/${id}`, {
    method: "POST",
    headers: {
      "X-Requested-With": "XMLHttpRequest",
      Accept: "application/json",
      "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
    },
    body: formData,
  })
    .then(async (response) => {
      const contentType = response.headers.get("content-type")
      const text = await response.text()
      console.log("Raw response text:", text)

      if (!response.ok) {
        throw new Error(`Error ${response.status}: ${text}`)
      }

      if (contentType && contentType.includes("application/json")) {
        return JSON.parse(text)
      } else {
        throw new Error("Expected JSON but got something else")
      }
    })
    .then((data) => {
      console.log("Update response:", data)
      if (data.success) {
        alert("Opération mise à jour avec succès")
        closeEditModal()
        // Optionally refresh the page or update the table row
        location.reload()
      } else {
        throw new Error(data.message || "Erreur lors de la mise à jour")
      }
    })
    .catch((error) => {
      console.error("Failed to update operation:", error)
      alert("Erreur lors de la mise à jour: " + error.message)
    })
    .finally(() => {
      // Reset button state
      saveBtn.disabled = false
      if (span) span.textContent = "Enregistrer"
    })
}

function populateViewForm(data) {
  document.getElementById("view_id_op").value = data.id_op || ""
  document.getElementById("view_date_virement").value = data.date_virement || ""
  document.getElementById("view_compte_debiteur").value = data.compte_debiteur || ""
  document.getElementById("view_montant").value = data.montant || ""
  document.getElementById("view_beneficiaire_nom").value = data.beneficiaire_nom || ""
  document.getElementById("view_beneficiaire_rib").value = data.beneficiaire_rib || ""
  document.getElementById("view_beneficiaire_banque").value = data.beneficiaire_banque || ""
  document.getElementById("view_beneficiaire_agence").value = data.beneficiaire_agence || ""
  document.getElementById("view_objet").value = data.objet || ""
}

function populateEditForm(data) {
  document.getElementById("edit_id_op").value = data.id_op || ""
  document.getElementById("edit_date_virement").value = data.date_virement || ""
  document.getElementById("edit_compte_debiteur").value = data.compte_debiteur || ""
  document.getElementById("edit_montant").value = data.montant || ""
  document.getElementById("edit_beneficiaire_nom").value = data.beneficiaire_nom || ""
  document.getElementById("edit_beneficiaire_rib").value = data.beneficiaire_rib || ""
  document.getElementById("edit_beneficiaire_banque").value = data.beneficiaire_banque || ""
  document.getElementById("edit_beneficiaire_agence").value = data.beneficiaire_agence || ""
  document.getElementById("edit_objet").value = data.objet || ""
}

// ========================================
// DOM CONTENT LOADED - SEARCH FUNCTIONALITY
// ========================================
document.addEventListener("DOMContentLoaded", () => {
  console.log("DOM loaded, initializing search functionality...")

  // ========================================
  // GET DOM ELEMENTS
  // ========================================
  const searchForm = document.getElementById("searchForm")
  const searchBtn = document.getElementById("searchBtn")
  const resultsContainer = document.getElementById("results-container")
  const beneficiaireInput = document.getElementById("search_beneficiaire_rib")
  const factureInput = document.getElementById("search_facture_number")
  const dateInput = document.getElementById("search_date")

  console.log("Elements found:", {
    searchForm: !!searchForm,
    searchBtn: !!searchBtn,
    resultsContainer: !!resultsContainer,
    beneficiaireInput: !!beneficiaireInput,
    factureInput: !!factureInput,
    dateInput: !!dateInput,
  })

  if (!searchForm || !searchBtn || !resultsContainer) {
    console.error("Required elements not found!")
    console.log("Modal functions are still available globally")
    return
  }

  // ========================================
  // SEARCH FUNCTIONS
  // ========================================
  function showLoading() {
    searchBtn.disabled = true
    const span = searchBtn.querySelector("#searchBtnText")
    if (span) span.textContent = "Recherche..."
    searchBtn.classList.add("opacity-75")
  }

  function hideLoading() {
    searchBtn.disabled = false
    const span = searchBtn.querySelector("#searchBtnText")
    if (span) span.textContent = "Rechercher"
    searchBtn.classList.remove("opacity-75")
  }

  function handleFormSubmit(e) {
    if (e) e.preventDefault()
    console.log("Performing search...")

    showLoading()

    const formData = new FormData(searchForm)
    const params = new URLSearchParams(formData).toString()
    const url = searchForm.action + (params ? "?" + params : "")

    console.log("Search URL:", url)
    console.log("Form data:", Object.fromEntries(formData))

    fetch(url, {
      method: "GET",
      headers: {
        "X-Requested-With": "XMLHttpRequest",
        Accept: "application/json",
      },
    })
      .then((response) => {
        console.log("Response status:", response.status)
        if (!response.ok) {
          throw new Error(`Network response was not ok: ${response.status}`)
        }
        return response.json()
      })
      .then((data) => {
        console.log("Search response:", data)
        if (data.success && data.html) {
          resultsContainer.innerHTML = data.html
          // Update URL without reload
          const newUrl = params ? `${searchForm.action}?${params}` : searchForm.action
          window.history.pushState({}, "", newUrl)
        } else {
          throw new Error("Invalid response format")
        }
      })
      .catch((error) => {
        console.error("AJAX request failed:", error)
        // Fallback to normal form submission
        searchForm.submit()
      })
      .finally(() => {
        hideLoading()
      })
  }

  // ========================================
  // EVENT LISTENERS - FIXED DATE HANDLING
  // ========================================

  // Form submission
  searchForm.addEventListener("submit", handleFormSubmit)

  // Search button click
  searchBtn.addEventListener("click", (e) => {
    e.preventDefault()
    console.log("Search button clicked")
    handleFormSubmit()
  })

  // REMOVED: Date input automatic change event
  // Date input will now only trigger search when:
  // 1. Search button is clicked
  // 2. Form is submitted
  // 3. Enter key is pressed in date input (optional - see below)

  // Text inputs - Enter key triggers search
  if (beneficiaireInput) {
    beneficiaireInput.addEventListener("keypress", (e) => {
      if (e.key === "Enter") {
        console.log("Enter pressed in beneficiaire input")
        e.preventDefault()
        handleFormSubmit()
      }
    })
  }

  if (factureInput) {
    factureInput.addEventListener("keypress", (e) => {
      if (e.key === "Enter") {
        console.log("Enter pressed in facture input")
        e.preventDefault()
        handleFormSubmit()
      }
    })
  }

  // Optional: Date input - Enter key triggers search (but not onChange)
  if (dateInput) {
    dateInput.addEventListener("keypress", (e) => {
      if (e.key === "Enter") {
        console.log("Enter pressed in date input")
        e.preventDefault()
        handleFormSubmit()
      }
    })
  }

  // ========================================
  // MODAL EVENT LISTENERS
  // ========================================
  const createModal = document.getElementById("createModal")
  if (createModal) {
    createModal.addEventListener("click", function (e) {
      if (e.target === this) closeModal()
    })
  }

  const viewModal = document.getElementById("viewModal")
  if (viewModal) {
    viewModal.addEventListener("click", function (e) {
      if (e.target === this) closeViewModal()
    })
  }

  const editModal = document.getElementById("editModal")
  if (editModal) {
    editModal.addEventListener("click", function (e) {
      if (e.target === this) closeEditModal()
    })
  }

  // Escape key closes modals
  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape") {
      if (createModal && !createModal.classList.contains("hidden")) {
        closeModal()
      }
      if (viewModal && !viewModal.classList.contains("hidden")) {
        closeViewModal()
      }
      if (editModal && !editModal.classList.contains("hidden")) {
        closeEditModal()
      }
    }
  })

  console.log("Search functionality initialized successfully")
})
</script>

</x-app-layout>