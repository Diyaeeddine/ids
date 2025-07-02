<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet"> 
<script src="//unpkg.com/alpinejs" defer></script>
<title>Création table Budgétaire</title>

<style>
    .fade-in {
        animation: fadeIn 0.5s ease-in-out;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .slide-in {
        animation: slideIn 0.3s ease-out;
    }
    
    @keyframes slideIn {
        from { transform: translateX(-20px); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    
    .button-hover {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        transform: translateY(0);
    }
    
    .button-hover:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }
    
    .dark .button-hover:hover {
        box-shadow: 0 10px 25px rgba(255, 255, 255, 0.1);
    }
    
    .input-focus {
        transition: all 0.3s ease;
    }
    
    .input-focus:focus {
        transform: scale(1.02);
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }
    
    .table-row {
        transition: all 0.2s ease;
    }
    
    .table-row:hover {
        background-color: rgba(59, 130, 246, 0.05);
    }
    
    .dark .table-row:hover {
        background-color: rgba(59, 130, 246, 0.1);
    }
    
    .gradient-bg {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .card-shadow {
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
    
    .dark .card-shadow {
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3), 0 10px 10px -5px rgba(0, 0, 0, 0.2);
    }
    
    .icon-bounce {
        transition: transform 0.2s ease;
    }
    
    .icon-bounce:hover {
        transform: scale(1.1);
    }
    
    .success-alert {
        background: linear-gradient(90deg, #10b981, #059669);
        color: white;
        border: none;
    }
    
    .blue-title-row {
        background: linear-gradient(90deg, #3b82f6, #1d4ed8);
    }
    
    .dark .blue-title-row {
        background: linear-gradient(90deg, #1e40af, #1e3a8a);
    }
    
    .header-row {
        background: linear-gradient(90deg, #6b7280, #4b5563);
    }
    
    .dark .header-row {
        background: linear-gradient(90deg, #374151, #1f2937);
    }
</style>

<x-app-layout>
    <x-slot name="header">
        <div class="gradient-bg rounded-lg p-6 text-white">
            <div class="flex items-center space-x-3">
                <i class="fas fa-table text-2xl"></i>
                <h2 class="font-bold text-2xl">
                    {{ __('Création Table Budgétaire') }}
                </h2>
            </div>
            <p class="mt-2 text-blue-100">Créez et gérez vos tables budgétaires avec précision</p>
        </div>
    </x-slot>

    <div class="py-8 mt-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg card-shadow fade-in">
                @if(session('success'))
                    <div x-data="{ show: true }" x-show="show" x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 transform translate-y-2"
                         x-transition:enter-end="opacity-1 transform translate-y-0"
                         class="m-6 mb-0 px-6 py-4 success-alert rounded-lg shadow-lg">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-xl mr-3"></i>
                            <span class="font-medium">{{ session('success') }}</span>
                            <button @click="show = false" class="ml-auto">
                                <i class="fas fa-times hover:text-green-200"></i>
                            </button>
                        </div>
                    </div>
                @endif

                <div class="p-8">
                    <form action="{{ route('budget-tables.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <div class="border-b border-gray-200 dark:border-gray-700 pb-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                                <i class="fas fa-info-circle mr-2 text-blue-500"></i>
                                Informations Générales
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        <i class="fas fa-heading mr-1"></i>
                                        Titre du Budget
                                    </label>
                                    <input type="text" name="title" id="title" placeholder="Ex: Budget Prévisionnel 2024"
                                           class="w-full border border-gray-300 dark:border-gray-600 rounded-lg p-3 dark:bg-gray-700 dark:text-white input-focus placeholder-gray-400 dark:placeholder-gray-500" required>
                                </div>

                                <div class="space-y-2">
                                    <label for="prevision" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        <i class="fas fa-calendar-alt mr-1"></i>
                                        Prévisions Budgétaires (année)
                                    </label>
                                    <input type="number" name="prevision" id="prevision" placeholder="2024"
                                           class="w-full border border-gray-300 dark:border-gray-600 rounded-lg p-3 dark:bg-gray-700 dark:text-white input-focus placeholder-gray-400 dark:placeholder-gray-500" required>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row sm:justify-between items-start sm:items-center space-y-3 sm:space-y-0 sm:space-x-4">
                            <div class="flex flex-wrap gap-3">
                                <button type="button" onclick="addRow()"
                                        class="bg-green-600 text-white px-6 py-3 rounded-lg hover:from-green-600 hover:to-green-700 button-hover shadow-lg flex items-center space-x-2">
                                    <i class="fas fa-plus icon-bounce"></i>
                                    <span>Ajouter une ligne</span>
                                </button>
                                <button type="button" onclick="addBlueTitleRow()"
                                        class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-6 py-3 rounded-lg hover:from-blue-600 hover:to-blue-700 button-hover shadow-lg flex items-center space-x-2">
                                    <i class="fas fa-plus icon-bounce"></i>
                                    <span>Ajouter un titre</span>
                                </button>
                            </div>
                            
                            <div class="text-sm text-gray-600 dark:text-gray-400 bg-gray-50 dark:bg-gray-700 px-4 py-2 rounded-lg">
                                <i class="fas fa-info-circle mr-1"></i>
                                <span id="row-count">0</span> ligne(s) ajoutée(s)
                            </div>
                        </div>
                        
                        <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-4">
                            <div class="overflow-x-auto">
                                <table class="min-w-full table-auto border-collapse shadow-sm">
                                    <thead>
                                        <tr class="bg-gradient-to-r from-gray-700 to-gray-800 text-white">
                                            <th class="border border-black dark:border-gray-600 px-4 py-4 text-left text-black dark:text-white font-semibold">
                                                <i class="fas fa-hashtag mr-2"></i>
                                                Imputation comptable
                                            </th>
                                            <th class="border border-black dark:border-gray-600 px-4 py-4 text-left text-black dark:text-white font-semibold">
                                                <i class="fas fa-tag mr-2"></i>
                                                Intitulé
                                            </th>
                                            <th class="border border-black dark:border-gray-600 px-4 py-4 text-left text-black dark:text-white font-semibold">
                                                <i class="fas fa-chart-line mr-2"></i>
                                                Budget Prévisionnel
                                            </th>
                                            <th class="border border-black dark:border-gray-600 px-4 py-4 text-left text-black dark:text-white font-semibold">
                                                <i class="fas fa-bullseye mr-2"></i>
                                                Atterrissage
                                            </th>
                                            <th class="border border-black dark:border-gray-600 px-4 py-4 text-left text-black dark:text-white font-semibold">
                                                <i class="fas fa-header mr-2"></i>
                                                Titre Gris
                                            </th>
                                            <th class="border border-black dark:border-gray-600 px-4 py-4 text-left text-black dark:text-white font-semibold">
                                                <i class="fas fa-trash mr-2"></i>
                                                Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="rows" class="bg-white dark:bg-gray-800">
                                    </tbody>
                                </table>
                            </div>
                            
                            <div id="empty-state" class="text-center py-12 text-gray-500 dark:text-gray-400">
                                <i class="fas fa-table text-4xl mb-4 opacity-50"></i>
                                <p class="text-lg font-medium">Aucune ligne ajoutée</p>
                                <p class="text-sm">Cliquez sur "Ajouter une ligne" pour commencer</p>
                            </div>
                        </div>

                        <div class="flex justify-end pt-6 border-t border-gray-200 dark:border-gray-700">
                            <button type="submit" class="bg-indigo-600 text-white  px-8 py-3 rounded-lg hover:from-indigo-600 hover:to-purple-700 button-hover shadow-lg flex items-center space-x-2 text-lg font-semibold">
                                <i class="fas fa-save"></i>
                                <span class="ml-2 text-sm text-white-600">Enregistrer le Budget</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let rowIndex = 0;

        function addRow() {
            const table = document.getElementById('rows');
            const emptyState = document.getElementById('empty-state');
            const row = document.createElement('tr');
            
            row.className = 'table-row slide-in bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700';
            row.innerHTML = `
                <td class="border border-black dark:border-gray-600 px-4 py-4 text-left text-black dark:text-white font-semibold">
                    <input type="text" name="rows[${rowIndex}][imputation]" 
                           placeholder="Ex: 6411"
                           class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded-md dark:bg-gray-700 dark:text-white input-focus placeholder-gray-400 dark:placeholder-gray-500">
                </td>
                <td class="border border-black dark:border-gray-600 px-4 py-4 text-left text-black dark:text-white font-semibold">
                    <input type="text" name="rows[${rowIndex}][intitule]" 
                           placeholder="Ex: Salaires et charges"
                           class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded-md dark:bg-gray-700 dark:text-white input-focus placeholder-gray-400 dark:placeholder-gray-500">
                </td>
                <td class="border border-black dark:border-gray-600 px-4 py-4 text-left text-black dark:text-white font-semibold">
                    <div class="relative">
                        <input type="number" name="rows[${rowIndex}][previsionnel]" 
                               placeholder="0"
                               class="w-full p-2 pl-8 border border-gray-300 dark:border-gray-600 rounded-md dark:bg-gray-700 dark:text-white input-focus placeholder-gray-400 dark:placeholder-gray-500">
                        <i class="fas fa-euro-sign absolute left-3 top-3 text-gray-400 dark:text-gray-500"></i>
                    </div>
                </td>
                <td class="border border-black dark:border-gray-600 px-4 py-4 text-left text-black dark:text-white font-semibold">
                    <div class="relative">
                        <input type="number" name="rows[${rowIndex}][atterrissage]" 
                               placeholder="0"
                               class="w-full p-2 pl-8 border border-gray-300 dark:border-gray-600 rounded-md dark:bg-gray-700 dark:text-white input-focus placeholder-gray-400 dark:placeholder-gray-500">
                        <i class="fas fa-euro-sign absolute left-3 top-3 text-gray-400 dark:text-gray-500"></i>
                    </div>
                </td>
                <td class="border border-black dark:border-gray-600 px-4 py-4 text-left text-black dark:text-white font-semibold text-center">
                    <input type="hidden" name="rows[${rowIndex}][is_header]" value="0">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="rows[${rowIndex}][is_header]" value="1" 
                               class="w-5 h-5 is-header-checkbox text-indigo-600 rounded focus:ring-indigo-500 focus:ring-2">
                        <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Titre</span>
                    </label>
                </td>
                <td class="border border-black dark:border-gray-600 px-4 py-4 text-left text-black dark:text-white font-semibold text-center">
                    <button type="button" onclick="removeRow(this)" 
                            class="text-red-500 hover:text-red-700 hover:bg-red-50 dark:hover:bg-red-900 p-2 rounded-full transition-colors duration-200"
                            title="Supprimer cette ligne">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </td>
            `;
            
            table.appendChild(row);
            emptyState.style.display = 'none';
            rowIndex++;
            updateRowCount();
        }

        function addBlueTitleRow() {
            const table = document.getElementById('rows');
            const emptyState = document.getElementById('empty-state');
            const row = document.createElement('tr');
            
            row.className = 'blue-title-row slide-in text-white';
            row.innerHTML = `
                <td class="border border-blue-400 px-4 py-4" colspan="4">
                    <input type="hidden" name="rows[${rowIndex}][imputation]" value="">
                    <input type="hidden" name="rows[${rowIndex}][intitule]" value="">
                    <input type="hidden" name="rows[${rowIndex}][previsionnel]" value="">
                    <input type="hidden" name="rows[${rowIndex}][atterrissage]" value="">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-heading text-xl"></i>
                        <input type="text" name="rows[${rowIndex}][b_title]" 
                               placeholder="Titre de section (ex: CHARGES D'EXPLOITATION)"
                               class="flex-1 p-3 border border-blue-300 rounded-lg bg-blue-50 dark:bg-blue-800 text-blue-900 dark:text-white font-semibold placeholder-blue-400 dark:placeholder-blue-300 focus:ring-2 focus:ring-blue-200">
                    </div>
                </td>
                <td class="border border-blue-400 px-4 py-4 text-center">
                    <input type="hidden" name="rows[${rowIndex}][is_header]" value="0">
                    <i class="fas fa-star text-yellow-300"></i>
                </td>
                <td class="border border-blue-400 px-4 py-4 text-center">
                    <button type="button" onclick="removeRow(this)" 
                            class="text-red-300 hover:text-red-100 hover:bg-red-500 p-2 rounded-full transition-colors duration-200"
                            title="Supprimer ce titre">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </td>
            `;
            
            table.appendChild(row);
            emptyState.style.display = 'none';
            rowIndex++;
            updateRowCount();
        }

        function removeRow(button) {
            const row = button.closest('tr');
            row.style.opacity = '0';
            row.style.transform = 'translateX(-20px)';
            
            setTimeout(() => {
                row.remove();
                updateRowCount();
                checkEmptyState();
            }, 200);
        }

        function updateRowCount() {
            const count = document.getElementById('rows').children.length;
            document.getElementById('row-count').textContent = count;
        }

        function checkEmptyState() {
            const table = document.getElementById('rows');
            const emptyState = document.getElementById('empty-state');
            
            if (table.children.length === 0) {
                emptyState.style.display = 'block';
            }
        }

        document.addEventListener('change', function (e) {
            if (e.target.classList.contains('is-header-checkbox')) {
                const row = e.target.closest('tr');
                if (e.target.checked) {
                    row.classList.add('header-row');
                    row.classList.add('text-white');
                    row.classList.add('font-semibold');
                } else {
                    row.classList.remove('header-row');
                    row.classList.remove('text-white');
                    row.classList.remove('font-semibold');
                }
            }
        });

        checkEmptyState();
    </script>
</x-app-layout>