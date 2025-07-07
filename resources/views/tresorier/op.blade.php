<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Ordres de Paiement') }}
            </h2>
            <a href="{{route('tresorier.create-OP')}}" 
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
                        <form method="GET" action="" class="flex flex-wrap gap-4">
                            <div class="flex-1 min-w-48">
                                <input type="text" 
                                       name="search" 
                                       value="{{ request('search') }}"
                                       placeholder="Rechercher par numéro ou référence..."
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            
                            <div class="min-w-40">
                                <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="">Tous les statuts</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>En attente</option>
                                    <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Payé</option>
                                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Annulé</option>
                                    <option value="overdue" {{ request('status') == 'overdue' ? 'selected' : '' }}>En retard</option>
                                </select>
                            </div>
                            
                            <div class="min-w-40">
                                <select name="payment_method" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="">Toutes les méthodes</option>
                                    <option value="cash" {{ request('payment_method') == 'cash' ? 'selected' : '' }}>Espèces</option>
                                    <option value="bank_transfer" {{ request('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Virement bancaire</option>
                                    <option value="credit_card" {{ request('payment_method') == 'credit_card' ? 'selected' : '' }}>Carte de crédit</option>
                                    <option value="check" {{ request('payment_method') == 'check' ? 'selected' : '' }}>Chèque</option>
                                </select>
                            </div>
                            
                            <div class="flex gap-2">
                                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                                    Filtrer
                                </button>
                                <a href="" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                                    Réinitialiser
                                </a>
                            </div>
                        </form>
                    </div>

                    @if(session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Numéro d'ordre
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Facture
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Montant
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Méthode
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Statut
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Date d'échéance
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                {{-- @forelse($paymentOrders as $paymentOrder) --}}
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{-- {{ $paymentOrder->order_number }} --}}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                {{-- {{ $paymentOrder->invoice->invoice_number }} --}}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{-- {{ $paymentOrder->invoice->request->title ?? 'N/A' }} --}}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{-- {{ number_format($paymentOrder->amount, 2) }} MAD --}}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                {{-- {{ $paymentOrder->payment_method_label }} --}}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{-- <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $paymentOrder->status_badge }}"> --}}
                                                {{-- {{ $paymentOrder->status_label }} --}}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{-- {{ $paymentOrder->due_date->format('d/m/Y') }} --}}
                                            {{-- @if($paymentOrder->isOverdue()) --}}
                                                <span class="text-red-600 font-medium">(En retard)</span>
                                            {{-- @endif --}}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-2">
                                                <a href="" 
                                                   class="text-blue-600 hover:text-blue-900">
                                                    Voir
                                                </a>
                                                
                                                {{-- @if($paymentOrder->status !== 'paid') --}}
                                                    {{-- <a href="" 
                                                       class="text-green-600 hover:text-green-900">
                                                        Modifier
                                                    </a>
                                                     --}}
                                                    {{-- @if($paymentOrder->status === 'pending') --}}
                                                        <form method="POST" action="" class="inline">
                                                            @csrf
                                                            <button type="submit" 
                                                                    class="text-green-600 hover:text-green-900"
                                                                    onclick="return confirm('Marquer comme payé?')">
                                                                Marquer payé
                                                            </button>
                                                        </form>
                                                    {{-- @endif --}}
                                                {{-- @endif --}}
                                            </div>
                                        </td>
                                    </tr>
                                {{-- @empty --}}
                                    <tr>
                                        <td colspan="7" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                            Aucun ordre de paiement trouvé.
                                        </td>
                                    </tr>
                                {{-- @endforelse --}}
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{-- {{ $paymentOrders->appends(request()->query())->links() }} --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>