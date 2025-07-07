<title>Tableau de bord - Bouregreg Marina</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Ordres de Paiement') }}
            </h2>
            <a href="{{ route('tresorier.create-OP') }}" 
               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Créer un Ordre de Paiement
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-6">
                        <div class="flex flex-wrap gap-4">
                            <div class="flex-1 min-w-48">
                                <input type="text" 
                                       id="searchInput"
                                       placeholder="Rechercher par numéro ou référence..."
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            
                            <div class="min-w-40">
                                <select id="paymentMethodFilter" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="">Toutes les méthodes</option>
                                    <option value="espèces">Espèces</option>
                                    <option value="virement bancaire">Virement bancaire</option>
                                    <option value="chèque">Chèque</option>
                                </select>
                            </div>

                            <div class="flex gap-2">
                                <button onclick="resetFilters()" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                                    Réinitialiser
                                </button>
                            </div>
                        </div>
                    </div>

                    @if(session('success'))
                        <div id="success-message" class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div id="error-message"  class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            {{ session('error') }}
                        </div>
                    @endif
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
 
                 
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Numéro d'ordre</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Demande</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Facture</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Méthode</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date Validation</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="ordersTableBody" class="bg-white divide-y divide-gray-200">
                                @forelse ($orders as $order)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $order->reference }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $order->entite_ordonnatrice ?? '—' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $order->id_facture ?? '—' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ number_format($order->montant_chiffres, 2, ',', ' ') }} MAD
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ ucfirst($order->mode_paiement) ?? '—' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $order->date_paiment ? \Carbon\Carbon::parse($order->date_paiment)->format('d/m/Y') : '—' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-y-1">
                                            <!-- Valider -->
                                            <form action="{{ route('ordre-paiement.valider', $order->id) }}" method="POST" onsubmit="return confirm('Marquer comme validé?')">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="text-green-600 hover:text-green-900">
                                                    Valider
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4 text-gray-500">
                                            Aucun ordre de paiement trouvé.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('searchInput');
            const methodSelect = document.getElementById('paymentMethodFilter');
            const tableRows = document.querySelectorAll('#ordersTableBody tr');

            function filterRows() {
                const searchValue = searchInput.value.toLowerCase();
                const selectedMethod = methodSelect.value.toLowerCase();

                tableRows.forEach(row => {
                    const rowText = row.textContent.toLowerCase();
                    const methodCell = row.querySelector('td:nth-child(5)').textContent.toLowerCase();

                    const matchesSearch = rowText.includes(searchValue);
                    const matchesMethod = !selectedMethod || methodCell.includes(selectedMethod);

                    row.style.display = matchesSearch && matchesMethod ? '' : 'none';
                });
            }

            searchInput.addEventListener('keyup', filterRows);
            methodSelect.addEventListener('change', filterRows);
        });

        function resetFilters() {
            document.getElementById('searchInput').value = '';
            document.getElementById('paymentMethodFilter').value = '';
            const rows = document.querySelectorAll('#ordersTableBody tr');
            rows.forEach(row => row.style.display = '');
        }
    </script>
</x-app-layout>
