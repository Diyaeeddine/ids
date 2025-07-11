<title>Tables Budgétaires</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"/>
<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Tables Budgétaires</h2>
    </x-slot>

    <div class="flex flex-col md:flex-row h-full gap-4 mt-6">
        <!-- Sidebar: full width on small, 1/4 width on md+ -->
        <aside class="w-full md:w-1/4 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm p-4 overflow-y-auto max-h-[70vh] md:max-h-full">
            <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-white">Titres</h3>
            <ul class="space-y-2">
                @foreach ($tables as $table)
                    @php $isSelected = $selectedTable && $selectedTable->id === $table->id; @endphp
                    <li>
                        <a href="{{ route('budget-tables.show', $table->id) }}"
                           class="block px-4 py-2 rounded-md text-sm font-medium transition duration-200
                           {{ $isSelected 
                                ? 'bg-indigo-600 text-white font-semibold border-l-4 border-blue-300' 
                                : 'bg-gray-100 dark:bg-gray-700 hover:bg-blue-100 dark:hover:bg-gray-600 text-gray-800 dark:text-white' }}">
                            {{ $table->title }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </aside>

        <!-- Main content: full width on small, 3/4 width on md+ -->
        <main class="w-full md:w-3/4 p-4 bg-white dark:bg-gray-900 rounded-md shadow-sm overflow-auto">
            @if ($selectedTable)
                <div class="flex flex-col md:flex-row justify-between mb-4 gap-4 md:gap-0">
                    <div>
                        <h3 class="text-xl font-bold mb-2 dark:text-white break-words">{{ $selectedTable->title }}</h3>
                        <p class="text-gray-700 dark:text-gray-300 text-sm">{{ $selectedTable->prevision_label }}</p>
                    </div>

                    <div class="flex gap-x-4">
                        <a href="{{ route('budget-tables.export', $selectedTable->id) }}"
                           class="inline-flex items-center bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md transition duration-200 whitespace-nowrap">
                            <i class="fas fa-file-pdf mr-2"></i> Exporter PDF
                        </a>

                        <a href="{{ route('budget-tables.edit', $selectedTable->id) }}"
                           class="inline-flex items-center bg-yellow-600 hover:bg-yellow-800 text-black px-4 py-2 rounded-md transition duration-200 dark:bg-yellow-900 dark:hover:bg-yellow-700 dark:text-white whitespace-nowrap">
                            <i class="fas fa-edit mr-2"></i> Modifier
                        </a>
                    </div>
                </div>

                <!-- Add horizontal scrolling for table on small screens -->
                <div class="overflow-x-auto">
                    <table class="w-full border border-gray-400 dark:border-gray-600 text-sm min-w-[600px]">
                        <thead>
                            <tr>
                                <th colspan="4" class="text-center text-white bg-blue-800 dark:bg-blue-900 text-base md:text-xl font-bold py-2 border border-black">
                                    {{ $selectedTable->title }}
                                </th>
                            </tr>
                            <tr>
                                <th colspan="4" class="text-center bg-blue-100 dark:bg-gray-300 text-base md:text-lg font-semibold py-2 text-black border border-black">
                                    {{ $selectedTable->prevision_label }}
                                </th>
                            </tr>
                            <tr class="bg-blue-800 text-white text-xs md:text-sm dark:bg-blue-900 border border-black">
                                <th class="border border-black px-2 py-2">Imputation<br>comptable</th>
                                <th class="border border-black px-2 py-2">Intitulé</th>
                                <th class="border border-black px-2 py-2">Budget<br>Prévisionnel</th>
                                <th class="border border-black px-2 py-2">Atterrissage</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($selectedTable->entries->sortBy('position') as $entry)
                                @if ($entry->b_title)
                                    <tr class="bg-blue-600 text-white dark:bg-blue-900 font-bold">
                                        <td colspan="4" class="border border-black px-4 py-2 break-words">
                                            {{ $entry->b_title }}
                                        </td>
                                    </tr>
                                @elseif ($entry->is_header)
                                    <tr class="bg-gray-200 text-black font-bold dark:bg-gray-300">
                                        <td class="border border-black px-2 py-2 break-words">{{ $entry->imputation_comptable }}</td>
                                        <td class="border border-black px-2 py-2 break-words">{{ $entry->intitule }}</td>
                                        <td class="border border-black px-2 py-2 break-words">{{ $entry->budget_previsionnel }}</td>
                                        <td class="border border-black px-2 py-2 break-words">{{ $entry->atterrissage }}</td>
                                    </tr>
                                @else
                                    <tr class="bg-white dark:bg-white text-black dark:text-black">
                                        <td class="border border-black px-2 py-2 break-words">{{ $entry->imputation_comptable }}</td>
                                        <td class="border border-black px-2 py-2 break-words">{{ $entry->intitule }}</td>
                                        <td class="border border-black px-2 py-2 break-words">{{ $entry->budget_previsionnel }}</td>
                                        <td class="border border-black px-2 py-2 break-words">{{ $entry->atterrissage }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-600 dark:text-gray-400">Aucune table budgétaire sélectionnée.</p>
            @endif
        </main>
    </div>
</x-app-layout>