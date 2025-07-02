<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Ajouter une ligne à la table : {{ $budgetTable->title }}
        </h2>
    </x-slot>

    <div class="py-6 px-4">
        <div class="bg-white text-white dark:bg-gray-800 p-6 rounded shadow">
            <form action="{{ route('demande.save-entry-and-return') }}" method="POST">
                
                @csrf
                <input type="hidden" name="budget_table_id" value="{{ $budgetTable->id }}">

                <div class="mb-4">
                    <label class="block text-sm font-medium">Imputation Comptable</label>
                    <input type="text" name="imputation_comptable" class="mt-1 block w-full dark:bg-gray-700" required>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium">Intitulé</label>
                    <input type="text" name="intitule" class="mt-1 block w-full dark:bg-gray-700">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium">Budget Prévisionnel</label>
                    <input type="number" placeholder="Ex: 5000" name="budget_previsionnel"  class="mt-1 block w-full dark:bg-gray-700">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium">Atterrissage</label>
                    <input type="number" name="atterrissage" placeholder="Ex: N°"  class="mt-1 block w-full dark:bg-gray-700">
                </div>

                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Ajouter et sélectionner</button>
            </form>
        </div>
    </div>
</x-app-layout>
