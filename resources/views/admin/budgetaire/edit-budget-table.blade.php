<title>Edite table Budgétaire </title>

<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
            Modifier la Table Budgétaire
        </h2>
    </x-slot>

    <form method="POST" action="{{ route('budget-tables.update.entries', $budgetTable->id) }}">
        @csrf
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mt-6">
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700 dark:text-white">Titre</label>
                <input type="text" name="title" id="title" value="{{ $budgetTable->title }}"
                    class="w-full mt-1 rounded-md border-gray-300 dark:bg-gray-700 dark:text-white dark:border-gray-600">
            </div>

            <div class="mb-6">
                <label for="prevision_label" class="block text-sm font-medium text-gray-700 dark:text-white">Prévision Label</label>
                <input type="text" name="prevision_label" id="prevision_label" value="{{ $budgetTable->prevision_label }}"
                    class="w-full mt-1 rounded-md border-gray-300 dark:bg-gray-700 dark:text-white dark:border-gray-600">
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm border border-gray-300 dark:border-gray-600" id="budgetTable">
                    <thead class="bg-blue-700 text-white dark:bg-blue-800">
                        <tr>
                            <th class="border px-4 py-2">Imputation</th>
                            <th class="border px-4 py-2">Intitulé</th>
                            <th class="border px-4 py-2">Prévision</th>
                            <th class="border px-4 py-2">Atterrissage</th>
                            <th class="border px-4 py-2">B. Title</th>
                            <th class="border px-4 py-2">Type</th>
                            <th class="border px-4 py-2">Action</th>
                        </tr>
                    </thead>
                    <tbody id="tableRows">

                        @foreach($budgetTable->entries->sortBy('position') as $entry)
                            <tr>
                                <td class="border px-2 py-2">
                                    <input type="hidden" name="entries[{{ $entry->id }}][id]" value="{{ $entry->id }}">
                                    <input type="text" name="entries[{{ $entry->id }}][imputation_comptable]" value="{{ $entry->imputation_comptable }}"
                                        class="w-full rounded-md dark:bg-gray-700 dark:text-white">
                                </td>
                                <td class="border px-2 py-2">
                                    <input type="text" name="entries[{{ $entry->id }}][intitule]" value="{{ $entry->intitule }}"
                                        class="w-full rounded-md dark:bg-gray-700 dark:text-white">
                                </td>
                                <td class="border px-2 py-2">
                                    <input type="number" step="0.01" name="entries[{{ $entry->id }}][budget_previsionnel]" value="{{ $entry->budget_previsionnel }}"
                                        class="w-full rounded-md dark:bg-gray-700 dark:text-white">
                                </td>
                                <td class="border px-2 py-2">
                                    <input type="number" step="0.01" name="entries[{{ $entry->id }}][atterrissage]" value="{{ $entry->atterrissage }}"
                                        class="w-full rounded-md dark:bg-gray-700 dark:text-white">
                                </td>
                                <td class="border px-2 py-2">
                                    <input type="text" name="entries[{{ $entry->id }}][b_title]" value="{{ $entry->b_title }}"
                                        class="w-full rounded-md dark:bg-gray-700 dark:text-white">
                                </td>
                                <td class="border px-2 py-2">
                                    <select name="entries[{{ $entry->id }}][is_header]" class="w-full rounded-md dark:bg-gray-700 dark:text-white">
                                        <option value="0" @selected(!$entry->is_header)>Normal</option>
                                        <option value="1" @selected($entry->is_header)>Entête</option>
                                    </select>
                                </td>
                                <td class="border px-2 py-2 text-center">
                                    <button type="button" onclick="this.closest('tr').remove()" class="text-red-600 font-bold">🗑️</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="flex gap-x-4">
    <div class="mt-4">
        <button type="button" onclick="addRow()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
            Ajouter une ligne
        </button>
    </div>

    <div class="mt-4">
        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-md">
            Enregistrer les modifications
        </button>
    </div>
</div>

        </div>
    </form>

    <script>
        let rowIndex = 1000;

    function addRow() {
        const tbody = document.getElementById('tableRows');
        const id = `new_${rowIndex++}`;
        const row = document.createElement('tr');

        row.innerHTML = `
            <td class="border px-2 py-2">
                <input type="text" name="entries[${id}][imputation_comptable]" class="w-full rounded-md dark:bg-gray-700 dark:text-white">
            </td>
            <td class="border px-2 py-2">
                <input type="text" name="entries[${id}][intitule]" class="w-full rounded-md dark:bg-gray-700 dark:text-white">
            </td>
            <td class="border px-2 py-2">
                <input type="number" step="0.01" name="entries[${id}][budget_previsionnel]" class="w-full rounded-md dark:bg-gray-700 dark:text-white">
            </td>
            <td class="border px-2 py-2">
                <input type="number" step="0.01" name="entries[${id}][atterrissage]" class="w-full rounded-md dark:bg-gray-700 dark:text-white">
            </td>
            <td class="border px-2 py-2">
                <input type="text" name="entries[${id}][b_title]" class="w-full rounded-md dark:bg-gray-700 dark:text-white">
            </td>
            <td class="border px-2 py-2">
                <select name="entries[${id}][is_header]" class="w-full rounded-md dark:bg-gray-700 dark:text-white">
                    <option value="0">Normal</option>
                    <option value="1">Entête</option>
                </select>
            </td>
            <td class="border px-2 py-2 text-center">
                <button type="button" onclick="this.closest('tr').remove()" class="text-red-600 font-bold">🗑️</button>
            </td>
        `;

        tbody.appendChild(row);
    }
    </script>
</x-app-layout>