<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Créer un Ordre de Paiement') }}
            </h2>
            <a href="" 
               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Retour à la liste
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            <div class="md:col-span-2">
                                <label for="invoice_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    Facture <span class="text-red-500">*</span>
                                </label>
                                <select name="invoice_id" id="invoice_id" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('invoice_id') border-red-500 @enderror"
                                        required>
                                    <option value="">Sélectionner une facture</option>
                                </select>
                                @error('invoice_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="amount" class="block text-sm font-medium text-gray-700 mb-2">
                                    Montant (MAD) <span class="text-red-500">*</span>
                                </label>
                                <input type="number" 
                                       name="amount" 
                                       id="amount" 
                                       step="0.01"
                                       min="0.01"
                                       value="{{ old('amount') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('amount') border-red-500 @enderror"
                                       required>
                                @error('amount')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Méthode de paiement -->
                            <div>
                                <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-2">
                                    Méthode de paiement <span class="text-red-500">*</span>
                                </label>
                                <select name="payment_method" id="payment_method" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('payment_method') border-red-500 @enderror"
                                        required>
                                    <option value="">Sélectionner une méthode</option>
                                    <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>
                                        Espèces
                                    </option>
                                    <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>
                                        Virement bancaire
                                    </option>
                                    <option value="credit_card" {{ old('payment_method') == 'credit_card' ? 'selected' : '' }}>
                                        Carte de crédit
                                    </option>
                                    <option value="check" {{ old('payment_method') == 'check' ? 'selected' : '' }}>
                                        Chèque
                                    </option>
                                </select>
                                @error('payment_method')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Date d'échéance -->
                            <div>
                                <label for="due_date" class="block text-sm font-medium text-gray-700 mb-2">
                                    Date d'échéance <span class="text-red-500">*</span>
                                </label>
                                <input type="date" 
                                       name="due_date" 
                                       id="due_date" 
                                       value="{{ old('due_date', now()->addDays(30)->format('Y-m-d')) }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('due_date') border-red-500 @enderror"
                                       required>
                                @error('due_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                                    Notes
                                </label>
                                <textarea name="notes" 
                                          id="notes" 
                                          rows="3"
                                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('notes') border-red-500 @enderror"
                                          placeholder="Notes supplémentaires...">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end space-x-3">
                            <a href="" 
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
        // Auto-remplir le montant quand une facture est sélectionnée
        document.getElementById('invoice_id').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const amount = selectedOption.getAttribute('data-amount');
            
            if (amount) {
                document.getElementById('amount').value = amount;
            }
        });
    </script>
</x-app-layout>