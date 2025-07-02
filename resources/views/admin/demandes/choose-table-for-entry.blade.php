<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Choisir une table budgétaire
        </h2>
    </x-slot>

    <div class="py-6 px-4">
        <div class="bg-white text-white dark:bg-gray-800 p-6 rounded shadow">
            <h3 class="text-lg font-semibold mb-4">Sélectionnez une table :</h3>
            <ul>
                @foreach ($tables as $table)
                    <li class="mb-2">
                        <a href="{{ route('demande.add-entry-to-table', $table->id) }}" class="text-blue-600 dark:text-blue-400 hover:underline">
                            {{ $table->title }} ({{ $table->previsions_label }})
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</x-app-layout>
