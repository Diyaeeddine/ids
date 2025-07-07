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
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
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
                                <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-2">
                                    Méthode de paiement <span class="text-red-500">*</span>
                                </label>
                                <select name="payment_method" id="payment_method"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
                                    <option value="">Sélectionner une méthode</option>
                                    <option value="espèces">Espèces</option>
                                    <option value="virement bancaire">Virement bancaire</option>
                                    <option value="chèque">Chèque</option>
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
                                       value="{{ now()->format('Y-m-d') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md" readonly required>
                                @error('due_date')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
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
