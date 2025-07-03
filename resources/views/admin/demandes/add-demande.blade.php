@php  
    $user = auth()->user();
@endphp

{{-- Assets --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Figtree&display=swap" rel="stylesheet" />
<style>
    * {
        font-family: 'Figtree', sans-serif;
    }
    
</style>
<x-app-layout>
    <x-slot name="header">
        <div class='flex justify-between items-center'>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Demandes') }}
            </h2>
            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-4 py-2.5 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl font-medium text-sm text-gray-700 dark:text-gray-300 shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-all duration-200 group">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 group-hover:-translate-x-1 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                {{ __('Retour') }}
            </a>
        </div>
    </x-slot>

    <div class="max-w-xl mx-auto sm:px-6 lg:px-8 font-sans">    
        <div class="mt-4 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <h1 class="text-lg font-medium mb-6 pb-2 border-b border-gray-200 dark:border-gray-700">{{ __('Créer une demande') }}</h1>
                
                @if (session('success'))

                    <div class="bg-green-50 dark:bg-green-900/50 text-green-800 dark:text-green-300 p-4 mb-6 rounded-md">
                        {{ session('success') }}
                    </div>
                @endif
                <form action="{{ route('demande.store-demande') }}" method="POST" class="space-y-6 relative">
                    @csrf
                <div class="flex flex-col md:flex-row justify-between items-end gap-4 mb-4"> 
                    <div class="mb-4">
                        <button type="button" id="tableBudgetaireBtn" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                            Table Budgétaire
                        </button>
                    </div>

                    <div class="w-full md:w-64">
                        <label for="type_economique" class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">
                            Nature économique :
                        </label>
                        <select name="type_economique" id="type_economique"
                            class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 px-3 py-2 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                            <option value="">-- Sélectionner la nature --</option>
                            <option value="produit">Produit</option>
                            <option value="charge">Charge</option>
                        </select>
                    </div>
                </div>



                    {{-- Selected Imputation --}}
                    @if(session('selected_imputation'))
                        <div id="selectedImputation" class="bg-blue-100 dark:bg-blue-900 text-blue-900 dark:text-white p-4 rounded-md relative">
                            <div class="mb-4 p-2 bg-blue-100 rounded text-blue-800">
                                Ligne sélectionnée : {{ session('selected_imputation')['imputation'] }} - {{ session('selected_imputation')['intitule'] }}
                            </div>
                            <span>Imputation : {{ session('selected_imputation')['imputation'] }}</span><br>
                            <span>Intitulé : {{ session('selected_imputation')['intitule'] }}</span>
                            <input type="hidden" name="selected_imputation" value="{{ session('selected_imputation')['imputation'] }}">

                            {{-- JS Remove Button --}}
                            <button type="button" id="removeImputationBtn" class="absolute top-2 right-2 text-red-500 hover:text-red-700 text-sm" title="Retirer">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>
                    @endif

                    {{-- Modal with Blur & Animation --}}
                    <div id="tableOptionsModal"
                        class="fixed inset-0 z-50 hidden flex items-center justify-center backdrop-blur-sm bg-black bg-opacity-40 transition-all duration-300">
                        <div id="modalContent"
                            class="transform scale-95 opacity-0 transition-all duration-300 ease-out bg-white dark:bg-gray-800 rounded-xl p-6 shadow-2xl w-11/12 max-w-2xl relative">
                            {{-- Close Button --}}
                            <button type="button" id="closeModalBtn" class="absolute top-4 right-4 text-red-600 hover:text-red-800 text-2xl">
                                <i class="fa-solid fa-xmark"></i>
                            </button>

                            {{-- Modal Content --}}
                            <h3 class="text-xl font-semibold mb-5 text-gray-900 dark:text-gray-100 text-center">
                                Choisissez :
                            </h3>
                            <div class="space-y-4">
                                <a href="{{ route('demande.select-budget-table') }}"
                                   class="block w-full bg-blue-600 text-white text-bold py-4  text-center hover:bg-blue-700 transition">
                                    Sélectionner une ligne depuis une table budgétaire
                                </a>
                                {{-- <a href="{{ route('demande.choose-table-for-entry') }}" 
                                    class="block w-full bg-blue-600 text-white text-bold py-4  text-center hover:bg-blue-700 transition">
                                    Ajouter une nouvelle ligne dans une table budgétaire
                                </a> --}}
                            </div>
                        </div>
                    </div>

                    {{-- Title Field --}}
                    <div id="custom-fields" class="space-y-4">
                        <div class="flex flex-col">
                            <label for="titre" class="text-sm font-medium text-gray-700 dark:text-gray-300">Titre :</label>
                            <input type="text" name="titre" id="titre" placeholder="Titre de la demande"
                                   class="mt-1 block w-full px-3 py-2 border rounded-md dark:bg-gray-800 dark:text-white"
                                   required>
                        </div>
                    </div>

                    {{-- Add Field --}}
                    <button type="button" id="add-field"
                            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                        Ajouter un champ
                    </button>

                    {{-- Submit --}}
                    <button type="submit"
                            class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
                        Envoyer
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- JavaScript --}}
    <script>
        let index = 1;

        document.getElementById('add-field').addEventListener('click', () => {
            const container = document.getElementById('custom-fields');
            const div = document.createElement('div');
            div.className = "flex items-center gap-2";
            div.innerHTML = `
                <input type="text" name="fields[${index}][key]" placeholder="Nom du champ"
                    class="mt-1 block w-full px-3 py-2 border rounded-md dark:bg-gray-800 dark:text-white" required>
                <button type="button" class="remove-row text-red-500 hover:text-red-700 text-xl">✕</button>
            `;
            container.appendChild(div);
            index++;
        });

        document.addEventListener('click', function (e) {
            if (e.target && e.target.classList.contains('remove-row')) {
                e.target.parentElement.remove();
            }
        });

        const modal = document.getElementById('tableOptionsModal');
        const modalContent = document.getElementById('modalContent');
        const openBtn = document.getElementById('tableBudgetaireBtn');
        const closeBtn = document.getElementById('closeModalBtn');

        openBtn.addEventListener('click', () => {
            modal.classList.remove('hidden');
            requestAnimationFrame(() => {
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            });
        });

        closeBtn.addEventListener('click', () => {
            modalContent.classList.remove('scale-100', 'opacity-100');
            modalContent.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        });

        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modalContent.classList.remove('scale-100', 'opacity-100');
                modalContent.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    modal.classList.add('hidden');
                }, 300);
            }
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === "Escape" && !modal.classList.contains('hidden')) {
                modalContent.classList.remove('scale-100', 'opacity-100');
                modalContent.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    modal.classList.add('hidden');
                }, 300);
            }
        });

        const removeBtn = document.getElementById('removeImputationBtn');
                if (removeBtn) {
                    removeBtn.addEventListener('click', () => {
                        const selectedBlock = document.getElementById('selectedImputation');
                        if (selectedBlock) {
                            selectedBlock.remove();
                        }
                    });
                }


    </script>
</x-app-layout>
