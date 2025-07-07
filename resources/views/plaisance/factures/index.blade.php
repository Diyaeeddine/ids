
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            <i class="fas fa-file-invoice-dollar text-indigo-500 mr-3"></i>
            {{ __('Mes Factures') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('status'))
                <div class="mb-6 p-4 bg-green-100 dark:bg-green-900/50 border-l-4 border-green-500 text-green-700 dark:text-green-300 rounded-r-lg">
                    {{ session('status') }}
                </div>
            @endif

            <div class="space-y-6">
                @forelse($factures as $facture)
                    {{-- The main div for the card. It is made clickable by the JavaScript below. --}}
                    <div class="js-clickable-card bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700/50 transition duration-150 ease-in-out" 
                         data-href="{{ route('factures.show', $facture) }}">
                        <div class="p-6 flex flex-col md:flex-row justify-between md:items-center space-y-4 md:space-y-0">
                            
                            {{-- Left Side: Invoice Details --}}
                            <div class="flex-grow">
                                <div class="flex items-center space-x-4">
                                    <span class="bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 font-bold px-3 py-1 rounded-md text-sm">
                                        {{ $facture->numero_facture }}
                                    </span>
                                    <div>
                                        @if($facture->statut === 'payée')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200"><i class="fas fa-check-circle mr-1.5">&nbsp</i>Payée</span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200"><i class="fas fa-exclamation-circle mr-1.5">&nbsp</i>Non Payée</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="mt-4 text-sm text-gray-600 dark:text-gray-400 space-y-1">
                                    <p><strong class="font-semibold text-gray-700 dark:text-gray-300">Bateau:</strong> {{ $facture->contrat?->navire?->nom ?? 'N/A' }}</p>
                                    <p><strong class="font-semibold text-gray-700 dark:text-gray-300">Date:</strong> {{ \Carbon\Carbon::parse($facture->date_facture)->format('d F Y') }}</p>
                                </div>
                            </div>

                            {{-- Right Side: Amount and Action Buttons --}}
                            <div class="text-left md:text-right flex-shrink-0 flex items-center space-x-4">
                                <p class="text-xl font-semibold text-gray-900 dark:text-gray-100 w-32 text-right">
                                    {{ number_format($facture->total_ttc, 2, ',', ' ') }} DH 
                                </p>
                                
                                {{-- The Delete Button is now type="button" and uses data attributes --}}
                                <form id="delete-form-{{ $facture->id }}" method="POST" action="{{ route('factures.destroy', $facture) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" data-form-id="delete-form-{{ $facture->id }}" class="js-delete-btn text-gray-500 hover:text-red-600 dark:hover:text-red-400 transition" title="Supprimer la facture">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>

                                {{-- Visual cue that the card is clickable --}}
                                <i class="fas fa-chevron-right text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                        <p class="text-gray-500 dark:text-gray-400">Vous n'avez aucune facture pour le moment.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <div id="delete-confirmation-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-30 backdrop-blur-sm hidden transition-opacity duration-300 ease-in-out opacity-0">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl p-6 max-w-md mx-4 transform transition-all duration-300 ease-in-out scale-95 opacity-0">
            <div class="text-center">
                <i class="fas fa-exclamation-triangle text-5xl text-red-500 mb-4"></i>
                <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">Êtes-vous sûr ?</h3>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                    Vous êtes sur le point de supprimer cette facture. Cette action est irréversible.
                </p>
            </div>
            <div class="mt-6 flex justify-center space-x-4">
                <button id="cancel-delete-btn" type="button" class="px-6 py-2 rounded-md text-sm font-semibold bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 transition">
                    Annuler
                </button>
                <button id="confirm-delete-btn" type="button" class="px-6 py-2 rounded-md text-sm font-semibold bg-red-600 hover:bg-red-700 text-white transition">
                    Oui, Supprimer
                </button>
            </div>
        </div>
    </div>

    <style>
        #delete-confirmation-modal.show { opacity: 1; }
        #delete-confirmation-modal.show > div { opacity: 1; transform: scale(1); }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // --- MODAL LOGIC ---
            const modal = document.getElementById('delete-confirmation-modal');
            const confirmBtn = document.getElementById('confirm-delete-btn');
            const cancelBtn = document.getElementById('cancel-delete-btn');
            const deleteTriggerButtons = document.querySelectorAll('.js-delete-btn');
            
            let formToSubmit = null;

            const openModal = (formId) => {
                formToSubmit = document.getElementById(formId);
                modal.classList.remove('hidden');
                setTimeout(() => modal.classList.add('show'), 10);
            };

            const closeModal = () => {
                modal.classList.remove('show');
                setTimeout(() => modal.classList.add('hidden'), 300);
            };

            deleteTriggerButtons.forEach(button => {
                button.addEventListener('click', function (event) {
                    event.stopPropagation(); // Stop click from bubbling up to the card
                    const formId = this.getAttribute('data-form-id');
                    openModal(formId);
                });
            });

            cancelBtn.addEventListener('click', closeModal);
            confirmBtn.addEventListener('click', () => {
                if (formToSubmit) {
                    formToSubmit.submit();
                }
            });
            
            modal.addEventListener('click', function (event) {
                if (event.target === modal) {
                    closeModal();
                }
            });

            // --- CLICKABLE CARD LOGIC ---
            const cards = document.querySelectorAll('.js-clickable-card');
            cards.forEach(card => {
                card.addEventListener('click', function(event) {
                    // Check if the click was on the delete button or its form
                    if (event.target.closest('.js-delete-btn') || event.target.closest('form')) {
                        return; // Do nothing if the click was on the delete functionality
                    }
                    const href = this.getAttribute('data-href');
                    if (href) {
                        window.location.href = href;
                    }
                });
            });
        });
    </script>
</x-app-layout>