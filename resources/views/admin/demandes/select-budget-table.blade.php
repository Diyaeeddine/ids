<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Sélectionner une ligne depuis une table budgétaire
        </h2>
    </x-slot>

    <div class="py-8 px-6">
        @foreach ($tables as $table)
            <div class="mb-6 bg-white dark:bg-gray-800 shadow rounded-lg p-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $table->title }}</h3>
                <table class="w-full mt-4 text-sm text-left text-gray-600 dark:text-gray-300">
                    <thead class="text-xs uppercase bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-200">
                        <tr>
                            <th class="px-4 py-2">Imputation Comptable</th>
                            <th class="px-4 py-2">Intitulé</th>
                            <th class="px-4 py-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($table->entries as $entry)
                            @if ($entry->imputation_comptable)
                                <tr class="border-b dark:border-gray-700">
                                    <td class="px-4 py-2">{{ $entry->imputation_comptable }}</td>
                                    <td class="px-4 py-2">{{ $entry->intitule }}</td>
                                    <td class="px-4 py-2">
                                        <form action="{{ route('demande.add-imputation-to-form') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="imputation" value="{{ $entry->imputation_comptable }}">
                                            <input type="hidden" name="intitule" value="{{ $entry->intitule }}">
                                            <button type="submit" class="text-blue-600 hover:underline">Sélectionner</button>
                                        </form>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endforeach
    </div>
</x-app-layout>
