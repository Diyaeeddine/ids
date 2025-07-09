<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            {{ __('Boîte de Décision') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Square 1 : Demandes à vérifier --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6 border border-blue-400">
                <h3 class="text-lg font-bold text-blue-600 mb-4">Demandes à vérifier</h3>

                @forelse($notificationsDemandes as $notif)
                    <div class="mb-4 p-4 rounded bg-blue-50 dark:bg-blue-900 text-blue-900 dark:text-blue-100 shadow-sm">
                        <p class="font-semibold">{{ $notif->titre }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-300">{{ $notif->created_at->diffForHumans() }}</p>
                        <a href="{{ route('admin.demandes.afficher', [$notif->demande_id, $notif->source_user_id ?? $notif->user_id]) }}"
                           class="mt-2 inline-block px-3 py-1 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 transition">
                            Voir la demande
                        </a>
                    </div>
                @empty
                    <p class="text-sm text-gray-500 dark:text-gray-400">Aucune demande à vérifier.</p>
                @endforelse
            </div>

            {{-- Square 2 : Ordres de Paiement --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6 border border-green-400">
                <h3 class="text-lg font-bold text-green-600 mb-4">Ordres de Paiement (OP)</h3>

               
                    <div class="mb-4 p-4 rounded bg-green-50 dark:bg-green-900 text-green-900 dark:text-green-100 shadow-sm">
                        <p class="font-semibold">{{ $notif->titre }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-300">{{ $notif->created_at->diffForHumans() }}</p>
                        <a href="{{ route('admin.op.afficher', $notif->op_id ?? $notif->demande_id) }}"
                           class="mt-2 inline-block px-3 py-1 bg-green-600 text-white text-sm rounded hover:bg-green-700 transition">
                            Voir l'OP
                        </a>
                    </div>
                
                    <p class="text-sm text-gray-500 dark:text-gray-400">Aucun OP en attente.</p>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>
