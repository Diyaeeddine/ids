<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            <i class="fas fa-plus-circle text-indigo-500 mr-2"></i>
            Créer une Facture pour le Contrat #{{ $contrat->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900 dark:text-gray-100">

                    <form action="{{ route('plaisance.factures.store', ['contrat' => $contrat->id]) }}" method="POST" class="space-y-8">
                        @csrf
                        
                        @if ($errors->any())
                            <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 dark:text-red-200">
                                <p class="font-bold">Veuillez corriger les erreurs suivantes :</p>
                                <ul class="mt-2 list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        
                        <div class="p-6 border border-gray-200 dark:border-gray-700 rounded-lg">
                            <h3 class="text-lg font-semibold border-b border-gray-200 dark:border-gray-700 pb-3 mb-4">Détails de la Facturation</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="numero_facture" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Numéro de Facture</label>
                                    <input type="text" id="numero_facture" name="numero_facture" class="mt-1 block w-full bg-gray-100 dark:bg-gray-700 border-gray-300 dark:border-gray-600 rounded-md shadow-sm" value="{{ $invoiceNumber }}" readonly>
                                </div>
                                <div class="space-y-4">
                                    <div>
                                        <label for="date_facture" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date de la facture</label>
                                        <input type="date" id="date_facture" name="date_facture" class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-md shadow-sm" value="{{ date('Y-m-d') }}">
                                    </div>
                                    <div>
                                        <label for="date_echeance" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date d'échéance</label>
                                        <input type="date" id="date_echeance" name="date_echeance" class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-md shadow-sm" value="{{ date('Y-m-d', strtotime('+15 days')) }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="p-6 border border-gray-200 dark:border-gray-700 rounded-lg">
                            <h3 class="text-lg font-semibold border-b border-gray-200 dark:border-gray-700 pb-3 mb-4">Lignes de Facture</h3>
                            <div class="overflow-x-auto">
                                <table class="w-full" id="invoice-items-table">
                                    <thead class="text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">
                                        <tr>
                                            <th class="p-2">Description</th>
                                            <th class="p-2 w-28">Quantité</th>
                                            <th class="p-2 w-36">Prix Unitaire</th>
                                            <th class="p-2 w-36 text-right">Montant</th>
                                            <th class="p-2 w-12"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- Rows are added here by JavaScript --}}
                                    </tbody>
                                </table>
                            </div>
                            <button type="button" id="add-item-btn" class="mt-4 px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-md hover:bg-blue-700 transition">
                                <i class="fas fa-plus mr-1"></i>
                                Ajouter une ligne
                            </button>
                        </div>
                        
                        <div class="flex justify-end">
                            <div class="w-full max-w-md space-y-3 text-gray-700 dark:text-gray-300">
                                <div class="flex justify-between py-2 border-t dark:border-gray-600">
                                    <span class="font-semibold">Total HT</span>
                                    <span id="total-ht" class="font-semibold">0,00 DH</span>
                                    <input type="hidden" name="total_ht" id="input-total-ht" value="0">
                                </div>
                                <div class="flex justify-between py-2 border-t dark:border-gray-600">
                                    <span>Taxe régionale 5%</span>
                                    <span id="taxe-regionale">0,00 DH</span>
                                    <input type="hidden" name="taxe_regionale" id="input-taxe-regionale" value="0">
                                </div>
                                <div class="flex justify-between py-2 border-t dark:border-gray-600">
                                    <span>TVA 20%</span>
                                    <span id="total-tva">0,00 DH</span>
                                    <input type="hidden" name="total_tva" id="input-total-tva" value="0">
                                </div>
                                <div class="flex justify-between py-3 border-t-2 border-gray-300 dark:border-gray-500 text-lg font-bold text-gray-900 dark:text-white">
                                    <span>Total TTC</span>
                                    <span id="total-ttc">0,00 DH</span>
                                    <input type="hidden" name="total_ttc" id="input-total-ttc" value="0">
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 pt-6 border-t dark:border-gray-700 text-right">
                            <button type="submit" class="px-8 py-3 bg-green-600 text-white font-bold rounded-lg hover:bg-green-700 transition shadow-lg">
                                <i class="fas fa-save mr-2"></i>
                                Enregistrer la Facture
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tableBody = document.querySelector('#invoice-items-table tbody');
            const addItemBtn = document.getElementById('add-item-btn');
            let itemIndex = 0;
    
            function createRow() {
                const row = document.createElement('tr');
                row.classList.add('border-b', 'dark:border-gray-700');
                row.innerHTML = `
                    <td class="p-2"><input type="text" name="items[${itemIndex}][description]" class="block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-md shadow-sm" placeholder="Description du service" required></td>
                    <td class="p-2"><input type="number" name="items[${itemIndex}][quantite]" class="item-calc item-quantite block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-md shadow-sm" value="1" step="1" required></td>
                    <td class="p-2"><input type="number" name="items[${itemIndex}][prix_unitaire]" class="item-calc item-prix block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-md shadow-sm" placeholder="0.00" step="0.01" required></td>
                    <td class="p-2 text-right font-semibold text-gray-600 dark:text-gray-300"><span class="item-montant">0,00 DH</span></td>
                    <td class="p-2 text-center"><button type="button" class="remove-item-btn text-red-500 hover:text-red-700 font-bold text-lg">&times;</button></td>
                `;
                tableBody.appendChild(row);
                itemIndex++;
                updateTotals();
            }
    
            addItemBtn.addEventListener('click', createRow);
    
            tableBody.addEventListener('click', function (e) {
                if (e.target.classList.contains('remove-item-btn')) {
                    e.target.closest('tr').remove();
                    updateTotals();
                }
            });
    
            tableBody.addEventListener('input', function (e) {
                if (e.target.classList.contains('item-calc')) {
                    const row = e.target.closest('tr');
                    const quantite = parseFloat(row.querySelector('.item-quantite').value) || 0;
                    const prix = parseFloat(row.querySelector('.item-prix').value) || 0;
                    const montant = quantite * prix;
                    row.querySelector('.item-montant').textContent = montant.toLocaleString('fr-FR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' DH';
                    updateTotals();
                }
            });
    
            function updateTotals() {
                let totalHT = 0;
                document.querySelectorAll('#invoice-items-table tbody tr').forEach(row => {
                    const quantite = parseFloat(row.querySelector('.item-quantite').value) || 0;
                    const prix = parseFloat(row.querySelector('.item-prix').value) || 0;
                    totalHT += quantite * prix;
                });
    
                const taxeRegionale = totalHT * 0.05;
                const totalTVA = (totalHT + taxeRegionale) * 0.20;
                const totalTTC = totalHT + taxeRegionale + totalTVA;
    
                const formatCurrency = (value) => value.toLocaleString('fr-FR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' DH';
    
                document.getElementById('total-ht').textContent = formatCurrency(totalHT);
                document.getElementById('taxe-regionale').textContent = formatCurrency(taxeRegionale);
                document.getElementById('total-tva').textContent = formatCurrency(totalTVA);
                document.getElementById('total-ttc').textContent = formatCurrency(totalTTC);
    
                document.getElementById('input-total-ht').value = totalHT.toFixed(2);
                document.getElementById('input-taxe-regionale').value = taxeRegionale.toFixed(2);
                document.getElementById('input-total-tva').value = totalTVA.toFixed(2);
                document.getElementById('input-total-ttc').value = totalTTC.toFixed(2);
            }
    
            createRow();
    
            @if (session('download_contract'))
                const pdfUrl = "{{ route('contrats.genererPDF', ['id' => session('download_contract.id'), 'type' => session('download_contract.type')]) }}";
                const win = window.open(pdfUrl, '_blank');
                if (win) {
                    setTimeout(() => {
                        win.close();
                    }, 5000);
                }
            @endif
        });
    </script>
    
</x-app-layout>