<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Créer un Ordre de Paiement') }}
            </h2>
            <a href="{{ route('tresorier.op') }}" 
               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Retour à la liste
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    @if(session('success'))
                        <div id="success-message" class="mb-4 text-green-700 bg-green-100 border border-green-300 p-4 rounded">
                            {{ session('success') }}
                        </div>
                        <script>
                         document.addEventListener('DOMContentLoaded', function () {
                            setTimeout(function () {
                                const success = document.getElementById('success-message');
                                const error = document.getElementById('error-message');
                                if (success) success.style.display = 'none';
                                if (error) error.style.display = 'none';
                            }, 4000);
                        });
                        </script>
                    @endif

                    @if($errors->any())
                        <div class="mb-4 text-red-700 bg-red-100 border border-red-300 p-4 rounded">
                            <ul class="list-disc pl-5">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('tresorier.op.store') }}">
                        @csrf
                        
                        <!-- Section: Informations de base -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b border-gray-200 pb-2">
                                Informations de Base
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="md:col-span-2">
                                    <label for="invoice_id" class="block text-sm font-medium text-gray-700 mb-2">
                                        Facture <span class="text-red-500">*</span>
                                    </label>
                                    <select name="invoice_id" id="invoice_id" 
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
                                        <option value="">Sélectionner une facture</option>
                                        @foreach($factureData as $facture)
                                            <option value="{{ $facture['id'] }}"
                                                    data-demande="{{ $facture['demande_nom'] }}"
                                                    data-montant_paye="{{ $facture['montant_paye'] }}">
                                                {{ $facture['numero'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('invoice_id')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Demande associée
                                    </label>
                                    <input type="text" id="demande_nom" disabled
                                           class="w-full px-3 py-2 border border-gray-300 bg-gray-100 rounded-md">
                                </div>

                                <div class="md:col-span-2">
                                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                         Description <span class="text-red-500">*</span>
                                    </label>
                                    <textarea name="description" id="description" rows="2"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md"
                                        placeholder="Saisir la description de l'opération..." required>{{ old('description') }}</textarea>
                                    @error('description')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="amount" class="block text-sm font-medium text-gray-700 mb-2">
                                        Montant (MAD) <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" name="amount" id="amount" step="0.01" min="0.01"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md" readonly required>
                                    @error('amount')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="montant_lettres" class="block text-sm font-medium text-gray-700 mb-2">
                                        Montant en lettres
                                    </label>
                                    <input type="text" name="montant_lettres" id="montant_lettres"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md"
                                           placeholder="Montant en toutes lettres" value="{{ old('montant_lettres') }}">
                                    @error('montant_lettres')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-2">
                                        Méthode de paiement <span class="text-red-500">*</span>
                                    </label>
                                    <select name="payment_method" id="payment_method"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
                                        <option value="">Sélectionner une méthode</option>
                                        <option value="espèces" {{ old('payment_method') == 'espèces' ? 'selected' : '' }}>Espèces</option>
                                        <option value="virement bancaire" {{ old('payment_method') == 'virement bancaire' ? 'selected' : '' }}>Virement bancaire</option>
                                        <option value="chèque" {{ old('payment_method') == 'chèque' ? 'selected' : '' }}>Chèque</option>
                                    </select>
                                    @error('payment_method')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="due_date" class="block text-sm font-medium text-gray-700 mb-2">
                                        Date de Création <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" name="due_date" id="due_date"
                                           value="{{ old('due_date', now()->format('Y-m-d')) }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md" readonly required>
                                    @error('due_date')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="date_mise_paiement" class="block text-sm font-medium text-gray-700 mb-2">
                                        Date de mise en paiement
                                    </label>
                                    <input type="date" name="date_mise_paiement" id="date_mise_paiement"
                                           value="{{ old('date_mise_paiement') }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md">
                                    @error('date_mise_paiement')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Section: Informations fournisseur et marché -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b border-gray-200 pb-2">
                                Informations Fournisseur et Marché
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="fournisseur" class="block text-sm font-medium text-gray-700 mb-2">
                                        Fournisseur
                                    </label>
                                    <input type="text" name="fournisseur" id="fournisseur"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md"
                                           placeholder="Nom du fournisseur" value="{{ old('fournisseur') }}">
                                    @error('fournisseur')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="marche_bc" class="block text-sm font-medium text-gray-700 mb-2">
                                        Marché/BC
                                    </label>
                                    <input type="text" name="marche_bc" id="marche_bc"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md"
                                           placeholder="Référence du marché ou bon de commande" value="{{ old('marche_bc') }}">
                                    @error('marche_bc')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="periode_facturation" class="block text-sm font-medium text-gray-700 mb-2">
                                        Période de facturation
                                    </label>
                                    <input type="text" name="periode_facturation" id="periode_facturation"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md"
                                           placeholder="Ex: Janvier 2024" value="{{ old('periode_facturation') }}">
                                    @error('periode_facturation')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="pieces_justificatives" class="block text-sm font-medium text-gray-700 mb-2">
                                        Pièces justificatives
                                    </label>
                                    <input type="text" name="pieces_justificatives" id="pieces_justificatives"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md"
                                           placeholder="Liste des pièces justificatives" value="{{ old('pieces_justificatives') }}">
                                    @error('pieces_justificatives')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Section: Contrôle et validation -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b border-gray-200 pb-2">
                                Contrôle et Validation
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="md:col-span-2">
                                    <label for="visa_controle" class="block text-sm font-medium text-gray-700 mb-2">
                                        Visa de contrôle
                                    </label>
                                    <input type="text" name="visa_controle" id="visa_controle"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md"
                                           placeholder="Visa du contrôleur" value="{{ old('visa_controle') }}">
                                    @error('visa_controle')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Section: Imputation comptable -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b border-gray-200 pb-2">
                                Imputation Comptable
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="md:col-span-2">
                                    <label for="imputation_comptable" class="block text-sm font-medium text-gray-700 mb-2">
                                        Imputation comptable
                                    </label>
                                    <input type="text" name="imputation_comptable" id="imputation_comptable"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md"
                                           placeholder="Code d'imputation comptable" value="{{ old('imputation_comptable') }}">
                                    @error('imputation_comptable')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="metier" class="block text-sm font-medium text-gray-700 mb-2">
                                        Métier
                                    </label>
                                    <input type="text" name="metier" id="metier"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md"
                                           placeholder="Métier" value="{{ old('metier') }}">
                                    @error('metier')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="section_analytique" class="block text-sm font-medium text-gray-700 mb-2">
                                        Section analytique
                                    </label>
                                    <input type="text" name="section_analytique" id="section_analytique"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md"
                                           placeholder="Section analytique" value="{{ old('section_analytique') }}">
                                    @error('section_analytique')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="produit" class="block text-sm font-medium text-gray-700 mb-2">
                                        Produit
                                    </label>
                                    <input type="text" name="produit" id="produit"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md"
                                           placeholder="Produit" value="{{ old('produit') }}">
                                    @error('produit')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="extension_analytique" class="block text-sm font-medium text-gray-700 mb-2">
                                        Extension analytique
                                    </label>
                                    <input type="text" name="extension_analytique" id="extension_analytique"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md"
                                           placeholder="Extension analytique" value="{{ old('extension_analytique') }}">
                                    @error('extension_analytique')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Section: Notes et observations -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b border-gray-200 pb-2">
                                Notes et Observations
                            </h3>
                            <div class="grid grid-cols-1 gap-6">
                                <div>
                                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                                        Notes
                                    </label>
                                    <textarea name="notes" id="notes" rows="3"
                                              class="w-full px-3 py-2 border border-gray-300 rounded-md"
                                              placeholder="Notes supplémentaires...">{{ old('notes') }}</textarea>
                                    @error('notes')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end space-x-3">
                            <a href="{{ route('tresorier.op') }}" 
                               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Annuler
                            </a>
                            <button type="submit" 
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Créer l'ordre de paiement
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const select = document.getElementById('invoice_id');
        const demandeInput = document.getElementById('demande_nom');
        const amountInput = document.getElementById('amount');

        select.addEventListener('change', function () {
            const selected = this.options[this.selectedIndex];
            const demandeNom = selected.getAttribute('data-demande');
            const montantPaye = selected.getAttribute('data-montant_paye');

            demandeInput.value = demandeNom || 'N/A';
            amountInput.value = montantPaye || '';
        });
    });
    </script>
</x-app-layout>